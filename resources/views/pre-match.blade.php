<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Today's Matches</title>

    <!-- Tailwind v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      crossorigin="anonymous"
    />

    <!-- AOS (kept) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
      /* Keep only essentials: x-cloak helper + NEON animation */
      [x-cloak]{ display:none !important; }

      .neon{
        position: relative;
        display: inline-block;
        border-radius: .75rem;
        filter: drop-shadow(0 0 6px var(--glow, #22c55e))
                drop-shadow(0 0 16px var(--glow, #22c55e));
      }
      .neon::before{
        content:"";
        position:absolute; inset:0; border-radius: inherit;
        border: 2px solid var(--glow);
        box-shadow: inset 0 0 10px var(--glow, #22c55e),
                    0 0 10px var(--glow, #22c55e);
        animation: neonPulse 1.8s ease-in-out infinite;
        pointer-events:none;
      }
      .neon-slate{ --glow:#22c55e; }
      .neon-blue{  --glow:#0090ff; }
      .neon-amber{ --glow:#f59e0b; }

      @keyframes neonPulse{
        0%,100%{ opacity:.85; filter:brightness(1); }
        50%{ opacity:1; filter:brightness(1.2); }
      }
    </style>
  </head>

  <body
    class="overflow-x-hidden bg-[url('images/loginPicture2.png')] bg-cover bg-center bg-no-repeat min-h-screen [min-height:100dvh]"
    x-data="{ sport: 'billiards' }"
  >
    <!-- NAV -->
    <nav class="inset-x-0 z-50 border-b border-amber-400/20 bg-black/60 backdrop-blur-xl shadow-[0_8px_30px_rgba(251,191,36,.08)]">
      <div class="mx-auto max-w-7xl flex items-center justify-between px-4 py-3">
        <a href="/" class="flex items-center gap-2 group">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-black font-extrabold text-lg shadow-[0_0_25px_rgba(251,191,36,.35)] ring-1 ring-amber-400/30">B</span>
          <span class="tracking-wide text-slate-100 group-hover:text-amber-300 transition">BK2025</span>
        </a>

        <div class="flex items-center gap-4">
          <a href="/" class="text-sm font-semibold hover:text-amber-300 transition">
            <i class="fa-solid fa-house text-amber-300 mr-1"></i> <span class="text-white">Home</span>
          </a>

          <div class="relative" x-data="{ open:false }">
            <button
              @click="open = !open" @click.away="open = false"
              class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition border border-white/10 text-sm font-medium"
            >
              <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-400 text-black text-xs font-extrabold ring-1 ring-amber-300/40">
                {{ strtoupper(substr($user?->username ?? 'U', 0, 1)) }}
              </span>
              <span class="text-white">{{ Auth::user()->name }}</span>
              <i class="fa-solid fa-chevron-down text-white text-[10px]"></i>
            </button>

            <div
              x-show="open" x-transition x-cloak
              class="absolute right-0 mt-2 w-56 rounded-xl border border-white/10 bg-black/85 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,.5)] overflow-hidden z-50"
            >
              <div class="px-4 py-3 border-b border-white/10">
                <p class="text-sm font-semibold text-amber-300">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400">{{ $user?->email ?? 'player@example.com' }}</p>
              </div>
              <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-slate-200 hover:bg-white/5">
                <i class="fa-regular fa-user mr-2 text-amber-300"></i> Profile
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-rose-300 hover:bg-white/5">
                  <i class="fa-solid fa-right-from-bracket mr-2"></i> Sign out
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- BG GRADIENT SHEET -->
    <div class="overflow-x-hidden bg-gradient-to-b from-slate-950/70 via-slate-800/70 to-slate-700/30 min-h-full">
      <div class="w-full 2xl:max-w-screen-2xl 2xl:mx-auto 2xl:flex 2xl:gap-4">
        <!-- MAIN -->
        <main class="flex-1">
          <!-- SPORT CARDS -->
          <div class="flex space-x-4 justify-center my-2 2xl:my-6">
            <!-- Billiards -->
            <div class="rounded-xl" :class="sport==='billiards' ? 'neon neon-slate' : ''">
              <button
                class="relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-40 2xl:w-85"
                @click="sport='billiards'" :aria-pressed="sport==='billiards'"
              >
                <img src="images/billiardscard.png" alt="Billiards" class="block w-full h-full object-contain" />
              </button>
            </div>

            <!-- Motor -->
            <div class="rounded-xl" :class="sport==='motor' ? 'neon neon-blue' : ''">
              <button
                class="relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-40 2xl:w-85"
                @click="sport='motor'" :aria-pressed="sport==='motor'"
              >
                <img src="images/motorcard.png" alt="Motor" class="block w-full h-full object-contain -translate-y-2 2xl:-translate-y-5" />
              </button>
            </div>

            <!-- Horse -->
            <div class="rounded-xl" :class="sport==='horse' ? 'neon neon-amber' : ''">
              <button
                class="relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-40 2xl:w-85"
                @click="sport='horse'" :aria-pressed="sport==='horse'"
              >
                <img src="images/horsecard.png" alt="Horse" class="block w-full h-full object-contain -translate-y-2 2xl:-translate-y-8" />
              </button>
            </div>
          </div>

          <div class="flex items-center">
            <h1 class="font-bold text-xs ml-2 my-2 text-white lg:text-4xl lg:ml-2">Available Games:</h1>
            <h1 class="font-semibold text-xs ml-2 text-white lg:text-3xl">25 Games</h1>
          </div>

          <!-- TABLE CARD -->
          <div class="flex justify-center 2xl:py-4">
            <div
              class="w-full max-w-[1200px] rounded-lg overflow-hidden border border-slate-900/40
                     bg-[linear-gradient(180deg,rgba(2,6,23,.75),rgba(15,23,42,.7))] backdrop-blur-md
                     shadow-[inset_0_1px_0_rgba(255,255,255,.05),inset_0_-1px_0_rgba(0,0,0,.35),0_8px_28px_rgba(0,0,0,.45),0_0_0_1px_rgba(51,65,85,.8)]"
            >
              <table class="w-full table-fixed border-separate border-spacing-0 text-center">
                <!-- Column widths -->
                <colgroup>
                  <col class="w-[22%]" />
                  <col class="w-[18%]" />
                  <col class="w-[28%]" />
                  <col class="w-[12%]" />
                  <col class="w-[12%]" />
                  <col class="w-[8%]" />
                </colgroup>

                <!-- HEAD -->
                <thead class="text-white sticky top-0 z-10">
                  <tr class="bg-gradient-to-b from-slate-900 to-slate-700 relative text-[9px] 2xl:text-[17px] font-semibold">
                    <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20 last:border-r-0">Event</th>
                    <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20 last:border-r-0">Venue</th>
                    <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20 last:border-r-0">Participants</th>
                    <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20 last:border-r-0">Status</th>
                    <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20 last:border-r-0">Odds</th>
                    <th class="px-2 py-1 font-bold tracking-[.02em]">Actions</th>
                  </tr>
                </thead>

                <!-- BILLIARDS BODY -->
                <template x-if="sport==='billiards'">
                  <tbody class="text-[5px] 2xl:text-[16px]" x-transition.opacity.duration.200ms x-cloak>
                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">World Billiards Final</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Manila</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Strickland vs. Reyes</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60
                          bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i>
                          Upcoming / Live / Completed
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60
                          bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i>
                          Reyes 1.8 / Strickland 2.0
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#"
                           class="inline-block rounded-full font-bold
                                  bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900
                                  border border-yellow-500/70 px-2 py-0.5 text-[.8em]
                                  shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset]
                                  hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Philippine Open QF</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Cebu</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Orcullo vs. Ko</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.9 / 1.9
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">City Invitational</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Davao</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Filler vs. Ouschan</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.85 / 2.05
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Legends Showdown</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Quezon City</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Bustamante vs. Parica</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.75 / 2.20
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Doubles Masters</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Baguio</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Gomez/Moritz vs. Ko/Woodward</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 2.30 / 1.65
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>
                  </tbody>
                </template>

                <!-- MOTOR BODY -->
                <template x-if="sport==='motor'">
                  <tbody class="text-[5px] 2xl:text-[14px]" x-transition.opacity.duration.200ms x-cloak>
                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Grand Prix – Heat 1</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Clark International</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Team Apex vs. Velocity</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.90 / 1.95
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Street Circuit Sprint</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Subic</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Santos vs. Nakamura</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 2.10 / 1.75
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Time Attack Series</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Batangas Racing</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Rivera vs. Kim</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.85 / 2.05
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Drag Night Finals</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Cebu SRP</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Hayabusa vs. ZX-14R</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.70 / 2.20
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Endurance 200</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">BRC</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">TorqueWorks vs. RapidX</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 2.30 / 1.65
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>
                  </tbody>
                </template>

                <!-- HORSE BODY -->
                <template x-if="sport==='horse'">
                  <tbody class="text-[5px] 2xl:text-[14px]" x-transition.opacity.duration.200ms x-cloak>
                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">San Lazaro Cup</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">San Lazaro</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Thunderstrike vs. Golden Dusk</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 2.40 / 1.60
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Manila Derby Trial</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">MetroTurf</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Blue Comet vs. Night Ember</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.95 / 1.95
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Weekend Handicap</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Santa Ana Park</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Silver Arrow vs. Red Lantern</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.80 / 2.05
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Night Sprint Series</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">MetroTurf</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Jade Runner vs. Iron Fog</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 2.20 / 1.70
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>

                    <tr class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="font-bold">Metro Stakes</span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">San Lazaro</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">Star Harbor vs. Quicksilver</td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-bolt opacity-80 text-[.9em] text-yellow-300"></i> Upcoming
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20 border-r last:border-r-0">
                        <span class="inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 border text-[.75em]
                          text-white border-blue-500/60 bg-gradient-to-b from-[#0b2545] to-[#071a35]
                          shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                          <i class="fa-solid fa-coins opacity-80 text-[.9em] text-yellow-300"></i> 1.65 / 2.30
                        </span>
                      </td>
                      <td class="px-1 py-1 text-white border-t border-slate-500/20">
                        <a href="#" class="inline-block rounded-full font-bold bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-2 py-0.5 text-[.8em] shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95 transition">View Match</a>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </table>
            </div>
          </div>
        </main>

        <!-- SIDEBAR (auth only, hidden for now - Adriane
        @auth
        <aside class="w-80 mx-auto 2xl:w-[26rem] shrink-0 my-3 2xl:my-4 2xl:sticky 2xl:top-4">
          <div class="rounded-2xl border border-slate-800/50 bg-gradient-to-b from-slate-950/90 to-slate-900/70 backdrop-blur-md shadow-2xl overflow-hidden">
      
            <div class="relative px-3 py-3 sm:px-4 sm:py-4">
              <div class="absolute inset-0 pointer-events-none [background:radial-gradient(60%_80%_at_50%_0%,rgba(16,185,129,.15),transparent_60%)]"></div>
              <div class="relative flex items-center justify-between gap-2">
                <h2 class="text-white font-black tracking-wide text-sm sm:text-base">Bets</h2>

                <div class="flex items-center gap-1 sm:gap-2">
                  <button class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-white/90 border border-slate-500/30 hover:bg-slate-800/40 transition">Clear</button>
                  <button class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-950 bg-slate-400/90 hover:bg-slate-400 transition border border-slate-300/60">Export</button>
                </div>
              </div>

  
              <div class="mt-3 grid grid-cols-2 gap-2 sm:gap-3">
                <div class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2">
                  <i class="fa-solid fa-coins text-yellow-300 text-sm sm:text-base"></i>
                  <div>
                    <p class="text-[10px] sm:text-xs text-white/80">Total Staked</p>
                    <p class="font-bold text-white text-sm sm:text-base">₱ 12,500</p>
                  </div>
                </div>
                <div class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2">
                  <i class="fa-solid fa-gem text-teal-300/90 text-sm sm:text-base"></i>
                  <div>
                    <p class="text-[10px] text-white/80">Potential Payout</p>
                    <p class="font-bold text-white text-sm sm:text-base">₱ 21,750</p>
                  </div>
                </div>
              </div>
            </div>

      
            <div class="px-3 sm:px-4">
              <div class="text-[10px] sm:text-[11px] text-white/80 font-semibold grid grid-cols-12 border-t border-slate-800/60">
                <div class="col-span-5 py-2">Match</div>
                <div class="col-span-3 py-2 text-center">Bet</div>
                <div class="col-span-2 py-2 text-center">Odds</div>
                <div class="col-span-2 py-2 text-right pr-1.5">Result</div>
              </div>
            </div>

      
            <div class="max-h-64 sm:max-h-80 2xl:max-h-[520px] overflow-y-auto [scrollbar-width:thin] [scrollbar-color:#10b98133_transparent]">
              <ul class="divide-y divide-slate-800/50">
                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                  <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                    <div class="col-span-5">
                      <p class="text-white font-semibold leading-tight">#1232131</p>
                      <p class="text-[10px] sm:text-[11px] text-white/70">Strickland vs. Reyes</p>
                    </div>
                    <div class="col-span-3 flex justify-center">
                      <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-white">
                        <i class="fa-solid fa-coins text-yellow-300 text-xs sm:text-sm"></i> ₱500
                      </span>
                    </div>
                    <div class="col-span-2 text-center">
                      <span class="text-white font-semibold">1.90</span>
                    </div>
                    <div class="col-span-2 text-right">
                      <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-amber-200 bg-amber-600/20 border border-amber-400/30">
                        <i class="fa-regular fa-clock text-[11px]"></i> Pending
                      </span>
                    </div>
                  </div>
                </li>

                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                  <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                    <div class="col-span-5">
                      <p class="text-white font-semibold leading-tight">#1232132</p>
                      <p class="text-[10px] sm:text-[11px] text-white/70">Orcullo vs. Ko</p>
                    </div>
                    <div class="col-span-3 flex justify-center">
                      <span class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-800/30 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-white">
                        <i class="fa-solid fa-gem text-xs sm:text-sm"></i> ₱1,000
                      </span>
                    </div>
                    <div class="col-span-2 text-center">
                      <span class="text-white font-semibold">2.05</span>
                    </div>
                    <div class="col-span-2 text-right">
                      <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-white bg-slate-600/20 border border-slate-400/30">
                        <i class="fa-solid fa-circle-check text-[11px]"></i> Win
                      </span>
                    </div>
                  </div>
                </li>

                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                  <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                    <div class="col-span-5">
                      <p class="text-white font-semibold leading-tight">#1232133</p>
                      <p class="text-[10px] sm:text-[11px] text-white/70">Filler vs. Ouschan</p>
                    </div>
                    <div class="col-span-3 flex justify-center">
                      <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-white">
                        <i class="fa-solid fa-coins text-yellow-300 text-xs sm:text-sm"></i> ₱750
                      </span>
                    </div>
                    <div class="col-span-2 text-center">
                      <span class="text-white font-semibold">1.75</span>
                    </div>
                    <div class="col-span-2 text-right">
                      <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-rose-200 bg-rose-600/20 border border-rose-400/30">
                        <i class="fa-solid fa-circle-xmark text-[11px]"></i> Lost
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>

       
            <div class="px-3 sm:px-5 py-2.5 sm:py-3 border-t border-slate-800/60 bg-slate-950/60">
              <div class="flex items-center justify-between text-[11px] sm:text-[12px]">
                <div class="text-white/80">
                  <span class="mr-2">Open Bets:</span>
                  <span class="font-bold text-white">3</span>
                </div>
                <div class="flex items-center gap-3">
                  <div class="text-white/80">Won: <span class="font-bold text-white">2</span></div>
                  <div class="text-white/80">Lost: <span class="font-bold text-white">1</span></div>
                </div>
              </div>
            </div>
          </div>
        </aside>
        @endauth
        ) -->
      </div>

      <footer>
        <div class="flex justify-center items-center my-2 sm:mt-3">
          <p class="text-[10px] md:text-[12px] text-gray-800 text-center bg-orange-50/60 rounded px-2 py-0.5 sm:py-1">
            ©2024-2025 BK2025 PLUS ALL RIGHT RESERVED
          </p>
        </div>
      </footer>
    </div>

    <script>
      AOS.init({ once: true });
    </script>
  </body>
</html>
