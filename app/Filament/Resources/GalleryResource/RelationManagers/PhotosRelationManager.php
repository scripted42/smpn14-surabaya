<?php

namespace App\Filament\Resources\GalleryResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Koleksi Foto Album';

    protected static ?string $modelLabel = 'Foto';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo_path')
                    ->label('Unggah Foto')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('galleries')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('caption')
                    ->label('Keterangan Foto / Caption')
                    ->maxLength(200)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(asset('images/default-gallery.jpg')),

                TextColumn::make('caption')
                    ->label('Keterangan')
                    ->searchable()
                    ->wrap()
                    ->placeholder('Tanpa keterangan'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Foto'),
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
}
