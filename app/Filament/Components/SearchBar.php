<?php

namespace App\Filament\Components;

use Livewire\Component;

class SearchBar extends Component
{
    public string $query = '';
    public ?string $inputClass = null;
    public ?bool $scrollOnSearch = false;
    private bool $searchInProgress = false;
    private string $previousQuery = '';

    protected $listeners = [
        'clearSearchInput' => 'clearQuery', 
        'queryUpdated' => 'updateQuery', 
        'searchAndScroll' => 'search',
    ];
    
    public function search()
    {
        if ($this->query === $this->previousQuery) {
            return;
        }

        $this->dispatch('queryUpdated', $this->query);

        if ($this->scrollOnSearch) {
            $this->dispatch('homeSearchScroll');
        }

        $this->previousQuery = $this->query;

    }

    public function updateQuery($query)
    {
        if ($query === $this->query) {
            return;
        }

        $this->query = $query;
    }

    public function clearQuery()
    {
        $this->reset('query');
    }

    public function render()
    {
        return view('components.search-bar');
    }
}