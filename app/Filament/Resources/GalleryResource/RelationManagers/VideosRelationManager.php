<?php

namespace App\Filament\Resources\GalleryResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideosRelationManager extends RelationManager
{
    protected static string $relationship = 'videos';

    protected static ?string $title = 'Video Terkait (YouTube)';

    protected static ?string $modelLabel = 'Video';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('youtube_url')
                    ->label('Tautan Video YouTube')
                    ->url()
                    ->required()
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->columnSpanFull(),

                TextInput::make('caption')
                    ->label('Keterangan / Judul Video')
                    ->maxLength(200)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->columns([
                TextColumn::make('caption')
                    ->label('Keterangan / Judul Video')
                    ->searchable()
                    ->weight('bold')
                    ->placeholder('Video Tanpa Judul'),

                TextColumn::make('youtube_url')
                    ->label('Tautan YouTube')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn ($record) => $record->youtube_url, shouldOpenInNewTab: true)
                    ->color('primary')
                    ->limit(40),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Video YouTube'),
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
