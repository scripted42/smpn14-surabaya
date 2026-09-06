<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Teacher;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Guru & Staf';

    protected static ?string $modelLabel = 'Guru & Staf';

    protected static ?string $pluralModelLabel = 'Guru & Staf Sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Biodata Guru & Staf')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap & Gelar')
                                ->required()
                                ->maxLength(150),

                            TextInput::make('nip')
                                ->label('NIP / NUPTK')
                                ->maxLength(50)
                                ->placeholder('Contoh: 19680512 199403 1 005'),

                            TextInput::make('position')
                                ->label('Jabatan')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Contoh: Kepala Sekolah, Guru Matematika, Staf TU'),

                            TextInput::make('subject')
                                ->label('Mata Pelajaran yang Diampu')
                                ->maxLength(100)
                                ->placeholder('Contoh: Matematika (Kelas IX)'),

                            Textarea::make('bio')
                                ->label('Profil Singkat / Riwayat Singkat')
                                ->rows(4)
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Section::make('Foto & Tampilan')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('photo')
                                ->label('Foto Profil')
                                ->collection('photo')
                                ->image()
                                ->imageEditor()
                                ->avatar(),

                            Toggle::make('is_structural')
                                ->label('Tampilkan di Struktur Organisasi')
                                ->helperText('Aktifkan jika menduduki jabatan struktural (Kepala Sekolah, Wakil, Kaur TU)')
                                ->default(false),

                            TextInput::make('sort_order')
                                ->label('Urutan Tampil')
                                ->numeric()
                                ->default(0)
                                ->helperText('Angka lebih kecil tampil lebih awal'),
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
                    ->circular()
                    ->defaultImageUrl(asset('images/default-avatar.jpg')),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->placeholder('-'),

                IconColumn::make('is_structural')
                    ->label('Struktural')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('primary')
                    ->falseColor('gray')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_structural')
                    ->label('Jabatan Struktural'),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
