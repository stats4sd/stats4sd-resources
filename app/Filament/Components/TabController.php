<?php

namespace App\Filament\Components;

use Livewire\Attributes\Url;
use Livewire\Component;

class TabController extends Component
{
    #[Url]
    public $activeTab = null;

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->dispatch('tabChanged', $tab);
    }

    public function render()
    {
        return view('components.tab-controller');
    }
}
