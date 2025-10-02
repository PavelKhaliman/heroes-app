<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Клан Героев')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/heroes.css', 'resources/js/app.js', 'resources/js/heroes.js'])
    
    <style>
        body {
            background-image: url('{{ asset("Heroesback.png") }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="hero-overlay">
        <!-- Navigation -->
        <x-navigation />

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="text-white py-4">
            <div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 text-center">
                <p>&copy; 2025 HEROES</p>
            </div>
        </footer>
    </div>

</body>
</html>