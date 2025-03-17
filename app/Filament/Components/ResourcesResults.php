<?php

namespace App\Filament\Components;

use App\Models\Tag;
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
    public $selectedFilterType = 'themes'; // Default filter  displayed
    public $filtersExpanded = false; // Hide extra filters at start
    public $tags = [];
    public $selectedLanguages = [];
    public $selectedTags = [
        'themes' => [],
        'topics' => [],
        'keywords' => [],
        'locations' => [],
    ];

    protected $listeners = ['queryUpdated' => 'updateResults'];

    public function mount()
    {
        $this->fetchInitialData();
        $this->updateTags();
    }

    public function toggleFilters()
    {
        $this->filtersExpanded = true;
    }

    public function setSelectedFilterType($filter)
    {
        $this->selectedFilterType = $filter;
        $this->updateTags();
    }

    public function toggleTagSelection($tagId)
    {
        $selectedTagsArray = $this->getSelectedTagsArray();

        ray('Before toggling tag', [
            'selectedTags' => $selectedTagsArray,
            'selectedFilterType' => $this->selectedFilterType
        ]);

        if (in_array($tagId, $selectedTagsArray)) {
            // Remove tag if already selected
            $selectedTagsArray = array_diff($selectedTagsArray, [$tagId]);
        } else {
            // Add tag to selection
            $selectedTagsArray[] = $tagId;
        }

        // Trigger search
        $this->search();
    }

    private function getSelectedTagsArray()
    {
        switch ($this->selectedFilterType) {
            case 'themes':
                return $this->selectedThemes;
            case 'topics':
                return $this->selectedTopics;
            case 'keywords':
                return $this->selectedKeywords;
            case 'locations':
                return $this->selectedLocations;
            default:
                return [];
        }
    }

    public function updateTags()
    {
        // Get tags for the selected filter type (themes, topics, etc.)
        $this->tags = Tag::whereHas('tagType', function ($query) {
            $query->where('slug', $this->selectedFilterType);
        })->get();
    }

    public function fetchInitialData()
    {
        // Load all resources and collections initially
        $this->resources = Trove::where('is_published', 1)->get();
        $this->totalResources = $this->resources->count();

        $this->collections = Collection::where('public', 1)->get();
        $this->totalCollections = $this->collections->count();
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
        // Troves 
            // Step 1: Start with a base query for resources
            $query = Trove::query();
        
            // Step 2: Apply tag filters if selected
            $hasTags = false;
        
            foreach (['themes', 'topics', 'keywords', 'locations'] as $tagType) {
                if (!empty($this->selectedTags[$tagType])) {
                    $hasTags = true;
                    foreach ($this->selectedTags[$tagType] as $tagId) {
                        $query->whereHas('tags', function ($q) use ($tagId) {
                            $q->where('tags.id', $tagId);
                        });
                    }
                }
            }
        
            // Step 3: Apply language filters if selected
            if (!empty($this->selectedLanguages)) {
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
                    $this->resources = collect();
                    $this->totalResources = 0;
                }
            }
            else {
                $this->resources = $query->get();
                $this->totalResources = $this->resources->count();
            }
        
        // Collections
            // Step 1: Start with a base query for collections
            $collectionsQuery = Collection::where('public', 1);
        
            // Step 2: Apply search term if there's a query
            if (!empty($this->query)) {
                $collectionResults = Collection::search($this->query)->get();
                if ($collectionResults->isNotEmpty()) {
                    $collectionIds = $collectionResults->pluck('id');
                    $collectionsQuery->whereIn('id', $collectionIds);
                } else {
                    // No matching collections found, return empty collections
                    $this->collections = collect();
                    $this->totalCollections = 0;
                    return;
                }
            }
        
            // Step 3: Apply tag filters if selected
            if ($hasTags) {
                $collectionsQuery->whereHas('troves', function ($trovesQuery) {
                    foreach (['themes', 'topics', 'keywords', 'locations'] as $tagType) {
                        if (!empty($this->selectedTags[$tagType])) {
                            $trovesQuery->whereHas('tags', function ($tagsQuery) use ($tagType) {
                                $tagsQuery->where(function ($orQuery) use ($tagType) {
                                    foreach ($this->selectedTags[$tagType] as $tagId) {
                                        $orQuery->orWhere('tags.id', $tagId);
                                    }
                                });
                            });
                        }
                    }
                });
            }
        
            // Step 4: Apply language filters if selected
            if (!empty($this->selectedLanguages)) {
                $collectionsQuery->whereLocales('title', $this->selectedLanguages);
            }
        
            // Step 5: Retrieve filtered collections
            $this->collections = $collectionsQuery->get();
            $this->totalCollections = $this->collections->count();
    }
    
    public function clearSearch()
    {
        $this->reset('query');
        $this->dispatch('clearSearchInput');
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
