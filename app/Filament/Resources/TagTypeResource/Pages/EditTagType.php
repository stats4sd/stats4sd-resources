<?php

namespace App\Filament\Resources\TagTypeResource\Pages;

use App\Filament\Resources\TagTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagType extends EditRecord
{
    protected static string $resource = TagTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
