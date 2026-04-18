<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin TechnoBuilder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .login-bg {
            min-height: 100vh;
            background: #f5f1e8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .nm-card {
            background: linear-gradient(145deg, #f7f3ea, #ede9e0);
            box-shadow: 12px 12px 28px #d4d0c7, -12px -12px 28px #ffffff;
            border-radius: 28px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 380px;
            animation: fadeInUp 0.55s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
        }

        .nm-logo-wrap {
            width: 72px;
            height: 72px;
            border-radius: 22px;
            background: linear-gradient(145deg, #ede9e0, #f7f3ea);
            box-shadow: inset 4px 4px 10px #d4d0c7, inset -4px -4px 10px #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .nm-btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            border-radius: 14px;
            background: linear-gradient(145deg, #f7f3ea, #ede9e0);
            box-shadow: 6px 6px 14px #d4d0c7, -6px -6px 14px #ffffff;
            font-size: 0.9rem;
            font-weight: 700;
            color: #374151;
            text-decoration: none;
            transition: box-shadow 0.25s ease, transform 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .nm-btn-google:hover {
            box-shadow: 4px 4px 10px #d4d0c7, -4px -4px 10px #ffffff;
            transform: translateY(-2px);
        }

        .nm-btn-google:active {
            box-shadow: inset 4px 4px 10px #d4d0c7, inset -4px -4px 10px #ffffff;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="login-bg">
        <div class="nm-card">
            <div class="nm-logo-wrap">
                <i class="fas fa-microchip text-3xl text-[#C0533A]"></i>
            </div>

            <div class="text-center mb-6">
                <h1 class="text-2xl font-extrabold text-slate-700 leading-tight">Admin Panel</h1>
                <p class="text-sm font-semibold text-slate-400 mt-1 tracking-wide">Buildr</p>
            </div>

            <a href="#" class="nm-btn-google">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Login dengan Google
            </a>
        </div>
    </div>

    @if(session('toastify'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastData = @json(json_decode(session('toastify')));
                showToast(toastData.message, toastData.type, 3000);
            });
        </script>
    @endif
</body>
</html>
