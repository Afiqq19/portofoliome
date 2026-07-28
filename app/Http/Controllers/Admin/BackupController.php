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

        // Build mysqldump command
        $command = sprintf(
            'mysqldump --user=%s %s --host=%s --port=%s %s > %s',
            escapeshellarg($dbUser),
            $passwordArg,
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbName),
            escapeshellarg($backupPath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal membuat backup database. Pastikan mysqldump tersedia di sistem (Return Code: ' . $returnCode . ').');
        }

        return response()->download($backupPath)->deleteFileAfterSend(false);
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

        $command = sprintf(
            'mysql --user=%s %s --host=%s --port=%s %s < %s',
            escapeshellarg($dbUser),
            $passwordArg,
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbName),
            escapeshellarg($filePath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal me-restore database. Pastikan file SQL valid (Return Code: ' . $returnCode . ').');
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
