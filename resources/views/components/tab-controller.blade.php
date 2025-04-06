<div class="flex flex-col md:flex-row justify-center space-y-6 md:space-y-0 md:space-x-8 w-full items-center md:items-stretch px-4 mt-2 md:mt-4 pb-8">
    <!-- Resources tab -->
    <a href="{{ url()->current() }}?activeTab=resources"
        wire:click.prevent="setActiveTab('resources')"
        class="library-card hover-effect flex flex-col items-center 
        {{ $activeTab === 'resources' ? 'bg-black text-white' : 'bg-stats4sd-red' }}">
        <div class="flex-1 text-center">
            <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">{{ t("Resources") }}</h2>
            <p class="mb-4 md:mb-6 text-white">{{ t("Guides, tools, videos, papers and other items that we use and recommend to others.") }}</p>
        </div>
    </a>

    <!-- Collections tab -->
    <a href="?activeTab=collections"
        wire:click.prevent="setActiveTab('collections')"
        class="library-card hover-effect flex flex-col items-center 
        {{ $activeTab === 'collections' ? 'bg-black text-white' : 'bg-stats4sd-red' }}">
        <div class="flex-1 text-center">
            <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">{{ t("Collections") }}</h2>
            <p class="mb-4 md:mb-6 text-white">{{ t("A collection is a group of resources compiled together for a specific purpose.") }}</p>
        </div>
    </a>

    <!-- Browse all tab -->
    <a href="?activeTab=browse-all"
        wire:click.prevent="setActiveTab('browse-all')"
        class="library-card hover-effect flex flex-col items-center 
        {{ $activeTab === 'browse-all' ? 'bg-black text-white' : 'bg-stats4sd-red' }}">
        <div class="flex-1 text-center">
            <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">{{ t("Browse all") }}</h2>
            <p class="mb-4 md:mb-6 text-white">{{ t("Browse the full library of resources.") }}</p>
        </div>
    </a>

    <!-- Theme Pages tab -->
    <a href="?activeTab=theme-pages"
        wire:click.prevent="setActiveTab('theme-pages')"
        class="library-card hover-effect flex flex-col items-center 
        {{ $activeTab === 'theme-pages' ? 'bg-black text-white' : 'bg-stats4sd-red' }}">
        <div class="flex-1 text-center">
            <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">{{ t("Theme Pages") }}</h2>
            <p class="mb-4 md:mb-6 text-white">{{ t("Mini libraries showcasing a specific thematic area.") }}</p>
        </div>
    </a>
</div>