<div class="relative">
    <!-- Background Image -->
    <img src="images/crops.png" alt="Background Image"
        class="absolute inset-0 w-full h-[500px] sm:h-[40vh] object-cover filter brightness-[55%] z-0">

    <!-- Overlay Content -->
    <div class="relative z-10 flex flex-col items-center justify-center  h-[500px] sm:h-[40vh] px-8 sm:px-20 xl:px-4 text-white">
        <div class="max-w-5xl w-full mx-auto text-left">
            <!-- Heading -->
            <div class="font-bold text-4xl sm:text-5xl md:text-5xl">
                {{ t('Search resources') }}
            </div>

            <!-- Description -->
            <div class="mt-6 text-left pr-2 mx-auto">
                <p class="mb-4 text-base md:text-xl">{!! t('Guides, tools, videos, papers and other items that we use and recommend to others.') !!}</p>
            </div>
        </div>
        <div class="relative flex items-center mb-6 max-w-3xl w-full mt-8 md:mt-16 ">
            <livewire:search-bar
                inputClass="w-full py-2 pl-12 pr-4 border-none rounded-full focus:outline-none transition
                        duration-300 focus:bg-gray-100 focus:ring-0 text-gray-700" />

            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>

            <!-- Clear Button -->
            @if ($query)
                <svg xmlns="http://www.w3.org/2000/svg" wire:click="clearSearch" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="gray"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 cursor-pointer hover:stroke-gray-700 transition-colors duration-200">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            @endif
        </div>
    </div>

    <div class="">
        <div class="flex flex-col lg:flex-row lg:gap-12">

            <!-- Sidebar (Search & Filters) -->
            <div class="lg:min-w-[280px] w-full lg:w-2/12 bg-[#f4f4f4] lg:bg-white self-start lg:pl-12 px-8 py-6 lg:py-8 flex flex-col sm:flex-row lg:flex-col sm:gap-6 lg:gap-0">
                <div class="pb-4 sm:pb-0 lg:pb-4">
                    <div class="pb-4 sm:pb-0 lg:pb-4 text-xl font-bold">{{ t('Filters') }}</div>
                    <div class="divider hidden lg:block"></div>
                </div>

                <!-- Search bar -->
                {{-- <div class="relative flex items-center mb-6"> --}}
                {{-- <livewire:search-bar
                        inputClass="w-full py-2 pl-12 pr-4 border-2 border-black rounded-full focus:outline-none transition
                        duration-300 focus:border-stats4sd-red focus:ring-1 focus:ring-stats4sd-red" />

                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" class="w-5 h-5 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div> --}}

                <!-- Clear Button -->
                {{-- @if ($query)
                        <svg xmlns="http://www.w3.org/2000/svg" wire:click="clearSearch" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="gray"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 cursor-pointer hover:stroke-gray-700 transition-colors duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif --}}
                {{-- </div> --}}

                <!-- Language Filter -->
                <div class=" sm:ml-12 lg:ml-0" x-data="window.innerWidth >= 1024 ? { openLanguage: true } : { openLanguage: false }">
                    {{-- <div class="border-t border-gray-400 my-4"></div> --}}
                    <div class="flex justify-between items-center cursor-pointer" @click="openLanguage = !openLanguage">
                        <label class="text-base  lg:font-bold">{{ t('Language') }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300 ml-2"
                            :class="openLanguage ? 'rotate-90' : '-rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="space-y-2 mt-4 text-sm " x-show="openLanguage" x-show>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="es" wire:change="search"
                                class="mr-2 accent-stats4sd-red" />
                            {{ t('Spanish') }}
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="en" wire:change="search"
                                class="mr-2 accent-stats4sd-red" />
                            {{ t('English') }}
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="fr" wire:change="search"
                                class="mr-2 accent-stats4sd-red" />
                            {{ t('French') }}
                        </label>
                    </div>
                </div>

                <!-- Research Methods Filter -->
                <div class="  sm:ml-6 lg:ml-0" x-data="window.innerWidth >= 1024 ? { openMethods: true } : { openMethods: false }">
                    <div class="border-t border-gray-400 sm:border-0 lg:border-t my-6 sm:my-0 lg:my-6"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openMethods = !openMethods">
                        <label class="text-base lg:font-bold">{{ t('Research method') }}</label>
                        <svg class="w-5 h-5 ml-2 transition-transform duration-300"
                            :class="openMethods ? 'rotate-90' : '-rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="flex flex-col space-y-2 mt-4 text-sm " x-show="openMethods" x-show>
                        @foreach ($this->researchMethods as $researchMethod)
                            <label class="flex items-center rounded cursor-pointer">
                                <input type="checkbox" wire:model="selectedResearchMethods"
                                    value="{{ $researchMethod->id }}" class="mr-2 accent-stats4sd-red"
                                    wire:change="search" />
                                {{ $researchMethod->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Topics Filter -->
                <div class="  sm:ml-6 lg:ml-0" x-data="window.innerWidth >= 1024 ? { openTopics: true } : { openTopics: false }">
                    <div class="border-t border-gray-400 sm:border-0 lg:border-t my-6 sm:my-0 lg:my-6"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openTopics = !openTopics">
                        <label class="text-base lg:font-bold">{{ t('Topic') }}</label>
                        <svg class="w-5 h-5 ml-2 transition-transform duration-300"
                            :class="openTopics ? 'rotate-90' : '-rotate-90'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="flex flex-col space-y-2 mt-4 text-sm " x-show="openTopics" x-show>
                        @foreach ($this->topics as $topic)
                            <label class="flex items-center rounded cursor-pointer">
                                <input type="checkbox" wire:model="selectedTopics" value="{{ $topic->id }}"
                                    class="mr-2 accent-stats4sd-red" wire:change="search" />
                                {{ $topic->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            @if ($query || !empty($selectedLanguages) || !empty($selectedResearchMethods) || !empty($selectedTopics))
                <div class="flex-1">
                    <div class="p-8">
                        {{ t('Showing ') . $totalResources . t(' resources') }}
                        <button wire:click="clearFilters" class="text-gray-500 hover:text-gray-700 underline text-sm">
                            {{ t('Clear Filters') }}
                        </button>
                    </div>

                    <!-- Resources Result Cards -->
                    <div id="Resources-content" class=" py-8 px-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
                            @foreach ($this->resources as $index => $resource)
                                <x-resource-result-card :item="$resource"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Display message when no search term -->
                <div class="text-center text-semibold py-20 pl-20">
                    {{ t('Use the search bar or select from the research methods and topics to find resources') }}
                </div>
            @endif
        </div>
    </div>
</div>
