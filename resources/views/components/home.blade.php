@extends('layouts.app')
@section('content')
    <div>
        <!-- Background Image-->
        <img src="images/crops.png" alt="Background Image" class="absolute w-full h-[50vh] sm:h-[45vh] md:max-h-[50vh] object-cover filter brightness-50">
        
        <!-- Overlay Content -->
        <div class="relative">
            <div class="inset-0 flex flex-col items-center">
                <!-- Heading -->
                <div class="text-white font-bold text-4xl sm:text-5xl md:text-5xl pt-12 text-center">
                    {{ t("Stats4SD Resources Library") }}
                </div>

                <!-- Description -->
                <div class="relative flex items-center max-w-3xl md:pr-16 mb-0 md:mb-2 text-center md:text-left px-4 pt-8 md:pt-10">
                    <div class="flex-grow">
                        <h1 class="text-white mb-2 md:mb-4">{!! t("The Stats4SD resources library is a curated selection of materials 
                            that support <b>good practice, research and learning</b> in the broad range of topics relevant to our 
                            work. Select a tab below to get started.") !!}
                        </h1>
                    </div>
                </div>

                <!-- Tabs -->
                <livewire:tab-controller />

            </div>

        </div>

        <div class="pb-20"></div> 

        <!-- Tab Content -->
        <livewire:tab-content />

@endsection

