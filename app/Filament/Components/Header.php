<?php

namespace App\Filament\Components;

use Livewire\Component;

class Header extends Component
{
    #[Url]
    public $activeTab;

    protected $listeners = ['tabChanged' => 'setActiveTab'];

    public function mount()
    {
        $this->activeTab = request()->query('activeTab') ?? '';
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = is_string($tab) ? $tab : '';
        $this->dispatch('tabChanged', $this->activeTab);
    }

    public function render()
    {
        return view('components.header');
    }
}
