<?php

namespace App\Filament\Resources\IzinTidakHadirResource\Pages;

use App\Filament\Resources\IzinTidakHadirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIzinTidakHadirs extends ListRecords
{
    protected static string $resource = IzinTidakHadirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
