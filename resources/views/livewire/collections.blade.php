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
                <p class="mb-4 text-xl">{!! t("Stats4SD collections") !!}
                </p>
            </div>
        </div>
    </div>

    <div class="py-8 px-28">

        <div class="relative flex items-center">

            <livewire:search-bar
                inputClass="flex-grow py-2 pl-12 pr-4  border-2 border-black rounded-full focus:outline-none transition
                duration-300 focus:border-stats4sd-red focus:ring-1 focus:ring-stats4sd-red"/>
            
            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                    class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
                    
            <!-- Clear Button -->
            @if($query)
            <svg xmlns="http://www.w3.org/2000/svg" wire:click="clearSearch" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="gray"
                class="absolute right-12 md:right-2 top-1/2 transform -translate-y-1/2 w-5 h-5 cursor-pointer hover:stroke-gray-700 transition-colors duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            @endif
        </div>

        <!-- Language Selection -->
        <div class="mt-6 flex items-center space-x-4">
            <label class="text-lg font-bold">{{ t("Language:") }}</label>
            <!-- Spanish Option -->
            <div class="flex items-center">
                <input type="checkbox" id="spanish" wire:model="selectedLanguages" value="es" wire:change="search" class="mr-2 accent-stats4sd-red" />
                <label for="spanish">{{ t("Spanish") }}</label>
            </div>
            <!-- English Option -->
            <div class="flex items-center">
                <input type="checkbox" id="english" wire:model="selectedLanguages" value="en" wire:change="search" class="mr-2 accent-stats4sd-red" />
                <label for="english">{{ t("English") }}</label>
            </div>
            <!-- French Option -->
            <div class="flex items-center">
                <input type="checkbox" id="french" wire:model="selectedLanguages" value="fr" wire:change="search" class="mr-2 accent-stats4sd-red" />
                <label for="french">{{ t("French") }}</label>
            </div>
        </div>

        @if($query || !empty($selectedLanguages) )
            <!-- Display search results -->
            <div class="pt-8">
                {{ t("Showing ") . $totalCollections . t(" collections") }}
                <button wire:click="clearFilters" class="text-gray-500 hover:text-gray-700 underline">
                    {{ t("Clear Filters") }}
                </button>
            </div>

            <!-- Collections Result Cards -->
            <div id="Collections-content" class="bg-lightgrey py-8 px-16">
                <div class="container mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($this->collections as $index => $collection)
                            <div class="card hover-effect relative flex flex-col justify-between p-6 border border-gray-200 rounded-lg shadow-xl">
                                
                                <a href="/collections/{{ $collection->id }}" class="absolute inset-0 z-0"></a>
                                <!-- Title -->
                                <p class="text-xl font-bold bg-stats4sd-red text-white">{!! $collection['title'] !!}</p>

                                <p class="bg-white pt-8 mb-4 flex-grow">
                                    {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($collection['description']), ENT_QUOTES, 'UTF-8'), 120, '...') }}
                                </p>

                                <!-- View Button -->
                                <div class="flex justify-end">
                                    <button class="hover-effect bg-stats4sd-red text-white text-center py-2 px-8 rounded-lg">
                                        {{ t("VIEW") }}
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>

        @else
            <!-- Display message when no search term -->
            <div class="text-center text-semibold py-20">
                {{ t("Type a search term above to find collections") }}
            </div>

        @endif
        
    </div>
</div>