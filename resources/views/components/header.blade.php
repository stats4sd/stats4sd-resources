<header class="bg-white shadow-md py-2 px-4 sm:px-20">
    <div class="container mx-auto flex justify-between items-center py-4">
        <div class="flex items-center space-x-4">
            <a href="https://stats4sd.org/">
                <img src="/images/Stats4SD_logo.png" alt="Stats4SD logo" class="h-4 w-auto">
            </a>
        </div>

        <nav>
            <ul class="flex space-x-6 text-lg font-semibold">
                <li><a href="/home"
                    class="{{ request()->is('home') && !$activeTab ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Library Home") }}
                </a></li>
                <li><a href="/home?activeTab=resources"
                    class="{{ $activeTab === 'resources' ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Resources") }}
                </a></li>
                <li><a href="/home?activeTab=collections"
                    class="{{ $activeTab === 'collections' ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Collections") }}
                </a></li>
                <li><a href="/home?activeTab=browse-all"
                    class="{{ $activeTab === 'browse-all' ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Browse all") }}
                </a></li>
                <li><a href="/home?activeTab=theme-pages"
                    class="{{ $activeTab === 'theme-pages' ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Theme Pages") }}
                </a></li>
                 <!-- Language Dropdown -->
                 <li class="relative nav-item dropdown" x-data="{ open: false }">
                    <a class="nav-link dropdown-toggle px-4 py-2 border-2 border-black text-black rounded-3xl hover:bg-gray-100 cursor-pointer"
                        role="button" aria-expanded="false" x-on:click="open = !open">
                        {{ t("Change Language") }}
                    </a>
                    <div class="language-dropdown-menu" x-show="open" x-on:click.outside="open = false" style="display:none">
                        <a class="dropdown-item" href="{{ URL::current() . '?locale=en' }}">English</a>
                        <a class="dropdown-item" href="{{ URL::current() . '?locale=es' }}">Español</a>
                        <a class="dropdown-item" href="{{ URL::current() . '?locale=fr' }}">Français</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>
