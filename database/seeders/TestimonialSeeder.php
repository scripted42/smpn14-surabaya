<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Fathir Ahmad Pratama',
                'role' => 'siswa',
                'content' => 'Belajar di SMPN 14 Surabaya sangat seru dan tidak membosankan. Bapak dan ibu guru selalu sabar membimbing kami, fasilitas lab komputer dan lab IPA sangat lengkap untuk praktikum!',
                'status' => 'approved',
            ],
            [
                'name' => 'Hj. Ratna Sulistiyowati, S.E.',
                'role' => 'orang_tua',
                'content' => 'Sebagai orang tua, saya sangat bersyukur menyekolahkan anak saya di SMPN 14 Surabaya. Karakter kedisiplinan dan pembiasaan sholat dhuha berjamaah serta cinta lingkungan sangat terasa perkembangannya di rumah.',
                'status' => 'approved',
            ],
            [
                'name' => 'Dr. Bayu Wicaksono, M.Sc.',
                'role' => 'alumni',
                'content' => 'Fondasi kepemimpinan dan rasa ingin tahu ilmiah saya bermula dari bangku SMP Negeri 14 Surabaya. Guru-guru di sini tidak hanya mengajar pelajaran buku, tapi mendidik mental pemenang.',
                'status' => 'approved',
            ],
            [
                'name' => 'Nadia Syahputri (Alumni 2023, kini SMAN 5 Surabaya)',
                'role' => 'alumni',
                'content' => 'Pembekalan Kurikulum Merdeka dan bimbingan olimpiade sains di SMPN 14 sangat membantu saya ketika melanjutkan seleksi masuk SMA negeri favorit. Bangga pernah menjadi bagian dari Spenbel!',
                'status' => 'approved',
            ],
            [
                'name' => 'Ir. Hendra Gunawan',
                'role' => 'orang_tua',
                'content' => 'Komunikasi pihak sekolah dengan wali murid sangat terbuka melalui komite sekolah. Informasi jadwal ujian, kegiatan ekstrakurikuler, dan perkembangan nilai tersampaikan secara transparan.',
                'status' => 'approved',
            ],
            [
                'name' => 'Zahra Putri Ramadhani',
                'role' => 'siswa',
                'content' => 'Eskul karawitan dan tari tradisi di SMPN 14 membuat saya percaya diri tampil di panggung tingkat kota. Suasana sekolah yang rindang dan bersih membuat kami betah belajar seharian.',
                'status' => 'pending',
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }
    }
}
