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
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    
                    <!-- Clear Button -->
                    @if($query)
                        <svg xmlns="http://www.w3.org/2000/svg" wire:click="clearSearch" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="gray" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 cursor-pointer hover:stroke-gray-700 transition-colors duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </div>

                <!-- Language Filter -->
                <div class="mb-6" x-data="{ openLanguage: true }">
                    <div class="border-t border-gray-400 my-4"></div>
                    <div class="flex justify-between items-center cursor-pointer" @click="openLanguage = !openLanguage">
                        <label class="text-base font-bold">{{ t("Language:") }}</label>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="openLanguage ? 'rotate-90' : 'rotate-0'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div class="space-y-2 mt-2 text-sm" x-show="openLanguage" x-show>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="es" wire:change="search" class="mr-2 accent-stats4sd-red" />
                            {{ t("Spanish") }}
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="en" wire:change="search" class="mr-2 accent-stats4sd-red" />
                            {{ t("English") }}
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selectedLanguages" value="fr" wire:change="search" class="mr-2 accent-stats4sd-red" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
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
                    {{ t("Showing ") . $totalResourcesAndCollections . t(" resources and collections") }}
                    @if($query || !empty($selectedLanguages) || !empty($selectedResearchMethods))
                        <button wire:click="clearFilters" class="text-gray-500 hover:text-gray-700 underline text-sm">
                            {{ t("Clear Filters") }}
                        </button>
                    @endif
                </div>

                <div id="Items-content" class="py-8 px-2 sm:px-4 rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        @foreach ($this->items as $index => $item)
                          <div
                                    class="card hover-effect relative flex flex-col justify-between {{ $item['type'] === 'collection' ? 'bg-black' : 'bg-[#f2f2f2]' }} overflow-hidden  rounded-t-3xl rounded-bl-3xl ">
                                    <a href="/{{ $item['type'] === 'collection' ? 'collections/'.$item['id'] : 'resources/'.$item['slug'] }}"  class="absolute inset-0 z-0"
                                        target="_blank"></a>
                                            <div class="flex flex-col justify-start">
                                        <div class="h-52 bg-cover bg-center mb-4"
                                            style="background-image: url('images/crops.png');">
                                        </div>
                                        <div class="absolute top-4 left-4 h-12 w-12  rounded-full text-white text-center py-auto {{ $item['type'] === 'collection' ? 'bg-stats4sd-red ' : 'bg-black' }}">
                                         @if ($item['type'] === 'resource')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white"  class="mx-auto my-3"><path d="M4 22v-20h16v11.543c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362zm18-7.614v-14.386h-20v24h10.189c3.163 0 9.811-7.223 9.811-9.614z"/></svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white"  class="mx-auto my-3"><path d="M21.698 10.658l2.302 1.342-12.002 7-11.998-7 2.301-1.342 9.697 5.658 9.7-5.658zm-9.7 10.657l-9.697-5.658-2.301 1.343 11.998 7 12.002-7-2.302-1.342-9.7 5.657zm0-19l8.032 4.685-8.032 4.685-8.029-4.685 8.029-4.685zm0-2.315l-11.998 7 11.998 7 12.002-7-12.002-7z"/></svg>
                                        @endif
                                        </div>
                                     @if ($item['type'] === 'resource' && !empty($item['troveTypes']))
                                    <p class="text-sm text-stats4sd-red uppercase font-semibold mx-6 ">
                                            {{ $item['troveTypes']->sortBy('order')->first()->label ?? '' }}</p>
                                        @endif

                                        <p class="text-lg 2xl:text-xl font-bold mx-6 mb-3 xl:min-h-8 {{ $item['type'] === 'collection' ? 'text-white ' : 'text-black' }} "> {!! $item['title'] !!}</p>

                                        <p class=" text-sm 2xl:text-base mb-2  flex-grow mx-6 mb-4 {{ $item['type'] === 'collection' ? 'text-white ' : 'text-gray-600' }}">
                                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item['description']), ENT_QUOTES, 'UTF-8'), 110, '...') }}
                                        </p>

                                        <!-- Tags -->
            
                                @if ($item['type'] === 'resource' && !empty($item['tags']))
                                        <div class="flex flex-wrap gap-2 mb-2 mx-6 mb-4">
                                            @foreach ($item['tags']->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                                        
                                                    <div class="grey-badge ">{{ $tag->name }}</div>
                                               
                                            @endforeach
                                        </div>
                                         @endif
                                    </div>
                                        <!-- View Button -->
                                        <div class="flex justify-end mb-2 pb-4 px-8 ">
                                            <button class="{{ $item['type'] === 'collection' ? 'bg-white text-black' : 'bg-stats4sd-red  text-white' }} text-center py-2 px-8 rounded-full">
                                                {{ t("VIEW") }}
                                            </button>
                                        </div>
                                    
                                </div>

                            {{-- <div class="card hover-effect relative flex flex-col justify-between bg-white p-6 border border-gray-200 rounded-lg shadow-xl">
                                <a href="/{{ $item['type'] === 'collection' ? 'collections/'.$item['id'] : 'resources/'.$item['slug'] }}" class="absolute inset-0 z-0" target="_blank"></a>

                                @if ($item['type'] === 'resource' && !empty($item['troveTypes']))
                                    <p class="text-xl uppercase">{{ $item['troveTypes']->sortBy('order')->first()->label ?? '' }}</p>
                                @endif

                                <p class="text-xl font-bold {{ $item['type'] === 'collection' ? 'text-white bg-stats4sd-red p-2 rounded' : 'text-stats4sd-red' }}">
                                    {!! $item['title'] !!}
                                </p>

                                <p class="text-gray-600 pt-8 mb-4 flex-grow">
                                    {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item['description']), ENT_QUOTES, 'UTF-8'), 120, '...') }}
                                </p>

                                <!-- Tags (Only for Resources) -->
                                @if ($item['type'] === 'resource' && !empty($item['tags']))
                                    <div class="flex flex-wrap mb-4 gap-2 pt-8">
                                        @foreach ($item['tags']->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                                            <div class="grey-badge">{{ $tag->name }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- View Button -->
                                <div class="flex justify-end">
                                    <button class="text-white text-center py-2 px-8 rounded-lg {{ $item['type'] === 'collection' ? 'bg-stats4sd-red' : 'bg-black' }}">
                                        {{ t("VIEW") }}
                                    </button>
                                </div>
                            </div> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>