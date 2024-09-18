<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentDrafts\Admin\Resources\Pages\List\Draftable;

class ListTroves extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    use Draftable;

    protected static string $resource = TroveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
