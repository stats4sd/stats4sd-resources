<div class="bg-lightgrey py-8 px-16">
    @if ($relatedTroves->isNotEmpty())
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($relatedTroves as $resource)
                    <div class="card relative flex flex-col justify-between bg-white p-6 border border-gray-200 rounded-lg shadow-xl">

                        <!-- Title -->
                        <h3 class="text-xl text-stats4sd-red font-bold">{{ $resource->title }}</h3>

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
                            <a href="/resources/{{ $resource->slug }}" class="hover-effect bg-black text-white text-center py-2 px-8 rounded-lg">
                                {{ t("VIEW") }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500">{{ t("No related resources found.") }}</p>
    @endif
</div>
