<?php

namespace App\Filament\Components;

use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;

class ResourcesResults extends Component
{
    public $resources;
    public $totalResources;
    public $collections;
    public $totalCollections;
    public bool $expandedResults = false;

    public function mount()
    {
        $this->resources = Trove::all();
        $this->totalResources = $this->resources->count();
        $this->collections = Collection::all();
        $this->totalCollections = $this->collections->count();
    }

    public function render()
    {
        return view('components.resources-results', [
            'resources' => $this->resources,
            'totalResources' => $this->totalResources,
            'collections' => $this->collections,
            'totalCollections' => $this->totalCollections,
        ]);
    }
}
