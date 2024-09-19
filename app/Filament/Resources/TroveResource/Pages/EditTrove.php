<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;
use Guava\FilamentDrafts\Admin\Actions\SaveDraftAction;
use Guava\FilamentDrafts\Admin\Resources\Pages\Edit\Draftable;

class EditTrove extends EditRecord
{
    // Use custom draftable trait because of https://github.com/GuavaCZ/filament-drafts/issues/15;
    use \App\Filament\Draftable\Pages\Edit\Draftable;

    protected static string $resource = TroveResource::class;
    public static string|Alignment $formActionsAlignment = Alignment::End;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // override the default draftable form actions
    protected function getFormActions(): array
    {
        return [
            SaveDraftAction::make(),
            $this->getCancelFormAction(),
        ];
    }
}
