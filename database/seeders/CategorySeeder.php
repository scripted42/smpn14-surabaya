<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Kategori Berita
            ['name' => 'Akademik & Kurikulum', 'slug' => 'akademik-kurikulum', 'type' => 'news'],
            ['name' => 'Kegiatan Kesiswaan', 'slug' => 'kegiatan-kesiswaan', 'type' => 'news'],
            ['name' => 'Prestasi & Penghargaan', 'slug' => 'prestasi-penghargaan', 'type' => 'news'],
            ['name' => 'Adiwiyata & Lingkungan', 'slug' => 'adiwiyata-lingkungan', 'type' => 'news'],
            ['name' => 'Pengumuman Resmi', 'slug' => 'pengumuman-resmi', 'type' => 'news'],
            
            // Kategori Prestasi
            ['name' => 'Sains & Matematika', 'slug' => 'sains-matematika', 'type' => 'achievement'],
            ['name' => 'Seni, Bahasa & Budaya', 'slug' => 'seni-bahasa-budaya', 'type' => 'achievement'],
            ['name' => 'Olahraga & Atletik', 'slug' => 'olahraga-atletik', 'type' => 'achievement'],
            ['name' => 'Kepramukaan & Bela Negara', 'slug' => 'kepramukaan-bela-negara', 'type' => 'achievement'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
