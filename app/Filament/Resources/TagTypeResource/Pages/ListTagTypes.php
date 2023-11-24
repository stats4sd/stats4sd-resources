<?php

namespace App\Filament\Resources\TagTypeResource\Pages;

use App\Filament\Resources\TagTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTagTypes extends ListRecords
{
    protected static string $resource = TagTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
