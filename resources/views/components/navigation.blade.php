<!-- Navigation -->
<nav class="sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="welcome-title flex items-center text-white ml-0 sm:ml-[-2rem] lg:ml-[-4rem]" style="font-size: 1.5rem; line-height: 2rem;">
                        <a href="/" class="text-white font-extrabold no-underline hover:no-underline hover:text-white focus:text-white">HEROES</a>
                    </h1>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-2">
                @guest
                    <a href="/clan" class="nav-link">О Клане</a>
                    <a href="/link" class="nav-link">Связь</a>
                    <a href="{{ route('login') }}" class="nav-link">Вход</a>
                @else
                    @if(auth()->user()->role === 'authorized')
                        <a href="/clan" class="nav-link">О Клане</a>
                        <a href="/link" class="nav-link">Связь</a>
                        <a href="/account" class="nav-link">ЛК</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link">Выход</button>
                        </form>
                    @else
                        <a href="/clan" class="nav-link">О Клане</a>
                        <a href="/forum" class="nav-link">Форум</a>
                        <a href="/gallery/photo" class="nav-link">Галерея</a>
                        <a href="/link" class="nav-link">Связь</a>
                        <a href="/guide/north" class="nav-link">Гайды</a>
                        <a href="https://coldgun.ru/tools" class="nav-link">Таблицы</a>
                        <a href="/account" class="nav-link">ЛК</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link">Выход</button>
                        </form>
                    @endif
                @endguest
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
            @guest
                <a href="/clan" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">О Клане</a>
                <a href="/link" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Связь</a>
                <a href="{{ route('login') }}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Вход</a>
            @else
                @if(auth()->user()->role === 'authorized')
                    <a href="/clan" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">О Клане</a>
                    <a href="/link" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Связь</a>
                    <a href="/account" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">ЛК</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Выход</button>
                    </form>
                @else
                    <a href="/clan" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">О Клане</a>
                    <a href="/forum" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Форум</a>
                    <a href="/gallery/photo" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Галерея</a>
                    <a href="/link" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Связь</a>
                    <a href="/guide/north" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Полезное</a>
                    <a href="/account" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">ЛК</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-20">Выход</button>
                    </form>
                @endif
            @endguest
        </div>
    </div>
</nav>
