<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTag extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TagResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translations = $this->record->getTranslations('name');

        $data['name_en'] = isset($translations['en']) ? $this->record->getTranslation('name', 'en') : null;
        $data['name_es'] = isset($translations['es']) ? $this->record->getTranslation('name', 'es') : null;
        $data['name_fr'] = isset($translations['fr']) ? $this->record->getTranslation('name', 'fr') : null;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->name = '';

        if(!is_null($this->data['name_en'])){
            $this->record->setTranslation('name', 'en', $this->data['name_en']);
        }

        if(!is_null($this->data['name_es'])){
            $this->record->setTranslation('name', 'es', $this->data['name_es']);
        }

        if(!is_null($this->data['name_fr'])){
            $this->record->setTranslation('name', 'fr', $this->data['name_fr']);
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
