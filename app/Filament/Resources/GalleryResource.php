<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\GalleryResource\RelationManagers\VideosRelationManager;
use App\Models\Gallery;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationGroup = 'Media';

    protected static ?string $navigationLabel = 'Galeri Foto & Video';

    protected static ?string $modelLabel = 'Galeri';

    protected static ?string $pluralModelLabel = 'Album Galeri';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Informasi Album')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Album Galeri')
                                ->required()
                                ->maxLength(150)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->maxLength(170)
                                ->unique(Gallery::class, 'slug', ignoreRecord: true),

                            DatePicker::make('event_date')
                                ->label('Tanggal Acara / Kegiatan')
                                ->default(now()),

                            Textarea::make('description')
                                ->label('Deskripsi Kegiatan')
                                ->rows(4)
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Section::make('Sampul Album')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('cover')
                                ->label('Foto Sampul (Cover)')
                                ->collection('cover')
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
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Sampul')
                    ->collection('cover')
                    ->square()
                    ->defaultImageUrl(asset('images/default-gallery.jpg')),

                TextColumn::make('title')
                    ->label('Judul Album')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('photos_count')
                    ->label('Jumlah Foto')
                    ->counts('photos')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),

                TextColumn::make('videos_count')
                    ->label('Jumlah Video')
                    ->counts('videos')
                    ->badge()
                    ->color('warning')
                    ->alignCenter(),
            ])
            ->defaultSort('event_date', 'desc')
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
        return [
            PhotosRelationManager::class,
            VideosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
