<div id="Resources-content" class="bg-lightgrey py-8 px-16">
    <div class="container mx-auto">
        @if($resources->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($resources as $resource)
                    <div class="card hover-effect relative flex flex-col justify-between bg-white p-6 border border-gray-200 rounded-lg shadow-xl">

                        <a href="/resources/{{ $resource->slug }}" class="absolute inset-0 z-0"></a>

                        <p class="text-xl uppercase">{{ $resource->troveTypes->sortBy('order')->first()?->label ?? '' }}</p>
                        <p class="text-xl text-stats4sd-red font-bold">{{ $resource->title }}</p>

                        <p class="pt-8 mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($resource->description), ENT_QUOTES, 'UTF-8'), 120, '...') }}
                        </p>
                        <!-- Tags -->
                        <div class="flex flex-wrap mb-4 gap-2 pt-8">
                            @php 
                                $tags = $resource->themeAndTopicTags;
                            @endphp
                            @foreach ($tags as $tag)
                                @if(!empty($tag))
                                    <div class="grey-badge">{{ $tag->name }}</div>
                                @endif
                            @endforeach
                        </div>
                        <!-- View Button -->
                        <div class="flex justify-end">
                            <button class="bg-black text-white text-center py-2 px-8 rounded-lg">
                                {{ t("VIEW") }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">{{ t("No resources available for this collection.") }}</p>
        @endif
    </div>
</div>
