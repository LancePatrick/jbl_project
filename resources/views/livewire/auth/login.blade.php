<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BK2025 — Login</title>

    {{-- Vite assets --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Font Awesome (Free, solid icons) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>

    {{-- Alpine.js (for password toggle) --}}
    <script defer src="https://unpkg.com/alpinejs"></script>

    {{-- Custom Fonts --}}
    <style>
        .font-display { font-family: 'Orbitron', sans-serif; }
        .font-body    { font-family: 'Rubik', sans-serif; }
    </style>

    {{-- Custom Styles --}}
    <style>
        .login-glass {
            border-radius: 1rem;
            border: 1px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.05);
            backdrop-filter: blur(16px);
            box-shadow: 0 20px 60px rgba(0,0,0,.45);
        }
        .input-dark {
            width: 100%;
            border-radius: .75rem;
            background: rgba(0,0,0,.4);
            border: 1px solid rgba(100,116,139,.6);
            padding: .625rem .75rem;
            color: #e5e7eb;
        }
        .input-dark:focus {
            outline: none;
            box-shadow: 0 0 0 2px #f59e0b;
            border-color: #f59e0b;
        }
        .btn-amber {
            display: inline-flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            border-radius: .75rem;
            background: linear-gradient(90deg,#fbbf24,#f97316);
            color: #000;
            padding: .625rem 1rem;
            font-weight: 800;
            box-shadow: 0 0 30px rgba(251,191,36,.35);
        }
        @media (min-width:1024px){
            .login-right { padding-right: clamp(2rem,8vw,6rem); }
        }
    </style>
</head>

<body class="font-body min-h-dvh text-slate-100 antialiased relative">

    {{-- Background Layers --}}
    <div class="fixed inset-0 bg-[radial-gradient(65%_70%_at_20%_0%,rgba(168,85,247,0.25),transparent_60%),radial-gradient(70%_60%_at_100%_10%,rgba(147,51,234,0.2),transparent_60%),linear-gradient(180deg,#0a0211,40%,#0e0319,75%,#06010d)]"></div>
    <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px]"></div>

    {{-- Page Layout --}}
    <div class="relative flex flex-col md:flex-row min-h-dvh">

        {{-- Left Panel --}}
        <div class="flex flex-col justify-center items-center text-center px-6 py-10 md:w-1/2 md:px-10 lg:px-16">
            <div class="max-w-md mx-auto">
                <img src="{{ asset('images/logo.png') }}" alt="BK2025"
                     class="w-52 sm:w-64 md:w-72 drop-shadow-[0_0_35px_rgba(251,191,36,.5)] mx-auto"/>

                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight mt-8">
                    BK2025
                </h1>

                </p>

                <p class="mt-6 text-[12px] sm:text-sm text-slate-500 max-w-sm mx-auto">
                    Secure login. Encrypted sessions. Anti-cheat systems active.
                </p>

                <div class="hidden md:block mt-8 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-[0_30px_80px_rgba(0,0,0,.7)] p-4">
                    <p class="text-[12px] leading-relaxed text-slate-300">
                        “BK2025 Arena” is for authorized players only. This site is for testing and for entertainment only. 
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Panel (Login Form) --}}
        <div class="flex flex-col justify-center px-4 py-10 md:w-1/2 md:px-8 lg:px-12">
            <div class="w-full max-w-md mx-auto">
                <div class="mb-6 text-center md:hidden">
                    <p class="text-sm text-slate-400">Welcome back — sign in to continue</p>
                </div>

                <div class="login-glass">
                    <form method="POST" action="{{ route('login.store') }}" class="p-6 space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">Username</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required
                                   class="input-dark" placeholder="Username">
                            @error('email')
                                <p class="mt-1 text-xs text-rose-300">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div x-data="{ show:false }">
                            <label for="password" class="block text-xs font-semibold text-slate-300 mb-1">Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" id="password" name="password"
                                       autocomplete="current-password" required
                                       class="input-dark pr-10" placeholder="••••••••">
                                <button type="button"
                                        class="absolute inset-y-0 right-0 px-3 text-slate-400 hover:text-slate-200"
                                        @click="show = !show" aria-label="Toggle password visibility">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-300">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between pt-1">
                            <label class="inline-flex items-center gap-2 select-none">
                                <input type="checkbox" name="remember"
                                       class="h-4 w-4 rounded border-slate-600 text-amber-500 focus:ring-amber-400">
                                <span class="text-xs text-slate-300">Stay signed in</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-amber-300 hover:underline whitespace-nowrap">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-amber mt-2">Sign In</button>
                    </form>
                </div>

                {{-- Register link --}}
                {{-- @if (Route::has('register'))
                <div class="mt-4 space-x-1 text-sm text-center text-slate-300">
                    <span>Don’t have an account?</span>
                    <a href="{{ route('register') }}"
                       class="font-semibold text-amber-300 hover:text-amber-200 underline underline-offset-2">
                       Sign up
                    </a>
                </div>
                @endif --}}
            </div>
        </div>
    </div>

    {{-- Notifications (optional) --}}
    {{-- @include('components.notifications') --}}
</body>
</html>
