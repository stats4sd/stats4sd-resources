@php
    $featuredResourceIds = [
        'en' => [658, 659, 604],
        'es' => [474, 367, 604],
        'fr' => [625, 604],
    ];

    $collections = [
        [
            'url' => '/collections/49',
            'img' => '/images/icon_lb.png',
            'title' => t('What is an FRN?'),
            'desc' => t('Discover more about farmer research networks and how they work.'),
        ],
        [
            'url' => '/collections/50',
            'img' => '/images/icon_cog.png',
            'title' => t('Tools for FRNs'),
            'desc' => t('Guides, methods and references for FRNs.'),
        ],
        [
            'url' => '/collections/51',
            'img' => '/images/icon_mag.png',
            'title' => t('Research in FRNs'),
            'desc' => t('Resources related to research methods, and how to include farmers in the research process.'),
        ],
        [
            'url' => '/collections/52',
            'img' => '/images/icon_give.png',
            'title' => t('FRN principles'),
            'desc' => t('Important considerations for ethical and inclusive research practices.'),
        ],
        [
            'url' => '/collections/53',
            'img' => '/images/icon_ppl.png',
            'title' => t('Case Studies'),
            'desc' => t('Insights into what FRNs have been doing.'),
        ],
    ];

    $locale = app()->currentLocale();
    $featuredResources = \App\Models\Trove::whereIn('id', $featuredResourceIds[$locale])->get();
@endphp

@extends('layouts.app', ['hideHeader' => true])

@section('content')
<div class="relative">

    <!-- Top logo header -->
    <div class="w-full bg-white py-4">
        <div class="max-w-6xl mx-auto flex justify-center md:justify-end gap-8 px-4">
            <a href="https://stats4sd.org">
                <img src="{{ asset('images/stats4SD_logo.png') }}" class="w-28" alt="stats4sd">
            </a>
            <a href="https://ccrp.org">
                <img src="{{ asset('images/CRFSlogo.png') }}" class="w-28" alt="crfs">
            </a>
        </div>
    </div>

    <!-- Top section -->
    <div class="w-full mb-20">
        <div class="flex flex-col md:flex-row items-start gap-12 w-full">

            <!-- Left intro column -->
            <div class="flex flex-col w-full md:w-[45%]">
                <div class="flex flex-row h-full md:justify-between">
                    <div class="bg-frn-green h-auto w-6 flex-shrink-0"></div>
                    <div class="pl-12 xl:pl-22 pr-12 h-auto max-w-2xl">
                        <div class="text-4xl md:text-5xl font-bold text-frn-green">
                            {{ t('FRN Research Methods Hub') }}
                        </div>
                        <div class="text-lg md:text-xl pt-16">
                            {{ t('A library of reference materials, tools, and useful information relevant to farmer research networks. Provided by the') }}
                            <span class="font-bold">{{ t('Research Methods Support project') }}</span>
                            {{ t('of CRFS.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column -->
            <div class="flex flex-row w-full md:w-[55%]">

                <!-- Content with padding, aligned to top -->
                <div class="pl-12 xl:pl-22 pr-12 h-auto max-w-2xl flex flex-col gap-8 mt-6 md:mt-36 pt-0 md:pt-4">

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#collections" 
                        class="px-6 py-3 bg-white text-frn-green border-2 border-frn-green hover:bg-frn-green hover:text-white font-bold rounded-lg text-center transition">
                            {{ t('Explore topics') }}
                        </a>
                        <a href="#browse_all" 
                        class="px-6 py-3 bg-white text-frn-green border-2 border-frn-green hover:bg-frn-green hover:text-white font-bold rounded-lg text-center transition">
                            {{ t('Browse all resources') }}
                        </a>
                    </div>

                    <!-- Language Switch -->
                    <div class="flex flex-wrap items-center gap-2 mt-4">
                        <span class="text-gray-600 text-sm font-medium">{{ t('View this page in') }}</span>

                        <a class="frn_btn px-3 py-1.5 rounded-full text-sm transition
                            {{ request('locale') === 'en' ? 'bg-frn-green text-white font-bold' : 'bg-gray-100 hover:bg-gray-200' }}"
                            href="{{ URL::current() . '?locale=en' }}">
                            English
                        </a>

                        <a class="frn_btn px-3 py-1.5 rounded-full text-sm transition
                            {{ request('locale') === 'es' ? 'bg-frn-green text-white font-bold' : 'bg-gray-100 hover:bg-gray-200' }}"
                            href="{{ URL::current() . '?locale=es' }}">
                            Español
                        </a>

                        <a class="frn_btn px-3 py-1.5 rounded-full text-sm transition
                            {{ request('locale') === 'fr' ? 'bg-frn-green text-white font-bold' : 'bg-gray-100 hover:bg-gray-200' }}"
                            href="{{ URL::current() . '?locale=fr' }}">
                            Français
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Browse by collections -->
    <div class="max-w-6xl mx-auto px-4">
        <h2 id="collections" class="text-3xl font-bold">{{ t('Browse by collection') }}</h2>
        <div class="h-1 w-20 bg-stats4sd-red my-4"></div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($collections as $c)
                <a href="{{ url($c['url']) }}" target="_blank" class="bg-stats4sd-red rounded-lg hover-effect p-4 flex gap-4 group">
                    <img src="{{ $c['img'] }}" class="w-10 h-10 flex-shrink-0" alt="">
                    <div>
                        <h3 class="font-bold text-lg text-white">{{ $c['title'] }}</h3>
                        <p class="text-sm text-white">{{ $c['desc'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Resources -->
    <div class="max-w-6xl mx-auto px-4 mt-16">
        <h2 id="frn_all" class="text-3xl font-bold">{{ t('Featured resources') }}</h2>
        <div class="h-1 w-20 bg-stats4sd-red my-4"></div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($featuredResources as $resource)
                <a href="{{ url("resources/{$resource->id}") }}" target="_blank" class="hover-effect relative bg-gray-100 rounded-lg overflow-hidden group">
                    <div class="h-48 bg-cover bg-center" style="background-image: linear-gradient(to bottom, rgba(255,255,255,0), rgba(0,0,0,0.64)), url('{{ $resource->getCoverImageUrl() }}')"></div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg group-hover:text-stats4sd-green">
                            {{ $resource->getTranslation('title', $locale) ?? $resource->getTranslation('title', 'en') }}
                        </h3>
                        <p class="text-sm">
                            {!! $resource->getTranslation('description', $locale) ? \Illuminate\Support\Str::limit($resource->getTranslation('description', $locale), 200) : \Illuminate\Support\Str::limit($resource->getTranslation('description', 'en'), 200) !!}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Browse all -->
    <div class="max-w-6xl mx-auto px-4 mt-16 mb-16">
        <h2 id="browse_all" class="text-3xl font-bold">{{ t('Browse all') }}</h2>
        <div class="h-1 w-20 bg-stats4sd-red my-4"></div>

        @livewire('frn-hub-browse-all')

    </div>

</div>

@endsection
