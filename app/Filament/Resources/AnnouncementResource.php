<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Pengumuman';

    protected static ?string $modelLabel = 'Pengumuman';

    protected static ?string $pluralModelLabel = 'Pengumuman Sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Isi Pengumuman')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Pengumuman')
                                ->required()
                                ->maxLength(200),

                            RichEditor::make('content')
                                ->label('Uraian Pengumuman')
                                ->required()
                                ->columnSpanFull(),

                            FileUpload::make('attachment_path')
                                ->label('Lampiran Berkas (PDF / Dokumen)')
                                ->disk('public')
                                ->directory('announcements')
                                ->acceptedFileTypes([
                                    'application/pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                ])
                                ->helperText('Menerima format dokumen PDF, DOC, atau DOCX')
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Section::make('Atribut & Masa Berlaku')
                        ->schema([
                            Select::make('audience')
                                ->label('Sasaran Pengumuman')
                                ->options([
                                    'all' => 'Semua Warga Sekolah',
                                    'student' => 'Khusus Peserta Didik',
                                    'parent' => 'Khusus Orang Tua / Wali',
                                    'staff' => 'Khusus Guru & Staf',
                                ])
                                ->default('all')
                                ->required(),

                            DatePicker::make('valid_from')
                                ->label('Berlaku Mulai')
                                ->default(now()),

                            DatePicker::make('valid_until')
                                ->label('Berlaku Sampai')
                                ->helperText('Kosongkan jika berlaku permanen'),

                            Toggle::make('is_pinned')
                                ->label('Sematkan di Atas (Pin)')
                                ->helperText('Pengumuman prioritas akan tampil paling atas')
                                ->default(false),
                        ])
                        ->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_pinned')
                    ->label('Pin')
                    ->boolean()
                    ->trueIcon('heroicon-s-bookmark')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Judul Pengumuman')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('audience')
                    ->label('Sasaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'all' => 'Semua',
                        'student' => 'Siswa',
                        'parent' => 'Orang Tua',
                        'staff' => 'Guru & Staf',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'all' => 'primary',
                        'student' => 'info',
                        'parent' => 'warning',
                        'staff' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('valid_from')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('valid_until')
                    ->label('Berakhir')
                    ->date('d M Y')
                    ->placeholder('Permanen')
                    ->sortable(),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('audience')
                    ->options([
                        'all' => 'Semua',
                        'student' => 'Siswa',
                        'parent' => 'Orang Tua',
                        'staff' => 'Guru & Staf',
                    ]),
                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Pengumuman Disematkan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
