<div class="relative">

    <div class="">
        <div class="flex flex-col lg:flex-row lg:gap-12">

            <!-- Resources Cards -->
            <div class="flex-1">
                <div class="p-8">
                    {{ t("Showing ") . $totalResources . t(" resources") }}
                </div>

                <div id="Resources-content" class="p-8 rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        @foreach ($resources as $resource)
                            <x-resource-result-card :item="$resource"/>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
