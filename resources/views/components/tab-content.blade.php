<div class="px-6">
    @if ($activeTab === 'resources')
        <livewire:resources/>
    @elseif ($activeTab === 'collections')
        <livewire:collections/>
    @elseif ($activeTab === 'browse-all')
        <livewire:browse-all/>
    @elseif ($activeTab === 'theme-pages')
        <livewire:theme-pages/>
    @endif
</div>