<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Jadwal Pelaksanaan Sumatif Akhir Semester (SAS) Ganjil TP 2026/2027',
                'content' => 'Pelaksanaan asesmen sumatif akhir semester ganjil bagi jenjang kelas VII, VIII, dan IX dijadwalkan pada tanggal 1 s.d. 8 Desember 2026. Seluruh siswa diwajibkan membawa kartu peserta ujian dan hadir tepat waktu.',
                'attachment_path' => null,
                'audience' => 'all',
                'valid_from' => now()->subDays(5)->toDateString(),
                'valid_until' => now()->addDays(20)->toDateString(),
                'is_pinned' => true,
            ],
            [
                'title' => 'Pertemuan Sosialisasi Pembelajaran Semester Genap & Parenting Wali Murid',
                'content' => 'Mengundang bapak/ibu orang tua/wali murid kelas VII dan VIII untuk menghadiri pertemuan komite dan sosialisasi evaluasi capaian belajar siswa pada Sabtu pagi di Aula Graha Widya.',
                'attachment_path' => null,
                'audience' => 'parent',
                'valid_from' => now()->subDays(2)->toDateString(),
                'valid_until' => now()->addDays(10)->toDateString(),
                'is_pinned' => true,
            ],
            [
                'title' => 'Jadwal Registrasi Ulang Ekstrakurikuler Semester Genap',
                'content' => 'Pendaftaran peminatan ekstrakurikuler wajib (Pramuka) dan ekstrakurikuler pilihan (Futsal, Tari, Karawitan, Robotika, PMR) dibuka melalui koordinator kesiswaan di ruang OSIS.',
                'attachment_path' => null,
                'audience' => 'student',
                'valid_from' => now()->subDays(3)->toDateString(),
                'valid_until' => now()->addDays(15)->toDateString(),
                'is_pinned' => false,
            ],
            [
                'title' => 'Edaran Kebersihan Lingkungan dan Larangan Kemasan Plastik Sekali Pakai',
                'content' => 'Dalam rangka penguatan Sekolah Adiwiyata, seluruh warga sekolah diimbau membawa botol minum (tumbler) dan wadah makan sendiri ke kantin sekolah.',
                'attachment_path' => null,
                'audience' => 'all',
                'valid_from' => now()->subDays(10)->toDateString(),
                'valid_until' => now()->addMonths(3)->toDateString(),
                'is_pinned' => false,
            ],
        ];

        foreach ($announcements as $a) {
            Announcement::updateOrCreate(['title' => $a['title']], $a);
        }
    }
}
