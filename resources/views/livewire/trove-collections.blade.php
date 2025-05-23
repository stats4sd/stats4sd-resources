<div id="Collections-content" class="bg-lightgrey py-8 px-16">
    <div class="container mx-auto">
        @if($collections->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($collections as $collection)
                    <div class="card hover-effect relative flex flex-col justify-between bg-stats4sd-red text-white p-6 border border-gray-200 rounded-lg shadow-xl" data-category="Collections">

                        <a href="/collections/{{ $collection->id }}" class="absolute inset-0 z-0"></a>

                        <p class="text-xl font-bold">{{ $collection->title }}</p>

                        <p class="pt-8 mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($collection->description), ENT_QUOTES, 'UTF-8'), 120, '...') }}
                        </p>

                        <!-- View Button -->
                        <div class="flex justify-end">
                            <button class="bg-white text-stats4sd-red text-center py-2 px-8 rounded-lg">
                                {{ t("VIEW") }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">{{ t("No collections available for this resource.") }}</p>
        @endif
    </div>
</div>
