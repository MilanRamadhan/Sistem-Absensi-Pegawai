<?php

namespace App\Filament\Resources\IzinTidakHadirResource\Pages;

use App\Filament\Resources\IzinTidakHadirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIzinTidakHadir extends EditRecord
{
    protected static string $resource = IzinTidakHadirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
