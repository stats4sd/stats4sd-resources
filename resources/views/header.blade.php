<header class="sticky top-0 z-50 bg-white shadow-md py-2 px-4 sm:px-20" x-data="{ open: false }">
    <div class="container mx-auto flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="https://stats4sd.org/">
                <img src="/images/Stats4SD_logo.png" alt="Stats4SD logo" class="h-4 w-auto">
            </a>
        </div>

        <!-- Hamburger Menu (visible on small screens) -->
        <button 
            class="sm:hidden text-gray-800 focus:outline-none" 
            x-on:click="open = !open">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Nav Items (hidden on small screens) -->
        <nav class="hidden sm:flex">
            <ul class="flex space-x-6 font-semibold">
                <li><a href="/home"
                    class="{{ request()->is('home') ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Library Home") }}
                </a></li>
                <li><a href="/resources"
                    class="{{ request()->is('resources') ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Resources") }}
                </a></li>
                <li><a href="/collections"
                    class="{{ request()->is('collections') ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Collections") }}
                </a></li>
                <li><a href="/browse-all"
                    class="{{ request()->is('browse-all') ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
                    {{ t("Browse all") }}
                </a></li>
                <li><a href="/theme-pages"
                    class="{{ request()->is('theme-pages') ? 'border-b-2 border-stats4sd-red pb-1' : '' }}">
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
        
        <!-- Nav Items (visible on small screens) -->
        <div 
            class="sm:hidden" 
            x-show="open"
            x-on:click.outside="open = false" 
            style="display: none;">
            <nav class="bg-white text-right">
                <ul class="flex flex-col space-y-2 px-6 pb-4">
                    <li><a href="/home" class="text-gray-800 hover:text-gray-600">{{ t("Library Home") }}</a></li>
                    <li><a href="/resources" class="text-gray-800 hover:text-gray-600">{{ t("Resources") }}</a></li>
                    <li><a href="/collections" class="text-gray-800 hover:text-gray-600">{{ t("Collections") }}</a></li>
                    <li><a href="/browse-all" class="text-gray-800 hover:text-gray-600">{{ t("Browse All") }}</a></li>
                    <li><a href="/theme-pages" class="text-gray-800 hover:text-gray-600">{{ t("Theme Pages") }}</a></li>
                    <li class="relative nav-item pt-2 text-gray-800" x-data="{ open: false }">
                        <a class="nav-link" role="button" x-on:click="open = !open">
                            {{ t("Change Language") }}
                        </a>
                        <ul class="language-options" x-show="open" x-on:click.outside="open = false" style="display:none">
                            <li><a class="pt-2" href="{{ URL::current() . '?locale=en' }}">English</a></li>
                            <li><a class="py-2" href="{{ URL::current() . '?locale=es' }}">Español</a></li>
                            <li><a href="{{ URL::current() . '?locale=fr' }}">Français</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
