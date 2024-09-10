<?php

namespace App\Filament\Shared\Form;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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

            // if the record exists, and has a translation for this field, return the translations to populate the state
            if ($record && $record->{$this->getName()} && method_exists($record, 'getTranslations')) {
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

    /*
     * Set the child field. The given field will be duplicated for each locale.
     * @param Closure|string|Field $childField - either the FQDN of a Field class, or a Field instance. If a field instance is given its properties will be copied for each locale (except for name, label, and statePath)
     */
    public function childField(Closure|string|Field $childField = null): static
    {
        // check that $childField is a class that extends Form Field
        $childField = $this->evaluate($childField);

        if (is_string($childField) &&
            (!class_exists($childField) || !is_subclass_of($childField, Field::class)
            )
        ) {
            abort(501, 'Invalid field type: The childField for this TranslatableComboField must be a FQDN of a class that extends Filament\Forms\Components\Field (e.g. `TextInput::class`');
        }

        $localeFields = [];

        // create a field for each locale
        foreach ($this->getLocales() as $locale => $localeLabel) {


            // clone the childField properties
            if ($childField instanceof Field) {
                $newField = clone $childField;
                // set the name and label based on the locale.
                $newField->label($localeLabel);
                $newField->statePath($locale);
            } else {
                // create a new field instance using the given FQDN
                $newField = $childField::make($locale)
                    ->label($localeLabel);
            }

            $localeFields[] = $newField;
        }

        $this->childComponents($localeFields);
        return $this;
    }

    public
    static function checkParent($childField, $parentClass, $newField): Field
    {

        if ($parentClass === Field::class) {
            return $newField;
        }

        $parentClass = new $parentClass($newField->name);
        foreach ($parentClass as $key => $value) {
            if ($key !== 'name' && $key !== 'label' && $key !== 'statePath') {
                $newField->{$key} = $childField->{$key};
            }
        }

        if ($nextParentClass = get_parent_class($parentClass)) {
            $newField = self::checkParent($parentClass, $nextParentClass, $newField);
        }

        return $newField;

    }

}
