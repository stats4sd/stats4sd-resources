@extends('layouts.app')

@section('content')
    <div class="relative">
        <!-- Image Header -->
        @php
            $cover_photo = $collection->getMedia('cover_photo')->first();
            $cover_photo_url = $cover_photo ? $cover_photo->getUrl() : asset('images/default-cover-photo.jpg');
        @endphp
        <div class="relative h-112 bg-cover bg-center"  style="height: 600px; background-image: url('{{ $cover_photo_url }}');">
            <div class="absolute bottom-0 w-full h-fit bg-stats4sd-red-70 flex justify-left " style="min-height: 33%;">
                <div class="text-left px-4 mx-auto my-4 container">
                    <div class="text-lg md:text-2xl text-white">{{ t("COLLECTION") }}</div>
                    <div class="text-xl md:text-3xl text-white font-bold">{{ $collection->title }}</div>
                    <button onclick="scrollToSection('collection-resources')" class="border border-white px-6 py-2 mt-2 rounded-2xl text-white hover:bg-white hover:text-black transition">
                    {{ t("Jump to resources") }} </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Back Link -->
    <div class="container mx-auto p-6">
        <a href="{{ url('/browse-all') }}" class="text-gray-500 hover:text-black">&lt; {{ t("Browse all resources and collections") }}</a>
    </div>

    <!-- Description -->
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold pb-2">{{ t("Description") }}</h2>
        <div class="divider"></div>
        <p>{{ t("Dated: ") }} {{ \Carbon\Carbon::parse($collection->created_at)->translatedFormat('F Y') }}</p>
        <p class="mt-4">{{ strip_tags($collection->description) }}</p>
    </div>

    <!-- Divider -->
    <hr class="border-t border-black my-6 px-12">

    <!-- Troves -->
    <div id="collection-resources" class="container mx-auto p-6">
        <h2 class="text-xl font-bold pb-2">{{ t("Resources in this collection") }}</h2>
        <div class="divider"></div>
        <livewire:collection-troves :collection="$collection"/>
    </div>

@endsection


<script>
    function scrollToSection(sectionId) {
        const target = document.getElementById(sectionId);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>