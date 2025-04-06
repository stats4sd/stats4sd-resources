<?php

namespace App\Filament\Components;

use Livewire\Component;

class TabController extends Component
{
    #[Url]
    public $activeTab = null;

    public function setActiveTab($tab)
    {
        $this->activeTab = is_string($tab) ? $tab : '';
        $this->dispatch('tabChanged', $this->activeTab);
    }

    public function mount()
    {
        $this->activeTab = request()->query('activeTab') ?? null;
    }

    public function render()
    {
        return view('components.tab-controller');
    }
}
