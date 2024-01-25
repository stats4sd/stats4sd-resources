<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTroveType extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TroveTypeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translations = $this->record->getTranslations('label');

        $data['label_en'] = isset($translations['en']) ? $this->record->getTranslation('label', 'en') : null;
        $data['label_es'] = isset($translations['es']) ? $this->record->getTranslation('label', 'es') : null;
        $data['label_fr'] = isset($translations['fr']) ? $this->record->getTranslation('label', 'fr') : null;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->label = '';

        if(!is_null($this->data['label_en'])){
            $this->record->setTranslation('label', 'en', $this->data['label_en']);
        }

        if(!is_null($this->data['label_es'])){
            $this->record->setTranslation('label', 'es', $this->data['label_es']);
        }

        if(!is_null($this->data['label_fr'])){
            $this->record->setTranslation('label', 'fr', $this->data['label_fr']);
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
