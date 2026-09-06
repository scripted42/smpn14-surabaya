<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $catSains = Category::where('slug', 'sains-matematika')->first();
        $catSeni = Category::where('slug', 'seni-bahasa-budaya')->first();
        $catOlahraga = Category::where('slug', 'olahraga-atletik')->first();
        $catPramuka = Category::where('slug', 'kepramukaan-bela-negara')->first();

        $achievements = [
            [
                'student_name' => 'Rizky Pratama (Kelas IX-A)',
                'title' => 'Medali Emas Olimpiade Sains Pelajar Surabaya (OSPS) Cabang IPA Terpadu',
                'category_id' => $catSains?->id,
                'level' => 'kota',
                'year' => 2026,
                'description' => 'Meraih nilai tertinggi dalam babak teori eksperimen fisika dan biologi tingkat SMP se-Surabaya.',
            ],
            [
                'student_name' => 'Tim Tari Sanggar Widya 14',
                'title' => 'Juara 1 Festival Lomba Seni Siswa Nasional (FLS2N) Tari Tradisional Jawa Timur',
                'category_id' => $catSeni?->id,
                'level' => 'provinsi',
                'year' => 2026,
                'description' => 'Menampilkan tari kreasi baru bertema kepahlawanan Arek Suroboyo dengan iringan gamelan live.',
            ],
            [
                'student_name' => 'Tim Futsal Putra SMPN 14',
                'title' => 'Juara 1 Turnamen Futsal Piala Walikota Pelajar SMP Tingkat Kota Surabaya',
                'category_id' => $catOlahraga?->id,
                'level' => 'kota',
                'year' => 2026,
                'description' => 'Tak terkalahkan sepanjang babak penyisihan hingga menang dramatis 3-2 di partai final.',
            ],
            [
                'student_name' => 'Regu Rajawali - Gugus Depan 14',
                'title' => 'Juara Umum Lomba Tingkat (LT) III Pramuka Penggalang Kwarcab Kota Surabaya',
                'category_id' => $catPramuka?->id,
                'level' => 'kota',
                'year' => 2026,
                'description' => 'Menyapu bersih gelar di cabang pioneering, sandi morse, navigasi darat, dan pentas seni budaya.',
            ],
            [
                'student_name' => 'Aulia Cindy Maharani (Kelas VIII-C)',
                'title' => 'Medali Perak Olimpiade Bahasa Inggris Pelajar SMP Tingkat Nasional',
                'category_id' => $catSeni?->id,
                'level' => 'nasional',
                'year' => 2025,
                'description' => 'Meraih predikat runner-up dalam kompetisi esai bahasa Inggris dan sesi speech presentation.',
            ],
            [
                'student_name' => 'Kevin Arya Danendra (Kelas VIII-F)',
                'title' => 'Medali Perunggu Kejuaraan Renang Antar-Pelajar Jawa Timur (50m Gaya Dada)',
                'category_id' => $catOlahraga?->id,
                'level' => 'provinsi',
                'year' => 2025,
                'description' => 'Mencatatkan rekor waktu terbaik pribadi dalam ajang tahunan akuatik pelajar Jawa Timur.',
            ],
        ];

        foreach ($achievements as $ach) {
            Achievement::updateOrCreate(['title' => $ach['title']], $ach);
        }
    }
}
