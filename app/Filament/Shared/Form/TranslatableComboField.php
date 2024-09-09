<?php

namespace App\Filament\Shared\Form;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Concerns\CanBeCollapsed;
use Filament\Support\Concerns\HasDescription;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Filament\Support\Concerns\HasHeading;
use Filament\Support\Concerns\HasIcon;
use Filament\Support\Concerns\HasIconColor;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Color\Contrast;

//
class TranslatableComboField extends Field implements Contracts\HasHeaderActions, Contracts\HasFooterActions
{

    use Concerns\CanBeCollapsed;
    use Concerns\CanBeCompacted;
    use Concerns\HasFooterActions;
    use Concerns\HasHeaderActions;
    use HasDescription;
    use HasExtraAlpineAttributes;
    use HasHeading;
    use HasIcon;
    use HasIconColor;

    // NOTES:
    // Is a wrapper around a set of fields that all populate the same value in the database, but in different languages.


    protected string $view = 'filament.shared.forms.translatable-combo-field';

    public Closure|array|null $locales = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(function ($livewire, $state) {
            $record = $livewire->getRecord();

            if ($record->{$this->getName()} && method_exists($record, 'getTranslations')) {
                return $record->getTranslations($this->getName());
            }

            return $state;
        });

    }

    public function locales(Closure|array|null $locales): static
    {
        $this->locales = $locales;

        return $this;
    }

    public function getLocales(): array
    {
        // default to the app locales
        if (!$this->locales) {
            return config('app.locales');
        }

        return $this->evaluate($this->locales);
    }

    public function fieldType(Closure|string $fieldType = null): static
    {
        // check that $fieldType is a class that extends Form Field
        $fieldType = $this->evaluate($fieldType);

        if (is_string($fieldType) &&
            (!class_exists($fieldType) || !is_subclass_of($fieldType, Field::class)
            )
        ) {
            abort(501, 'Invalid field type: The fieldType for this TranslatableComboField must be a FQDN of a class that extends Filament\Forms\Components\Field (e.g. `TextInput::class`');
        }

        $localeFields = [];

        // create a field for each locale
        foreach ($this->getLocales() as $key => $label) {

            $localeFields[] = $fieldType::make($key)
                ->label($label);
        }

        $this->childComponents($localeFields);
        return $this;
    }


}
