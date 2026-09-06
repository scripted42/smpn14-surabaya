<?php

namespace Database\Seeders;

use App\Models\PpdbFaq;
use App\Models\PpdbSetting;
use App\Models\PpdbTimeline;
use Illuminate\Database\Seeder;

class PpdbSeeder extends Seeder
{
    public function run(): void
    {
        $ppdb = PpdbSetting::updateOrCreate(
            ['academic_year' => '2026/2027'],
            [
                'is_open' => true,
                'academic_year' => '2026/2027',
                'intro_text' => 'Penerimaan Peserta Didik Baru (PPDB) SMP Negeri di Kota Surabaya dilaksanakan secara terpusat, transparan, dan akuntabel melalui sistem daring resmi Dinas Pendidikan Kota Surabaya. SMP Negeri 14 Surabaya siap melayani konsultasi dan verifikasi dokumen calon peserta didik sesuai petunjuk teknis yang berlaku.',
                'registration_url' => 'https://ppdb.surabaya.go.id',
                'requirements' => '<h4>Ketentuan Umum Pendaftaran:</h4><ol><li>Telah lulus Sekolah Dasar (SD/MI) atau bentuk lain yang sederajat, dibuktikan dengan Surat Keterangan Lulus (SKL) atau Ijazah.</li><li>Berusia setinggi-tingginya 15 (lima belas) tahun pada tanggal 1 Juli tahun berjalan.</li><li>Memiliki Kartu Keluarga (KK) Kota Surabaya yang diterbitkan paling singkat 1 (satu) tahun sebelum tanggal pendaftaran PPDB.</li><li>Melakukan proses validasi data dan nilai rapor SD secara daring melalui portal resmi PPDB Kota Surabaya.</li><li>Bagi pendaftar Jalur Prestasi Perlombaan, wajib melampirkan sertifikat/piagam kejuaraan yang telah dilegalisasi dan terverifikasi oleh dinas terkait.</li></ol>',
            ]
        );

        // Timelines
        $timelines = [
            [
                'stage_name' => 'Uji Coba Sistem & Validasi Data Nilai Rapor',
                'start_date' => '2026-05-15',
                'end_date' => '2026-05-25',
                'sort_order' => 1,
            ],
            [
                'stage_name' => 'Pendaftaran Jalur Afirmasi Kategori Mitra Warga & Inklusi',
                'start_date' => '2026-06-08',
                'end_date' => '2026-06-11',
                'sort_order' => 2,
            ],
            [
                'stage_name' => 'Pendaftaran Jalur Perpindahan Tugas Orang Tua / Wali',
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-14',
                'sort_order' => 3,
            ],
            [
                'stage_name' => 'Pendaftaran Jalur Prestasi (Nilai Rapor & Piagam Lomba)',
                'start_date' => '2026-06-16',
                'end_date' => '2026-06-20',
                'sort_order' => 4,
            ],
            [
                'stage_name' => 'Pendaftaran Jalur Zonasi Kelurahan & Radius Zonasi Kota',
                'start_date' => '2026-06-23',
                'end_date' => '2026-06-27',
                'sort_order' => 5,
            ],
            [
                'stage_name' => 'Pengumuman Hasil Seleksi & Daftar Ulang Siswa Baru',
                'start_date' => '2026-06-29',
                'end_date' => '2026-07-02',
                'sort_order' => 6,
            ],
        ];

        PpdbTimeline::where('ppdb_setting_id', $ppdb->id)->delete();
        foreach ($timelines as $t) {
            $t['ppdb_setting_id'] = $ppdb->id;
            PpdbTimeline::create($t);
        }

        // FAQs
        $faqs = [
            [
                'question' => 'Apakah pendaftaran calon siswa baru dilakukan langsung di gedung SMPN 14 Surabaya?',
                'answer' => 'Tidak. Pendaftaran seluruh jalur PPDB SMP Negeri di Surabaya dilaksanakan secara mandiri dan online melalui situs resmi Dinas Pendidikan Kota Surabaya di https://ppdb.surabaya.go.id. Sekolah menyediakan Posko Layanan Informasi dan Pendampingan bagi orang tua yang mengalami kendala teknis jaringan.',
                'sort_order' => 1,
            ],
            [
                'question' => 'Jalur apa saja yang dibuka dalam PPDB SMP Negeri di Surabaya?',
                'answer' => 'Terdapat 4 jalur utama: (1) Jalur Afirmasi bagi keluarga pra-sejahtera dan anak berkebutuhan khusus, (2) Jalur Perpindahan Tugas Orang Tua/Wali, (3) Jalur Prestasi (Prestasi Nilai Rapor dan Prestasi Perlombaan Akademik/Non-akademik), dan (4) Jalur Zonasi (berdasarkan jarak domisili kartu keluarga ke sekolah).',
                'sort_order' => 2,
            ],
            [
                'question' => 'Berapa batasan usia maksimal untuk calon siswa baru jenjang SMP?',
                'answer' => 'Calon peserta didik baru jenjang SMP berusia setinggi-tingginya 15 (lima belas) tahun terhitung pada tanggal 1 Juli 2026.',
                'sort_order' => 3,
            ],
            [
                'question' => 'Apakah calon siswa yang ber-KK luar Kota Surabaya bisa mendaftar di SMPN 14 Surabaya?',
                'answer' => 'Bisa, melalui kuota Jalur Perpindahan Tugas Orang Tua (bagi orang tua yang dipindahtugaskan dinas ke Surabaya) atau kuota Jalur Prestasi Perlombaan sesuai ketentuan proporsi persentase yang ditetapkan oleh Dinas Pendidikan Kota Surabaya.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Apakah ada biaya pendaftaran atau pungutan uang gedung di SMPN 14 Surabaya?',
                'answer' => 'Sama sekali TIDAK ADA biaya pendaftaran (Gratis 100%). Seluruh proses PPDB SMP Negeri di Kota Surabaya dibiayai oleh APBD Pemerintah Kota Surabaya.',
                'sort_order' => 5,
            ],
        ];

        PpdbFaq::where('ppdb_setting_id', $ppdb->id)->delete();
        foreach ($faqs as $f) {
            $f['ppdb_setting_id'] = $ppdb->id;
            PpdbFaq::create($f);
        }
    }
}
