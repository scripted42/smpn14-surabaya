<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Drs. H. Bambang Sutrisno, M.Pd.',
                'nip' => '19680512 199403 1 005',
                'position' => 'Kepala Sekolah',
                'subject' => null,
                'bio' => 'Mengabdi di dunia pendidikan lebih dari 30 tahun. Bertekad membawa SMPN 14 Surabaya menjadi sekolah unggul berprestasi dan berwawasan lingkungan terdepan di Jawa Timur.',
                'is_structural' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Dra. Hj. Sri Wahyuni, M.Pd.',
                'nip' => '19720315 199702 2 003',
                'position' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'subject' => 'Matematika (Kelas IX)',
                'bio' => 'Penggerak implementasi Kurikulum Merdeka dan pembimbing tim olimpiade matematika SMPN 14 Surabaya.',
                'is_structural' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Achmad Fauzi, S.Pd., M.Si.',
                'nip' => '19760820 200112 1 004',
                'position' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'subject' => 'IPA Terpadu (Kelas VIII)',
                'bio' => 'Fokus pada pembinaan kedisiplinan, kepemimpinan OSIS, pembinaan ekstrakurikuler, dan karakter Profil Pelajar Pancasila.',
                'is_structural' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Endang Retnowati, S.Pd.',
                'nip' => '19741108 199903 2 006',
                'position' => 'Wakil Kepala Sekolah Bidang Sarpras & Humas',
                'subject' => 'Bahasa Indonesia (Kelas VII)',
                'bio' => 'Bertanggung jawab atas pemeliharaan fasilitas modern sekolah dan komunikasi kemitraan dengan komite sekolah dan masyarakat.',
                'is_structural' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Budi Santoso, S.Kom.',
                'nip' => '19850414 201001 1 012',
                'position' => 'Koordinator Lab IT & Guru Informatika',
                'subject' => 'Informatika (Kelas VII, VIII, IX)',
                'bio' => 'Mengembangkan program literasi digital, coding dasar, dan kesiapan infrastruktur ANBK sekolah.',
                'is_structural' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Siti Rahmawati, S.Pd.',
                'nip' => '19820719 200801 2 018',
                'position' => 'Pembina Tim Adiwiyata & Guru IPA',
                'subject' => 'Ilmu Pengetahuan Alam (Kelas VII & VIII)',
                'bio' => 'Pelopor program Bank Sampah Sekolah, kebun hidroponik Green House, dan pembina kader lingkungan muda SMPN 14.',
                'is_structural' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Rahmat Hidayat, S.Pd.',
                'nip' => '19880226 201402 1 003',
                'position' => 'Pembina Ekstrakurikuler Olahraga',
                'subject' => 'Pendidikan Jasmani, Olahraga & Kesehatan (PJOK)',
                'bio' => 'Pelatih tim futsal dan bola basket SMPN 14 Surabaya dengan berbagai raihan trofi tingkat kota Surabaya.',
                'is_structural' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'Nurul Azizah, S.Pd., Gr.',
                'nip' => '19910905 201903 2 014',
                'position' => 'Guru Penggerak & Wali Kelas VII',
                'subject' => 'Bahasa Inggris',
                'bio' => 'Aktif mengembangkan metode pembelajaran interaktif berbahasa Inggris berbasis proyek dan kegiatan storytelling.',
                'is_structural' => false,
                'sort_order' => 8,
            ],
            [
                'name' => 'I Made Sudarma, S.Sn.',
                'nip' => '19841210 200902 1 007',
                'position' => 'Pembina Sanggar Seni & Karawitan',
                'subject' => 'Seni Budaya',
                'bio' => 'Membimbing siswa dalam seni musik tradisional, tari kreasi Arek Suroboyo, dan pergelaran teater sekolah.',
                'is_structural' => false,
                'sort_order' => 9,
            ],
            [
                'name' => 'Tri Handayani, S.Sos.',
                'nip' => '19780104 200501 2 009',
                'position' => 'Kepala Urusan Tata Usaha',
                'subject' => null,
                'bio' => 'Mengkoordinasikan administrasi persuratan, kepegawaian, kesiswaan, dan pelaporan keuangan operasional sekolah.',
                'is_structural' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::updateOrCreate(['name' => $teacher['name']], $teacher);
        }
    }
}
