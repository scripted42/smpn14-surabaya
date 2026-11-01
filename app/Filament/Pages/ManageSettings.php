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

                                    FileUpload::make('hero_image')
                                        ->label('Foto Banner Hero Beranda')
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings')
                                        ->helperText('Format JPG/PNG/WebP rasio 4:3. Foto ini akan tampil sebagai banner visual utama di halaman depan beranda sekolah.')
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
            }
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'type' => 'text']
            );
        }

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->success()
            ->send();
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
