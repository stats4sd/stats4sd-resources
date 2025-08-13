<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Traits\UsesCustomSearchOptions;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class FrnHubBrowseAll extends Component
{
    public EloquentCollection $resources;
    public int $totalResources = 0;
    public int $tagId = 406;

    public function __construct()
    {
        $this->resources = new EloquentCollection();  
    }

    public function mount($tagId = 406)
    {
        $this->tagId = $tagId;
        $this->loadResources();
    }

    public function loadResources()
    {
        $this->resources = Trove::where('is_published', 1)
            ->whereHas('tags', fn($q) => $q->where('id', $this->tagId))
            ->orderBy('created_at', 'desc')
            ->get();

        $this->totalResources = $this->resources->count();
    }

    public function render()
    {
        return view('livewire.frn-hub-browse-all', [
            'resources' => $this->resources,
            'totalResources' => $this->totalResources,
        ]);
    }
}
