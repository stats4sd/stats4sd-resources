<?php

namespace App\Filament\Resources\TagTypeResource\Pages;

use App\Filament\Resources\TagTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ManageRecords;

class ListTagTypes extends ManageRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = TagTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
