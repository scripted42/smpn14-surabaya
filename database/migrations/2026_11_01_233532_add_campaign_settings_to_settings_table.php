<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $campaignSettings = [
            [
                'key' => 'campaign_popup_active',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'campaign_popup_badge',
                'value' => 'Suara Warga · Layanan Terbuka',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_title',
                'value' => 'Layanan Aduan, Kritik & Saran Sekolah',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_subtitle',
                'value' => 'Kanal Resmi Aspirasi & Pengaduan SMP Negeri 14 Surabaya',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_description',
                'value' => 'SMP Negeri 14 Surabaya membuka ruang keterbukaan untuk menampung aspirasi, kritik, saran, maupun aduan dari seluruh siswa, orang tua, alumni, dan masyarakat demi peningkatan mutu pendidikan dan fasilitas sekolah kita bersama.',
                'type' => 'textarea',
            ],
            [
                'key' => 'campaign_popup_image',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_btn_text',
                'value' => 'Kirim Aspirasi / Aduan Sekarang',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_btn_url',
                'value' => '/aduan',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_secondary_text',
                'value' => 'Nanti Saja',
                'type' => 'text',
            ],
            [
                'key' => 'campaign_popup_frequency',
                'value' => 'once_per_session',
                'type' => 'text',
            ],
        ];

        foreach ($campaignSettings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::whereIn('key', [
            'campaign_popup_active',
            'campaign_popup_badge',
            'campaign_popup_title',
            'campaign_popup_subtitle',
            'campaign_popup_description',
            'campaign_popup_image',
            'campaign_popup_btn_text',
            'campaign_popup_btn_url',
            'campaign_popup_secondary_text',
            'campaign_popup_frequency',
        ])->delete();
    }
};
