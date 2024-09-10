<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ManageRecords;

class ListTags extends ManageRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalHeading(''),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
