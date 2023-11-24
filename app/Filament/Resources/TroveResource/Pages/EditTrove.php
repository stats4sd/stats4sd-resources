<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrove extends EditRecord
{
    protected static string $resource = TroveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
