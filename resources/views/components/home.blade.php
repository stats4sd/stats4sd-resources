@extends('layouts.app')
@section('content')
    <div>
        <!-- Background Image-->
        <img src="images/crops.png" alt="Background Image" class="absolute w-full h-[60vh] sm:h-[50vh] md:max-h-[50vh] object-cover filter brightness-50 " style="max-height: 40rem;" >
        
        <!-- Overlay Content -->
        <div class="relative h-[60vh] sm:h-[50vh] md:max-h-[50vh]" style="max-height: 40rem;">
            <div class="inset-0  flex flex-col items-center lg:w-10/12 mx-auto xl:pt-20">
                <!-- Heading -->
                <div class="text-white font-bold text-4xl sm:text-5xl lg:text-7xl pt-20 text-center sm:w-10/12 lg:w-full sm:mx-auto px-2 sm:px-4 max-w-xs sm:max-w-screen-xl ">
                    {{ t("Stats4SD Resources Library") }}
                </div>

                <!-- Description -->
                <div class="relative flex items-center  md:pr-16 mb-0 md:mb-2 text-center md:text-left px-4 pt-8 md:pt-10 mb-8 sm:mb-0 sm:w-10/12 sm:mx-auto px-2 sm:px-4 lg:w-full max-w-xs sm:max-w-screen-xl ">
                    <div class="flex-grow ">
                        <h1 class="text-white mb-2 md:mb-4 md:text-lg">{!! t("The Stats4SD resources library is a curated selection of materials 
                            that support <b>good practice, research and learning</b> in the broad range of topics relevant to our 
                            work. Select a tab below to get started.") !!}
                        </h1>
                    </div>
                </div>
</div></div>
                <!-- Tabs -->
                <livewire:tab-controller />

            


        <div class="pb-20"></div> 

        <!-- Tab Content -->
        <livewire:tab-content />

@endsection

