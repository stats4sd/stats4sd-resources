<div class="relative">
    <!-- Background Image -->
    <img src="images/crops.png" alt="Background Image"
        class="absolute inset-0 w-full h-[40vh] sm:h-[40vh] object-cover filter brightness-[65%] z-0">

    <!-- Overlay Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-[45vh] sm:h-[40vh] px-4 text-white">
        <div class="max-w-5xl w-full mx-auto text-left">
            <!-- Heading -->
            <div class="font-bold text-4xl sm:text-5xl md:text-5xl">
                {{ t('Search resources') }}
            </div>

            <!-- Description -->
            <div class="mt-6 text-left pr-2 mx-auto">
                <p class="mb-4 text-xl">{!! t('Guides, tools, videos, papers and other items that we use and recommend to others.') !!}</p>
            </div>
        </div>
        <div class="relative flex items-center mb-6 max-w-3xl w-full mt-16 ">
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
        <div class="flex flex-col lg:flex-row gap-12">

            <!-- Sidebar (Search & Filters) -->
            <div class="lg:min-w-[220px] w-2/12 bg-white self-start pl-12 py-8">
                <div class="pb-4">
                    <div class="pb-4 text-xl font-bold">{{ t('Filters') }}</div>
                    <div class="divider"></div>
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
                <div class="mb-6" x-data="{ openLanguage: true }">
                    {{-- <div class="border-t border-gray-400 my-4"></div> --}}
                    <div class="flex justify-between items-center cursor-pointer" @click="openLanguage = !openLanguage">
                        <label class="text-base font-bold">{{ t('Language:') }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300"
                            :class="openLanguage ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="space-y-2 mt-2 text-sm" x-show="openLanguage" x-show>
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
                <div class="mb-6" x-data="{ openMethods: true }">
                    <div class="border-t border-gray-400 my-4"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openMethods = !openMethods">
                        <label class="text-base font-bold">{{ t('Research method:') }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300"
                            :class="openMethods ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="flex flex-col space-y-2 mt-2 text-sm" x-show="openMethods" x-show>
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
                <div class="mb-6" x-data="{ openTopics: true }">
                    <div class="border-t border-gray-400 my-4"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openTopics = !openTopics">
                        <label class="text-base font-bold">{{ t('Topic:') }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300"
                            :class="openTopics ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="flex flex-col space-y-2 mt-2 text-sm" x-show="openTopics" x-show>
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
                                <div
                                    class="card hover-effect relative flex flex-col justify-between bg-[#f2f2f2] overflow-hidden  rounded-t-3xl rounded-bl-3xl ">
                                    <a href="/resources/{{ $resource->slug }}" class="absolute inset-0 z-0"
                                        target="_blank"></a>
                                    <div class="flex flex-col justify-start">
                                        <div class="h-52 bg-cover bg-center mb-4"
                                            style="background-image: url('images/crops.png');">
                                        </div>
                                        <div
                                            class="absolute top-4 left-4 h-12 w-12 bg-black rounded-full text-white text-center py-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                viewBox="0 0 24 24" fill="white" class="mx-auto my-3">
                                                <path
                                                    d="M4 22v-20h16v11.543c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362zm18-7.614v-14.386h-20v24h10.189c3.163 0 9.811-7.223 9.811-9.614z" />
                                            </svg>
                                        </div>

                                        <p class="text-sm text-stats4sd-red uppercase font-semibold mx-6 ">
                                            {{ $resource->troveTypes->sortBy('order')->first()?->label ?? '' }}</p>
                                        <p class="text-lg 2xl:text-xl font-bold mx-6 mb-3 xl:min-h-8">
                                            {!! $resource['title'] !!}</p>

                                        <p class="text-gray-600 text-sm 2xl:text-base mb-2  flex-grow mx-6 mb-4">
                                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($resource['description']), ENT_QUOTES, 'UTF-8'), 110, '...') }}
                                        </p>

                                        <!-- Tags -->
                                        <div class="flex flex-wrap gap-2 mb-2 mx-6 mb-4">
                                            @foreach ($resource->themeAndTopicTags->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                                                @if (!empty($tag))
                                                    <div class="grey-badge">{{ $tag->name }}</div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- View Button -->
                                    <div class="flex justify-end mb-2 pb-4 px-8 ">
                                        <button class="bg-stats4sd-red text-white text-center py-2 px-8 rounded-full">
                                            {{ t('VIEW') }}
                                        </button>
                                    </div>

                                </div>
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
