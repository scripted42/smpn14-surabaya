<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbSettingResource\Pages;
use App\Filament\Resources\PpdbSettingResource\RelationManagers\FaqsRelationManager;
use App\Filament\Resources\PpdbSettingResource\RelationManagers\TimelinesRelationManager;
use App\Models\PpdbSetting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PpdbSettingResource extends Resource
{
    protected static ?string $model = PpdbSetting::class;

    protected static ?string $navigationGroup = 'PPDB';

    protected static ?string $navigationLabel = 'Pengaturan PPDB / SPMB';

    protected static ?string $modelLabel = 'Pengaturan PPDB';

    protected static ?string $pluralModelLabel = 'Pengaturan PPDB';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Status Utama PPDB')
                    ->description('Kontrol banner dan akses pengumuman PPDB di situs publik')
                    ->schema([
                        Toggle::make('is_open')
                            ->label('Pendaftaran PPDB Sedang DIBUKA')
                            ->helperText('Jika aktif, banner merah PPDB akan muncul mencolok di beranda')
                            ->default(false)
                            ->onColor('danger')
                            ->offColor('gray'),
                    ]),

                Section::make('Informasi & Jalur PPDB')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('academic_year')
                                ->label('Tahun Ajaran')
                                ->required()
                                ->maxLength(20)
                                ->placeholder('Contoh: 2026/2027'),

                            TextInput::make('registration_url')
                                ->label('Tautan Portal Resmi PPDB')
                                ->url()
                                ->placeholder('https://ppdb.surabaya.go.id')
                                ->helperText('Mengarahkan ke portal resmi Dinas Pendidikan Kota Surabaya'),
                        ]),

                        RichEditor::make('intro_text')
                            ->label('Sambutan & Panduan Umum PPDB')
                            ->columnSpanFull(),

                        RichEditor::make('requirements')
                            ->label('Ketentuan & Persyaratan Berkas')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('academic_year')
                    ->label('Tahun Ajaran')
                    ->weight('bold')
                    ->sortable(),

                ToggleColumn::make('is_open')
                    ->label('Status Dibuka')
                    ->onColor('danger')
                    ->offColor('gray'),

                TextColumn::make('registration_url')
                    ->label('Portal Tautan')
                    ->limit(35)
                    ->url(fn ($record) => $record->registration_url, true),

                TextColumn::make('timelines_count')
                    ->label('Tahapan')
                    ->counts('timelines')
                    ->badge()
                    ->color('info'),

                TextColumn::make('faqs_count')
                    ->label('FAQ')
                    ->counts('faqs')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TimelinesRelationManager::class,
            FaqsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbSettings::route('/'),
            'create' => Pages\CreatePpdbSetting::route('/create'),
            'edit' => Pages\EditPpdbSetting::route('/{record}/edit'),
        ];
    }
}
