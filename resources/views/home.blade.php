@extends('layouts.app')
@section('content')
<div class="relative">
    <div class="w-full mt-24 mb-12">
        <div class="max-w-screen-xl mx-auto px-8 sm:px-20 md:px-12 2xl:px-0">
            <div class="flex flex-col md:flex-row items-start gap-12">
                <div class="w-full md:w-[45%]">
                    <div class="border-l-[24px] border-stats4sd-red pl-6">
                        <div class="text-4xl md:text-5xl font-bold text-stats4sd-red">
                            Stats4SD
                        </div>
                        <div class="text-5xl md:text-6xl font-bold pt-2 whitespace-nowrap">
                            {!! t("Resources Library") !!}
                        </div>
                    </div>

                    <div class="mt-6 text-left pr-2">
                        <p class="mb-4">
                            {!! t("Welcome to the Stats4SD Resources Library - a carefully selected set of resources designed to support good practice in research methods. Select a starting point on the right to begin") !!}
                        </p>
                    </div>
                </div>

                <div class="bg-white w-full md:w-[55%] grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-6 justify-items-start">
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
                                'image' => 'images/theme-card.jpg',
                            ],
                            [
                                'url' => '/browse-all',
                                'title' => t('View All'),
                                'desc' => t('Browse the full library of resources and collections on a variety of topics.'),
                                'image' => 'images/browse-all-card.jpg',
                            ],
                        ];
                    @endphp

                    @foreach ($cards as $card)
                        <a href="{{ $card['url'] }}" 
                           class="relative group h-80 w-[18rem] overflow-hidden shadow-lg hover-effect rounded-t-3xl rounded-bl-3xl">

                            <img src="{{ asset($card['image']) }}" 
                                 alt="{{ $card['title'] }}" 
                                 class="absolute inset-0 w-full h-full object-cover z-0">

                            <div class="absolute top-0 w-full z-10 bg-stats4sd-red text-white px-4 pt-4 pb-3 rounded-t-3xl">
                                <div class="text-lg font-bold mb-1 uppercase">{{ $card['title'] }}</div>
                                <p class="text-sm">{{ $card['desc'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="pb-20"></div> 
</div>
@endsection
