@extends('layouts.app')

@section('content')
    <div class="relative">

        <!-- Preview Banner -->
        @if(!$resource->is_published)
        <div class="bg-stats4sd-red text-white py-4 px-6 font-semibold flex justify-center space-x-1">
            <x-heroicon-o-exclamation-circle class="w-6 h-6 text-white"/>
            <span>
                {{ t("PREVIEW MODE: This resource has not been published and is only visible to authorised users") }}
            </span>
            </div>
        @endif
        <!-- Image Header -->
        @php
            $cover_photo = $resource->getMedia('cover_photo')->first();
            $cover_photo_url = $cover_photo ? $cover_photo->getUrl() : asset('images/default-cover-photo.jpg');
        @endphp
        <div class="relative h-112 bg-cover bg-center"  style="height: 600px; background-image: url('{{ $cover_photo_url }}');">
            <div class="absolute bottom-0 w-full h-fit bg-black bg-opacity-70 flex justify-left " style="min-height: 33%;">
                <div class="text-left px-4 mx-auto my-4 container">
                    <div class="text-xl md:text-3xl text-white font-bold">{{ $resource->title }}</div>
                    <button onclick="scrollToSection('trove-content')" class="border border-white px-6 py-2 mt-2 rounded-2xl text-white hover:bg-white hover:text-black transition">
                    {{ t("Jump to view/download") }} </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Language Selection -->
    @php
        $languages = [
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
        ];
        $availableLanguages = array_keys($resource->getTranslations('title'));
        $currentLocale = request('locale', app()->getLocale()); // Get the current locale
    @endphp

    <div class="container mx-auto p-6">
        <p class="text-lg font-semibold">{{ t("Available Languages:") }}</p>
        <div class="flex gap-2 mt-2">
        @foreach($availableLanguages as $language)
            <a href="{{ URL::current() . '?locale=' . $language }}"
               class="px-4 py-2 rounded-2xl border border-black 
               {{ ($currentLocale == $language || count($availableLanguages) == 1) ? 'bg-black text-white' : 'text-black' }}">
                {{ $languages[$language] }}
            </a>
        @endforeach
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-black my-6"></div>

    <!-- Back Link -->
    <div class="container mx-auto p-6">
        <a href="{{ url('/home') }}" class="text-gray-500 hover:text-black">&lt; {{ t("Back to all resources") }}</a>
    </div>

    <!-- Description -->
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold pb-2">{{ t("Description") }}</h2>
        <div class="divider"></div>
        <p>{{ t("Dated: ") }} {{ \Carbon\Carbon::parse($resource->creation_date)->translatedFormat('F Y') }}</p>
        @php
            $authorTags = $resource->tags()->whereHas('tagType', function ($query) {
                $query->where('slug', 'authors');
            })->get();
            $authorCount = $authorTags->count();
            $authorLabel = $authorCount === 1 ? t("Author:") : t("Authors:");
        @endphp
        <p>{{ $authorLabel }}
            @foreach($authorTags as $authorTag)
                {{ $authorTag->name }}@if(!$loop->last), @endif
            @endforeach
        </p>
        <p class="mt-4">{{ strip_tags($resource->description) }}</p>
    </div>

    <!-- Divider -->
    <div class="border-t border-black mx-20 my-6"></div>

    <!-- Content -->
    <div id="trove-content" class="container mx-auto p-6">
        <h2 class="text-xl font-bold pb-2">{{ t("View/download") }}</h2>
        <div class="divider"></div>

        <!-- Embedded Youtube Video -->
        <div class="pb-8">
            @if($resource->youtube_links)
                @php
                    $youtubeLinks = $resource->getTranslation('youtube_links', app()->getLocale());
                    if (isset($youtubeLinks['youtube_id'])) {
                        $youtubeLinks = [$youtubeLinks];
                    }
                    $videoCount = count($youtubeLinks);
                @endphp

                @if($videoCount > 0)
                    <p class="text-lg mb-4">
                        {{ $videoCount === 1 ? t("This resource includes a video on our YouTube channel, embedded here.") : t("This resource includes videos on our YouTube channel, embedded here.") }}
                    </p>

                    @foreach($youtubeLinks as $link)
                        @php
                            $youtubeId = $link['youtube_id'] ?? null;
                        @endphp
                        <div class="flex justify-center mt-8">
                            <div class="iframe-container">
                                <iframe
                                    width="560"
                                    height="315"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                    frameborder="0"
                                    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>

        @php
            $externalLinks = $resource->getTranslation('external_links', app()->getLocale());
            if (isset($externalLinks['link_url'])) {
                $externalLinks = [$externalLinks];
            }

            $mediaFiles = $resource->getMedia('content_' . app()->getLocale());
        @endphp

        @if($externalLinks || $mediaFiles->isNotEmpty())
            <!-- Files and URLs -->
            <p class="text-lg py-8">
                {{ t("The individual components of the trove are listed below. Click on one to download the file or go to the 
                    external url. You can download the full trove below as a .zip file.") }}
            </p>  

            <div class="space-y-2"> <!-- This ensures equal spacing for both URLs and files -->
                <!-- URLs -->
                @if($externalLinks && is_array($externalLinks))
                    @foreach($externalLinks as $link)
                        @if(isset($link['link_url']) && isset($link['link_title']))
                            <div class="flex items-center justify-between p-4 border-l-8 border-stats4sd-red shadow-lg bg-white">
                                <div>
                                    <p class="text-xl font-bold">{{ $link['link_title'] }}</p>
                                    <p class="text-lg text-gray-600">{{ $link['link_url'] }}</p>
                                </div>
                                <div>
                                    <a href="{{ $link['link_url'] }}" target="_blank" rel="noopener noreferrer" class="bg-stats4sd-red text-white hover-effect px-4 py-2 rounded-2xl flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                        {{ t("VISIT LINK") }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                <!-- Files -->
                @if ($mediaFiles->isNotEmpty())
                    @foreach ($mediaFiles as $media)
                        <div class="flex items-center justify-between p-4 border-l-8 border-stats4sd-red shadow-lg bg-white">
                            <div>
                                <p class="text-lg font-bold">{{ $media->file_name }}</p>
                                <p class="text-gray-600">{{ Number::fileSize($media->size) }}</p>
                            </div>
                            <div>
                                <a href="{{ $media->getUrl() }}" target="_blank" rel="noopener noreferrer"
                                    class="bg-stats4sd-red text-white hover-effect px-4 py-2 rounded-2xl flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    {{ t("DOWNLOAD") }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if($mediaFiles->isNotEmpty())
                <!-- DOWNLOAD ALL (ZIP) BUTTON -->
                <div class="flex justify-end mt-12">
                    <a href="{{ route('trove.download.zip', ['slug' => $resource->slug]) }}" class="bg-stats4sd-red text-white hover-effect px-6 py-3 rounded-2xl text-lg font-bold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ t("DOWNLOAD ALL (ZIP)") }}
                    </a>
                </div>
            @endif
        @endif
    </div>

    <!-- Divider -->
    <div class="border-t border-black mx-20 my-6"></div>

    <!-- Collections -->
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold pb-2">{{ t("Collections including this resource") }}</h2>
        <div class="divider"></div>
        <livewire:trove-collections :resource="$resource"/>
    </div>

    <!-- Divider -->
    <div class="border-t border-black mx-20 my-6"></div>

    <!-- Related Resources -->
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold pb-2">{{ t("Related resources") }}</h2>
        <div class="divider"></div>
        <livewire:trove-related-troves :resource="$resource" />
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