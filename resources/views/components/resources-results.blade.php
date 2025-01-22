<div>

    <div id="Collections" class="bg-black text-white py-4 px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center w-full sm:w-auto sm:mr-4">
            <!-- Result Category Name -->
            <div class="flex-shrink-0 w-full sm:w-1/5 mb-2 sm:mb-0 sm:text-right">
                <h1 class="text-center sm:text-right text-2xl font-bold">Collections</h1>
            </div>
            <!-- Toggle Button for small screens -->
            <button class="text-white sm:hidden -ml-2" data-target="Collections-section" onclick="toggleCollapse('Collections-section', 'Collections-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>

        <!-- "Showing... results" & See All Button -->
        <div id="Collections-toggle-content" class="flex items-center justify-center w-full sm:w-2/5">
            <span class="text-lg text-center sm:text-left mr-2">
                Showing {{ $expandedResults ? $totalCollections : 3 }}
                out of {{ $totalCollections }}
                Collections
            </span>
            @if ($collections->count() > 3)
                <button
                    class="transparent-white-button hover-effect px-4 py-2 text-center ml-2"
                    wire:click="$toggle('expandedResults')"
                >
                    See {{ $this->expandedResults ? 'Less' : 'More' }}
                </button>
            @endif
        </div>

        <!-- Toggle Button for larger screens -->
        <div class="hidden sm:flex flex-shrink-0 justify-center sm:justify-end mt-2 sm:mt-0 w-full sm:w-auto">
            <button class="text-white" data-target="Collections-section" onclick="toggleCollapse('Collections-section', 'Collections-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>
        </div>

        <!-- Result Card -->
        <div id="Collections-section" class="collapse-section bg-lightgrey py-8 px-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->collections as $index => $collection)
                    <div class="card relative flex flex-col justify-between bg-stats4sd-red text-white p-6 border border-gray-200 rounded-lg shadow-xl @if(!$expandedResults && $index >= 3) hidden @endif" data-category="Collections">

                        <!-- Category & Title -->
                        <h3 class="text-xl font-semibold mb-4">COLLECTION</h3>
                        <h3 class="text-xl font-bold">{!! $collection['title'] !!}</h3>

                        <p class="pt-8 mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit(strip_tags($collection['description']), 120, '...') }}
                        </p>

                        <!-- View Button -->
                        <div class="flex justify-end">
                            <a href="https://stats4sd.org/collections/{{ $collection->id }}" target="_blank" class="hover-effect bg-white text-stats4sd-red text-center py-2 px-8 rounded-lg">
                                VIEW
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            @if($expandedResults && $totalCollections < $totalCollections)
                <div class="my-4 flex content-end justify-end">
                    <button class="bg-gray-800 hover-effect text-white text-center py-2 px-4 rounded-lg flex items-center justify-center">
                        SEE MORE RESULTS
                    </button>
                </div>
            @endif

        </div>
    </div>

    <div id="Resources" class="bg-black text-white py-4 px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center w-full sm:w-auto sm:mr-4">
            <!-- Result Category Name -->
            <div class="flex-shrink-0 w-full sm:w-1/5 mb-2 sm:mb-0 sm:text-right">
                <h1 class="text-center sm:text-right text-2xl font-bold">Resources</h1>
            </div>
            <!-- Toggle Button for small screens -->
            <button class="text-white sm:hidden -ml-2" data-target="Resources-section" onclick="toggleCollapse('Resources-section', 'Resources-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>

        <!-- "Showing... results" & See All Button -->
        <div id="Resources-toggle-content" class="flex items-center justify-center w-full sm:w-2/5">
            <span class="text-lg text-center sm:text-left mr-2">
                Showing {{ $expandedResults ? $totalResources : 3 }}
                out of {{ $totalResources }}
                Resources
            </span>
            @if ($resources->count() > 3)
                <button
                    class="transparent-white-button hover-effect px-4 py-2 text-center ml-2"
                    wire:click="$toggle('expandedResults')"
                >
                    See {{ $this->expandedResults ? 'Less' : 'More' }}
                </button>
            @endif
        </div>

        <!-- Toggle Button for larger screens -->
        <div class="hidden sm:flex flex-shrink-0 justify-center sm:justify-end mt-2 sm:mt-0 w-full sm:w-auto">
            <button class="text-white" data-target="Resources-section" onclick="toggleCollapse('Resources-section', 'Resources-toggle-content', this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="transition-transform transform rotate-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Result Card -->
    <div id="Resources-section" class="collapse-section bg-lightgrey py-8 px-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->resources as $index => $resource)
                    <div class="card relative flex flex-col justify-between bg-white p-6 border border-gray-200 rounded-lg shadow-xl @if(!$expandedResults && $index >= 3) hidden @endif" data-category="Resources">

                        <!-- Category & Title -->
                        <h3 class="text-xl font-semibold mb-4">RESOURCE</h3>
                        <h3 class="text-xl font-bold text-stats4sd-red">{!! $resource['title'] !!}</h3>

                        <p class="text-gray-600 pt-8 mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit(strip_tags($resource['description']), 120, '...') }}
                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap mb-4 gap-2 pt-8">
                            @php 
                                $tags = null;
                                $tags = $resource->themeAndTopicTags;
                            @endphp
                            @foreach ($tags as $tag)
                                @if(!empty($tag))
                                    <div class="grey-badge">{{ $tag->name }}</div>
                                @endif
                            @endforeach
                        </div>

                        <!-- View Button -->
                        <div class="flex justify-end">
                            <a href="https://stats4sd.org/resources/{{ $resource->slug }}" target="_blank" class="hover-effect bg-black text-white text-center py-2 px-8 rounded-lg">
                                VIEW
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            @if($expandedResults && $totalResources < $totalResources)
                <div class="my-4 flex content-end justify-end">
                    <button class="bg-gray-800 hover-effect text-white text-center py-2 px-4 rounded-lg flex items-center justify-center">
                        SEE MORE RESULTS
                    </button>
                </div>
            @endif

        </div>
    </div>

</div>