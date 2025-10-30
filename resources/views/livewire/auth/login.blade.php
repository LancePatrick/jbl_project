<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>BK2025 — Login</title>

  <!-- Tailwind CDN (quick fix) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>

  <style>
    .login-glass{
      border-radius:1rem;border:1px solid rgba(255,255,255,.1);
      background:rgba(255,255,255,.05);backdrop-filter:blur(16px);
      box-shadow:0 20px 60px rgba(0,0,0,.45)
    }
    .input-dark{
      width:100%;border-radius:.75rem;background:rgba(0,0,0,.4);
      border:1px solid rgba(100,116,139,.6);padding:.625rem .75rem;color:#e5e7eb
    }
    .input-dark:focus{
      outline:none;box-shadow:0 0 0 2px #f59e0b;border-color:#f59e0b
    }
    .btn-amber{
      display:inline-flex;width:100%;justify-content:center;align-items:center;border-radius:.75rem;
      background:linear-gradient(90deg,#fbbf24,#f97316);color:#000;padding:.625rem 1rem;
      font-weight:800;box-shadow:0 0 30px rgba(251,191,36,.35)
    }
    @media (min-width:1024px){.login-right{padding-right:clamp(2rem,8vw,6rem)}}
  </style>
</head>
<body class="min-h-dvh text-slate-100 antialiased">
  <!-- Background -->
  <div class="fixed inset-0 bg-[radial-gradient(65%_70%_at_20%_0%,rgba(168,85,247,0.25),transparent_60%),radial-gradient(70%_60%_at_100%_10%,rgba(147,51,234,0.2),transparent_60%),linear-gradient(180deg,#0a0211,40%,#0e0319,75%,#06010d)]"></div>
  <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px]"></div>

  <main class="relative grid min-h-dvh md:grid-cols-2">
    <!-- Left (nudged a bit to the right on md+) -->
    <section class="flex items-center justify-center md:justify-center px-6 md:px-8 lg:px-12">
      <div class="w-full max-w-xl md:pl-[6vw] lg:pl-[8vw] xl:pl-[10vw]">
        <img src="{{ asset('images/logo.png') }}" class="w-56 sm:w-64 md:w-72 drop-shadow-[0_0_35px_rgba(251,191,36,.5)] mb-6" alt="">
        <h1 class="font-bold tracking-tight text-4xl md:text-5xl">BK2025</h1>
        <p class="mt-3 text-lg text-slate-300">High-stakes. High energy.</p>
        <p class="text-amber-300 text-lg font-semibold">All in, every round.</p>
        <p class="mt-5 text-sm text-slate-400 max-w-md">
          Secure login. Encrypted sessions. Anti-cheat systems active.
        </p>
        <div class="mt-8 hidden md:block login-glass p-4 max-w-md">
          <p class="text-[12px] leading-relaxed text-slate-300">
            “BK2025 Arena” is for authorized players only. By continuing, you agree to monitoring and fair play enforcement.
          </p>
        </div>
      </div>
    </section>

    <!-- Right -->
    <section class="login-right flex items-center justify-center px-4 md:px-6 lg:px-8">
      <div class="w-full max-w-md">
        @if (session('status'))
          <div class="mb-4 rounded-xl border border-amber-400/30 bg-black/40 px-4 py-3 text-sm text-amber-200">{{ session('status') }}</div>
        @endif
        @error('login')
          <div class="mb-4 rounded-xl border border-rose-500/40 bg-rose-900/30 px-4 py-3 text-sm text-rose-200">{{ $message }}</div>
        @enderror

        <div class="login-glass">
          <form method="POST" action="{{ route('login.store') }}" class="p-6 space-y-4">
            @csrf
            <div>
              <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">Username</label>
              <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required
                     class="input-dark" placeholder="Username">
              @error('email') <p class="mt-1 text-xs text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div x-data="{ show:false }">
              <label for="password" class="block text-xs font-semibold text-slate-300 mb-1">Password</label>
              <div class="relative">
                <input :type="show ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required
                       class="input-dark pr-10" placeholder="••••••••">
                <button type="button" class="absolute inset-y-0 right-0 px-3 text-slate-400 hover:text-slate-200"
                        @click="show = !show" aria-label="Toggle password visibility">
                  <i class="fa-regular" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
              </div>
              @error('password') <p class="mt-1 text-xs text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between pt-1">
              <label class="inline-flex items-center gap-2 select-none">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-600 text-amber-500 focus:ring-amber-400">
                <span class="text-xs text-slate-300">Stay signed in</span>
              </label>
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-xs text-amber-300 hover:underline whitespace-nowrap">Forgot password?</a>
              @endif
            </div>

            <button type="submit" class="btn-amber mt-2">Sign In</button>
          </form>
        </div>

        @if (Route::has('register'))
        <div class="mt-4 space-x-1 text-sm text-center text-slate-300">
          <span>Don’t have an account?</span>
          <a href="{{ route('register') }}" class="font-semibold text-amber-300 hover:text-amber-200 underline underline-offset-2">Sign up</a>
        </div>
        @endif
      </div>
    </section>
  </main>

  <script defer src="https://unpkg.com/alpinejs"></script>
</body>
</html>
