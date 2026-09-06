<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita & Artikel';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Konten Berita')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Berita')
                                ->required()
                                ->maxLength(200)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->maxLength(220)
                                ->unique(News::class, 'slug', ignoreRecord: true),

                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name', fn (Builder $query) => $query->where('type', 'news'))
                                ->preload()
                                ->searchable()
                                ->required(),

                            Select::make('tags')
                                ->label('Tag Terkait')
                                ->relationship('tags', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable(),

                            Textarea::make('excerpt')
                                ->label('Ringkasan Singkat')
                                ->rows(3)
                                ->maxLength(300)
                                ->placeholder('Ringkasan berita untuk pratinjau kartu...'),

                            RichEditor::make('content')
                                ->label('Isi Berita Lengkap')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Grid::make(1)->schema([
                        Section::make('Media & Publikasi')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('cover')
                                    ->label('Cover Gambar')
                                    ->collection('cover')
                                    ->image()
                                    ->imageEditor(),

                                Select::make('status')
                                    ->label('Status Publikasi')
                                    ->options([
                                        'draft' => 'Draft',
                                        'scheduled' => 'Terjadwal',
                                        'published' => 'Terbit',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->live(),

                                DateTimePicker::make('published_at')
                                    ->label('Waktu Publikasi')
                                    ->visible(fn (Get $get) => in_array($get('status'), ['scheduled', 'published']))
                                    ->required(fn (Get $get) => $get('status') === 'scheduled')
                                    ->default(now()),
                            ]),

                        Section::make('Optimasi SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(160),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->maxLength(300),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Cover')
                    ->collection('cover')
                    ->circular()
                    ->defaultImageUrl(asset('images/default-news.jpg')),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(60)
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'scheduled',
                        'success' => 'published',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'scheduled' => 'Terjadwal',
                        'published' => 'Terbit',
                        default => $state,
                    }),

                TextColumn::make('published_at')
                    ->label('Waktu Terbit')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('views_count')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Filter Kategori'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Terjadwal',
                        'published' => 'Terbit',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
