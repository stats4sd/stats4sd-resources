@props([
    'item'
])

<div
    class="card hover-effect relative flex shadow-xl flex-col justify-between bg-[#f2f2f2] overflow-hidden  rounded-t-3xl rounded-bl-3xl ">
    <a href="{{ url('resources/'.$item['slug']) }}" class="absolute inset-0 z-0"
       target="_blank"></a>
    <div class="flex flex-col justify-start">
        <div class="h-52 bg-cover bg-center mb-4 overflow-y-hidden">
            <img src="{{ $item['cover_image_thumb'] }}" class="overflow-y-hidden card-img w-full"/>
        </div>
        <div class="absolute top-4 left-4 h-12 w-12  rounded-full text-white text-center py-auto bg-black">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white" class="mx-auto my-3">
                <path d="M4 22v-20h16v11.543c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362zm18-7.614v-14.386h-20v24h10.189c3.163 0 9.811-7.223 9.811-9.614z"/>
            </svg>
        </div>
        @if (!empty($item['troveTypes']))
            <p class="text-sm text-stats4sd-red uppercase font-semibold mx-6 ">
                {{ $item['troveTypes']->sortBy('order')->first()->label ?? '' }}
            </p>
        @endif

        <p class="text-lg 2xl:text-xl font-bold mx-6 mb-3 xl:min-h-8 text-black"> {!! $item['title'] !!}</p>

        <p class="text-sm 2xl:text-base mb-2  flex-grow mx-6 mb-4 text-gray-600">
            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item['description']), ENT_QUOTES, 'UTF-8'), 110, '...') }}
        </p>

        <!-- Tags -->

        @if (!empty($item['tags']))
            <div class="flex flex-wrap gap-2 mb-2 mx-6 mb-4">
                @foreach ($item['tags']->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                    <div class="grey-badge ">{{ $tag->name }}</div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- View Button -->
    <div class="flex justify-end mb-2 pb-4 px-8 ">
        <button class="bg-stats4sd-red  text-white text-center py-2 px-8 rounded-full">
            {{ t("VIEW") }}
        </button>
    </div>

</div>
