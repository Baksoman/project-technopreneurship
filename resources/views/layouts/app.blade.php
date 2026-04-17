{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buildr — @yield('title', 'Rakit PC Terbaik')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-parchment min-h-screen">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-parchment border-b border-charcoal/8 px-6 py-4">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="/" class="text-lg font-semibold text-charcoal">
                Buildr<span class="text-terracotta">.</span>
            </a>
            <div class="flex items-center gap-6 text-sm">
                <a href="/"
                    class="text-charcoal/60 hover:text-charcoal transition {{ request()->is('/') ? 'text-charcoal font-medium' : '' }}">Home</a>
                <a href="/compatibility"
                    class="text-charcoal/60 hover:text-charcoal transition {{ request()->is('compatibility') ? 'text-charcoal font-medium' : '' }}">Compatibility</a>
                <a href="/compare"
                    class="text-charcoal/60 hover:text-charcoal transition {{ request()->is('compare') ? 'text-charcoal font-medium' : '' }}">Compare</a>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main class="max-w-5xl mx-auto px-6 py-10">
        @yield('content')
    </main>

    @livewireScripts
</body>

</html>