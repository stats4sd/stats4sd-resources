<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTroveType extends EditRecord
{
    protected static string $resource = TroveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
