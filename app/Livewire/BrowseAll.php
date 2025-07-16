<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;
use App\Traits\UsesCustomSearchOptions;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class BrowseAll extends Component
{
    use UsesCustomSearchOptions;

    public ?string $query = null;
    public EloquentCollection $resources;
    public EloquentCollection $collections;
    public SupportCollection $items;

    public SupportCollection $renderedItems; // subset of items made with custom pagination
    public int $pagesLoaded = 0;

    public int $totalResourcesAndCollections = 0;
    public int $renderedResourcesAndCollections = 0;

    public array $selectedLanguages = [];
    public array $selectedResearchMethods = [];
    public array $selectedTopics = [];

    protected $listeners = ['queryUpdated' => 'updateResults'];

    public function mount()
    {
        $this->locale = session('locale', app()->getLocale());
        app()->setLocale($this->locale);

        $this->renderedItems = collect();

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
        $resourceQuery = Trove::query()->where('is_published', 1)->pagin;
        if (!empty($this->query)) {
            $searchResults = Trove::search($this->query, $this->getSearchWithOptions())->get();
            $resourceQuery->whereIn('id', $searchResults->pluck('id'));
        }
        if (!empty($this->selectedResearchMethods)) {
            foreach ($this->selectedResearchMethods as $methodId) {
                $resourceQuery->whereHas('tags', fn($q) => $q->where('tags.id', $methodId));
            }
        }
        if (!empty($this->selectedTopics)) {
            foreach ($this->selectedTopics as $topicId) {
                $resourceQuery->whereHas('tags', fn($q) => $q->where('tags.id', $topicId));
            }
        }
        if (!empty($this->selectedLanguages)) {
            $resourceQuery->whereLocales('title', $this->selectedLanguages);
        }
        $this->resources = $resourceQuery->get();

        // Fetch Collections
        $collectionQuery = Collection::where('public', 1);
        if (!empty($this->query)) {
            $searchResults = Collection::search($this->query, $this->getSearchWithOptions())->get();
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
        $resources = $this->resources->map(fn(Trove $resource) => [
            'id' => $resource->id,
            'title' => $resource->title,
            'description' => $resource->description,
            'slug' => $resource->slug,
            'type' => 'resource',
            'troveTypes' => $resource->troveTypes,
            'tags' => $resource->themeAndTopicTags,
            'cover_image_thumb' => $resource->cover_image_thumb,
        ]);

        $collections = $this->collections->map(fn($collection) => [
            'id' => $collection->id,
            'title' => $collection->title,
            'description' => $collection->description,
            'slug' => null, // Collections use ID instead of slug
            'type' => 'collection',
            'troveTypes' => null,
            'tags' => null,
            'cover_image_thumb' => $collection->cover_image_thumb,
        ]);

        // Merge and shuffle for a mixed order
        $this->items = collect($resources)->merge($collections)->shuffle();

        $this->totalResourcesAndCollections = $this->items->count();

        // start by loading first 100
        $this->loadNextPage();

    }

    public function clearFilters()
    {
        $this->reset('query', 'selectedLanguages', 'selectedResearchMethods', 'selectedTopics');
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
        $locale = app()->getLocale();

        return Tag::whereHas('tagType', function ($query) {
            $query->where('slug', 'research-methods');
        })->orderByRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.\"$locale\"')))")->get();
    }

    public function getTopicsProperty()
    {
        $locale = app()->getLocale();

        return Tag::whereHas('tagType', function ($query) {
            $query->where('slug', 'topics');
        })->orderByRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.\"$locale\"')))")->get();
    }

    public function loadNextPage(): void
    {
        $this->renderedItems = $this->renderedItems->merge($this->items->skip($this->pagesLoaded * 100)->take(100));
        $this->pagesLoaded++;

        $this->renderedResourcesAndCollections = min([$this->pagesLoaded * 100, $this->totalResourcesAndCollections]);
    }

    public function render()
    {
        return view('livewire.browse-all', [
            'researchMethods' => $this->researchMethods,
            'topics' => $this->topics,
            'items' => $this->items,
        ]);
    }
}
