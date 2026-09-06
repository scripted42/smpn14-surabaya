<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Komputer & CBT Modern',
                'description' => 'Dilengkapi 90 unit PC all-in-one terkoneksi jaringan gigabit serat optik dan AC, digunakan untuk pembelajaran Informatika, coding, dan pelaksanaan ANBK.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Laboratorium IPA Terpadu',
                'description' => 'Fasilitas praktikum fisika, kimia dasar, dan biologi dengan mikroskop monokuler/binokuler, kit mekanika, dan alat keselamatan laboratorium standar.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Perpustakaan "Graha Pustaka"',
                'description' => 'Pusat literasi sekolah dengan koleksi lebih dari 7.000 judul buku fiksi, non-fiksi, ensiklopedia, area baca lesehan nyaman ber-AC, dan katalog digital (OPAC).',
                'sort_order' => 3,
            ],
            [
                'name' => 'Lapangan Olahraga Multifungsi',
                'description' => 'Lapangan outdoor dengan lantai cor standar untuk olahraga futsal, basket, voli, bulutangkis, serta area upacara bendera berkapasitas 900 siswa.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Green House & Taman Edukasi Adiwiyata',
                'description' => 'Instalasi hidroponik, rumah bibit tanaman toga, area komposter daun kering, dan kolam bioflok lele sebagai laboratorium hidup lingkungan.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Ruang Seni Musik & Karawitan',
                'description' => 'Ruang kedap suara yang dilengkapi seperangkat gamelan Jawa pelog-slendro, alat musik band modern, kolintang, dan sound system latihan.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Masjid Al-Ikhlas SMPN 14',
                'description' => 'Tempat ibadah yang luas dan bersih, memfasilitasi salat dhuha rutin, salat zuhur berjamaah, dan kegiatan bimbingan baca Al-Qur\'an.',
                'sort_order' => 7,
            ],
            [
                'name' => 'Unit Kesehatan Sekolah (UKS) Terakreditasi',
                'description' => 'Ruang rawat terpisah putra dan putri, dilengkapi tempat tidur medis, tabung oksigen, P3K lengkap, dan kerja sama berkala dengan Puskesmas setempat.',
                'sort_order' => 8,
            ],
        ];

        foreach ($facilities as $fac) {
            Facility::updateOrCreate(['name' => $fac['name']], $fac);
        }
    }
}
