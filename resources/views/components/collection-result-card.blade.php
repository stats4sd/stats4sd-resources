@props([
    'item'
])

<div
    class="card hover-effect relative flex flex-col justify-between bg-black overflow-hidden  rounded-t-3xl rounded-bl-3xl ">
    <a href="{{ url('collections/'.$item['id']) }}" class="absolute inset-0 z-0"
       target="_blank"></a>
    <div class="flex flex-col justify-start">
        <div class="h-52 bg-cover bg-center mb-4 overflow-y-hidden">
            <img src="{{ $item['cover_image_thumb'] }}" class="overflow-y-hidden card-img w-full"/>
        </div>
        <div class="absolute top-4 left-4 h-12 w-12  rounded-full text-white text-center py-auto bg-stats4sd-red">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white" class="mx-auto my-3">
                <path d="M21.698 10.658l2.302 1.342-12.002 7-11.998-7 2.301-1.342 9.697 5.658 9.7-5.658zm-9.7 10.657l-9.697-5.658-2.301 1.343 11.998 7 12.002-7-2.302-1.342-9.7 5.657zm0-19l8.032 4.685-8.032 4.685-8.029-4.685 8.029-4.685zm0-2.315l-11.998 7 11.998 7 12.002-7-12.002-7z"/>
            </svg>
        </div>

        <p class="text-lg 2xl:text-xl font-bold mx-6 mb-3 xl:min-h-8 text-white"> {!! $item['title'] !!}</p>

        <p class=" text-sm 2xl:text-base mb-2  flex-grow mx-6 mb-4 text-white">
            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item['description']), ENT_QUOTES, 'UTF-8'), 110, '...') }}
        </p>

    </div>
    <!-- View Button -->
    <div class="flex justify-end mb-2 pb-4 px-8 ">
        <button class="bg-white text-black text-center py-2 px-8 rounded-full">
            {{ t("VIEW") }}
        </button>
    </div>

</div>
