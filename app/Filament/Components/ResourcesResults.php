<?php

namespace App\Filament\Components;

use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;

class ResourcesResults extends Component
{
    public $query; 
    public $resources;
    public $totalResources;
    public $collections;
    public $totalCollections;
    public bool $expandedResourceResults = false;
    public bool $expandedCollectionResults = false;

    public function mount()
    {
        $this->fetchInitialData();
    }

    public function fetchInitialData()
    {
        // Load all resources and collections initially
        $this->resources = Trove::all();
        $this->totalResources = $this->resources->count();

        $this->collections = Collection::all();
        $this->totalCollections = $this->collections->count();
    }

    public function updatedQuery()
    {
        // When the query is updated, call the search function
        $this->search();
    }

    public function search()
    {
        if (trim($this->query) === '') {
            // If no search query - show all
            $this->fetchInitialData();
        } else {
            // Do the search
            $this->resources = Trove::search($this->query)->get();
            $this->totalResources = $this->resources->count();

            $this->collections = Collection::search($this->query)->get();
            $this->totalCollections = $this->collections->count();
        }
    }

    public function clearSearch()
    {
        $this->reset('query');
        $this->fetchInitialData();
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
