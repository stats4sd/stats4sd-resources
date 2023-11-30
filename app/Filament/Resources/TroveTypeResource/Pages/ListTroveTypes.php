<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTroveTypes extends ListRecords
{
    protected static string $resource = TroveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
