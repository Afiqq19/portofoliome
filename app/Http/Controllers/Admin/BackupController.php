<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backups = [];
        $files = Storage::disk('local')->files('backups');
        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), ['sql', 'txt'])) {
                continue;
            }

            $timestamp = Storage::disk('local')->lastModified($file);
            $backups[] = [
                'name' => basename($file),
                'size' => round(Storage::disk('local')->size($file) / 1024, 2), // KB
                'timestamp' => $timestamp,
                'date' => Carbon::createFromTimestamp($timestamp, config('app.timezone'))->format('d/m/Y H:i'),
            ];
        }
        
        // Sort by newest first
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return view('admin.backup.index', compact('backups'));
    }

    public function download()
    {
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port', 3306);

        $filename = 'backup_' . $dbName . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        
        if (!Storage::disk('local')->exists('backups')) {
            Storage::disk('local')->makeDirectory('backups');
        }
        
        $backupPath = Storage::disk('local')->path('backups/' . $filename);
        $passwordArg = !empty($dbPass) ? '--password=' . escapeshellarg($dbPass) : '';

        $success = false;

        // 1. Coba dump menggunakan utilitas CLI mysqldump dengan flag aman (MySQL 8 friendly)
        try {
            $command = sprintf(
                'mysqldump --user=%s %s --host=%s --port=%s --single-transaction --quick --skip-lock-tables --no-tablespaces %s > %s 2>&1',
                escapeshellarg($dbUser),
                $passwordArg,
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbName),
                escapeshellarg($backupPath)
            );

            exec($command, $output, $returnCode);

            // Validasi jika file terisi dan tidak error
            if ($returnCode === 0 && file_exists($backupPath) && filesize($backupPath) > 50) {
                $success = true;
            }
        } catch (\Throwable $e) {
            $success = false;
        }

        // 2. Jika mysqldump gagal / error (Code 2, 127, dll), gunakan mesin Native PDO Laravel
        if (!$success) {
            try {
                $this->backupUsingPdo($backupPath);
                $success = true;
            } catch (\Throwable $e) {
                Storage::disk('local')->delete('backups/' . $filename);
                return redirect()->route('admin.backup.index')
                    ->with('error', "Gagal backup database: " . $e->getMessage());
            }
        }

        return response()->download($backupPath)->deleteFileAfterSend(false);
    }

    private function backupUsingPdo(string $backupPath): void
    {
        $pdo = DB::connection()->getPdo();
        $handle = fopen($backupPath, 'w');
        
        fwrite($handle, "-- Laravel Native Database Backup (Auto PDO Fallback)\n");
        fwrite($handle, "-- Server: " . config('database.connections.mysql.host') . "\n");
        fwrite($handle, "-- Database: " . config('database.connections.mysql.database') . "\n");
        fwrite($handle, "-- Tanggal: " . Carbon::now()->toDateTimeString() . "\n\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
        fwrite($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n\n");
        
        $tables = [];
        $stmt = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
        while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }
        
        foreach ($tables as $table) {
            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "-- Struktur tabel `{$table}`\n");
            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
            
            $createStmt = $pdo->query("SHOW CREATE TABLE `{$table}`");
            $createRow = $createStmt->fetch(\PDO::FETCH_NUM);
            fwrite($handle, $createRow[1] . ";\n\n");
            
            // Dump isi data tabel
            $dataStmt = $pdo->query("SELECT * FROM `{$table}`");
            $rows = $dataStmt->fetchAll(\PDO::FETCH_ASSOC);
            
            if (!empty($rows)) {
                fwrite($handle, "-- Data untuk tabel `{$table}`\n");
                $columns = array_map(fn($col) => "`{$col}`", array_keys($rows[0]));
                $colNames = implode(", ", $columns);
                
                foreach (array_chunk($rows, 100) as $chunk) {
                    $values = [];
                    foreach ($chunk as $row) {
                        $escapedRow = array_map(function ($val) use ($pdo) {
                            if (is_null($val)) {
                                return 'NULL';
                            }
                            return $pdo->quote($val);
                        }, $row);
                        $values[] = "(" . implode(", ", $escapedRow) . ")";
                    }
                    fwrite($handle, "INSERT INTO `{$table}` ({$colNames}) VALUES\n" . implode(",\n", $values) . ";\n");
                }
                fwrite($handle, "\n");
            }
        }
        
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($handle);
    }

    public function store(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt|max:51200', // Max 50MB
        ]);

        $filename = 'backup_upload_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $request->file('backup_file')->storeAs('backups', $filename, 'local');

        return redirect()->route('admin.backup.index')
            ->with('success', 'File backup berhasil di-upload! Gunakan tombol Restore untuk mengembalikan data.');
    }

    public function restore(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $filename = $request->filename;
        $filePath = Storage::disk('local')->path('backups/' . $filename);

        if (!Storage::disk('local')->exists('backups/' . $filename)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'File backup tidak ditemukan.');
        }

        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port', 3306);

        $passwordArg = !empty($dbPass) ? '--password=' . escapeshellarg($dbPass) : '';

        $restored = false;

        try {
            $command = sprintf(
                'mysql --user=%s %s --host=%s --port=%s %s < %s 2>&1',
                escapeshellarg($dbUser),
                $passwordArg,
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbName),
                escapeshellarg($filePath)
            );

            exec($command, $output, $returnCode);
            if ($returnCode === 0) {
                $restored = true;
            }
        } catch (\Throwable $e) {
            $restored = false;
        }

        // Fallback jika mysql CLI gagal / tidak tersedia
        if (!$restored) {
            try {
                $sql = file_get_contents($filePath);
                DB::unprepared($sql);
                $restored = true;
            } catch (\Throwable $e) {
                return redirect()->route('admin.backup.index')
                    ->with('error', "Gagal me-restore database: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.backup.index')
            ->with('success', 'Database berhasil di-restore dari file: ' . $filename);
    }

    public function delete(Request $request)
    {
        $filename = $request->filename;
        
        if (Storage::disk('local')->exists('backups/' . $filename)) {
            Storage::disk('local')->delete('backups/' . $filename);
        }

        return redirect()->route('admin.backup.index')
            ->with('success', 'File backup berhasil dihapus.');
    }
}
