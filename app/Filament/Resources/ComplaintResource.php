<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationGroup = 'Layanan Publik';

    protected static ?string $navigationLabel = 'Aduan & Aspirasi';

    protected static ?string $modelLabel = 'Aduan & Aspirasi';

    protected static ?string $pluralModelLabel = 'Layanan Aduan & Aspirasi';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            $count = Complaint::where('status', 'pending')->count();
            return $count > 0 ? (string) $count : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Pelapor & Tiket')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('ticket_number')
                                ->label('Nomor Registrasi Tiket')
                                ->disabled(),

                            TextInput::make('name')
                                ->label('Nama Pelapor')
                                ->disabled(),

                            Toggle::make('is_anonymous')
                                ->label('Identitas Dirahasiakan (Anonim)')
                                ->disabled(),
                        ]),

                        Grid::make(4)->schema([
                            Select::make('role')
                                ->label('Kategori Pelapor')
                                ->options(Complaint::ROLES)
                                ->disabled(),

                            Select::make('category')
                                ->label('Kategori Masukan')
                                ->options(Complaint::CATEGORIES)
                                ->disabled(),

                            TextInput::make('email')
                                ->label('Email Pelapor')
                                ->disabled(),

                            TextInput::make('phone')
                                ->label('Nomor Telepon / WA')
                                ->disabled(),
                        ]),
                    ]),

                Section::make('Uraian Aspirasi / Pengaduan')
                    ->schema([
                        TextInput::make('title')
                            ->label('Perihal / Judul')
                            ->disabled()
                            ->columnSpanFull(),

                        Textarea::make('content')
                            ->label('Isi Lengkap Aduan / Aspirasi')
                            ->disabled()
                            ->rows(6)
                            ->columnSpanFull(),

                        FileUpload::make('attachment')
                            ->label('Lampiran Dokumen / Foto Bukti')
                            ->disk('public')
                            ->downloadable()
                            ->openable()
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Section::make('Tindak Lanjut & Verifikasi Sekolah')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('Status Penanganan')
                                ->options(Complaint::STATUSES)
                                ->required(),

                            Toggle::make('is_read')
                                ->label('Tandai Sudah Dibaca/Diverifikasi')
                                ->default(true),
                        ]),

                        DateTimePicker::make('responded_at')
                            ->label('Waktu Tanggapan / Tindak Lanjut')
                            ->default(now()),

                        Textarea::make('response')
                            ->label('Tanggapan Resmi Pihak Sekolah')
                            ->placeholder('Tuliskan tanggapan resmi atau hasil tindak lanjut yang dapat dilihat oleh pemohon saat mengecek tiket...')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_read')
                    ->label('Dibaca')
                    ->onColor('success')
                    ->offColor('gray'),

                TextColumn::make('ticket_number')
                    ->label('No. Tiket')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->fontFamily('mono'),

                TextColumn::make('title')
                    ->label('Perihal / Judul')
                    ->searchable()
                    ->limit(35)
                    ->wrap(),

                TextColumn::make('name')
                    ->label('Pelapor')
                    ->searchable()
                    ->description(fn (Complaint $record): string => $record->is_anonymous ? '🔒 Anonim' : ($record->role_label ?? '')),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Complaint::CATEGORIES[$state] ?? $state),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Complaint::STATUSES[$state] ?? $state),

                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(Complaint::STATUSES),

                SelectFilter::make('category')
                    ->label('Filter Kategori')
                    ->options(Complaint::CATEGORIES),

                SelectFilter::make('role')
                    ->label('Filter Pelapor')
                    ->options(Complaint::ROLES),

                TernaryFilter::make('is_read')
                    ->label('Status Baca'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Tinjau & Tindak Lanjut'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComplaints::route('/'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}

