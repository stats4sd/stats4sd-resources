<?php

namespace App\Filament\Components;

use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class TabContent extends Component
{
    #[Url]
    public ?string $activeTab = null;

    protected $listeners = ['tabChanged' => 'setActiveTab'];

    public function setActiveTab($tab): void
    {
        $this->activeTab = $tab;
    }

    public function render(): View
    {
        return view('components.tab-content');
    }
}
