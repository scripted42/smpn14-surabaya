<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Prestasi Siswa';

    protected static ?string $modelLabel = 'Prestasi';

    protected static ?string $pluralModelLabel = 'Prestasi & Penghargaan';

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Informasi Prestasi')
                        ->schema([
                            TextInput::make('title')
                                ->label('Nama Kejuaraan / Prestasi')
                                ->required()
                                ->maxLength(200)
                                ->placeholder('Contoh: Juara 1 FLS2N Tari Tradisional Surabaya'),

                            TextInput::make('student_name')
                                ->label('Nama Siswa / Tim Pemenang')
                                ->maxLength(150)
                                ->placeholder('Kosongkan jika prestasi atas nama institusi sekolah'),

                            Select::make('category_id')
                                ->label('Kategori Prestasi')
                                ->relationship('category', 'name', fn (Builder $query) => $query->where('type', 'achievement'))
                                ->preload()
                                ->searchable(),

                            Select::make('level')
                                ->label('Tingkat Kejuaraan')
                                ->options([
                                    'sekolah' => 'Tingkat Sekolah',
                                    'kecamatan' => 'Tingkat Kecamatan',
                                    'kota' => 'Tingkat Kota (Surabaya)',
                                    'provinsi' => 'Tingkat Provinsi (Jawa Timur)',
                                    'nasional' => 'Tingkat Nasional',
                                    'internasional' => 'Tingkat Internasional',
                                ])
                                ->required()
                                ->default('kota'),

                            TextInput::make('year')
                                ->label('Tahun Perolehan')
                                ->numeric()
                                ->default((int) date('Y'))
                                ->required(),

                            Textarea::make('description')
                                ->label('Deskripsi / Uraian Prestasi')
                                ->rows(4)
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Section::make('Foto Dokumentasi')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('photo')
                                ->label('Foto Penghargaan / Piala')
                                ->collection('photo')
                                ->image()
                                ->imageEditor(),
                        ])
                        ->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')
                    ->label('Foto')
                    ->collection('photo')
                    ->square()
                    ->defaultImageUrl(asset('images/default-achievement.jpg')),

                TextColumn::make('title')
                    ->label('Prestasi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('student_name')
                    ->label('Siswa / Tim')
                    ->searchable()
                    ->placeholder('Institusi SMPN 14'),

                TextColumn::make('level')
                    ->label('Tingkat')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'internasional' => 'danger',
                        'nasional' => 'warning',
                        'provinsi' => 'success',
                        'kota' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'sekolah' => 'Sekolah',
                        'kecamatan' => 'Kecamatan',
                        'kota' => 'Kota',
                        'provinsi' => 'Provinsi',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name', fn (Builder $query) => $query->where('type', 'achievement')),
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
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
