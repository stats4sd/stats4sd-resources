<div class="relative">
    <!-- Background Image-->
    <img src="images/crops.png" alt="Background Image" class="absolute inset-0 w-full h-[35vh] sm:h-[30vh] object-cover filter brightness-50 z-0">

    <!-- Overlay Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-[35vh] sm:h-[30vh] px-4 text-white">
        <div class="max-w-3xl w-full mx-auto text-center">
            <!-- Heading -->
            <div class="font-bold text-4xl sm:text-5xl md:text-5xl">
                {{ t("Stats4SD Resources Library") }}
            </div>

            <!-- Description -->
            <div class="mt-6 text-left pl-16 pr-2 mx-auto">
                <p class="mb-4 text-xl">{!! t("Browse the full library of resources and collections on a variety of topics.") !!}
                </p>
            </div>
        </div>
    </div>

    <div class="">
        <div class="flex flex-col lg:flex-row gap-12">

            <!-- Sidebar (Search & Filters) -->
            <div class="lg:min-w-[220px] w-2/12 bg-white self-start pl-12 py-8">
                <div class="pb-4">
                    <div class="pb-4 text-xl font-bold">{{ t('Search and filter') }}</div>
                </div>

                <!-- Search bar -->
                <div class="relative flex items-center mb-6">
                    <livewire:search-bar
                        inputClass="w-full py-2 pl-12 pr-4 bg-gray-200 border-none rounded-full focus:outline-none transition
                        duration-300 focus:bg-gray-100 focus:ring-0 text-gray-700"/>

                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </div>

                    <!-- Clear Button -->
                    @if($query)
                        <svg xmlns="http://www.w3.org/2000/svg" wire:click="clearSearch" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="gray" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 cursor-pointer hover:stroke-gray-700 transition-colors duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    @endif
                </div>

                <!-- Language Filter -->
                <div class="mb-6" x-data="{ openLanguage: true }">
                    <div class="border-t border-gray-400 my-4"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openLanguage = !openLanguage">
                        <label class="text-base font-bold">{{ t("Language:") }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="openLanguage ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                    <div class="space-y-2 mt-2 text-sm" x-show="openLanguage" x-show>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="es" wire:change="search" class="mr-2 accent-stats4sd-red"/>
                            {{ t("Spanish") }}
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="en" wire:change="search" class="mr-2 accent-stats4sd-red"/>
                            {{ t("English") }}
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="fr" wire:change="search" class="mr-2 accent-stats4sd-red"/>
                            {{ t("French") }}
                        </label>
                    </div>
                </div>

                <!-- Research Methods Filter -->
                <div class="mb-6" x-data="{ openMethods: true }">
                    <div class="border-t border-gray-400 my-4"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openMethods = !openMethods">
                        <label class="text-base font-bold">{{ t("Research method:") }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="openMethods ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                    <div class="flex flex-col space-y-2 mt-2 text-sm" x-show="openMethods" x-show>
                        @foreach($this->researchMethods as $researchMethod)
                            <label class="flex items-center rounded cursor-pointer">
                                <input type="checkbox" wire:model="selectedResearchMethods" value="{{ $researchMethod->id }}" class="mr-2 accent-stats4sd-red" wire:change="search"/>
                                {{ $researchMethod->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Topics Filter -->
                <div class="mb-6" x-data="{ openTopics: true }">
                    <div class="border-t border-gray-400 my-4"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openTopics = !openTopics">
                        <label class="text-base font-bold">{{ t("Topic:") }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="openTopics ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                    <div class="flex flex-col space-y-2 mt-2 text-sm" x-show="openTopics" x-show>
                        @foreach($this->topics as $topic)
                            <label class="flex items-center rounded cursor-pointer">
                                <input type="checkbox" wire:model="selectedTopics" value="{{ $topic->id }}" class="mr-2 accent-stats4sd-red" wire:change="search"/>
                                {{ $topic->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Resources and Collections Cards -->
            <div class="w-3/4">
                <div class="p-8">
                    {{ t("Showing ") . $this->startOfPage . ' - ' . $this->endOfPage . ' out of ' . $totalResourcesAndCollections . t(" resources and collections") }}
                    @if($query || !empty($selectedLanguages) || !empty($selectedResearchMethods))
                        <button wire:click="clearFilters" class="text-gray-500 hover:text-gray-700 underline text-sm">
                            {{ t("Clear Filters") }}
                        </button>
                    @endif
                </div>

                <div id="Items-content" class="py-8 px-2 sm:px-4 rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        @foreach ($this->renderedItems as $index => $item)
                            @if($item['type'] === 'resource')
                                <x-resource-result-card :item="$item"/>
                            @elseif($item['type'] === 'collection')
                                <x-collection-result-card :item="$item"/>
                            @endif
                        @endforeach
                    </div>
                </div>


                <div class="max-w-6xl mx-auto my-5">
                        <nav class="rounded-md shadow-xs flex w-full justify-end" aria-label="Pagination" x-data="{currentPage: $wire.entangle('currentPage')}">

                            <button
                                :class="currentPage===1 ? bg-gray-50 : 'bg-white hover:text-stats4sd-red'"
                                class="py-2 px-4 rounded-full"
                                x-on:click="$wire.loadPage(currentPage-1); window.scrollTo({ top: 0, behavior: 'smooth' });"
                                {{ $currentPage === 1 ? 'disabled="disabled"' : '' }}
                            >
                                Previous
                            </button>

                            @for($i=1; $i<=$pageCount; $i++)
                                <button
                                    :class="currentPage==={{$i}} ? 'text-white bg-stats4sd-red' : 'text-black hover:text-stats4sd-red'"
                                    class="py-2 px-4 rounded-full"

                                    x-on:click="$wire.loadPage({{$i}}); window.scrollTo({ top: 0, behavior: 'smooth' });"
                                >{{ $i }}</button>
                            @endfor

                            <button
                                :class="currentPage==={{$pageCount}} ? bg-gray-50 : 'bg-white hover:text-stats4sd-red'"
                                class="py-2 px-4 rounded-full"
                                x-on:click="$wire.loadPage(currentPage+1); window.scrollTo({ top: 0, behavior: 'smooth' });"
                                {{ $currentPage === $pageCount ? 'disabled="disabled"' : ''}}
                            >
                                Next
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
