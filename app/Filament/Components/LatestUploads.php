<?php

namespace App\Filament\Components;

use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class LatestUploads extends Component
{
    public EloquentCollection $latestResources;
    public ?Collection $latestCollection;

    public function mount()
    {
        $this->latestResources = Trove::latest()->take(2)->get();
        $this->latestCollection = Collection::latest()->first();
    }

    public function render()
    {
        return view('components.latest-uploads');
    }
}
