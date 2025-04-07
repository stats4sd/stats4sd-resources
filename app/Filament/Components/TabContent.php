<?php

namespace App\Filament\Components;

use Livewire\Attributes\Url;
use Livewire\Component;

class TabContent extends Component
{
    #[Url]
    public $activeTab = null;

    protected $listeners = ['tabChanged' => 'setActiveTab'];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('components.tab-content');
    }
}
