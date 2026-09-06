<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Bambang Irawan',
                'email' => 'bambang.irawan@gmail.com',
                'phone' => '081234567890',
                'subject' => 'Pertanyaan Informasi Mutasi Siswa Masuk Kelas VIII',
                'message' => 'Selamat pagi bapak/ibu TU, kami ingin menanyakan apakah pada semester genap mendatang tersedia kuota bangku kosong untuk mutasi masuk siswa pindahan dari luar kota? Mohon arahan syarat kelengkapannya.',
                'is_read' => true,
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Siti Nur Kholifah',
                'email' => 'sitinur.kh@yahoo.com',
                'phone' => '085712345678',
                'subject' => 'Konsultasi Jalur Afirmasi PPDB SMP Surabaya',
                'message' => 'Mohon bantuan informasi terkait syarat verifikasi kepemilikan data DTKS/KMS untuk pendaftaran jalur afirmasi PPDB Kota Surabaya ke SMPN 14.',
                'is_read' => false,
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Yayasan Literasi Anak Nusantara',
                'email' => 'kerjasama@literasianak.org',
                'phone' => '082198765432',
                'subject' => 'Penawaran Kolaborasi Program Duta Baca dan Hibah Buku',
                'message' => 'Kami dari Yayasan Literasi bermaksud mengajukan kerja sama penyelenggaraan workshop penulisan kreatif dan donasi 200 eksemplar buku ensiklopedia untuk perpustakaan SMPN 14 Surabaya.',
                'is_read' => false,
                'created_at' => now()->subHours(8),
            ],
            [
                'name' => 'Dwi Prasetyo Utomo',
                'email' => 'dwi.prasetyo@outlook.com',
                'phone' => '081345678912',
                'subject' => 'Legalitas Pengesahan Ijazah Alumni Tahun 2024',
                'message' => 'Halo bapak/ibu, apakah layanan legalisir ijazah SMP bisa dilayani setiap hari kerja dan apa saja berkas yang harus dibawa? Terima kasih.',
                'is_read' => true,
                'created_at' => now()->subDays(6),
            ],
        ];

        foreach ($messages as $msg) {
            ContactMessage::create($msg);
        }
    }
}
