<?php

namespace App\Filament\Components;

use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class TabController extends Component
{
    #[Url]
    public ?string $activeTab = null;

    public function setActiveTab($tab): void
    {
        $this->activeTab = $tab;
        $this->dispatch('tabChanged', $tab);
    }

    public function render(): View
    {
        return view('components.tab-controller');
    }
}
