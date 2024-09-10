<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrove extends EditRecord
{
    protected static string $resource = TroveResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $translations = $this->record->getTranslations('youtube_links');

        $data['youtube_links_en'] = isset($translations['en']) ? $this->record->getTranslation('youtube_links', 'en') : null;
        $data['youtube_links_es'] = isset($translations['es']) ? $this->record->getTranslation('youtube_links', 'es') : null;
        $data['youtube_links_fr'] = isset($translations['fr']) ? $this->record->getTranslation('youtube_links', 'fr') : null;

        return $data;
    }

    protected function afterSave(): void
    {


        $this->record->setTranslation('youtube_links', 'en', $this->data['youtube_links_en']);
        $this->record->setTranslation('youtube_links', 'es', $this->data['youtube_links_es']);
        $this->record->setTranslation('youtube_links', 'fr', $this->data['youtube_links_fr']);

        $this->record->save();
    }

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
}
