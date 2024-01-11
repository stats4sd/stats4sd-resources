<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCollection extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
    
}
