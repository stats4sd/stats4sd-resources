@extends('layouts.app')
@section('content')

<div>
    <!-- Background Image-->
    <img src="images/crops.png" alt="Background Image" class="absolute w-full h-[70vh] sm:h-[60vh] md:max-h-[65vh] object-cover filter brightness-50">
    
    <!-- Overlay Content -->
    <div class="relative">
        <div class="inset-0 flex flex-col items-center">
            <!-- Heading -->
            <div class="text-white font-bold text-4xl sm:text-5xl md:text-5xl pt-12 text-center">
                Stats4SD Resources Collection
            </div>

            <!-- Search -->
            <h1 class="text-white text-base sm:text-lg md:text-xl mt-8 md:mt-10">Search the collection</h1>

            <div class="mt-4 flex items-center space-x-3 relative">
                <input
                    wire:model="query"
                    wire:keydown.enter="searchResources"
                    type="text"
                    class="border-2 border-white rounded-full py-2 md:py-2 focus:outline-none transition duration-300 focus:border-stats4sd-red focus:ring-1 focus:ring-stats4sd-red"
                >

                <!-- Search Button -->
                <svg xmlns="http://www.w3.org/2000/svg" wire:click="searchResources" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="w-8 h-8 text-white cursor-pointer ml-4 transition-colors duration-200 hover:text-mint">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>

            <!-- Description -->
            <div class="relative flex items-center max-w-3xl md:pr-16 mb-0 md:mb-2 text-center md:text-left px-4 pt-8 md:pt-10">
                <div class="flex-grow">
                    <h1 class="text-white mb-2 md:mb-4">The Stats4SD resources collection is a curated selection of materials that support <b>good practice, research and learning</b> in 
                        the broad range of topics relevant to our work. Search, or select a library below to get started.
                    </h1>
                </div>
            </div>

            <!-- Library Cards -->
            <div class="flex flex-col md:flex-row justify-center space-y-6 md:space-y-0 md:space-x-8 w-full items-center md:items-stretch px-4 mt-2 md:mt-4 pb-8">
                <!-- Card -->
                <div class="library-card bg-stats4sd-red hover-effect flex flex-col items-center">
                    <div class="flex-1 text-center">
                        <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">Research Methods</h2>
                        <p class="mb-4 md:mb-6 text-white">Our extensive collection of resources on research methods, including designing studies, quantitative and qualitative methods,
                            and statistical analysis.</p>
                    </div>
                </div>

                <div class="library-card bg-stats4sd-red hover-effect flex flex-col items-center">
                    <div class="flex-1 text-center">
                        <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">Research Methods</h2>
                        <p class="mb-4 md:mb-6 text-white">Our extensive collection of resources on research methods, including designing studies, quantitative and qualitative methods,
                            and statistical analysis.</p>
                    </div>
                </div>

                <div class="library-card bg-stats4sd-red hover-effect flex flex-col items-center">
                    <div class="flex-1 text-center">
                        <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">Research Methods</h2>
                        <p class="mb-4 md:mb-6 text-white">Our extensive collection of resources on research methods, including designing studies, quantitative and qualitative methods,
                            and statistical analysis.</p>
                    </div>
                </div>

                <div class="library-card bg-black hover-effect flex flex-col items-center">
                    <div class="flex-1 text-center">
                        <h2 class="text-bold text-lg md:text-xl mb-4 md:mb-6">Browse all</h2>
                        <p class="mb-4 md:mb-6 text-white">Browse the full collection of resources on a variety of topics.</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Main Content -->
    <div class="container mx-6 md:mx-auto">
        <div class="px-4">
            <!-- Latest Uploads -->
            <div class="pt-20 pb-4 text-2xl font-bold">Latest Uploads</div>
            <div class="divider"></div>

            @livewire('latest-uploads')

            <!-- Browse all resources -->
            <div class="pt-20 pb-4 text-2xl font-bold">Browse All Resources</div>
            <div class="divider"></div>

            <!-- Search and Filter Section -->
            <div class="pt-8 pb-4 pr-12">
                <!-- Search Bar -->
                <div class="relative flex items-center border border-gray-300 rounded-none">
                    <input 
                        type="text"
                        class="flex-grow py-2 pl-12 pr-4 focus:outline-none focus:border-stats4sd-red focus:ring-1 focus:ring-stats4sd-red"
                        placeholder="Search here"
                    />
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" wire:click="searchResources" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                            class="w-5 h-5 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>

                <!-- Language Selection -->
                <div class="mt-6 flex items-center space-x-4">
                    <label class="font-bold">Language:</label>
                    <!-- Spanish Option -->
                    <div class="flex items-center">
                        <input type="checkbox" id="spanish" class="mr-2 accent-stats4sd-red" />
                        <label for="spanish">Spanish</label>
                    </div>
                    <!-- English Option -->
                    <div class="flex items-center">
                        <input type="checkbox" id="english" class="mr-2 accent-stats4sd-red" />
                        <label for="english">English</label>
                    </div>
                    <!-- French Option -->
                    <div class="flex items-center">
                        <input type="checkbox" id="french" class="mr-2 accent-stats4sd-red" />
                        <label for="french">French</label>
                    </div>
                </div>

                <!-- Filter by Section -->
                <div class="mt-6 flex items-center space-x-4">
                    <!-- Filter Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-7.414 7.414A2 2 0 0 0 12 16.828V20a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 8 19v-2.172a2 2 0 0 0-.586-1.414L3.293 6.707A1 1 0 0 1 3 6V4z" />
                        </svg>

                    <!-- Filter Text -->
                    <span class="font-bold">Filter by:</span>

                </div>

            </div>

            <div class="pb-12"></div>
        </div>
    </div>
    
    @livewire('resources-results')

</div>
@endsection

<script>
    function toggleCollapse(sectionId, toggleContentId, button) {
        // Toggle the visibility of the section
        var section = document.getElementById(sectionId);
        var content = document.getElementById(toggleContentId);
        if (section && content) {
            section.classList.toggle('hidden');
            content.classList.toggle('hidden');
        }

        // Rotate the arrow icon on the button by 90 degrees
        var svgIcon = button.querySelector('svg');
        if (svgIcon) {
            svgIcon.classList.toggle('rotate-90');
        }
    }
</script>