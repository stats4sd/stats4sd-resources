<div class="flex flex-wrap items-start gap-8">
    <!-- Resources Section -->
    <div class="flex flex-col flex-1">
        <h2 class="text-2xl font-bold mb-4">Resources</h2>
        <div class="flex flex-wrap gap-4 justify-center items-center">
            <!-- Resource Card 1 -->
            <div class="card bg-white p-6 border border-gray-200 rounded-lg shadow-xl flex-1 min-w-[300px] max-w-[48%]">
                <h3 class="text-xl font-semibold mb-2">TROVE</h3>
                <h3 class="text-xl text-bold text-stats4sd-red">{{ $latestResources->first()['title'] }}</h3>
                <p class="text-gray-600 pt-8 mb-4 flex-grow">
                    {{ \Illuminate\Support\Str::limit(strip_tags($latestResources->first()['description']), 120, '...') }}
                </p>
                <!-- Tags -->
                <div class="flex flex-wrap mb-4 gap-2 pt-8">
                    @php 
                        $tags = $latestResources->first()->themeAndTopicTags;
                    @endphp
                    @foreach ($tags as $tag)
                        @if(!empty($tag))
                            <div class="grey-badge">{{ $tag->name }}</div>
                        @endif
                    @endforeach
                </div>
                <!-- View Button -->
                <div class="flex justify-end">
                    <a href="https://stats4sd.org/resources/{{ $latestResources->first()->slug }}" target="_blank" class="hover-effect bg-black text-white text-center py-2 px-8 rounded-lg">
                        VIEW
                    </a>
                </div>
            </div>

            <!-- Resource Card 2 -->
            <div class="card bg-white p-6 border border-gray-200 rounded-lg shadow-xl flex-1 min-w-[300px] max-w-[48%]">
                <h3 class="text-xl font-semibold mb-2">TROVE</h3>
                <h3 class="text-xl text-bold text-stats4sd-red">{{ $latestResources->last()['title'] }}</h3>
                <p class="text-gray-600 pt-8 mb-4 flex-grow">
                    {{ \Illuminate\Support\Str::limit(strip_tags($latestResources->last()['description']), 120, '...') }}
                </p>
                <!-- Tags -->
                <div class="flex flex-wrap mb-4 gap-2 pt-8">
                    @php 
                        $tags = $latestResources->last()->themeAndTopicTags;
                    @endphp
                    @foreach ($tags->sortBy('name') as $tag)
                        @if(!empty($tag))
                            <div class="grey-badge">{{ $tag->name }}</div>
                        @endif
                    @endforeach
                </div>
                <!-- View Button -->
                <div class="flex justify-end">
                    <a href="https://stats4sd.org/resources/{{ $latestResources->last()->slug }}" target="_blank" class="hover-effect bg-black text-white text-center py-2 px-8 rounded-lg">
                        VIEW
                    </a>
                </div>
            </div>
        </div>
        <!-- See All Resources Button -->
        <div class="mt-6 mr-6 text-center md:text-right">
            <button
                onclick="scrollToSection('Resources-section')"
                class="text-stats4sd-red font-semibold hover:underline">
                See all
            </button>
        </div>
    </div>

    <!-- Collections Section -->
    <div class="flex flex-col flex-1 max-w-[35%] ml-0 md:ml-16">
        <h2 class="text-2xl font-bold mb-4">Collections</h2>
        <!-- Collections Card -->
        <div class="card bg-stats4sd-red text-white p-6 border border-gray-200 rounded-lg shadow-xl flex-1 min-w-[300px]">
            <h3 class="text-xl font-semibold mb-2">COLLECTION</h3>
            <h3 class="text-xl">{{ $latestCollection['title'] }}</h3>
            <p class="pt-8 mb-4 flex-grow">
                {{ \Illuminate\Support\Str::limit(strip_tags($latestCollection['description']), 120, '...') }}
            </p>
            <!-- View Button -->
            <div class="flex justify-end">
                <a href="https://stats4sd.org/collections/{{ $latestCollection->id }}" target="_blank" class="hover-effect bg-white text-stats4sd-red text-center py-2 px-8 rounded-lg">
                    VIEW
                </a>
            </div>
        </div>
        <!-- See All Collections Button -->
        <div class="mt-6 text-right">
            <button
                onclick="scrollToSection('Collections-section')"
                class="text-stats4sd-red font-semibold hover:underline">
                See all
            </button>
        </div>
    </div>
</div>