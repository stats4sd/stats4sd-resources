<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ManageRecords;

class ListTroveTypes extends ManageRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = TroveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading(''),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
