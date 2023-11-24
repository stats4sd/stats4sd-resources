<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTroves extends ListRecords
{
    protected static string $resource = TroveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
