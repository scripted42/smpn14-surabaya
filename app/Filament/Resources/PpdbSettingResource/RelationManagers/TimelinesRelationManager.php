<?php

namespace App\Filament\Resources\PpdbSettingResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TimelinesRelationManager extends RelationManager
{
    protected static string $relationship = 'timelines';

    protected static ?string $title = 'Jadwal & Tahapan PPDB';

    protected static ?string $modelLabel = 'Tahap PPDB';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('stage_name')
                    ->label('Nama Tahapan / Jalur')
                    ->required()
                    ->maxLength(150)
                    ->placeholder('Contoh: Pendaftaran Jalur Zonasi Kelurahan')
                    ->columnSpanFull(),

                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),

                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('stage_name')
            ->columns([
                TextColumn::make('stage_name')
                    ->label('Nama Tahapan')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Tahapan'),
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
