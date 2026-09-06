<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtracurricularResource\Pages;
use App\Models\Extracurricular;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;

    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Ekstrakurikuler';

    protected static ?string $modelLabel = 'Ekstrakurikuler';

    protected static ?string $pluralModelLabel = 'Ekstrakurikuler Sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Informasi Ekstrakurikuler')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Ekstrakurikuler')
                                ->required()
                                ->maxLength(150),

                            TextInput::make('coach_name')
                                ->label('Nama Pembina / Pelatih')
                                ->maxLength(150)
                                ->placeholder('Contoh: Coach Rahmat Hidayat, S.Pd.'),

                            TextInput::make('schedule_text')
                                ->label('Jadwal Latihan')
                                ->maxLength(150)
                                ->placeholder('Contoh: Setiap Jumat, 14.00 - 16.00 WIB'),

                            TextInput::make('sort_order')
                                ->label('Urutan Tampil')
                                ->numeric()
                                ->default(0),

                            Textarea::make('description')
                                ->label('Uraian Kegiatan & Manfaat')
                                ->rows(4)
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Section::make('Foto Kegiatan')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('photo')
                                ->label('Foto Ekstrakurikuler')
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
                    ->defaultImageUrl(asset('images/default-extra.jpg')),

                TextColumn::make('name')
                    ->label('Nama Ekstrakurikuler')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('coach_name')
                    ->label('Pembina')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('schedule_text')
                    ->label('Jadwal')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
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
            'index' => Pages\ListExtracurriculars::route('/'),
            'create' => Pages\CreateExtracurricular::route('/create'),
            'edit' => Pages\EditExtracurricular::route('/{record}/edit'),
        ];
    }
}
