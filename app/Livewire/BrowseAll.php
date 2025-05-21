<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class BrowseAll extends Component
{
    public ?string $query = null;
    public EloquentCollection $resources;
    public EloquentCollection $collections;
    public SupportCollection $items;
    public int $totalResourcesAndCollections = 0;
    public array $selectedLanguages = [];
    public array $selectedResearchMethods = [];

    protected $listeners = ['queryUpdated' => 'updateResults'];

    public function mount()
    {
        $this->locale = session('locale', app()->getLocale());
        app()->setLocale($this->locale);
        $this->fetchInitialData();
    }

    public function fetchInitialData()
    {
        $this->resources = Trove::with(['troveTypes', 'themeAndTopicTags'])->where('is_published', 1)->get();
        $this->collections = Collection::where('public', 1)->get();
        $this->mergeItems();
    }

    public function updateResults($query)
    {
        if ($query !== $this->query) {
            $this->query = $query;
            $this->search();
        }
    }

    public function search()
    {
        // Fetch Resources (Trove)
        $resourceQuery = Trove::query()->where('is_published', 1);
        if (!empty($this->query)) {
            $searchResults = Trove::search($this->query)->get();
            $resourceQuery->whereIn('id', $searchResults->pluck('id'));
        }
        if (!empty($this->selectedResearchMethods)) {
            foreach ($this->selectedResearchMethods as $methodId) {
                $resourceQuery->whereHas('tags', fn ($q) => $q->where('tags.id', $methodId));
            }
        }
        if (!empty($this->selectedLanguages)) {
            $resourceQuery->whereLocales('title', $this->selectedLanguages);
        }
        $this->resources = $resourceQuery->get();

        // Fetch Collections
        $collectionQuery = Collection::where('public', 1);
        if (!empty($this->query)) {
            $searchResults = Collection::search($this->query)->get();
            $collectionQuery->whereIn('id', $searchResults->pluck('id'));
        }
        if (!empty($this->selectedLanguages)) {
            $collectionQuery->whereLocales('title', $this->selectedLanguages);
        }
        $this->collections = $collectionQuery->get();

        // Merge both into $items
        $this->mergeItems();
    }

    public function mergeItems()
    {
        $resources = $this->resources->map(fn ($resource) => [
            'id' => $resource->id,
            'title' => $resource->title,
            'description' => $resource->description,
            'slug' => $resource->slug,
            'type' => 'resource',
            'troveTypes' => $resource->troveTypes,
            'tags' => $resource->themeAndTopicTags,
        ]);

        $collections = $this->collections->map(fn ($collection) => [
            'id' => $collection->id,
            'title' => $collection->title,
            'description' => $collection->description,
            'slug' => null, // Collections use ID instead of slug
            'type' => 'collection',
            'troveTypes' => null,
            'tags' => null,
        ]);

        // Merge and shuffle for a mixed order
        $this->items = collect($resources)->merge($collections)->shuffle();
        $this->totalResourcesAndCollections = $this->items->count();
    }

    public function clearFilters()
    {
        $this->reset('query', 'selectedLanguages', 'selectedResearchMethods');
        $this->dispatch('clearSearchInput');
        $this->search();
    }

    public function clearSearch()
    {
        $this->reset('query');
        $this->dispatch('clearSearchInput');
        $this->search();
    }

    public function getResearchMethodsProperty()
    {
        return Tag::whereHas('tagType', function ($query) {
            $query->where('slug', 'themes');
        })->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.browse-all', [
            'researchMethods' => $this->researchMethods,
            'items' => $this->items
        ]);
    }
}
