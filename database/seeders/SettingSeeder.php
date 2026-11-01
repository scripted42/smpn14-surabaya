<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'school_name', 'value' => 'SMP Negeri 14 Surabaya', 'type' => 'text'],
            ['key' => 'npsn', 'value' => '20532552', 'type' => 'text'],
            ['key' => 'school_tagline', 'value' => 'Cerdas Berkarakter, Unggul Berprestasi, dan Berbudaya Lingkungan', 'type' => 'text'],
            ['key' => 'school_logo', 'value' => 'images/logo-smpn14.png', 'type' => 'text'],
            ['key' => 'address', 'value' => 'Jl. Jurang Kuping, Kel. Benowo, Kec. Pakal, Kota Surabaya, Jawa Timur 60195', 'type' => 'textarea'],
            ['key' => 'phone', 'value' => '(031) 7405230', 'type' => 'text'],
            ['key' => 'email', 'value' => 'info@smpn14surabaya.sch.id', 'type' => 'text'],
            ['key' => 'principal_name', 'value' => 'Drs. H. Bambang Sutrisno, M.Pd.', 'type' => 'text'],
            ['key' => 'principal_nip', 'value' => '19680512 199403 1 005', 'type' => 'text'],
            ['key' => 'principal_quote', 'value' => 'Kami berkomitmen mewujudkan lingkungan belajar yang ramah anak, mengembangkan literasi digital, memperkuat karakter Profil Pelajar Pancasila, dan mencetak generasi muda Surabaya yang siap bersaing.', 'type' => 'textarea'],
            ['key' => 'stat_students', 'value' => '864', 'type' => 'text'],
            ['key' => 'stat_teachers', 'value' => '52', 'type' => 'text'],
            ['key' => 'stat_classes', 'value' => '27 Rombel', 'type' => 'text'],
            ['key' => 'running_announcement', 'value' => 'Selamat Datang di Website Resmi SMP Negeri 14 Surabaya · Informasi Resmi SPMB Tahun Pelajaran 2026/2027 Telah Dibuka! · Layanan Konsultasi & Meja Bantuan Buka di Ruang Tata Usaha Setiap Hari Kerja', 'type' => 'text'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/smpn14surabaya', 'type' => 'text'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@smpn14surabaya', 'type' => 'text'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/smpn14surabaya', 'type' => 'text'],
            ['key' => 'operational_hours', 'value' => 'Senin - Jumat: 06.30 - 15.30 WIB', 'type' => 'text'],
            ['key' => 'google_maps_embed', 'value' => 'https://maps.google.com/maps?q=SMP+Negeri+14+Surabaya&t=&z=15&ie=UTF8&iwloc=&output=embed', 'type' => 'textarea'],
            ['key' => 'campaign_popup_active', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'campaign_popup_badge', 'value' => 'Suara Warga · Layanan Terbuka', 'type' => 'text'],
            ['key' => 'campaign_popup_title', 'value' => 'Layanan Aduan, Kritik & Saran Sekolah', 'type' => 'text'],
            ['key' => 'campaign_popup_subtitle', 'value' => 'Kanal Resmi Aspirasi & Pengaduan SMP Negeri 14 Surabaya', 'type' => 'text'],
            ['key' => 'campaign_popup_description', 'value' => 'SMP Negeri 14 Surabaya membuka ruang keterbukaan untuk menampung aspirasi, kritik, saran, maupun aduan demi peningkatan mutu pendidikan dan fasilitas sekolah.', 'type' => 'textarea'],
            ['key' => 'campaign_popup_image', 'value' => '', 'type' => 'text'],
            ['key' => 'campaign_popup_btn_text', 'value' => 'Kirim Aspirasi / Aduan Sekarang', 'type' => 'text'],
            ['key' => 'campaign_popup_btn_url', 'value' => '/aduan', 'type' => 'text'],
            ['key' => 'campaign_popup_secondary_text', 'value' => 'Nanti Saja', 'type' => 'text'],
            ['key' => 'campaign_popup_frequency', 'value' => 'once_per_session', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
