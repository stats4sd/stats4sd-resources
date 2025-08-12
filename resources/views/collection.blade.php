@extends('layouts.app')

@section('content')
    <div class="relative">
        <!-- Image Header -->
        @php
            $cover_photo = $collection->getMedia('cover_image_' . app()->getLocale())->first();
            $cover_photo_url = $cover_photo ? $cover_photo->getUrl() : asset('images/default-cover-photo.jpg');
        @endphp

               <div class="overflow-hidden w-100vw ">
            <div class="relative bg-repeat-x bg-center -ml-24 blur-xl  w-[120vw] bg-cover"
                style="height: 500px; background-image: url('{{ $cover_photo_url }}');">
            </div>
        </div>
        <div class="absolute top-0 h-full w-full bg-center bg-no-repeat">
            <div class="w-full flex items-center overflow-hidden" style="height: 500px">
                <img src="{{ $cover_photo_url }}" style="min-height: 500px;  " class="mx-auto object-cover"
                    alt="cover image">
            </div>
            <div class="absolute bottom-0 w-full py-8 lg:py-12  h-fit  " style="min-height: 25%; background-color: #D32229dd">
                <div
                    class="text-left px-8  lg:px-32 mx-auto container flex flex-col gap-8 lg:gap-12   md:flex-row items-center justify-between">
                    <div class="md:w-1/2 lg:w-2/3">

                    <div class="text-lg md:text-2xl text-white">{{ t("COLLECTION") }}</div>
                    <div class="text-3xl lg:text-4xl text-white font-bold ">{{ $collection->title }}</div>
                    </div>
                    <button onclick="scrollToSection('collection-resources')" class="border-2 border-white  px-6 py-2 mt-2 font-semibold uppercase rounded-full text-white hover:bg-white hover:text-stats4sd-red transition">
                    {{ t("Jump to resources") }} </button>



                </div>

                <!-- Language Selection -->
                @php
                    $languages = [
                        'en' => 'English',
                        'es' => 'Español',
                        'fr' => 'Français',
                    ];
                    $availableLanguages = array_keys($collection->getTranslations('title'));
                    $currentLocale = request('locale', app()->getLocale()); // Get the current locale
                @endphp

                <div class="container mx-auto px-8 pt-6 lg:px-32 flex flex-col md:flex-row items-center">

                    <p class="text-lg text-white mr-6">{{ t('Available Languages:') }}</p>
                    <div class="flex gap-2 mt-2">
                        @foreach ($availableLanguages as $language)
                            <a href="{{ URL::current() . '?locale=' . $language }}"
                                class="px-4 py-1 rounded-full border border-white border
               {{ $currentLocale == $language || count($availableLanguages) == 1 ? 'bg-white text-stats4sd-red' : 'text-white  hover:bg-white hover:text-text-stats4sd-red' }}">
                                {{ $languages[$language] }}
                            </a>
                        @endforeach
                    </div>


                </div>

            </div>
        </div>
    </div>




    <!-- Back Link -->
    <div class="container mx-auto p-6">
        <a href="{{ url('/browse-all') }}" class="text-gray-500 hover:text-black">&lt; {{ t("Browse all resources and collections") }}</a>
    </div>

    <!-- Description -->
    <div class="container mx-auto py-6 px-8 lg:px-32 my-12">
        <div class="divider"></div>
        <h2 class="text-2xl font-bold pb-2">{{ t('Description') }}</h2>
        <p>{{ t("Dated: ") }} {{ \Carbon\Carbon::parse($collection->created_at)->translatedFormat('F Y') }}</p>
        <p class="mt-4">{{ strip_tags($collection->description) }}</p>
    </div>



    <!-- Troves -->
    <div id="collection-resources" class="container mx-auto py-6 px-8 lg:px-32">
        <div class="divider"></div>
        <h2 class="text-2xl font-bold pb-2">{{ t("Resources in this collection") }}</h2>

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
