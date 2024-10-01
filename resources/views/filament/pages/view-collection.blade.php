<x-filament-panels::page
    @class([
        'fi-resource-view-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'fi-resource-record-' . $record->getKey(),
    ])
>

    @php
        $relationManagers = $this->getRelationManagers();
    @endphp

    {{ $this->infolist }}

    <div class="flex justify-start">
        <x-filament::button wire:click="$toggle('showAllTroves')" class="mt-4">
            {{ $showAllTroves ? __('Show Troves in Collection') : __('Show All Troves') }}
        </x-filament::button>
    </div>

    @if($showAllTroves)
        {{ $this->table }}
    @else
        <x-filament-panels::resources.relation-managers
            :active-locale="$activeLocale ?? null"
            :active-manager="$this->activeRelationManager ?? array_key_first($relationManagers)"
            :content-tab-label="$this->getContentTabLabel()"
            :content-tab-icon="$this->getContentTabIcon()"
            :content-tab-position="$this->getContentTabPosition()"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        >
        </x-filament-panels::resources.relation-managers>
    @endif
</x-filament-panels::page>
