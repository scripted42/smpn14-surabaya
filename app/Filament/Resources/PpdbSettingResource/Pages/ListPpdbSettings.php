<?php

namespace App\Filament\Resources\PpdbSettingResource\Pages;

use App\Filament\Resources\PpdbSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPpdbSettings extends ListRecords
{
    protected static string $resource = PpdbSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
