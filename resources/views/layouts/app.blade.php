<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buildr — @yield('title', 'Rakit PC Terbaik')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            flex: 1;
            text-decoration: none;
        }

        .nav-icon-wrap {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: transform .4s cubic-bezier(.34, 1.56, .64, 1), background .3s, box-shadow .3s;
        }

        .nav-item.active .nav-icon-wrap,
        .nav-item:hover .nav-icon-wrap {
            background: #C0533A;
            transform: translateY(-20px);
            box-shadow: 0 8px 24px rgba(192, 83, 58, .45);
        }

        .nav-icon-wrap svg {
            width: 22px;
            height: 22px;
            stroke: rgba(255, 255, 255, .4);
            transition: stroke .3s;
            fill: none;
        }

        .nav-item.active .nav-icon-wrap svg,
        .nav-item:hover .nav-icon-wrap svg {
            stroke: #fff;
        }

        .nav-label {
            font-size: 10px;
            letter-spacing: .03em;
            margin-bottom: 6px;
            color: rgba(255, 255, 255, .4);
            transition: color .3s;
            white-space: nowrap;
        }

        .nav-item.active .nav-label,
        .nav-item:hover .nav-label {
            color: rgba(255, 255, 255, .9);
        }

        @media(max-width:380px) {
            .nav-label {
                font-size: 8px;
            }

            .nav-icon-wrap {
                width: 36px;
                height: 36px;
            }

            .nav-item.active .nav-icon-wrap {
                transform: translateY(-16px);
            }
        }
    </style>
</head>

<body class="bg-parchment min-h-screen">

    @php
        $active = request()->is('/') ? 0 : (request()->is('compatibility') ? 1 : (request()->is('compare') ? 2 : 3));
    @endphp

    <nav class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-2rem)] max-w-sm">
        <div class="flex items-end justify-around rounded-full px-4 py-2 shadow-2xl" style="background:#1e1e1e">

            <a href="{{ route('welcome') }}" wire:navigate class="nav-item {{ $active === 0 ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span class="nav-label">Build</span>
            </a>

            <a href="{{ route('compatibility') }}" wire:navigate class="nav-item {{ $active === 1 ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="nav-label">Compatibility</span>
            </a>

            <a href="{{ route('compare') }}" wire:navigate class="nav-item {{ $active === 2 ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="nav-label">Compare</span>
            </a>

            @if(session('user_id'))
                <a href="{{ route('profile') }}" wire:navigate class="nav-item {{ $active === 3 ? 'active' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="nav-label">Profile</span>
                </a>
            @else
                <a href="{{ route('login') }}" wire:navigate class="nav-item {{ $active === 3 ? 'active' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span class="nav-label">Login</span>
                </a>
            @endif

        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-10 pb-32">
        @yield('content')
    </main>

    @livewireScripts

    <script>
        window.addEventListener('load', function () {
            @if(session('success')) showSuccess("{{ session('success') }}"); @endif
            @if(session('error')) showError("{{ session('error') }}"); @endif
            @if(session('info')) showInfo("{{ session('info') }}"); @endif
            @if(session('warning')) showWarning("{{ session('warning') }}"); @endif
        });
    </script>
</body>

</html>