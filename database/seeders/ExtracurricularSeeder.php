<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use Illuminate\Database\Seeder;

class ExtracurricularSeeder extends Seeder
{
    public function run(): void
    {
        $extras = [
            [
                'name' => 'Pramuka Penggalang (Gudep 14)',
                'description' => 'Ekstrakurikuler wajib pembentuk karakter kemandirian, kedisiplinan, pioneering, sandi, serta pengabdian masyarakat dasadarma pramuka.',
                'coach_name' => 'Kak Wahyudi, S.Pd. (Pembina Mahir Lanjutan)',
                'schedule_text' => 'Setiap Jumat, 13.30 - 15.30 WIB',
                'sort_order' => 1,
            ],
            [
                'name' => 'Paskibra (Pasukan Pengibar Bendera)',
                'description' => 'Membina kedisiplinan baris-berbaris (LKBB), patriotisme, kepemimpinan, dan etika tata upacara bendera resmi kenegaraan.',
                'coach_name' => 'Dwi Handoko (Pelatih Purna Paskibraka Kota Surabaya)',
                'schedule_text' => 'Setiap Selasa & Kamis, 15.30 - 17.00 WIB',
                'sort_order' => 2,
            ],
            [
                'name' => 'Palang Merah Remaja (PMR Madya)',
                'description' => 'Pelatihan pertolongan pertama pada kecelakaan (P3K), tandu darurat, donor darah sukarela, dan kesiapsiagaan tanggap bencana.',
                'coach_name' => 'Nurmala Sari, A.Md.Kep. & Tim PMI Surabaya',
                'schedule_text' => 'Setiap Rabu, 15.30 - 17.00 WIB',
                'sort_order' => 3,
            ],
            [
                'name' => 'Futsal & Sepak Bola Pelajar',
                'description' => 'Mengasah keterampilan teknik dasar mengolah bola, taktik tim, fisik prima, dan sportivitas kompetisi antar-SMP.',
                'coach_name' => 'Coach Rahmat Hidayat, S.Pd.',
                'schedule_text' => 'Setiap Senin & Jumat, 15.30 - 17.30 WIB',
                'sort_order' => 4,
            ],
            [
                'name' => 'Bola Basket ("Fourteen Hoops")',
                'description' => 'Pembinaan bakat bola basket pelajar mulai dari fundamental dribble, passing, shooting, hingga tanding persahabatan DBL Junior.',
                'coach_name' => 'Coach Dimas Prasetya',
                'schedule_text' => 'Setiap Rabu & Sabtu, 15.30 - 17.30 WIB',
                'sort_order' => 5,
            ],
            [
                'name' => 'Seni Tari Tradisional & Karawitan',
                'description' => 'Melestarikan warisan budaya luhur melalui seni tari kreasi Jawa Timur, Remo Surabaya, dan tabuhan gamelan karawitan.',
                'coach_name' => 'I Made Sudarma, S.Sn.',
                'schedule_text' => 'Setiap Kamis, 15.30 - 17.00 WIB',
                'sort_order' => 6,
            ],
            [
                'name' => 'Paduan Suara "Bahana Belasan"',
                'description' => 'Olah vokal kelompok, pernapasan diafragma, harmonisasi suara SATB, dan pembawa lagu hymne/mars pada upacara resmi.',
                'coach_name' => 'Clara Dewi Anggraini, S.Pd.',
                'schedule_text' => 'Setiap Selasa, 15.30 - 17.00 WIB',
                'sort_order' => 7,
            ],
            [
                'name' => 'Klub Coding & Robotika SMP',
                'description' => 'Mengenalkan logika komputasi, pemrograman visual Scratch/Python dasar, dan perakitan mikrokontroler sensor robotika sederhana.',
                'coach_name' => 'Budi Santoso, S.Kom.',
                'schedule_text' => 'Setiap Sabtu, 08.00 - 10.30 WIB',
                'sort_order' => 8,
            ],
        ];

        foreach ($extras as $ex) {
            Extracurricular::updateOrCreate(['name' => $ex['name']], $ex);
        }
    }
}
