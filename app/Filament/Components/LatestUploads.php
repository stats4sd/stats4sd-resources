<?php

namespace App\Filament\Components;

use App\Models\Trove;
use Livewire\Component;
use App\Models\Collection;

class LatestUploads extends Component
{
    public $latestResources;
    public $latestCollection;

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
