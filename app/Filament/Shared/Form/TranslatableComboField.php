<?php

namespace App\Filament\Shared\Form;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

//
class TranslatableComboField extends Section
{
    // NOTES:
    // Is a wrapper around a set of fields that all populate the same value in the database, but in different languages.

    // Maybe we have 2 versions - for Section and for Fieldset

    public Closure|string|null $name = null;

    public Closure|array|null $locales = null;

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

    public function name(Closure|string|null $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        // default to the heading
        if (!$this->name) {
            return Str::lower($this->getHeading());
        }

        return $this->evaluate($this->name);
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

            $localeFields[] = $fieldType::make($this->getName() . '_' . $key)
                ->label($label);
        }

        $this->childComponents($localeFields);
        return $this;
    }
}
