<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('experiences', 'category')) {
            Schema::table('experiences', function (Blueprint $table) {
                $table->string('category')->default('work')->after('company');
            });
        }

        // Authentic CV Experiences data for Syafiq
        $authenticExperiences = [
            [
                'title' => 'Teknologi Informasi (IT) - Magang',
                'company' => 'PT Pelindo Multi Terminal (Kuala Tanjung)',
                'category' => 'work',
                'period' => 'Januari 2026 - Maret 2026',
                'description' => 'Memegang peran dalam pengembangan sistem dan dukungan teknis (IT Support). Bertanggung jawab atas pemeliharaan infrastruktur jaringan, troubleshooting perangkat keras operasional pelabuhan, serta mendukung digitalisasi sistem manajemen terminal maritim.',
                'tags' => 'IT Support, Network Infrastructure, Troubleshooting, System Management',
                'color' => 'indigo',
                'order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Admin Administrasi Umum - Magang',
                'company' => 'PT Telkom Akses (Siantar)',
                'category' => 'work',
                'period' => 'Oktober 2024 - November 2024',
                'description' => 'Mengelola administrasi data operasional teknis jaringan fiber optic, terlibat langsung dalam pengawasan teknis di lapangan, validasi dokumen laporan berkala, serta rekonsiliasi data inventaris jaringan.',
                'tags' => 'Administrasi Digital, Fiber Optic, Data Management, Field Technical Monitoring',
                'color' => 'rose',
                'order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Freelance Fullstack & Mobile Developer',
                'company' => 'Self-Employed / Freelance',
                'category' => 'work',
                'period' => '2024 - Sekarang',
                'description' => 'Merancang dan mengembangkan aplikasi web dinamis berskala produksi, aplikasi mobile Android (APK), integrasi payment gateway QRIS, manajemen database, dan sistem inventori kasir digital untuk berbagai klien.',
                'tags' => 'Laravel, Vue.js, MySQL, REST API, Tailwind CSS',
                'color' => 'emerald',
                'order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'D3 Manajemen Informatika',
                'company' => 'Politeknik Negeri Medan (Polmed)',
                'category' => 'education',
                'period' => '2023 - 2026',
                'description' => 'Mendalami rekayasa perangkat lunak modern, arsitektur basis data relasional, pemrograman web & mobile, analisis perancangan sistem informasi, dan struktur data & algoritma.',
                'tags' => 'Manajemen Informatika, Software Engineering, Database Systems, Web Development',
                'color' => 'cyan',
                'order' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Pengurus Departemen (Purna Tugas)',
                'company' => 'BEM Politeknik Negeri Medan',
                'category' => 'organization',
                'period' => '2024 - 2025',
                'description' => 'Berperan aktif dalam perencanaan dan eksekusi program kerja kemahasiswaan tingkat kampus, koordinasi advokasi kesejahteraan mahasiswa, dan manajemen kepanitiaan event kampus berskala besar.',
                'tags' => 'Leadership, Event Organizing, Student Advocacy, Team Collaboration',
                'color' => 'amber',
                'order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Pengurus Wilayah / Nasional (Purna Tugas)',
                'company' => 'FKMPI (Forum Komunikasi Mahasiswa Politeknik se-Indonesia)',
                'category' => 'organization',
                'period' => '2024 - 2025',
                'description' => 'Mengoordinasikan komunikasi dan konsolidasi strategis antar mahasiswa politeknik seluruh Indonesia, sinergi program vokasi nasional, serta perumusan gagasan kepemudaan.',
                'tags' => 'National Networking, Public Relations, Strategic Coordination, Youth Leadership',
                'color' => 'purple',
                'order' => 6,
                'is_published' => true,
            ],
        ];

        $firstProfileId = DB::table('profiles')->value('id');
        $hasPelindo = DB::table('experiences')->where('company', 'LIKE', '%Pelindo%')->exists();
        
        if (!$hasPelindo) {
            DB::table('experiences')->truncate();
            foreach ($authenticExperiences as $item) {
                $item['profile_id'] = $firstProfileId;
                $item['created_at'] = now();
                $item['updated_at'] = now();
                DB::table('experiences')->insert($item);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('experiences', 'category')) {
            Schema::table('experiences', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};
