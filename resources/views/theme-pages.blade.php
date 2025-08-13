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
                    <p class="mb-4 text-xl">{!! t("Stats4SD theme pages") !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="py-8 px-28">
            <div class="py-12 px-28 text-xl text-center">
                Theme pages coming soon.....
            </div>
        </div>

    </div>
@endsection