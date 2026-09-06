<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $catAdiwiyata = Category::where('slug', 'adiwiyata-lingkungan')->first();
        $catKesiswaan = Category::where('slug', 'kegiatan-kesiswaan')->first();
        $catPrestasi = Category::where('slug', 'prestasi-penghargaan')->first();
        $catAkademik = Category::where('slug', 'akademik-kurikulum')->first();
        $catPengumuman = Category::where('slug', 'pengumuman-resmi')->first();

        $tagP5 = Tag::where('slug', 'p5')->first();
        $tagAdiwiyata = Tag::where('slug', 'adiwiyata')->first();
        $tagKurikulum = Tag::where('slug', 'kurikulum-merdeka')->first();
        $tagOSN = Tag::where('slug', 'osn-smp')->first();
        $tagSurabaya = Tag::where('slug', 'surabaya-hebat')->first();

        $articles = [
            [
                'category_id' => $catAdiwiyata?->id,
                'title' => 'SMPN 14 Surabaya Raih Penghargaan Sekolah Adiwiyata Kota Surabaya',
                'slug' => 'smpn-14-surabaya-raih-penghargaan-sekolah-adiwiyata-kota-surabaya',
                'excerpt' => 'Komitmen seluruh warga sekolah dalam pemilahan sampah, pengelolaan green house, dan pembiasaan eco-lifestyle membuahkan apresiasi bergengsi dari Pemerintah Kota Surabaya.',
                'content' => '<p>SMP Negeri 14 Surabaya kembali menorehkan prestasi membanggakan di bidang lingkungan hidup. Dalam ajang evaluasi Gerakan Peduli dan Berbudaya Lingkungan Hidup di Sekolah (PBLHS) yang diselenggarakan oleh Dinas Lingkungan Hidup Kota Surabaya, SMPN 14 Surabaya secara resmi dinobatkan sebagai <strong>Sekolah Adiwiyata Tingkat Kota Surabaya</strong>.</p><p>Kepala SMPN 14 Surabaya, Drs. H. Bambang Sutrisno, M.Pd., menyampaikan apresiasi mendalam kepada seluruh dewan guru, staf tata usaha, kader lingkungan siswa, dan orang tua wali murid yang senantiasa bergotong royong menjaga kebersihan dan kelestarian ekosistem sekolah.</p><p>"Penghargaan ini bukan tujuan akhir, melainkan pengingat bagi kita semua untuk terus konsisten mendidik karakter anak-anak agar mencintai bumi sejak dini," ujar beliau saat memimpin apel penyerahan piagam penghargaan di lapangan sekolah.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views_count' => 342,
                'tags' => [$tagAdiwiyata?->id, $tagSurabaya?->id],
            ],
            [
                'category_id' => $catKesiswaan?->id,
                'title' => 'Semarak Gelar Karya P5 Kelas VII & VIII: Kearifan Lokal Arek Suroboyo dan Kewirausahaan Kreatif',
                'slug' => 'semarak-gelar-karya-p5-kelas-vii-dan-viii-kearifan-lokal',
                'excerpt' => 'Siswa menampilkan aneka kreasi daur ulang, bazar jajanan tradisional khas Surabaya, serta pertunjukan tari kreasi daerah dalam perayaan Projek Penguatan Profil Pelajar Pancasila.',
                'content' => '<p>Halaman utama SMP Negeri 14 Surabaya disulap menjadi panggung kreativitas akbar dalam rangka Gelar Karya Projek Penguatan Profil Pelajar Pancasila (P5). Mengusung dua tema utama, yakni <em>"Kearifan Lokal Arek Suroboyo"</em> untuk kelas VII dan <em>"Kewirausahaan Berkelanjutan"</em> untuk kelas VIII, kegiatan ini berhasil memukau para undangan dan wali murid.</p><p>Berbagai stan bazar memamerkan karya inovatif siswa, mulai dari produk olahan toga hidroponik dari kebun sekolah, tas belanja daur ulang plastik, hingga kuliner semanggi dan rujak uleg modern hasil racikan kelompok siswa.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'views_count' => 520,
                'tags' => [$tagP5?->id, $tagKurikulum?->id],
            ],
            [
                'category_id' => $catPrestasi?->id,
                'title' => 'Siswa SMPN 14 Sabet Medali Emas Olimpiade Sains Pelajar Surabaya 2026',
                'slug' => 'siswa-smpn-14-sabet-medali-emas-olimpiade-sains-pelajar-surabaya',
                'excerpt' => 'Ananda Rizky Pratama dari kelas IX-A berhasil meraih juara 1 cabang IPA Terpadu dalam kompetisi sains yang diikuti lebih dari 150 SMP negeri dan swasta se-Surabaya.',
                'content' => '<p>Kabar gembira datang dari arena kompetisi sains tingkat kota. Ananda <strong>Rizky Pratama</strong>, siswa kelas IX-A SMPN 14 Surabaya, berhasil mempersembahkan Medali Emas dalam ajang Olimpiade Sains Pelajar Surabaya (OSPS) tahun 2026 untuk bidang IPA Terpadu.</p><p>Keberhasilan ini merupakan buah dari bimbingan intensif tim pembina olimpiade sekolah yang dilakukan secara rutin setiap pekan setelah jam pelajaran usai. Sekolah memberikan beasiswa pembinaan dan dukungan penuh untuk persiapan menuju tingkat provinsi Jawa Timur.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'views_count' => 615,
                'tags' => [$tagOSN?->id, $tagSurabaya?->id],
            ],
            [
                'category_id' => $catAkademik?->id,
                'title' => 'Sosialisasi Kesiapan Simulasi Asesmen Nasional Berbasis Komputer (ANBK) Kelas VIII',
                'slug' => 'sosialisasi-kesiapan-simulasi-anbk-kelas-viii',
                'excerpt' => 'Laboratorium komputer sekolah telah memenuhi standarisasi client-server dan bandwidth cadangan untuk memastikan kelancaran gladi bersih ANBK pekan mendatang.',
                'content' => '<p>Guna memastikan kelancaran pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK), tim kurikulum dan IT SMPN 14 Surabaya menggelar sosialisasi teknis kepada siswa kelas VIII yang terpilih sebagai sampel nasional.</p><p>Koordinator IT, Budi Santoso, S.Kom., menegaskan bahwa 90 unit komputer pada 3 ruang laboratorium telah selesai dikalibrasi dengan topologi jaringan gigabit dan suplai daya cadangan (UPS) untuk mengantisipasi kendala teknis saat sesi literasi dan numerasi berlangsung.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'views_count' => 280,
                'tags' => [$tagKurikulum?->id],
            ],
            [
                'category_id' => $catKesiswaan?->id,
                'title' => 'Peringatan Hari Pahlawan: Meneladani Jiwa Kejuangan Arek Surabaya Lewat Teatrikal Sejarah',
                'slug' => 'peringatan-hari-pahlawan-meneladani-jiwa-kejuangan-arek-surabaya',
                'excerpt' => 'Mengenakan busana pejuang tempo doeloe, ratusan siswa dan guru menggelar upacara khidmat dilanjutkan teatrikal peristiwa perobekan bendera di Hotel Yamato.',
                'content' => '<p>Suasana peringatan Hari Pahlawan di SMP Negeri 14 Surabaya berlangsung penuh haru dan patriotisme. Seluruh dewan guru dan perwakilan siswa mengenakan pakaian bernuansa perjuangan, pejuang kemerdekaan, dan lurik tradisional.</p><p>Acara puncak diwarnai persembahan drama teatrikal kolosal oleh ekstrakurikuler Teater dan Paskibra yang menggambarkan kegigihan para santri dan arek-arek Surabaya dalam mempertahankan kedaulatan bangsa pada pertempuran 10 November 1945.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'views_count' => 470,
                'tags' => [$tagSurabaya?->id],
            ],
            [
                'category_id' => $catPengumuman?->id,
                'title' => 'Informasi Pelaksanaan Sumatif Akhir Semester (SAS) Ganjil Tahun Ajaran 2026/2027',
                'slug' => 'informasi-pelaksanaan-sumatif-akhir-semester-sas-ganjil',
                'excerpt' => 'Jadwal, tata tertib, dan panduan teknis asesmen sumatif akhir semester ganjil bagi seluruh siswa kelas VII, VIII, dan IX SMP Negeri 14 Surabaya.',
                'content' => '<p>Diberitahukan kepada seluruh siswa dan bapak/ibu orang tua/wali murid kelas VII, VIII, dan IX, bahwa kegiatan Sumatif Akhir Semester (SAS) Ganjil Tahun Pelajaran 2026/2027 akan diselenggarakan mulai tanggal 1 Desember 2026.</p><p>Siswa diharapkan mempersiapkan diri secara optimal, menjaga kesehatan, dan mematuhi tata tertib asesmen yang telah dibagikan melalui grup komunikasi kelas masing-masing.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(25),
                'views_count' => 890,
                'tags' => [$tagKurikulum?->id],
            ],
        ];

        foreach ($articles as $art) {
            $tags = $art['tags'];
            unset($art['tags']);
            $art['author_id'] = $admin?->id;

            $news = News::updateOrCreate(['slug' => $art['slug']], $art);
            if (!empty($tags)) {
                $news->tags()->sync(array_filter($tags));
            }
        }
    }
}
