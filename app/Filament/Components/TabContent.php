<?php

namespace App\Filament\Components;

use Livewire\Component;

class TabContent extends Component
{
    public $activeTab = null;

    protected $listeners = ['tabChanged' => 'setActiveTab'];

    public function mount()
    {
        $this->activeTab = null;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function render()
    {
        return view('components.tab-content');
    }
}
