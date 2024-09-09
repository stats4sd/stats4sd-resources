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
        $translations = $this->record->getTranslations('description');

        $data['description_en'] = isset($translations['en']) ? $this->record->getTranslation('description', 'en') : null;
        $data['description_es'] = isset($translations['es']) ? $this->record->getTranslation('description', 'es') : null;
        $data['description_fr'] = isset($translations['fr']) ? $this->record->getTranslation('description', 'fr') : null;

        $translations = $this->record->getTranslations('external_links');

        $data['external_links_en'] = isset($translations['en']) ? $this->record->getTranslation('external_links', 'en') : null;
        $data['external_links_es'] = isset($translations['es']) ? $this->record->getTranslation('external_links', 'es') : null;
        $data['external_links_fr'] = isset($translations['fr']) ? $this->record->getTranslation('external_links', 'fr') : null;

        $translations = $this->record->getTranslations('youtube_links');

        $data['youtube_links_en'] = isset($translations['en']) ? $this->record->getTranslation('youtube_links', 'en') : null;
        $data['youtube_links_es'] = isset($translations['es']) ? $this->record->getTranslation('youtube_links', 'es') : null;
        $data['youtube_links_fr'] = isset($translations['fr']) ? $this->record->getTranslation('youtube_links', 'fr') : null;

        return $data;
    }

    protected function afterSave(): void
    {

        $this->record->description = '';

        if(!is_null($this->data['description_en'])) {$this->record->setTranslation('description', 'en', $this->data['description_en']);}
        if(!is_null($this->data['description_es'])) {$this->record->setTranslation('description', 'es', $this->data['description_es']);}
        if(!is_null($this->data['description_fr'])) {$this->record->setTranslation('description', 'fr', $this->data['description_fr']);}

        $this->record->setTranslation('external_links', 'en', $this->data['external_links_en']);
        $this->record->setTranslation('external_links', 'es', $this->data['external_links_es']);
        $this->record->setTranslation('external_links', 'fr', $this->data['external_links_fr']);

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
