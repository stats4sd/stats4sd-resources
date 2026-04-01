@extends('layouts.app', ['hideHeader' => true])

@section('content')
    <header class="sticky top-0 z-50 bg-white  lg:pl-20 theme_ifa" x-data="{ open: false }">
        <div class=" w-full flex flex-col md:flex-row justify-between items-center min-h-16 ">
            <!-- Logos -->
            
            <div class="flex justify-start w-full xl:w-2/3 items-center space-x-4 pl-4 lg:pl-0 lg:space-x-8 mb-4 sm:mb-0">
            
                <a href="https://www.uvm.edu/instituteforagroecology">
                    <img src="{{ asset('images/ifalogo1.png') }}" class="max-h-16  " alt="crfs">
                </a>

    


            </div>

            <nav class="flex w-full  justify-end">
                <ul class="flex justify-between flex-col md:flex-row lg:justify-end md:space-x-6 font-medium uppercase w-full text-xs md:text-sm">

                    <!-- Language Dropdown -->
                    <li class="relative nav-item dropdown flex   pl-4 pr-8 md:px-0 md:pl-0 min-w-40" x-data="{ langOpen: false }">
                        <a class="nav-link dropdown-toggle flex w-full justify-end m items-center py-4" role="button" aria-expanded="false"
                            x-on:click="langOpen = !langOpen">
                            {{ t('Change Language') }}
                            <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-5 w-5 ml-2"
                                fill="black" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m16.843 10.211c.108-.141.157-.3.157-.456 0-.389-.306-.755-.749-.755h-8.501c-.445 0-.75.367-.75.755 0 .157.05.316.159.457 1.203 1.554 3.252 4.199 4.258 5.498.142.184.36.29.592.29.23 0 .449-.107.591-.291 1.002-1.299 3.044-3.945 4.243-5.498z" />
                            </svg>
                        </a>
                        <div class="language-dropdown-menu min-w-[11rem] top-9 md:top-16" x-show="langOpen" x-on:click.outside="langOpen = false"
                           style="display:none">
                            <a class="dropdown-item" href="{{ URL::current() . '?locale=en' }}">English</a>
                            <a class="dropdown-item" href="{{ URL::current() . '?locale=es' }}">Español</a>
                            <a class="dropdown-item" href="{{ URL::current() . '?locale=fr' }}">Français</a>
                        </div>
                    </li>
                    <li>
                    
                     <a class=" py-2  sm:px-8 bg-stats4sd-red text-white w-full flex flex-col items-center sm:items-start w-full md:w-80  justify-left text-left  "
                            href="https://stats4sd.org/resources">


                            <div class="flex flex-row  gap-2 justify-left ">
                                <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" fill="#ffffff"
                                    stroke-miterlimit="2" viewBox="0 0 24 24" height="1.5rem" class="w-min my-auto md:mr-4 flex-none "
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z"
                                        fill-rule="nonzero" />
                                </svg>
                                <div class=" ml-2 md:ml-0">
                                    <span class="uppercase text-xs font-normal ">{{ t('Part of the') }}</span>
                                    <h2 class="text-sm md:text-lg normal-case font-bold ">{{ t('Stats4SD Resources Library') }}</h2>
                                </div>

                            </div>
                        </a>

                    </li>
                </ul>
            </nav>
        </div>
        
    </header>

    <div class=" relative md:absolute md:top-0 z-50 w-full  md:items-right">

    </div>
    <div class="relative theme_ifa">

        <div class="relative">
            <!-- Background Image -->
            <img src="images/ifacover.png" alt="Background Image"
                class="absolute inset-0 w-full h-[21rem] object-cover filter brightness-[70%] z-0">

            <!-- Overlay Content -->
            <div class="relative z-10 flex flex-col items-start w-full h-[20rem] text-white">
                <div class="h-[20rem] pb-16 flex flex-col sm:flex-row items-end w-full 2xl:pr-32">
                    <!-- Heading -->
                    <div class="pt-10 px-8 sm:pl-16  2xl:pl-32 flex-grow" style="text-wrap: balance">
                        <h1 class="font-bold text-4xl sm:text-5xl md:text-5xl mb-4 md:!leading-[3.5rem]">
                            {{ t('Resource Library: Education for Agroecological Transformations') }}
                        </h1>
                        <h2 class="font-normal text-xl">{{ t('Information for students') }}</h2>

                    </div>

                </div>
            </div>

        </div>

        <!-- Top section -->
        <div class="w-full bg-gray-100 flex justify-center py-6">
            <div class="flex flex-col md:flex-row items-start justify-between gap-12 w-screen max-w-7xl p-12">
                <div class="text-base w-3/5">
                    {{ t('Below you will find information about the various programs and courses run by our member institutions.') }}
                </div>
                <div class="flex flex-col w-2/6 px-12 gap-y-3">
                    <h2 class=" text-black text-2xl mb-2">{{ t('Quick links') }}</h2>
                    <a href="{{ url('/ifa') }}"
                        class="px-6 py-3 text-white bg-ifa-green flex flex-row justify-between
                                    hover:bg-black 
                                    font-semibold text-sm rounded-full uppercase text-center transition
                                    w-full">
                        <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6 mr-6"
                            stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z" />
                        </svg>
                        <span> {{ t('IFA Resource Library') }}</span>

                    </a>

                    <a href="mailto:georgemca20@gmail.com"
                        class="px-6 pt-3 pb-2 text-white bg-ifa-green w-full flex flex-row justify-between
                                    hover:bg-black 
                                    font-semibold text-sm rounded-full uppercase text-center transition">
                        <span> {{ t('Contact us') }}</span>
                        <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" class="h-6 w-6"
                            stroke-miterlimit="2" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M24 21h-24v-18h24v18zm-23-16.477v15.477h22v-15.477l-10.999 10-11.001-10zm21.089-.523h-20.176l10.088 9.171 10.088-9.171z" />
                        </svg>

                    </a>
                </div>
            </div>
        </div>
        <div class="flex flex-row w-full h-full justify-between gap-12 mt-12">
            <div class="bg-ifa-green w-6 flex-shrink-0 h-auto"></div>
            <div class="h-auto w-full max-w-7xl py-3 pl-12">

                <h2 class="text-black text-2xl">
                    {{ t('University of Vermont') }}
                </h2>
            </div>
            <div class="bg-none w-6 flex-shrink-0 h-auto"></div>
        </div>

        <div class="flex justify-center max-w-7xl  px-16 w-full mb-12">
            <div class="w-full flex flex-row px-14 justify-between">
                <p class="">
                    {{ t('Description text.') }}
                </p>
                <p>Links and details</p>
            </div>
        </div>

        <div class="flex flex-row w-full h-full justify-between gap-12 mt-12">
            <div class="bg-ifa-green w-6 flex-shrink-0 h-auto"></div>
            <div class="h-auto w-full max-w-7xl py-3 pl-12">

                <h2 class="text-black text-2xl">
                    {{ t('Veracruzana University') }}
                </h2>
            </div>
            <div class="bg-none w-6 flex-shrink-0 h-auto"></div>
        </div>

        <div class="flex justify-center max-w-7xl  px-16 w-full mb-12">
            <div class="w-full flex flex-row px-14 justify-between">
                <p class="">
                    {{ t('Description text.') }}
                </p>
                <p>Links and details</p>
            </div>
        </div>


    </div>


    </div>
@endsection
