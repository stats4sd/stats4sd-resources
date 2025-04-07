<?php

namespace App\Filament\Components;

use Livewire\Attributes\Url;
use Livewire\Component;

class TabController extends Component
{
    #[Url]
    public ?string $activeTab = null;

    public function setActiveTab($tab)
    {
        $this->activeTab = is_string($tab) ? $tab : '';

        $this->dispatch('tabChanged', $this->activeTab);
    }


    public function render()
    {
        return view('components.tab-controller');
    }
}
