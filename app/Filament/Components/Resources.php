<?php

namespace App\Filament\Components;

use App\Models\Tag;
use App\Models\Trove;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Resources extends Component
{
    public ?string $query = null;
    public EloquentCollection $resources;
    public int $totalResources = 0;
    public array $selectedLanguages = [];
    public array $selectedResearchMethods = [];

    protected $listeners = ['queryUpdated' => 'updateResults'];

    public function __construct()
    {
        $this->resources = new EloquentCollection();  
    }

    public function getResearchMethodsProperty()
    {
        return Tag::whereHas('tagType', function ($query) {
            $query->where('slug', 'themes');
        })->orderBy('name')->get();
    }

    public function search()
    {
        // Troves 
            // Step 1: Start with a base query for resources
            $query = Trove::where('is_published', 1);
        
            // Step 2: Apply research methods filters if selected
            if (!empty($this->selectedResearchMethods)) {
                foreach ($this->selectedResearchMethods as $methodId) {
                    $query->whereHas('tags', function ($q) use ($methodId) {
                        $q->where('tags.id', $methodId);
                    });
                }
            }
        
            // Step 3: Apply language filters if selected
            if (!empty($this->selectedLanguages)) {
                ray('langfilter selected');
                $query->whereLocales('title', $this->selectedLanguages);
            }

            // Step 4: Apply search term if there's a query
            // Step 5: Retrieve filtered troves
            if (!empty($this->query)) {
                $searchResults = Trove::search($this->query)->get();
                if ($searchResults->isNotEmpty()) {
                    $ids = $searchResults->pluck('id');
                    $query->whereIn('id', $ids);
                    $this->resources = $query->get();
                    $this->totalResources = $this->resources->count();

                } else {
                    // No search results, return empty for resources
                    $this->resources = new EloquentCollection();
                    $this->totalResources = 0;
                }
            }
            else {
                $this->resources = $query->get();
                $this->totalResources = $this->resources->count();
            }
    }

    public function updateResults($query)
    {
        if ($query !== $this->query) {
            $this->query = $query;
            $this->search();
        }
    }
    
    public function clearFilters()
    {
        $this->reset('query', 'selectedLanguages', 'selectedResearchMethods');
        $this->dispatch('clearSearchInput');
    }

    public function clearSearch()
    {
        $this->reset('query');
        $this->dispatch('clearSearchInput');
        $this->search();
    }

    public function render()
    {
        return view('components.resources', [
            'researchMethods' => $this->researchMethods
        ]);
    }
}
