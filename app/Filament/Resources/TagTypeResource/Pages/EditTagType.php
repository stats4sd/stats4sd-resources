<?php

namespace App\Filament\Resources\TagTypeResource\Pages;

use App\Filament\Resources\TagTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagType extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TagTypeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translations = $this->record->getTranslations('label');

        $data['label_en'] = isset($translations['en']) ? $this->record->getTranslation('label', 'en') : null;
        $data['label_es'] = isset($translations['es']) ? $this->record->getTranslation('label', 'es') : null;
        $data['label_fr'] = isset($translations['fr']) ? $this->record->getTranslation('label', 'fr') : null;

        $translations = $this->record->getTranslations('description');

        $data['description_en'] = isset($translations['en']) ? $this->record->getTranslation('description', 'en') : null;
        $data['description_es'] = isset($translations['es']) ? $this->record->getTranslation('description', 'es') : null;
        $data['description_fr'] = isset($translations['fr']) ? $this->record->getTranslation('description', 'fr') : null;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->label = '';
        $this->record->description = '';

        if(!is_null($this->data['label_en'])){
            $this->record->setTranslation('label', 'en', $this->data['label_en']);
        }

        if(!is_null($this->data['label_es'])){
            $this->record->setTranslation('label', 'es', $this->data['label_es']);
        }

        if(!is_null($this->data['label_fr'])){
            $this->record->setTranslation('label', 'fr', $this->data['label_fr']);
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
