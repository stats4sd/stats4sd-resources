<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTroveType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    
    protected static string $resource = TroveTypeResource::class;

    protected static bool $canCreateAnother = false;

    protected function afterCreate(): void
    {
        $language = $this->data['label_language'];

        if($language!=='en'){

            $this->record->setTranslations('label', [$language => $this->record->label]);
            $this->record->forgetTranslation('label', 'en');
        
        }

        $this->record->save();
    }

}
