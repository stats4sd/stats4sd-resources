<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Trove;
use Livewire\Component;
use App\Traits\UsesCustomSearchOptions;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class IfaHubBrowseResources extends Component
{
    use UsesCustomSearchOptions;

    public ?string $query = null;
    public EloquentCollection $resources;
    public int $totalResources = 0;
    public array $selectedLanguages = [];
    public array $selectedLevels = [];
    public array $selectedInstitutions = [];
    public array $selectedTopics = [];
    protected $listeners = ['queryUpdated' => 'updateResults'];

    public function __construct()
    {
        $this->resources = new EloquentCollection();
    }

    public function getLevelsProperty()
    {
        return Tag::whereIn('id', [945, 946, 947])->get();
    }

    public function getInstitutionsProperty()
    {
        $institutions = Tag::whereIn('id', [940, 971, 984, 1010, 1009])->get();

        $locations = [
            940 => t('USA'),
            971 => t('Mexico'),
            1010 => t('Spain'),
            1008 => t('Mexico'),
            1009 => t('Norway'),
        ];

        return $institutions->map(function ($inst) use ($locations) {
            $inst->location = $locations[$inst->id] ?? null;
            return $inst;
        });
    }

    public function getTopicsProperty()
    {
        return Tag::whereIn('id', [935, 109, 955, 956, 957, 933, 959, 934, 961, 962, 963, 964, 942, 966, 967, 38, 151, 364, 936, 941, 943, 944, 969, 970, 975, 975, 976, 977, 978, 979, 987, 988, 989, 990, 991, 993, 994, 995, 996, 997, 998, 999, 1000, 1003, 1004, 1005, 1006])->get();
    }
      public function getFeatureTopicsProperty()
    {
        return Tag::whereIn('id', [935, 109, 957, 956, 955, 933, 959, 961, 962, 963, 964, 942, 966, 967, 960])->get();
    }

    public function mount()
    {
        $this->fetchInitialData();
    }

    public function fetchInitialData()
    {
         $this->resources = Trove::where('organisation_id', 2)
            ->whereHas('tags')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->totalResources = $this->resources->count();
    }

    public function search()
    {
        // Step 1: Start with a base query for resources
        $query = Trove::where('organisation_id', 2)
                    ->whereHas('tags');

        // // Step 2: Apply levels filters if selected
        if (!empty($this->selectedLevels)) {
            foreach ($this->selectedLevels as $levelId) {
                $query->whereHas('tags', function ($q) use ($levelId) {
                    $q->where('tags.id', $levelId);
                });
            }
        }

        // // Step 3: Apply institutions filters if selected
        if (!empty($this->selectedInstitutions)) {
            foreach ($this->selectedInstitutions as $institutionId) {
                $query->whereHas('tags', function ($q) use ($institutionId) {
                    $q->where('tags.id', $institutionId);
                });
            }
        }

        // // Step 4: Apply topics filters if selected
        if (!empty($this->selectedTopics)) {
            foreach ($this->selectedTopics as $topicId) {
                $query->whereHas('tags', function ($q) use ($topicId) {
                    $q->where('tags.id', $topicId);
                });
            }
        }

        // Step 5: Apply language filters if selected
        if (!empty($this->selectedLanguages)) {
            ray('langfilter selected');
            $query->whereLocales('title', $this->selectedLanguages);
        }

        // Step 6: Apply search term if there's a query
        // Step 7: Retrieve filtered troves
        if (!empty($this->query)) {
            $searchResults = Trove::search($this->query, $this->getSearchWithOptions())->get();
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
        $this->reset('query', 'selectedLanguages', 'selectedLevels', 'selectedInstitutions', 'selectedTopics');
        $this->dispatch('clearSearchInput');
        $this->search();
    }

    public function clearSearch()
    {
        $this->reset('query');
        $this->dispatch('clearSearchInput');
        $this->search();
    }

    public function render()
    {
        return view('livewire.ifa-hub-browse-resources', [
            'resources' => $this->resources,
            'totalResources' => $this->totalResources,
        ]);
    }
}
