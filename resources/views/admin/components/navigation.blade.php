<!-- Navigation -->
<nav class="sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-white text-2xl font-bold flex items-center opacity-80">
                        <span class="text-3xl mr-3"></span>
                        <a href="/" class="nav-link">HEROES</a>
                    </h1>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-2">
                <a href="/clan" class="nav-link">О Клане</a>
                <a href="/gallery" class="nav-link">Галерея</a>
                <a href="/link" class="nav-link">Связь</a>
                <a href="/guide/north" class="nav-link">Полезное</a>
                <a href="#contact" class="nav-link">ЛК</a>
                <a href="#contact" class="nav-link">Вход</a>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-white hover:text-gray-300 focus:outline-none" onclick="toggleMobileMenu()">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#about" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">О Клане</a>
            <a href="#features" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Галерея</a>
            <a href="#gallery" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Связь</a>
            <a href="#contact" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Полезное</a>
            <a href="#contact" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">ЛК</a>
            <a href="#contact" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Вход</a>
        </div>
    </div>
</nav>
