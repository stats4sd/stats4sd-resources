<?php

namespace App\Filament\Components;

use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class Header extends Component
{
    #[Url]
    public string $activeTab;

    protected $listeners = ['tabChanged' => 'setActiveTab'];

    public function setActiveTab($tab)
    {
        $this->activeTab = is_string($tab) ? $tab : '';
    }

    public function render(): View
    {
        return view('components.header');
    }
}
