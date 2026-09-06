<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\GalleryVideo;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Peringatan Hari Pahlawan 10 November 2026',
                'slug' => 'peringatan-hari-pahlawan-10-november-2026',
                'description' => 'Dokumentasi khidmatnya upacara bendera dan pergelaran drama teatrikal perjuangan Arek-Arek Suroboyo oleh siswa dan guru SMPN 14.',
                'event_date' => '2026-11-10',
                'photos' => [
                    ['caption' => 'Upacara bendera khidmat dengan busana pejuang tempo doeloe', 'sort_order' => 1],
                    ['caption' => 'Teatrikal perobekan bendera oleh ekstrakurikuler teater', 'sort_order' => 2],
                    ['caption' => 'Penyerahan cinderamata kepada sesepuh veteran Surabaya', 'sort_order' => 3],
                ],
                'videos' => [
                    ['youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'caption' => 'Video Kilas Balik Peringatan Hari Pahlawan SMPN 14'],
                ],
            ],
            [
                'title' => 'Gelar Karya Projek Penguatan Profil Pelajar Pancasila (P5)',
                'slug' => 'gelar-karya-projek-penguatan-profil-pelajar-pancasila-p5',
                'description' => 'Pameran kreasi inovasi daur ulang limbah, seni rupa kearifan lokal, dan pentas musik tradisional hasil projek siswa kelas VII dan VIII.',
                'event_date' => '2026-10-24',
                'photos' => [
                    ['caption' => 'Stan pameran kerajinan daur ulang limbah plastik kelas VII-B', 'sort_order' => 1],
                    ['caption' => 'Pentas tari kreasi Arek Suroboyo di panggung terbuka', 'sort_order' => 2],
                    ['caption' => 'Bazar kewirausahaan jajanan sehat nusantara', 'sort_order' => 3],
                ],
                'videos' => [
                    ['youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'caption' => 'Highlights Perayaan P5 Bhinneka Tunggal Ika'],
                ],
            ],
            [
                'title' => 'Aksi Lingkungan Hidup & Panen Hidroponik Green House',
                'slug' => 'aksi-lingkungan-hidup-dan-panen-hidroponik',
                'description' => 'Kader Adiwiyata SMPN 14 memanen sayur selada dan pakcoy hidroponik, serta aksi pilah sampah serentak di lingkungan sekolah.',
                'event_date' => '2026-09-18',
                'photos' => [
                    ['caption' => 'Panen perdana selada hidroponik bersama Kepala Sekolah', 'sort_order' => 1],
                    ['caption' => 'Edukasi pembuatan pupuk kompos cair dari sisa dedaunan', 'sort_order' => 2],
                ],
                'videos' => [],
            ],
            [
                'title' => 'Latihan Dasar Kepemimpinan Siswa (LDKS) Pengurus OSIS',
                'slug' => 'latihan-dasar-kepemimpinan-siswa-ldks-osis',
                'description' => 'Pembekalan karakter kepemimpinan, manajemen organisasi, kedisiplinan, dan kerja sama tim bagi pengurus OSIS dan MPK periode baru.',
                'event_date' => '2026-08-30',
                'photos' => [
                    ['caption' => 'Pelatihan baris-berbaris dan kedisiplinan lapangan', 'sort_order' => 1],
                    ['caption' => 'Simulasi perumusan program kerja OSIS masa bakti 2026/2027', 'sort_order' => 2],
                ],
                'videos' => [],
            ],
        ];

        foreach ($galleries as $g) {
            $photos = $g['photos'];
            $videos = $g['videos'];
            unset($g['photos'], $g['videos']);

            $gallery = Gallery::updateOrCreate(['slug' => $g['slug']], $g);

            // Insert photos
            foreach ($photos as $p) {
                GalleryPhoto::firstOrCreate(
                    ['gallery_id' => $gallery->id, 'caption' => $p['caption']],
                    [
                        'photo_path' => 'galleries/photo-default.jpg',
                        'sort_order' => $p['sort_order'],
                    ]
                );
            }

            // Insert videos
            foreach ($videos as $v) {
                GalleryVideo::firstOrCreate(
                    ['gallery_id' => $gallery->id, 'youtube_url' => $v['youtube_url']],
                    [
                        'caption' => $v['caption'],
                    ]
                );
            }
        }
    }
}
