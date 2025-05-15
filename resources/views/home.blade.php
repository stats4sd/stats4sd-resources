@extends('layouts.app')
@section('content')
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
                    <p class="mb-4">{!! t("The Stats4SD resources library is a curated selection of materials 
                        that support good practice, research and learning in the broad range of topics relevant to our 
                        work.") !!}
                    </p>
                    <p class="font-bold">{!! t("Select a starting point below to begin.") !!}</p>
                </div>
            </div>
        </div>

        <div class="bg-white max-w-6xl mx-auto px-6 py-12 mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

            @php
                $cards = [
                    [
                        'url' => '/resources',
                        'title' => t('Search resources'),
                        'desc' => t('Guides, tools, videos, papers and other items that we use and recommend to others.'),
                        'image' => 'images/resources-card.jpg',
                    ],
                    [
                        'url' => '/collections',
                        'title' => t('Search collections'),
                        'desc' => t('A collection is a group of resources compiled together for a specific purpose, such as series of guides on a specific topic, or the reading for an online course.'),
                        'image' => 'images/collections-card.jpg',
                    ],
                    [
                        'url' => '/browse-all',
                        'title' => t('View All'),
                        'desc' => t('Browse the full library of resources and collections on a variety of topics.'),
                        'image' => 'images/browse-all-card.jpg',
                    ],
                    [
                        'url' => '/theme-pages',
                        'title' => t('Theme pages'),
                        'desc' => t('Mini libraries which showcase a specific thematic area, containing a subset of our resources and/or resources provided by partner organisations.'),
                        'image' => 'images/theme-card.jpg',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <a href="{{ $card['url'] }}" class="relative group h-80 overflow-hidden shadow-lg hover-effect">
                    <img src="{{ asset($card['image']) }}" alt="{{ $card['title'] }}" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute bottom-0 w-full h-1/2 flex flex-col justify-start px-4 pt-4" style="background-color: var(--stats4sd-red-transparent);">
                        <div class="text-white text-lg font-bold mb-2">{{ $card['title'] }}</div>
                        <p class="text-white text-sm">{{ $card['desc'] }}</p>
                    </div>
                </a>
            @endforeach

        </div>

        <div class="pb-20"></div> 

@endsection

