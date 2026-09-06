<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Sejarah Sekolah',
                'slug' => 'sejarah',
                'content' => '<h3>Lintas Sejarah SMP Negeri 14 Surabaya</h3><p>SMP Negeri 14 Surabaya didirikan untuk memenuhi kebutuhan akses pendidikan menengah pertama yang berkualitas bagi masyarakat di kawasan Surabaya Selatan. Berawal dari bangunan sederhana dengan beberapa ruang kelas rintisan, kini sekolah telah bertransformasi menjadi salah satu institusi pendidikan negeri terfavorit di Surabaya.</p><p>Dengan dukungan Pemerintah Kota Surabaya dan Dinas Pendidikan, sarana prasarana terus ditingkatkan, mulai dari laboratorium berbasis teknologi modern, ruang multimedia, hingga pencapaian predikat Sekolah Adiwiyata.</p>',
                'meta_title' => 'Sejarah SMP Negeri 14 Surabaya',
                'meta_description' => 'Mengenal sejarah panjang, dedikasi, dan transformasi SMP Negeri 14 Surabaya dalam mencetak generasi cerdas berkarakter.',
                'is_published' => true,
            ],
            [
                'title' => 'Visi dan Misi',
                'slug' => 'visi-misi',
                'content' => '<h3>Visi Sekolah</h3><blockquote class="lead">"Terwujudnya Insan yang Beriman dan Bertakwa, Unggul dalam Prestasi, Berkarakter Profil Pelajar Pancasila, serta Berbudaya Lingkungan Hidup."</blockquote><h3>Misi Sekolah</h3><ol><li>Menumbuhkembangkan penghayatan dan pengamalan ajaran agama yang dianut sebagai landasan moral dan budi pekerti luhur.</li><li>Melaksanakan pembelajaran berdiferensiasi yang aktif, inovatif, kreatif, dan menyenangkan melalui Kurikulum Merdeka.</li><li>Membina potensi minat, bakat, dan penalaran ilmiah siswa guna meraih prestasi di bidang akademik maupun non-akademik hingga tingkat nasional.</li><li>Mewujudkan lingkungan sekolah yang bersih, hijau, sehat, asri, dan bebas dari sampah plastik sekali pakai (Gerakan Adiwiyata).</li><li>Membangun kemitraan yang harmonis dan transparan antara sekolah, orang tua siswa, alumni, dan masyarakat luas.</li></ol>',
                'meta_title' => 'Visi dan Misi SMP Negeri 14 Surabaya',
                'meta_description' => 'Visi, misi, dan nilai-nilai luhur penyelenggaraan pendidikan di SMP Negeri 14 Surabaya.',
                'is_published' => true,
            ],
            [
                'title' => 'Tata Tertib Peserta Didik',
                'slug' => 'tata-tertib',
                'content' => '<h3>Tata Tertib & Norma Kehidupan Siswa</h3><p>Tata tertib ini disusun guna menciptakan suasana belajar mengajar yang kondusif, aman, nyaman, dan berkeadilan bagi seluruh peserta didik kelas VII, VIII, dan IX SMPN 14 Surabaya.</p><h4>1. Kehadiran dan Waktu Sekolah</h4><ul><li>Hari kegiatan belajar mengajar: Senin hingga Jumat.</li><li>Bel tanda masuk berbunyi pukul 06.30 WIB. Siswa hadir selambat-lambatnya pukul 06.25 WIB untuk mengikuti pembiasaan literasi dan doa bersama.</li><li>Siswa yang terlambat wajib melapor ke guru piket sebelum memasuki kelas.</li></ul><h4>2. Seragam dan Kerapian</h4><ul><li>Senin & Selasa: Seragam Putih Biru lengkap dengan dasi, topi upacara, ikat pinggang hitam, dan sepatu hitam polos.</li><li>Rabu: Seragam Khas Batik SMPN 14 Surabaya.</li><li>Kamis: Seragam Pramuka Lengkap.</li><li>Jumat: Pakaian Olahraga / Baju Muslim / Seragam Khas Surabaya.</li></ul>',
                'meta_title' => 'Tata Tertib Siswa SMP Negeri 14 Surabaya',
                'meta_description' => 'Pedoman kedisiplinan dan tata tertib siswa jenjang SMP Negeri 14 Surabaya.',
                'is_published' => true,
            ],
            [
                'title' => 'Kurikulum & Program Akademik',
                'slug' => 'kurikulum',
                'content' => '<h3>Kurikulum Merdeka SMP Negeri 14 Surabaya</h3><p>SMP Negeri 14 Surabaya menerapkan <strong>Kurikulum Merdeka</strong> secara utuh pada jenjang kelas VII, VIII, dan IX. Pembelajaran difokuskan pada penguasaan materi esensial, pengembangan karakter kepribadian, serta penguatan kompetensi literasi dan numerasi abad 21.</p><h4>Struktur Program Unggulan</h4><ul><li><strong>Projek Penguatan Profil Pelajar Pancasila (P5):</strong> Alokasi 20-30% jam pelajaran dialokasikan untuk projek berbasis kehidupan nyata (Kearifan Lokal, Gaya Hidup Berkelanjutan, dan Suara Demokrasi).</li><li><strong>Program Literasi Digital & Numerasi:</strong> Pembiasaan membaca 15 menit setiap pagi sebelum jam pertama, didukung perpustakaan digital e-book.</li><li><strong>Program Bimbingan Prestasi (Klinik Sains & Bahasa):</strong> Bimbingan intensif sore hari untuk persiapan kompetisi OSN, FLS2N, dan O2SN.</li></ul>',
                'meta_title' => 'Kurikulum Merdeka SMP Negeri 14 Surabaya',
                'meta_description' => 'Informasi struktur kurikulum merdeka dan program unggulan akademik jenjang SMP.',
                'is_published' => true,
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
