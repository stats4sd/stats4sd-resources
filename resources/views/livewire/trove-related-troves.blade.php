<div class="bg-lightgrey py-8 px-16">
    @if ($relatedTroves->isNotEmpty())
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($relatedTroves as $resource)
                    <div
                                    class="card hover-effect relative flex flex-col justify-between bg-[#f2f2f2] overflow-hidden  rounded-t-3xl rounded-bl-3xl ">
                                    <a href="/resources/{{ $resource->slug }}" class="absolute inset-0 z-0"
                                        target="_blank"></a>
                                    <div class="flex flex-col justify-start">
                                        <div class="h-52 bg-cover bg-center mb-4"
                                            style="background-image: url('/images/crops.png');">
                                        </div>
                                        <div
                                            class="absolute top-4 left-4 h-12 w-12 bg-black rounded-full text-white text-center py-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                viewBox="0 0 24 24" fill="white" class="mx-auto my-3">
                                                <path
                                                    d="M4 22v-20h16v11.543c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362zm18-7.614v-14.386h-20v24h10.189c3.163 0 9.811-7.223 9.811-9.614z" />
                                            </svg>
                                        </div>

                                        <p class="text-sm text-stats4sd-red uppercase font-semibold mx-6 ">
                                            {{ $resource->troveTypes->sortBy('order')->first()?->label ?? '' }}</p>
                                        <p class="text-lg 2xl:text-xl font-bold mx-6 mb-3 xl:min-h-8">
                                            {!! $resource['title'] !!}</p>

                                        <p class="text-gray-600 text-sm 2xl:text-base mb-2  flex-grow mx-6 mb-4">
                                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($resource['description']), ENT_QUOTES, 'UTF-8'), 110, '...') }}
                                        </p>

                                        <!-- Tags -->
                                        <div class="flex flex-wrap gap-2 mb-2 mx-6 mb-4">
                                            @foreach ($resource->themeAndTopicTags->sortBy(fn($tag) => strtolower($tag->name)) as $tag)
                                                @if (!empty($tag))
                                                    <div class="grey-badge">{{ $tag->name }}</div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- View Button -->
                                    <div class="flex justify-end mb-2 pb-4 px-8 ">
                                        <button class="bg-stats4sd-red text-white text-center py-2 px-8 rounded-full">
                                            {{ t('VIEW') }}
                                        </button>
                                    </div>

                                </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500">{{ t("No related resources found.") }}</p>
    @endif
</div>
