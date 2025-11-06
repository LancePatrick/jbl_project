@props(['user' => auth()->user()])

<!DOCTYPE html>
<html lang="en" x-data="{ profileOpen:false }">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BK2025</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        crossorigin="anonymous" />

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .font-display { font-family: 'Orbitron', sans-serif; }
        .font-body    { font-family: 'Rubik', sans-serif; }
    </style>

    @stack('before-scripts')
    @stack('style')
    @include('partials.head')
</head>

<body class="font-body min-h-screen text-slate-100 antialiased relative">
    <div class="fixed inset-0 bg-[radial-gradient(60%_60%_at_20%_10%,rgba(168,85,247,0.22),transparent_60%),radial-gradient(70%_60%_at_90%_0%,rgba(147,51,234,0.18),transparent_60%),linear-gradient(180deg,#0b0213,40%,#0f031a,70%,#07020f)]"></div>
    <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px]"></div>

    <nav class="fixed top-0 inset-x-0 z-50 border-b border-amber-400/20 bg-black/60 backdrop-blur-xl shadow-[0_8px_30px_rgba(251,191,36,.08)]">
        <div class="mx-auto max-w-7xl flex items-center justify-between px-4 py-3">
            <a href="/" class="flex items-center gap-2 group">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-black font-extrabold text-lg shadow-[0_0_25px_rgba(251,191,36,.35)] ring-1 ring-amber-400/30">
                    B
                </span>
                <span class="font-display tracking-wide text-slate-100 group-hover:text-amber-300 transition">
                    BK2025
                </span>
            </a>

            <div class="flex items-center gap-4">
                <a href="/" class="text-sm font-semibold hover:text-amber-300 transition">
                    <i class="fa-solid fa-house text-amber-300 mr-1"></i> Home
                </a>

                <div class="relative" x-data="{ open:false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition border border-white/10 text-sm font-medium">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-400 text-black text-xs font-extrabold ring-1 ring-amber-300/40">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </span>
                        <span>{{ Auth::user()->name ?? 'Player' }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </button>

                    <div x-show="open" x-transition
                        class="absolute right-0 mt-2 w-56 rounded-xl border border-white/10 bg-black/85 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,.5)] overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-white/10">
<<<<<<< HEAD
                            <p class="text-sm font-semibold text-amber-300">{{Auth::user()->name}}</p>
=======
                            <p class="text-sm font-semibold text-amber-300">{{ Auth::user()->name }}</p>
>>>>>>> 8b6c27a68eff291a9301447726e19c68baa4b1c1
                            <p class="text-xs text-slate-400">{{ $user?->email ?? 'player@example.com' }}</p>
                        </div>
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-slate-200 hover:bg-white/5">
                            <i class="fa-regular fa-user mr-2 text-amber-300"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-rose-300 hover:bg-white/5">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="relative z-10 pt-24 px-4 md:px-6 lg:max-w-7xl lg:mx-auto">
        {{ $slot }}
    </main>
    {{-- @include('components.notifications') --}}
    @stack('scripts')
</body>
</html>
