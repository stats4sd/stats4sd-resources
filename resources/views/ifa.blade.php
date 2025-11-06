@php
    $featuredResourceIds = [
        'en' => [658, 659, 604],
        'es' => [474, 367, 604],
        'fr' => [625, 604],
    ];

    $collections = [
        [
            'url' => '/collections/49',
            'img' => '/images/ifa1.png',
            'title' => t('Introductions'),
            'desc' => t(' '),
        ],
        [
            'url' => '/collections/50',
            'img' => '/images/ifa2.png',
            'title' => t('Reading for developers'),
            'desc' => t(' '),
        ],
        [
            'url' => '/collections/51',
            'img' => '/images/ifa3.jpg',
            'title' => t('Participatory action research'),
            'desc' => t(' '),
        ],
      
    ];

    $topics = [
        'Transformative', 'Principles', 'Diets', 'Transitions', 'Pests', 'Participation (PAR)', 'Social movements', 'Knowledge', 'Food sovereignty', 'Policies', 'Diversity', 'Soils', 'Feminism', 'Ecology', 'Evaluations',
    ];

    $institutions = [
        [
            'name' => 'University of Vermont',
            'location' => 'USA',

        ],
        [
            'name' => 'Veracruzana University',
            'location' => 'Mexico',
            
        ],
        [
            'name' => 'University of Cordoba',
            'location' => 'Spain',
            
        ],
                [
            'name' => 'El Colegio de la Frontera Sur',
            'location' => 'Mexico',
            
        ],
                [
            'name' => 'Norwegian University of Life Sciences ',
            'location' => 'Norway',
            
        ],
      
    ];
    $levels = [
       'Undergraduate', 'Graduate/Masters', 'Student reading list',
      
    ];

    $locale = app()->currentLocale();
    $featuredResources = \App\Models\Trove::whereIn('id', $featuredResourceIds[$locale])->get();
@endphp

@extends('layouts.app', ['hideHeader' => true])

@section('content')

    <header class="sticky top-0 z-50 bg-white  px-8 lg:px-20 theme_ifa" x-data="{ open: false }" >
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center min-h-16 py-4">
            <!-- Logos -->
            <div class="flex justify-start w-full xl:w-2/3 items-center space-x-4 lg:space-x-6 mb-8 sm:mb-0">
                <a href="https://stats4sd.org/">
                    <img src="/images/Stats4SD_logo.png" alt="Stats4SD logo" class="max-h-6 ">
                </a>
                <a href="https://ccrp.org">
                    <img src="{{ asset('images/uvmlogo.png') }}" class="max-h-8 px-8 border-r border-[--ifa-green] " alt="crfs">
                </a>
                <a href="https://ccrp.org">
                    <img src="{{ asset('images/ifalogo.png') }}" class="max-h-32  " alt="crfs">
                </a>

            </div>

            <nav class="flex w-full justify-end">
                <ul class="flex space-x-6 font-medium uppercase text-sm">

                    <!-- Language Dropdown -->
                    <li class="relative nav-item dropdown" x-data="{ langOpen: false }">
                        <a class="nav-link dropdown-toggle flex items-center" role="button" aria-expanded="false"
                            x-on:click="langOpen = !langOpen">
                            {{ t('Change Language') }}
                            <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-5 w-5 ml-2"
                                fill="black" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m16.843 10.211c.108-.141.157-.3.157-.456 0-.389-.306-.755-.749-.755h-8.501c-.445 0-.75.367-.75.755 0 .157.05.316.159.457 1.203 1.554 3.252 4.199 4.258 5.498.142.184.36.29.592.29.23 0 .449-.107.591-.291 1.002-1.299 3.044-3.945 4.243-5.498z" />
                            </svg>
                        </a>
                        <div class="language-dropdown-menu" x-show="langOpen" x-on:click.outside="langOpen = false"
                            style="display:none">
                            <a class="dropdown-item" href="{{ URL::current() . '?locale=en' }}">English</a>
                            <a class="dropdown-item" href="{{ URL::current() . '?locale=es' }}">Español</a>
                            <a class="dropdown-item" href="{{ URL::current() . '?locale=fr' }}">Français</a>
                        </div>
                    </li>
                </ul>
            </nav>

        </div>
    </header>




    <div class="relative theme_ifa">


        <div class="relative">
            <!-- Background Image -->
            <img src="images/ifacover.png" alt="Background Image"
                class="absolute inset-0 w-full h-[20rem] object-cover filter brightness-[65%] z-0">

            <!-- Overlay Content -->
            <div class="relative z-10 flex flex-col items-start w-full h-[20rem]  text-white">
                <div class="h-[20rem] pb-16 flex flex-col sm:flex-row items-end w-full 2xl:pr-32">
                    <!-- Heading -->
                    <h1 class="font-bold text-4xl sm:text-5xl md:text-5xl pt-10 px-8 sm:pl-16  2xl:pl-32 flex-grow">
                        {{ t('FRN Research Methods Hub') }}
                    </h1>

                    <a
                        class="p-12 bg-stats4sd-red text-white sm:rounded-bl-[4rem] font-opensans 2xl:rounded-b-[4rem] flex flex-col items-start justify-left text-left h-full w-full sm:w-2/5 sm:max-w-[24rem]"
                        href="https://stats4sd.org/resources">
                        <span class="uppercase text-base font-normal ">Part of the</span>
                        <h2 class="text-3xl font-bold mb-8">Stats4SD Resources Library</h2>
                        <div class="flex">
                            <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" fill="#ffffff"
                                stroke-miterlimit="2" viewBox="0 0 24 24" height="1.5rem"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z"
                                    fill-rule="nonzero" />
                            </svg>
                            <span class="uppercase text-base font-normal ml-3 ">Library home</span>
                        </div>
                    </a>
                </div>


            </div>

        </div>




        <!-- Top section -->
        <div class="w-full bg-gray-100 flex justify-center py-6">
            <div class="flex flex-col md:flex-row items-start justify-between gap-12 w-screen max-w-7xl p-12">
                <div class="text-base w-3/5">
                    {{ t("Let's Educate for Agroecological Transformations is an international community of practice focusing on transformative learning for agroecology in higher education consisting of people who are either already teaching, or who are building agroecology programmes/courses in HE. Programmes consist of undergraduate, graduate and/or post-graduate courses, and extend to continuing education aimed practitioners and professionals in the field of agroecology. We are committed to co-creating and inspiring transformative agroecological learning that transgresses formal-informal education boundaries to create learning spaces that connect academic knowledge with community and movement building practices across multiple contexts.") }}
                </div>
                <div class="flex flex-col w-2/6 px-12 gap-y-4">
                    <h2 class=" text-black text-2xl mb-2">Quick links</h2>
                    <a href="#collections"
                        class="px-6 py-3 text-white bg-ifa-green flex flex-row justify-between
                                    hover:bg-black 
                                    font-semibold  text-sm rounded-full uppercase text-center transition">
                      <span> {{ t('Browse by topic') }}</span> 
<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6" stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>

                    </a>
                    <a href="#browse_all"
                        class="px-6 py-3 text-white bg-ifa-green flex flex-row justify-between
                                    hover:bg-black 
                                    font-semibold  text-sm rounded-full uppercase text-center transition">
                        <span>{{ t('View all syllabi') }}</span>
                        <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6" stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-row w-full h-full justify-between gap-12 mt-12 ">
            <div class="bg-ifa-green w-6 flex-shrink-0 h-auto"></div>
            <div class="h-auto w-full max-w-7xl py-3 pl-12">

                <h2 class="text-black text-2xl">
                    {{ t('Browse by topic') }}
                </h2>

            </div>
            <div class="bg-none  w-6 flex-shrink-0 h-auto"></div>
        </div>

{{-- View by topic - collections --}}

 <div class="w-full  flex justify-center py-6">

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center max-w-7xl p-12">
                @foreach ($collections as $c)
                    <a href="{{ url($c['url']) }}" target="_blank"
                        class="hover-effect relative bg-ifa-green rounded-t-[2.5rem] rounded-bl-[2.5rem] overflow-hidden group sm:max-w-[20rem] min-w-[15rem]">
                         <div class="absolute top-4 left-4 h-12 w-12  rounded-full text-white text-center py-auto bg-ifa-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white"
                                class="mx-auto my-3">
                                <path
                                    d="M21.698 10.658l2.302 1.342-12.002 7-11.998-7 2.301-1.342 9.697 5.658 9.7-5.658zm-9.7 10.657l-9.697-5.658-2.301 1.343 11.998 7 12.002-7-2.302-1.342-9.7 5.657zm0-19l8.032 4.685-8.032 4.685-8.029-4.685 8.029-4.685zm0-2.315l-11.998 7 11.998 7 12.002-7-12.002-7z" />
                            </svg>
                        </div>
                        <div class="h-48 bg-cover bg-center"
                            style="background-image: linear-gradient(to bottom, rgba(255,255,255,0), rgba(0,0,0,0.14)), url('{{ $c['img'] }}">
                        </div>
                        <div class="p-10 text-white h-[10rem]">
                            <p class="text-xs  uppercase font-semibold ">
                                Collection
                            </p>
                            <h3 class="font-bold text-xl mb-2 ">
                                {{ $c['title'] }}
                            </h3>
                            <p class="text-sm">
                                {{ $c['desc'] }}
                            </p>
                        </div>
                        <div class="w-full  px-10 pb-5">
                            <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6" stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
{{-- Search bar --}}
<div class="flex flex-row w-full h-full justify-between gap-12 mt-32 ">
            <div class="bg-ifa-green w-6 flex-shrink-0 h-auto"></div>
            <div class="h-auto w-full max-w-7xl py-3 px-12">

                <h2 class="text-black text-2xl">
                    {{ t('Search or explore resources') }}
                </h2>

            </div>
            <div class="bg-none  w-6 flex-shrink-0 h-auto"></div>
        </div>
<div class="w-full  flex justify-center py-6">

        <div class="relative w-full items-center mb-6  max-w-2xl lg:max-w-5xl xl:max-w-7xl px-12 hidden lg:flex">
            <livewire:search-bar
                inputClass="w-full py-5 pl-12 pr-4 bg-gray-200 border-none rounded-full focus:outline-none transition
                duration-300 focus:bg-gray-100 focus:ring-0 text-gray-700 "/>

            <div class="absolute left-16 top-1/2 transform -translate-y-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </div>
            </div>
    </div>


    <!-- topics filters -->
        <div class="flex flex-row w-full h-full justify-between gap-12 mt-12 ">
            <div class="bg-none  w-6 flex-shrink-0 h-auto"></div>
            <div class="h-auto w-full max-w-7xl py-3 px-12">

                <h3 class="text-black text-lg uppercase font-medium">
                    {{ t('Explore selected topics') }}
                </h3>

            </div>
            <div class="bg-none  w-6 flex-shrink-0 h-auto"></div>
        </div>

<div class="w-full  flex justify-center py-6 px-12">

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6 justify-left max-w-7xl px-12">
                                @foreach ($topics as $t)
                    <a href="" target="_blank"
                        class="hover-effect flex justify-between relative bg-ifa-yellow rounded-full  overflow-hidden group sm:max-w-[20rem] min-w-[14rem] text-black text-sm px-6 py-4">
                        {{ $t }}
                         <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6" stroke-miterlimit="2"  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>
                        </a>
                @endforeach
            </div>
        </div>


    <!-- institutions and syllabi filters 2 cols-->
    <div class="w-full flex justify-center py-6">
        <div class="w-full flex flex-row gap-20 justify-between w-screen max-w-7xl p-12 ">
            <div class="">
                <h3 class="text-black text-lg uppercase font-medium">
                    {{ t('Explore Institutions') }}
                </h3>
                <div class="sm:grid sm:grid-cols-2 sm:gap-6  mt-12">
                                        @foreach ($institutions as $i)
                            <button href="" target="_blank"
                                class="hover-effect relative bg-ifa-green flex flex-col justify-around text-left rounded-t-[1.5rem] rounded-bl-[1.5rem]  overflow-hidden group sm:max-w-[20rem] min-w-[14rem] text-white text-sm px-6 py-4 h-[9rem]">
                                <div>
                                <h3> {{ $i['name'] }}</h3>
                                <p>{{ $i['location'] }}</p>
                               </div>
                                    <div class="w-full ">
                                    <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6" stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>
                                </div>                               
                                     </button>
                        @endforeach
                    </div>
            </div>
            <div class="">
                <h3 class="text-black text-lg uppercase font-medium">
                    {{ t('Browse by programme curricula or course syllabi') }}
                </h3>
                <div class="flex flex-col gap-6 mt-8">
                @foreach ($levels as $l)
                            <button href="" target="_blank"
                                class="hover-effect relative bg-ifa-green flex flex-col text-left justify-around rounded-t-[1.5rem] rounded-bl-[1.5rem]  overflow-hidden group sm:max-w-[20rem] min-w-[14rem] text-white text-sm px-6 py-4 h-[9rem]">
                           
                                <h3> {{ $l }}</h3>
                            
                            
                                    <div class="w-full ">
                                    <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6" stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>
                                </div>       
                                </button>
                        @endforeach
                
                </div>
            </div>
        </div>
               </div>



        {{-- <h2 id="frn_all" class="text-3xl font-bold">{{ t('Featured resources') }}</h2>
        <div class="h-1 w-20 bg-stats4sd-red my-4"></div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($featuredResources as $resource)
                <a href="{{ url("resources/{$resource->id}") }}" target="_blank"
                    class="hover-effect relative bg-gray-100 rounded-lg overflow-hidden group">
                    <div class="h-48 bg-cover bg-center"
                        style="background-image: linear-gradient(to bottom, rgba(255,255,255,0), rgba(0,0,0,0.64)), url('{{ $resource->getCoverImageUrl() }}')">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg group-hover:text-stats4sd-green">
                            {{ $resource->getTranslation('title', $locale) ?? $resource->getTranslation('title', 'en') }}
                        </h3>
                        <p class="text-sm">
                            {!! $resource->getTranslation('description', $locale)
                                ? \Illuminate\Support\Str::limit($resource->getTranslation('description', $locale), 200)
                                : \Illuminate\Support\Str::limit($resource->getTranslation('description', 'en'), 200) !!}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
         --}}
            




    </div>

    <!-- Browse all -->

     
<div class="w-full  ">

    @livewire('ifa-hub-browse-resources')
</div>
    </div>
@endsection
