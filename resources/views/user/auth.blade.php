<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechnoBuilder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .preserve-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }
        .perspective-1400 { perspective: 1400px; }
        .card-flip { transition: transform .85s cubic-bezier(.68,-.15,.27,1.15), min-height .3s ease; }
        .card-flip.is-flipped { transform: rotateY(180deg); }

        @keyframes cardIn {
            from { opacity: 0; transform: scale(.94) translateY(24px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-card-in { animation: cardIn .7s cubic-bezier(.22,1,.36,1) both; }

        .card-header::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse at 0% 110%, rgba(239,243,255,.18), transparent 55%),
                radial-gradient(ellipse at 110% -10%, rgba(239,243,255,.12), transparent 50%);
        }
        .card-header::after {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(239,243,255,.18) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .btn-primary::after {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(180deg, rgba(255,255,255,.12), transparent);
        }

        .field-input:focus {
            outline: none;
            border-color: #C0533A;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(192,83,58,.1);
        }
        .field-input:hover:not(:focus) { border-color: #C3CFEE; }
        .field-input:focus ~ .field-icon { color: #C0533A; }
    </style>
</head>
<body class="bg-parchment">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="animate-card-in perspective-1400 relative z-10 w-full max-w-[420px]">
            <div class="card-flip preserve-3d relative w-full" id="auth-card" style="min-height:560px">

                {{-- FRONT: Login --}}
                <div class="backface-hidden absolute inset-0 flex flex-col overflow-hidden rounded-3xl bg-white shadow-[0_40px_90px_rgba(14,27,69,.65),0_0_0_1px_rgba(239,243,255,.1)]">
                    <div class="card-header relative shrink-0 overflow-hidden bg-[#C0533A] px-10 pb-7 pt-9">
                        <p class="relative z-10 mb-5 text-[18px] font-bold tracking-tight text-white">Buildr</p>
                        <h1 class="relative z-10 mb-1 text-[22px] font-bold text-white">Selamat datang kembali</h1>
                        <p class="relative z-10 text-[13px] text-[#EFF3FF]/55">Masuk untuk melanjutkan</p>
                    </div>

                    <div class="flex-1 bg-white px-10 pb-9 pt-7">
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="relative mb-3">
                                <input id="login-email" name="email" type="email" required value="{{ old('email') }}" placeholder="Alamat email"
                                       class="field-input w-full rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-[#EFF3FF] py-3 pl-4 pr-11 text-[14px] text-[#0E1B45] placeholder-[#93A3C8] transition-all duration-200">
                                <span class="field-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#93A3C8] transition-colors duration-200">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </span>
                            </div>
                            <p id="email-error-login" class="text-[12px] text-red-600 mb-3 hidden">Format email tidak valid</p>

                            <div class="relative mb-3">
                                <input id="login-password" name="password" type="password" required placeholder="Password"
                                       class="field-input w-full rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-[#EFF3FF] py-3 pl-4 pr-11 text-[14px] text-[#0E1B45] placeholder-[#93A3C8] transition-all duration-200">
                                <span class="field-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#93A3C8] transition-colors duration-200">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                            </div>

                            <button type="submit"
                                    class="btn-primary relative w-full overflow-hidden rounded-[11px] bg-[#C0533A] py-[13px] text-[14px] font-semibold text-white shadow-[0_4px_18px_rgba(192,83,58,.35)] transition-all duration-200 hover:bg-[#A0432A] hover:shadow-[0_8px_24px_rgba(192,83,58,.45)] active:translate-y-0">
                                Masuk
                            </button>
                        </form>

                        <div class="my-4 flex items-center gap-3">
                            <div class="h-px flex-1 bg-[#EFF3FF]"></div>
                            <span class="whitespace-nowrap text-[12px] text-[#93A3C8]">atau masuk dengan</span>
                            <div class="h-px flex-1 bg-[#EFF3FF]"></div>
                        </div>

                        <a href="{{ route('google.redirect') }}"
                           class="flex w-full items-center justify-center gap-[9px] rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-white py-[11px] text-[13.5px] font-medium text-[#0E1B45] no-underline transition-all duration-200 hover:border-[#C3CFEE] hover:bg-[#EFF3FF]">
                            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            Lanjutkan dengan Google
                        </a>

                        <p class="mt-[18px] text-center text-[13px] text-slate-500">
                            Belum punya akun?
                            <button type="button" onclick="flipCard()"
                                    class="font-semibold text-[#C0533A] underline decoration-transparent underline-offset-2 transition-all duration-200 hover:text-[#A0432A] hover:decoration-[#A0432A]">
                                Daftar sekarang
                            </button>
                        </p>
                    </div>
                </div>

                {{-- BACK: Register --}}
                <div class="backface-hidden rotate-y-180 absolute inset-0 flex flex-col overflow-hidden rounded-3xl bg-white shadow-[0_40px_90px_rgba(14,27,69,.65),0_0_0_1px_rgba(239,243,255,.1)]">
                    <div class="card-header relative shrink-0 overflow-hidden bg-[#C0533A] px-10 pb-7 pt-9">
                        <p class="relative z-10 mb-5 text-[18px] font-bold tracking-tight text-white">Buildr</p>
                        <h1 class="relative z-10 mb-1 text-[22px] font-bold text-white">Buat akun baru</h1>
                        <p class="relative z-10 text-[13px] text-[#EFF3FF]/55">Bergabung dan mulai membangun PC</p>
                    </div>

                    <div class="flex-1 bg-white px-10 pb-9 pt-7">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="relative mb-3">
                                <input id="register-name" name="name" type="text" required value="{{ old('name') }}" placeholder="Nama lengkap"
                                       class="field-input w-full rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-[#EFF3FF] py-3 pl-4 pr-11 text-[14px] text-[#0E1B45] placeholder-[#93A3C8] transition-all duration-200">
                                <span class="field-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#93A3C8] transition-colors duration-200">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </span>
                            </div>

                            <div class="relative mb-3">
                                <input id="register-email" name="email" type="email" required value="{{ old('email') }}" placeholder="Alamat email"
                                       class="field-input w-full rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-[#EFF3FF] py-3 pl-4 pr-11 text-[14px] text-[#0E1B45] placeholder-[#93A3C8] transition-all duration-200">
                                <span class="field-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#93A3C8] transition-colors duration-200">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </span>
                            </div>
                            <p id="email-error-register" class="text-[12px] text-red-600 mb-3 hidden">Format email tidak valid</p>

                            <div class="relative mb-3">
                                <input id="register-password" name="password" type="password" required placeholder="Password (min. 8 karakter)"
                                       class="field-input w-full rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-[#EFF3FF] py-3 pl-4 pr-11 text-[14px] text-[#0E1B45] placeholder-[#93A3C8] transition-all duration-200">
                                <span class="field-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#93A3C8] transition-colors duration-200">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                            </div>

                            <div class="relative mb-3">
                                <input id="register-password-confirmation" name="password_confirmation" type="password" required placeholder="Konfirmasi password"
                                       class="field-input w-full rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-[#EFF3FF] py-3 pl-4 pr-11 text-[14px] text-[#0E1B45] placeholder-[#93A3C8] transition-all duration-200">
                                <span class="field-icon pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#93A3C8] transition-colors duration-200">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                            </div>
                            <p id="password-error" class="text-[12px] text-red-600 mb-3 hidden">Konfirmasi password salah</p>

                            <button type="submit"
                                    class="btn-primary relative w-full overflow-hidden rounded-[11px] bg-[#C0533A] py-[13px] text-[14px] font-semibold text-white shadow-[0_4px_18px_rgba(192,83,58,.35)] transition-all duration-200 hover:bg-[#A0432A] hover:shadow-[0_8px_24px_rgba(192,83,58,.45)] active:translate-y-0">
                                Daftar
                            </button>
                        </form>

                        <div class="my-4 flex items-center gap-3">
                            <div class="h-px flex-1 bg-[#EFF3FF]"></div>
                            <span class="whitespace-nowrap text-[12px] text-[#93A3C8]">atau daftar dengan</span>
                            <div class="h-px flex-1 bg-[#EFF3FF]"></div>
                        </div>

                        <a href="{{ route('google.redirect') }}"
                           class="flex w-full items-center justify-center gap-[9px] rounded-[11px] border-[1.5px] border-[#EFF3FF] bg-white py-[11px] text-[13.5px] font-medium text-[#0E1B45] no-underline transition-all duration-200 hover:border-[#C3CFEE] hover:bg-[#EFF3FF]">
                            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            Lanjutkan dengan Google
                        </a>

                        <p class="mt-[18px] text-center text-[13px] text-slate-500">
                            Sudah punya akun?
                            <button type="button" onclick="flipCard()"
                                    class="font-semibold text-[#C0533A] underline decoration-transparent underline-offset-2 transition-all duration-200 hover:text-[#A0432A] hover:decoration-[#A0432A]">
                                Masuk di sini
                            </button>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let isFlipped = false;

        function flipCard() {
            isFlipped = !isFlipped;
            const card = document.getElementById('auth-card');
            card.classList.toggle('is-flipped', isFlipped);

            const selector = isFlipped ? '.rotate-y-180' : '.backface-hidden:not(.rotate-y-180)';
            setTimeout(() => {
                const face = card.querySelector(selector);
                if (face) card.style.minHeight = Math.max(face.scrollHeight, 560) + 'px';
            }, isFlipped ? 0 : 420);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('auth-card');
            const faces = card.querySelectorAll('.backface-hidden');
            let max = 560;
            faces.forEach(f => { if (f.scrollHeight > max) max = f.scrollHeight; });
            card.style.minHeight = max + 'px';

            const emailRegister = document.getElementById('register-email');
            const emailLogin = document.getElementById('login-email');
            const emailErrorLogin = document.getElementById('email-error-login');
            const emailErrorRegister = document.getElementById('email-error-register');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            function adjustCardHeight() {
                const backFace = card.querySelector('.rotate-y-180');
                const frontFace = card.querySelector('.backface-hidden:not(.rotate-y-180)');
                const activeFace = isFlipped ? backFace : frontFace;
                if (activeFace) {
                    card.style.minHeight = Math.max(activeFace.scrollHeight, 560) + 'px';
                }
            }

            emailRegister.addEventListener('input', () => {
                if (emailRegister.value && !emailRegex.test(emailRegister.value)) {
                    emailRegister.classList.remove('border-[#EFF3FF]');
                    emailRegister.classList.add('border-red-600');
                    emailErrorRegister.classList.remove('hidden');
                } else {
                    emailRegister.classList.add('border-[#EFF3FF]');
                    emailRegister.classList.remove('border-red-600');
                    emailErrorRegister.classList.add('hidden');
                }
                adjustCardHeight();
            });

            emailLogin.addEventListener('input', () => {
                if (emailLogin.value && !emailRegex.test(emailLogin.value)) {
                    emailLogin.classList.remove('border-[#EFF3FF]');
                    emailLogin.classList.add('border-red-600');
                    emailErrorLogin.classList.remove('hidden');
                } else {
                    emailLogin.classList.add('border-[#EFF3FF]');
                    emailLogin.classList.remove('border-red-600');
                    emailErrorLogin.classList.add('hidden');
                }
                adjustCardHeight();
            });

            const password = document.getElementById('register-password');
            const confirmation = document.getElementById('register-password-confirmation');
            const errorMsg = document.getElementById('password-error');

            confirmation.addEventListener('input', () => {
                if (confirmation.value && password.value !== confirmation.value) {
                    confirmation.classList.remove('border-[#EFF3FF]');
                    confirmation.classList.add('border-red-600');
                    errorMsg.classList.remove('hidden');
                } else {
                    confirmation.classList.add('border-[#EFF3FF]');
                    confirmation.classList.remove('border-red-600');
                    errorMsg.classList.add('hidden');
                }
                adjustCardHeight();
            });
        });

        setTimeout(() => {
            @if(session('success'))
                showSuccess("{{ session('success') }}");
            @endif
            @if(session('error'))
                showError("{{ session('error') }}");
            @endif
            @if(session('info'))
                showInfo("{{ session('info') }}");
            @endif
        }, 100);
    </script>
</body>
</html>
