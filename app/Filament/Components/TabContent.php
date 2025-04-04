<?php

namespace App\Filament\Components;

use Livewire\Component;

class TabContent extends Component
{
    #[Url]
    public $activeTab = null;

    protected $listeners = ['tabChanged' => 'setActiveTab'];

    public function mount()
    {
        $this->activeTab = request()->query('activeTab') ?? null;
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
