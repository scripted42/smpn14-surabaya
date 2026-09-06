<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
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

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationGroup = 'Media';

    protected static ?string $navigationLabel = 'Testimoni & Moderasi';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimoni';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Isi Testimoni')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(150),

                            Select::make('role')
                                ->label('Status / Peran')
                                ->options([
                                    'siswa' => 'Peserta Didik (Siswa)',
                                    'orang_tua' => 'Orang Tua / Wali Murid',
                                    'alumni' => 'Alumni SMPN 14',
                                ])
                                ->required(),

                            Select::make('status')
                                ->label('Status Moderasi')
                                ->options([
                                    'pending' => 'Menunggu Persetujuan (Pending)',
                                    'approved' => 'Disetujui (Tampil di Web)',
                                    'rejected' => 'Ditolak (Tidak Tampil)',
                                ])
                                ->default('pending')
                                ->required(),

                            Textarea::make('content')
                                ->label('Isi Pesan Testimoni')
                                ->required()
                                ->rows(5)
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(2),

                    Section::make('Foto Profil')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('photo')
                                ->label('Foto Pengirim')
                                ->collection('photo')
                                ->image()
                                ->imageEditor()
                                ->avatar(),
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

                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'siswa' => 'Siswa',
                        'orang_tua' => 'Orang Tua',
                        'alumni' => 'Alumni',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'siswa' => 'info',
                        'orang_tua' => 'warning',
                        'alumni' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('content')
                    ->label('Isi Testimoni')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Kirim')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Moderasi')
                    ->options([
                        'pending' => 'Pending (Moderasi)',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending'),
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'siswa' => 'Siswa',
                        'orang_tua' => 'Orang Tua',
                        'alumni' => 'Alumni',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== 'approved')
                    ->action(fn ($record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== 'rejected')
                    ->action(fn ($record) => $record->update(['status' => 'rejected'])),

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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
