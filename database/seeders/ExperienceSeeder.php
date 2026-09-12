<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'title' => 'Freelance Fullstack & Mobile Developer',
                'company' => null,
                'period' => '2024 - Sekarang',
                'description' => 'Merancang dan mengembangkan solusi web kustom, sistem kasir inventori, aplikasi mobile Android (APK), integrasi payment gateway QRIS, dan otomatisasi bot WhatsApp untuk berbagai kebutuhan bisnis.',
                'tags' => 'Laravel, Vue.js, Tailwind, MySQL',
                'color' => 'indigo',
                'order' => 1,
            ],
            [
                'title' => 'Web App Architect & Modern Tech Explorer',
                'company' => null,
                'period' => '2023 - 2024',
                'description' => 'Fokus mendalami arsitektur modern web, RESTful API, dynamic UI/UX, optimasi SEO, serta membangun proyek open-source dan sistem manajemen berbasis cloud.',
                'tags' => 'REST API, JavaScript, Git Workflow',
                'color' => 'cyan',
                'order' => 2,
            ],
            [
                'title' => 'Pembelajaran Intensif & Sertifikasi',
                'company' => null,
                'period' => '2022 - 2023',
                'description' => 'Menyelesaikan berbagai pelatihan komprehensif di bidang pemrograman terstruktur, algoritma, database modeling, dan desain antarmuka pengguna (UI/UX).',
                'tags' => 'Figma, HTML5/CSS3, Database Design',
                'color' => 'purple',
                'order' => 3,
            ]
        ];

        foreach ($experiences as $exp) {
            Experience::create($exp);
        }
    }
}
