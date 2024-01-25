<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollection extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translations = $this->record->getTranslations('title');

        $data['title_en'] = isset($translations['en']) ? $this->record->getTranslation('title', 'en') : null;
        $data['title_es'] = isset($translations['es']) ? $this->record->getTranslation('title', 'es') : null;
        $data['title_fr'] = isset($translations['fr']) ? $this->record->getTranslation('title', 'fr') : null;

        $translations = $this->record->getTranslations('description');

        $data['description_en'] = isset($translations['en']) ? $this->record->getTranslation('description', 'en') : null;
        $data['description_es'] = isset($translations['es']) ? $this->record->getTranslation('description', 'es') : null;
        $data['description_fr'] = isset($translations['fr']) ? $this->record->getTranslation('description', 'fr') : null;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->title = '';
        $this->record->description = '';

        if(!is_null($this->data['title_en'])){
            $this->record->setTranslation('title', 'en', $this->data['title_en']);
        }

        if(!is_null($this->data['title_es'])){
            $this->record->setTranslation('title', 'es', $this->data['title_es']);
        }

        if(!is_null($this->data['title_fr'])){
            $this->record->setTranslation('title', 'fr', $this->data['title_fr']);
        }

        if(!is_null($this->data['description_en'])){
            $this->record->setTranslation('description', 'en', $this->data['description_en']);
        }

        if(!is_null($this->data['description_es'])){
            $this->record->setTranslation('description', 'es', $this->data['description_es']);
        }

        if(!is_null($this->data['description_fr'])){
            $this->record->setTranslation('description', 'fr', $this->data['description_fr']);
        }

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
