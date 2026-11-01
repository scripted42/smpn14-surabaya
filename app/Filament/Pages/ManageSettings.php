<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?string $navigationLabel = 'Pengaturan Global';

    protected static ?string $title = 'Pengaturan Global Sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public function mount(): void
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        if (isset($settings['campaign_popup_active'])) {
            $settings['campaign_popup_active'] = (bool) $settings['campaign_popup_active'];
        }

        if (isset($settings['fonnte_notification_active'])) {
            $settings['fonnte_notification_active'] = (bool) $settings['fonnte_notification_active'];
        }

        if (!empty($settings['hero_images'])) {
            $decoded = json_decode($settings['hero_images'], true);
            $settings['hero_images'] = is_array($decoded) ? $decoded : [$settings['hero_images']];
        } elseif (!empty($settings['hero_image'])) {
            $decoded = json_decode($settings['hero_image'], true);
            $settings['hero_images'] = is_array($decoded) ? $decoded : [$settings['hero_image']];
        } else {
            $settings['hero_images'] = [];
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Pengaturan')
                    ->tabs([
                        Tabs\Tab::make('Identitas Sekolah')
                            ->icon('heroicon-o-building-library')
                            ->schema([
                                Grid::make(2)->schema([
                                    FileUpload::make('school_logo')
                                        ->label('Logo Resmi Sekolah')
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings')
                                        ->helperText('Unggah logo/lambang resmi sekolah (format PNG transparan/JPG). Logo ini tampil pada navigation bar dan footer.')
                                        ->columnSpanFull(),

                                    TextInput::make('school_name')
                                        ->label('Nama Resmi Sekolah')
                                        ->required(),

                                    TextInput::make('npsn')
                                        ->label('NPSN')
                                        ->required(),

                                    TextInput::make('school_tagline')
                                        ->label('Motto / Slogan Sekolah')
                                        ->columnSpanFull(),

                                    TextInput::make('running_announcement')
                                        ->label('Teks Berjalan Pengumuman (Running Text Ticker)')
                                        ->placeholder('Contoh: Selamat Datang di Website Resmi SMP Negeri 14 Surabaya · Informasi SPMB 2026/2027 Telah Dibuka!')
                                        ->helperText('Teks berjalan ini akan tampil di bawah navigation bar untuk pengumuman atau berita penting terkini.')
                                        ->columnSpanFull(),

                                    Textarea::make('address')
                                        ->label('Alamat Lengkap')
                                        ->rows(3)
                                        ->columnSpanFull()
                                        ->required(),

                                    TextInput::make('phone')
                                        ->label('Nomor Telepon')
                                        ->tel(),

                                    TextInput::make('email')
                                        ->label('Email Resmi')
                                        ->email(),

                                    TextInput::make('operational_hours')
                                        ->label('Jam Operasional')
                                        ->placeholder('Senin - Jumat: 06.30 - 15.30 WIB')
                                        ->columnSpanFull(),

                                    FileUpload::make('hero_images')
                                        ->label('Foto Banner Hero Beranda (Bisa Multiple / Autoslide)')
                                        ->image()
                                        ->multiple()
                                        ->reorderable()
                                        ->appendFiles()
                                        ->disk('public')
                                        ->directory('settings')
                                        ->helperText('Unggah satu atau beberapa foto banner utama (format JPG/PNG/WebP). Jika mengunggah lebih dari 1 foto, banner di beranda akan otomatis bergeser (autoslide) dengan tombol indikator titik "..." navigasi.')
                                        ->columnSpanFull(),
                                ]),
                            ]),

                        Tabs\Tab::make('Pimpinan Sekolah')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('principal_name')
                                        ->label('Nama Kepala Sekolah'),

                                    TextInput::make('principal_nip')
                                        ->label('NIP Kepala Sekolah'),

                                    Textarea::make('principal_quote')
                                        ->label('Kutipan Sambutan Kepala Sekolah di Beranda')
                                        ->rows(4)
                                        ->columnSpanFull(),
                                ]),
                            ]),

                        Tabs\Tab::make('Statistik Beranda')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('stat_students')
                                        ->label('Jumlah Siswa Aktif')
                                        ->placeholder('Contoh: 864'),

                                    TextInput::make('stat_teachers')
                                        ->label('Jumlah Tenaga Pendidik & Staf')
                                        ->placeholder('Contoh: 52'),

                                    TextInput::make('stat_classes')
                                        ->label('Jumlah Rombongan Belajar')
                                        ->placeholder('Contoh: 27 Rombel'),
                                ]),
                            ]),

                        Tabs\Tab::make('Media Sosial & Peta')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Grid::make(1)->schema([
                                    TextInput::make('social_instagram')
                                        ->label('URL Instagram Resmi')
                                        ->url(),

                                    TextInput::make('social_youtube')
                                        ->label('URL Saluran YouTube')
                                        ->url(),

                                    TextInput::make('social_facebook')
                                        ->label('URL Halaman Facebook')
                                        ->url(),

                                    Textarea::make('google_maps_embed')
                                        ->label('Tautan / Embed Google Maps')
                                        ->rows(3),
                                ]),
                            ]),

                        Tabs\Tab::make('Campaign Pop-up')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Grid::make(1)->schema([
                                    Toggle::make('campaign_popup_active')
                                        ->label('Aktifkan Pop-up Campaign')
                                        ->helperText('Tampilkan jendela popout promosi / pengumuman penting saat pengunjung membuka beranda website.'),

                                    Grid::make(2)->schema([
                                        TextInput::make('campaign_popup_badge')
                                            ->label('Label / Badge Kategori')
                                            ->placeholder('Contoh: Suara Warga · Layanan Terbuka'),

                                        Select::make('campaign_popup_frequency')
                                            ->label('Frekuensi Tampil ke Pengunjung')
                                            ->options([
                                                'once_per_session' => '1 Kali Per Sesi Browser (Disarankan)',
                                                'always' => 'Selalu Muncul Setiap Buka Beranda',
                                            ])
                                            ->default('once_per_session'),

                                        TextInput::make('campaign_popup_title')
                                            ->label('Judul Utama Campaign')
                                            ->placeholder('Contoh: Layanan Aduan, Kritik & Saran Sekolah')
                                            ->required(),

                                        TextInput::make('campaign_popup_subtitle')
                                            ->label('Sub-judul Campaign')
                                            ->placeholder('Contoh: Kanal Resmi Aspirasi & Pengaduan SMP Negeri 14 Surabaya'),
                                    ]),

                                    Textarea::make('campaign_popup_description')
                                        ->label('Deskripsi / Pesan Campaign')
                                        ->rows(4)
                                        ->placeholder('Tuliskan pesan ajakan atau informasi detail campaign...'),

                                    FileUpload::make('campaign_popup_image')
                                        ->label('Banner / Gambar Campaign (Opsional)')
                                        ->image()
                                        ->disk('public')
                                        ->directory('campaigns')
                                        ->helperText('Format JPG/PNG/WebP rasio 16:9. Jika tidak diunggah, popout akan tampil elegan dengan teks & warna resmi.'),

                                    Grid::make(3)->schema([
                                        TextInput::make('campaign_popup_btn_text')
                                            ->label('Teks Tombol Aksi (CTA)')
                                            ->placeholder('Contoh: Kirim Aspirasi / Aduan Sekarang'),

                                        TextInput::make('campaign_popup_btn_url')
                                            ->label('Tautan / URL Tombol Aksi')
                                            ->placeholder('Contoh: /aduan atau https://...'),

                                        TextInput::make('campaign_popup_secondary_text')
                                            ->label('Teks Tombol Tutup')
                                            ->placeholder('Contoh: Nanti Saja'),
                                    ]),
                                ]),
                            ]),

                        Tabs\Tab::make('Notifikasi WhatsApp')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Grid::make(1)->schema([
                                    Toggle::make('fonnte_notification_active')
                                        ->label('Aktifkan Notifikasi WhatsApp Otomatis')
                                        ->helperText('Jika diaktifkan, setiap ada laporan / aduan baru dari website, sistem akan otomatis mengirim notifikasi ke nomor WhatsApp Kesiswaan.'),

                                    Grid::make(2)->schema([
                                        TextInput::make('fonnte_token')
                                            ->label('Token API Fonnte')
                                            ->password()
                                            ->revealable()
                                            ->placeholder('Salin token dari dashboard Fonnte...')
                                            ->helperText('Dapatkan token ini dari menu Device di https://md.fonnte.com setelah menghubungkan nomor WhatsApp.'),

                                        TextInput::make('fonnte_target_phones')
                                            ->label('Nomor WhatsApp Penerima (Kesiswaan)')
                                            ->placeholder('Contoh: 08123456789 atau 08123456789,08987654321')
                                            ->helperText('Nomor yang akan menerima notifikasi setiap ada aduan masuk. Bisa lebih dari 1 nomor dengan pemisah koma (,).'),
                                    ]),
                                ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            } elseif (is_array($value)) {
                $value = json_encode(array_values(array_filter($value)));
            }
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'type' => 'text']
            );
        }

        if (isset($state['hero_images']) && is_array($state['hero_images'])) {
            $filtered = array_values(array_filter($state['hero_images']));
            $firstImage = !empty($filtered) ? $filtered[0] : '';
            Setting::updateOrCreate(
                ['key' => 'hero_image'],
                ['value' => $firstImage, 'type' => 'text']
            );
        }

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->success()
            ->send();
    }

    public function runTestWa(): void
    {
        $state = $this->form->getState();
        $targets = !empty($state['fonnte_target_phones']) ? $state['fonnte_target_phones'] : Setting::get('fonnte_target_phones');
        $token = !empty($state['fonnte_token']) ? $state['fonnte_token'] : Setting::get('fonnte_token');

        if (empty($targets)) {
            Notification::make()
                ->title('Nomor WhatsApp Penerima Belum Diisi')
                ->body('Silakan isi kolom "Nomor WhatsApp Penerima (Kesiswaan)" terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        if (empty($token)) {
            Notification::make()
                ->title('Token Fonnte Belum Diisi')
                ->body('Silakan isi Token API Fonnte dari dashboard Fonnte terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        // Simpan ke database jika belum tersimpan
        Setting::set('fonnte_token', $token);
        Setting::set('fonnte_target_phones', $targets);

        $fonnte = app(\App\Services\FonnteService::class);
        $res = $fonnte->sendMessage(
            $targets,
            "✅ *TES KONEKSI WHATSAPP BERHASIL*\n\nWebsite SMP Negeri 14 Surabaya telah terhubung dengan layanan WhatsApp Gateway Fonnte.\n\nNotifikasi pengaduan / aspirasi siswa & wali murid akan otomatis diteruskan ke nomor ini.\n\n📅 Waktu: " . now()->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') . " WIB"
        );

        if ($res['status']) {
            Notification::make()
                ->title('Pesan Uji Coba Berhasil Terkirim!')
                ->body('Silakan periksa pesan masuk di WhatsApp nomor penerima: ' . $targets)
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Gagal Mengirim Pesan WhatsApp')
                ->body($res['message'])
                ->danger()
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save')
                ->color('primary'),
        ];
    }
}
