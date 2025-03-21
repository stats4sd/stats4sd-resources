<div>
    <!-- Search and Filters -->
    <div id="Search-filters-section" class="container mx-6 md:mx-auto">
        <div class="px-4">
            <!-- Heading -->
            <div class="pt-20 pb-4 text-2xl font-bold">{{ t("Browse All Resources") }}</div>
            <div class="divider"></div>

            <!-- Search Bar -->
            <div class="pt-8 pb-4 pr-12">

                <div class="relative flex items-center border border-gray-300 rounded-none">

                    <livewire:search-bar
                        inputClass="flex-grow py-2 pl-12 pr-4 focus:outline-none focus:border-stats4sd-red focus:ring-1 focus:ring-stats4sd-red"
                        :scrollOnSearch="false"/>
                    
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

            </div>

            <!-- Language Selection -->
            <div class="mt-6 flex items-center space-x-4">
                <label class="font-bold">{{ t("Language:") }}</label>
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

            <!-- Filters Section -->
            <div class="mt-6 flex items-start space-x-4">
                <!-- Filter Icon & "Filter by" Text -->
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-7.414 7.414A2 2 0 0 0 12 16.828V20a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 19v-2.172a2 2 0 0 0-.586-1.414L3.293 6.707A1 1 0 0 1 3 6V4z" />
                    </svg>
                    <span class="text-lg font-bold">{{ t("Filter by:") }}</span>
                </div>

                <!-- Filter Box -->
                <div class="border border-gray-300 rounded-lg p-4 flex-1">
                    <!-- Filter Headings Row -->
                    <div class="flex justify-between items-center pb-2">
                        <div class="flex items-center space-x-6">
                            <!-- Themes always shown -->
                            <button wire:click="setSelectedFilterType('themes')" 
                                class="relative pb-2 text-gray-700 font-semibold hover:text-gray-900 hover:border-b-2 hover:border-gray-400">
                                    {{ $this->themeLabel }}
                                <!-- Only show red underline if more filters selected and themes is selected -->
                                @if($filtersExpanded && $selectedFilterType === 'themes')
                                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-red-500"></span>
                                @endif
                            </button>

                            <!-- Show additional tag types if more filters selected -->
                            @if($filtersExpanded)
                                @foreach(['topics', 'keywords', 'locations'] as $filter)
                                    <button wire:click="setSelectedFilterType('{{ $filter }}')" 
                                        class="relative pb-2 text-gray-700 font-semibold hover:text-gray-900 hover:border-b-2 hover:border-gray-400">
                                        {{ $this->getTagTypeTranslation($filter) }}
                                        <span class="absolute left-0 bottom-0 w-full h-0.5 bg-red-500 {{ $selectedFilterType === $filter ? 'opacity-100' : 'opacity-0' }}"></span>
                                    </button>
                                @endforeach
                            @endif
                        </div>

                        <!-- More filters button-->
                        @if(!$filtersExpanded)
                            <button wire:click="toggleFilters" 
                                class="text-sm text-stats4sd-red font-semibold hover:underline cursor-pointer">
                                {{ t("More Filters +") }}
                            </button>
                        @endif
                    </div>

                    <!-- Tags for selected tag type -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach($tags[$selectedFilterType]->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                            <label class="flex items-center space-x-2 bg-gray-100 px-3 py-1 rounded-full cursor-pointer">
                                <input type="checkbox" wire:model="selectedTags.{{ $selectedFilterType }}" value="{{ $tag->id }}" class="accent-stats4sd-red" wire:change="search"/>
                                <span class="text-sm">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="pb-12"></div>

    <!-- Collections -->
    <div id="Collections-section" class="bg-black text-white py-4 px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center w-full sm:w-auto sm:mr-4">
            <!-- Result Category Name -->
            <div class="flex-shrink-0 w-full sm:w-1/5 mb-2 sm:mb-0 sm:text-right">
                <h1 class="text-center sm:text-right text-2xl font-bold">{{ t("Collections") }}</h1>
            </div>
            <!-- Toggle Button for small screens -->
            <button class="text-white sm:hidden -ml-2" onclick="toggleCollapse('Collections-content', 'Collections-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>

        <!-- "Showing... results" & See All Button -->
        <div id="Collections-toggle-content" class="flex items-center justify-center w-full sm:w-2/5">
            <span class="text-lg text-center sm:text-left mr-2">
            @php
                $minCount = min($collections->count(), 3);
                $totalCount = $totalCollections;
            @endphp
            {{ t("Showing ") . $minCount . t(" out of ") . $totalCount . t(" collections") }}
            </span>
            @if ($collections->count() > 3)
                @php
                    $text = $this->expandedCollectionResults ? t('Less') : t('More');
                @endphp
                <button
                    class="transparent-white-button hover-effect px-4 py-2 text-center ml-2"
                    wire:click="$toggle('expandedCollectionResults')"
                >
                    {{ t("See ") . $text }}
                </button>
            @endif
        </div>

        <!-- Toggle Button for larger screens -->
        <div class="hidden sm:flex flex-shrink-0 justify-center sm:justify-end mt-2 sm:mt-0 w-full sm:w-auto">
            <button class="text-white" onclick="toggleCollapse('Collections-content', 'Collections-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Collections Result Card -->
    <div id="Collections-content" class="collapse-section bg-lightgrey py-8 px-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->collections as $index => $collection)
                    <div class="card relative flex flex-col justify-between bg-stats4sd-red text-white p-6 border border-gray-200 rounded-lg shadow-xl @if(!$expandedCollectionResults && $index >= 3) hidden @endif" data-category="Collections">

                        <!-- Category & Title -->
                        <h3 class="text-xl font-semibold mb-4">{{ t("COLLECTION") }}</h3>
                        <h3 class="text-xl font-bold">{!! $collection['title'] !!}</h3>

                        <p class="pt-8 mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($collection['description']), ENT_QUOTES, 'UTF-8'), 120, '...') }}
                        </p>

                        <!-- View Button -->
                        <div class="flex justify-end">
                            <a href="https://stats4sd.org/collections/{{ $collection->id }}" target="_blank" class="hover-effect bg-white text-stats4sd-red text-center py-2 px-8 rounded-lg">
                                {{ t("VIEW") }}
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

    <div id="Resources-section" class="bg-black text-white py-4 px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center w-full sm:w-auto sm:mr-4">
            <!-- Result Category Name -->
            <div class="flex-shrink-0 w-full sm:w-1/5 mb-2 sm:mb-0 sm:text-right">
                <h1 class="text-center sm:text-right text-2xl font-bold">{{ t("Resources") }}</h1>
            </div>
            <!-- Toggle Button for small screens -->
            <button class="text-white sm:hidden -ml-2" data-target="Resources-toggle" onclick="toggleCollapse('Resources-content', 'Resources-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>

        <!-- "Showing... results" & See All Button -->
        <div id="Resources-toggle-content" class="flex items-center justify-center w-full sm:w-2/5">
            <span class="text-lg text-center sm:text-left mr-2">
                @php
                    $minCount = min($resources->count(), 3);
                    $totalCount = $totalResources;
                @endphp
                {{ t("Showing ") . $minCount . t(" out of ") . $totalCount . t(" resources") }}
            </span>
            @if ($resources->count() > 3)
                @php
                    $text = $this->expandedResourceResults ? t('Less') : t('More');
                @endphp
                <button
                    class="transparent-white-button hover-effect px-4 py-2 text-center ml-2"
                    wire:click="$toggle('expandedResourceResults')"
                >
                    {{ t("See ") . $text }}
                </button>
            @endif
        </div>

        <!-- Toggle Button for larger screens -->
        <div class="hidden sm:flex flex-shrink-0 justify-center sm:justify-end mt-2 sm:mt-0 w-full sm:w-auto">
            <button class="text-white" data-target="Resources-toggle" onclick="toggleCollapse('Resources-content', 'Resources-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Resources Result Cards -->
    <div id="Resources-content" class="collapse-section bg-lightgrey py-8 px-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->resources as $index => $resource)
                    <div class="card relative flex flex-col justify-between bg-white p-6 border border-gray-200 rounded-lg shadow-xl @if(!$expandedResourceResults && $index >= 3) hidden @endif" data-category="Resources">

                        <!-- Category & Title -->
                        <h3 class="text-xl font-semibold mb-4">{{ t("RESOURCE") }}</h3>
                        <h3 class="text-xl font-bold text-stats4sd-red">{!! $resource['title'] !!}</h3>

                        <p class="text-gray-600 pt-8 mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($resource['description']), ENT_QUOTES, 'UTF-8'), 120, '...') }}
                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap mb-4 gap-2 pt-8">
                            @php
                                $tags = $resource->themeAndTopicTags;
                            @endphp
                            @foreach ($tags->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                                @if(!empty($tag))
                                    <div class="grey-badge">{{ $tag->name }}</div>
                                @endif
                            @endforeach
                        </div>

                        <!-- View Button -->
                        <div class="flex justify-end">
                            <a href="https://stats4sd.org/resources/{{ $resource->slug }}" target="_blank" class="hover-effect bg-black text-white text-center py-2 px-8 rounded-lg">
                                {{ t("VIEW") }}
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

</div>