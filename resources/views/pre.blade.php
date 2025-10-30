<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Today's Matches</title>

    <!-- Tailwind -->
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
    <script
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
      defer
    ></script>

    <style>
      html, body { height: 100%; }
      [x-cloak]{ display:none!important; }
      tbody[x-cloak], tbody { will-change: opacity; }

      /* =============== Neon glow for active card =============== */
      .neon { position: relative; filter: drop-shadow(0 0 6px var(--glow,#22c55e)) drop-shadow(0 0 16px var(--glow,#22c55e)); }
      .neon::before{
        content:""; position:absolute; inset:0; border-radius:.75rem; border:2px solid var(--glow,#22c55e);
        box-shadow: inset 0 0 10px var(--glow,#22c55e), 0 0 10px var(--glow,#22c55e);
        animation: neonPulse 1.8s ease-in-out infinite; pointer-events:none;
      }
      .neon-slate{ --glow:#22c55e; } .neon-blue{ --glow:#60a5fa; } .neon-amber{ --glow:#f59e0b; }
      @keyframes neonPulse{ 0%,100%{opacity:.85;filter:brightness(1)} 50%{opacity:1;filter:brightness(1.2)} }

      .show-scrollbar{ scrollbar-width:thin; scrollbar-color:#10b981 transparent; }
      .show-scrollbar::-webkit-scrollbar{ height:10px; }
      .show-scrollbar::-webkit-scrollbar-track{ background:transparent; }
      .show-scrollbar::-webkit-scrollbar-thumb{ background-color:#10b981; border-radius:9999px; border:2px solid transparent; background-clip:content-box; }

      :root{
        --card-bg: rgba(7,29,22,.72); --card-edge: rgba(20,83,45,.8);
        --row-odd: rgba(4,21,17,.65); --row-even: rgba(6,29,23,.7); --row-hover: rgba(16,185,129,.12);
        --divider: rgba(52,211,153,.18); --hdr-grad-1:#065f46; --hdr-grad-2:#047857; --hdr-gloss: rgba(255,255,255,.08);
        --chip-bg:#0b3b2f; --chip-edge:#10b981; --chip-txt:#a7f3d0; --txt-strong:#e6fff6; --txt-dim:#a6e9d4;
      }
      .table-card{
        background: linear-gradient(180deg, rgba(6,24,20,.75), rgba(4,17,14,.7)), var(--card-bg);
        backdrop-filter: blur(8px); border-radius:14px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.05), inset 0 -1px 0 rgba(0,0,0,.35),
                    0 8px 28px rgba(0,0,0,.45), 0 0 0 1px var(--card-edge);
        overflow:hidden;
      }
      .night-table{ width:100%; border-collapse:separate; border-spacing:0; }
      .night-th,.night-td{ border-right:1px solid var(--divider); }
      .night-th:last-child,.night-td:last-child{ border-right:0; }
      .night-thead{ color:var(--txt-strong); background:linear-gradient(180deg,var(--hdr-grad-1),var(--hdr-grad-2)); position:sticky; top:0; z-index:1; }
      .night-thead tr{ position:relative; }
      .night-thead tr::after{ content:""; position:absolute; left:0; right:0; bottom:0; height:1px; background:linear-gradient(90deg,transparent,var(--divider),transparent); }
      .night-th{ font-weight:700; letter-spacing:.02em; padding:.25rem .5rem; white-space:nowrap; }
      .night-tbody{ color:var(--txt-strong); }
      .night-row{ background:var(--row-odd); transition: background .2s ease, transform .15s ease; }
      .night-row:nth-child(even){ background:var(--row-even); }
      .night-row:hover{ background: color-mix(in srgb, var(--row-odd) 70%, var(--row-hover)); }
      .night-row:hover .night-td{ box-shadow: inset 0 0 0 9999px rgba(16,185,129,.03); }
      .night-td{ padding:.25rem .25rem; color:var(--txt-dim); border-top:1px solid var(--divider); }
      .night-td .strong, .night-td strong{ color:var(--txt-strong); }

      .chip{ display:inline-flex; align-items:center; gap:.35rem; padding:.15rem .45rem; border-radius:999px;
        background:linear-gradient(180deg,#083127,#072a22); color:var(--chip-txt); border:1px solid var(--chip-edge);
        box-shadow:0 0 12px rgba(16,185,129,.15), inset 0 1px 0 rgba(255,255,255,.06); font-weight:600;
      }
      .chip i{ opacity:.8; font-size:.7em; }

      .pill-btn{ display:inline-block; padding:.2rem .6rem; border-radius:999px;
        background: radial-gradient(120% 120% at 50% -20%, #34d399, #065f46);
        color:#052e2a; font-weight:700; border:1px solid rgba(16,185,129,.65);
        box-shadow:0 2px 10px rgba(16,185,129,.25), 0 0 0 1px rgba(16,185,129,.35) inset, 0 -2px 0 rgba(0,0,0,.25) inset;
        transition: transform .12s ease, filter .12s ease;
      }
      .pill-btn:hover{ transform:translateY(-1px); filter:brightness(1.05); }
      .pill-btn:active{ transform:translateY(0); filter:brightness(.98); }

      .table-glow{ box-shadow: 0 0 0 1px rgba(16,185,129,.25), 0 0 22px rgba(16,185,129,.18); }
      .minh{ min-height:160px; }

      @media (max-width:480px){
        .night-table{ table-layout:fixed; width:100%; }
        .night-th,.night-td{ padding:.18rem .28rem; white-space:normal; word-break:break-word; overflow-wrap:anywhere; }
        .night-table th:nth-child(1), .night-table td:nth-child(1){ width:18%; }
        .night-table th:nth-child(2), .night-table td:nth-child(2){ width:16%; }
        .night-table th:nth-child(3), .night-table td:nth-child(3){ width:28%; }
        .night-table th:nth-child(4), .night-table td:nth-child(4){ width:14%; }
        .night-table th:nth-child(5), .night-table td:nth-child(5){ width:14%; }
        .night-table th:nth-child(6), .night-table td:nth-child(6){ width:10%; }
        .chip{ transform:scale(.78); transform-origin:left center; padding:.06rem .3rem; border-width:1px; gap:.25rem; }
        .chip i{ display:none; }
        .pill-btn{ transform:scale(.82); transform-origin:right center; padding:.12rem .4rem; border-width:1px; white-space:nowrap; }
        .night-th{ letter-spacing:0; }
        .night-row:hover .night-td{ box-shadow:none; }
      }

      @media (min-width:1536px){
        .minh{ min-height:420px; }
        .table-card{ border-radius:18px; }
        .night-th,.night-td{ padding:.5rem .75rem; }
        .night-table{ table-layout:auto; }
        .chip{ font-size:.95rem; gap:.5rem; padding:.25rem .6rem; }
        .chip i{ display:inline-block; font-size:.85em; }
        .pill-btn{ padding:.35rem .9rem; font-size:.95rem; }
        .sport-card img{ transform:none; }
        .user-menu{ font-size:1rem; }
      }
    </style>
  </head>

  <body
    class="overflow-x-hidden bg-[url('{{ asset('images/table.png') }}')] bg-cover bg-center bg-no-repeat min-h-screen [min-height:100dvh]"
    x-data="{ sport: 'billiards' }"
  >
    <!-- Full-width NAV (edge-to-edge) -->
    <nav class="relative bg-slate-950 shadow-lg shadow-slate-800/50 w-full">
      <div
        class="px-2 py-2 2xl:px-12 2xl:py-[2px] flex font-semibold items-center justify-between text-[10px] 2xl:text-xl w-full 2xl:max-w-screen-2xl 2xl:mx-auto"
      >
        <img src="{{ asset('images/logo2real.png') }}" class="h-8 2xl:h-20" alt="Logo" />

        <ul class="flex flex-wrap space-x-5 2xl:space-x-20 text-slate-50 relative" x-data="{ open: false }">
          <!-- ✅ Laravel route links -->
          <li><a href="{{ route('dashboard') }}" class="hover:text-slate-300">Home</a></li>
          <li><a href="{{ route('pre') }}" class="hover:text-slate-300">Pre-Match</a></li>
          <li><a href="#" class="hover:text-slate-300">About</a></li>
          <li><a href="#" class="hover:text-slate-300">Event</a></li>

          <!-- Dropdown -->
          <li class="relative items-center">
            <button @click="open = !open" class="hover:text-slate-300 inline-flex items-center text-center">
              Sports
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 2xl:w-6 2xl:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <ul
              x-show="open"
              @click.outside="open = false"
              x-transition.opacity.duration.150ms
              class="absolute left-0 mt-2 bg-slate-900 text-white rounded-lg shadow-lg w-44 z-50 2xl:w-64 2xl:text-base"
            >
              <!-- Keep as js filters; no route change needed -->
              <li><a href="#" class="block px-4 py-2 hover:bg-slate-700" @click.prevent="sport='billiards'; open=false">Billiards</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-slate-700" @click.prevent="sport='horse'; open=false">Horse Racing</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-slate-700" @click.prevent="sport='motor'; open=false">Motor Racing</a></li>
            </ul>
          </li>
        </ul>

        <!-- User menu -->
        <div x-data="{ open: false }" class="flex space-x-1 relative -translate-x-8 items-center">
          <div class="flex cursor-pointer" @click="open = !open">
            <img src="{{ asset('images/icon.png') }}" class="h-3 2xl:h-13" alt="User" />
          </div>
          <div
            x-show="open"
            @click.outside="open = false"
            x-transition.opacity.duration.150ms
            class="absolute left-10 top-2 mt-2 2xl:top-11 w-18 2xl:w-35 text-xs bg-white border border-gray-200 rounded-lg shadow-lg z-[100] user-menu"
          >
            <ul class="text-gray-700 text-sm 2xl:text-base">
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a></li>
            </ul>
          </div>
          <span class="text-white">User1</span>
        </div>
      </div>
    </nav>

    <!-- Gradient wrapper fills the remaining viewport height -->
    <div class="overflow-x-hidden bg-gradient-to-b from-slate-950/70 via-slate-800/70 to-slate-700/30 min-h-full">
      <!-- 2xl layout container -->
      <div class="w-full 2xl:max-w-screen-2xl 2xl:mx-auto 2xl:flex 2xl:gap-4">
        <!-- MAIN CONTENT -->
        <main class="flex-1">
          <!-- Sports Cards -->
          <div class="flex space-x-4 justify-center my-2 2xl:my-6">
            <!-- Billiards -->
            <button
              class="sport-card relative bg-slate-400 rounded-xl overflow-hidden h-12 w-26 transition 2xl:h-40 2xl:w-85"
              @click="sport='billiards'"
              :class="sport==='billiards' ? 'neon neon-slate' : ''"
              aria-pressed="false"
            >
              <img src="{{ asset('images/billiardscard.png') }}" class="object-contain" alt="Billiards" />
            </button>

            <!-- Motor -->
            <button
              class="sport-card relative bg-slate-400 rounded-xl overflow-hidden h-12 w-26 transition 2xl:h-40 2xl:w-85"
              @click="sport='motor'"
              :class="sport==='motor' ? 'neon neon-blue' : ''"
              aria-pressed="false"
            >
              <img src="{{ asset('images/motorcard.png') }}" class="object-contain -translate-y-2 2xl:-translate-y-5" alt="Motor" />
            </button>

            <!-- Horse -->
            <button
              class="sport-card relative bg-slate-400 rounded-xl overflow-hidden h-12 w-26 transition 2xl:h-40 2xl:w-85"
              @click="sport='horse'"
              :class="sport==='horse' ? 'neon neon-amber' : ''"
              aria-pressed="false"
            >
              <img src="{{ asset('images/horsecard.png') }}" class="object-contain -translate-y-2 2xl:-translate-y-8" alt="Horse" />
            </button>
          </div>

          <div class="flex items-center">
            <h1 class="font-bold text-xs ml-2 my-2 text-slate-100 2xl:text-2xl 2xl:ml-44">Available Games:</h1>
            <h1 class="font-semibold text-xs ml-2 text-slate-300 2xl:text-xl">25 Games</h1>
          </div>

          <!-- Games Table -->
          <div class="flex justify-center 2xl:py-4">
            <div class="table-card table-glow rounded-lg overflow-hidden border border-slate-900/40 minh 2xl:w-[1200px]">
              <div class="show-scrollbar overflow-x-scroll 2xl:overflow-x-visible [scrollbar-width:thin] [scrollbar-gutter:stable_both-edges] [-webkit-overflow-scrolling:touch]">
                <div class="min-w-[800px] whitespace-nowrap">
                  <table class="night-table text-center min-w-[720px] 2xl:min-w-0">
                    <thead class="night-thead font-semibold text-[9px] 2xl:text-[16px] text-white">
                      <tr>
                        <th class="night-th px-2 py-1">Event</th>
                        <th class="night-th px-2 py-1">Venue</th>
                        <th class="night-th px-2 py-1">Participants</th>
                        <th class="night-th px-2 py-1">Status</th>
                        <th class="night-th px-2 py-1">Odds</th>
                        <th class="night-th px-2 py-1">Actions</th>
                      </tr>
                    </thead>

                    <!-- BILLIARDS BODY -->
                    <template x-if="sport==='billiards'">
                      <tbody class="night-tbody text-[5px] 2xl:text-[14px]" x-transition.opacity.duration.200ms x-cloak>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">World Billiards Final</span></td>
                          <td class="night-td">Manila</td>
                          <td class="night-td">Strickland vs. Reyes</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming / Live / Completed</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> Reyes 1.8 / Strickland 2.0</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Philippine Open QF</span></td>
                          <td class="night-td">Cebu</td>
                          <td class="night-td">Orcullo vs. Ko</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.9 / 1.9</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">City Invitational</span></td>
                          <td class="night-td">Davao</td>
                          <td class="night-td">Filler vs. Ouschan</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.85 / 2.05</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Legends Showdown</span></td>
                          <td class="night-td">Quezon City</td>
                          <td class="night-td">Bustamante vs. Parica</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.75 / 2.20</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Doubles Masters</span></td>
                          <td class="night-td">Baguio</td>
                          <td class="night-td">Gomez/Moritz vs. Ko/Woodward</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 2.30 / 1.65</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                      </tbody>
                    </template>

                    <!-- MOTOR RACING BODY -->
                    <template x-if="sport==='motor'">
                      <tbody class="night-tbody text-[5px] 2xl:text-[14px]" x-transition.opacity.duration.200ms x-cloak>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Grand Prix – Heat 1</span></td>
                          <td class="night-td">Clark International</td>
                          <td class="night-td">Team Apex vs. Velocity</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.90 / 1.95</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Street Circuit Sprint</span></td>
                          <td class="night-td">Subic</td>
                          <td class="night-td">Santos vs. Nakamura</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 2.10 / 1.75</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Time Attack Series</span></td>
                          <td class="night-td">Batangas Racing</td>
                          <td class="night-td">Rivera vs. Kim</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.85 / 2.05</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Drag Night Finals</span></td>
                          <td class="night-td">Cebu SRP</td>
                          <td class="night-td">Hayabusa vs. ZX-14R</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.70 / 2.20</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Endurance 200</span></td>
                          <td class="night-td">BRC</td>
                          <td class="night-td">TorqueWorks vs. RapidX</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 2.30 / 1.65</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                      </tbody>
                    </template>

                    <!-- HORSE RACING BODY -->
                    <template x-if="sport==='horse'">
                      <tbody class="night-tbody text-[5px] 2xl:text-[14px]" x-transition.opacity.duration.200ms x-cloak>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">San Lazaro Cup</span></td>
                          <td class="night-td">San Lazaro</td>
                          <td class="night-td">Thunderstrike vs. Golden Dusk</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 2.40 / 1.60</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Manila Derby Trial</span></td>
                          <td class="night-td">MetroTurf</td>
                          <td class="night-td">Blue Comet vs. Night Ember</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.95 / 1.95</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Weekend Handicap</span></td>
                          <td class="night-td">Santa Ana Park</td>
                          <td class="night-td">Silver Arrow vs. Red Lantern</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.80 / 2.05</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Night Sprint Series</span></td>
                          <td class="night-td">MetroTurf</td>
                          <td class="night-td">Jade Runner vs. Iron Fog</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 2.20 / 1.70</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td"><span class="strong">Metro Stakes</span></td>
                          <td class="night-td">San Lazaro</td>
                          <td class="night-td">Star Harbor vs. Quicksilver</td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-bolt"></i> Upcoming</span></td>
                          <td class="night-td"><span class="chip"><i class="fa-solid fa-coins"></i> 1.65 / 2.30</span></td>
                          <td class="night-td"><a href="#" class="pill-btn">View Match</a></td>
                        </tr>
                      </tbody>
                    </template>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </main>

        <!-- BETS BLOCK / RIGHT SIDEBAR -->
        <aside class="w-80 mx-auto 2xl:w-[26rem] shrink-0 my-3 2xl:my-4 2xl:sticky 2xl:top-4">
          <div class="rounded-2xl border border-slate-800/50 bg-gradient-to-b from-slate-950/90 to-slate-900/70 backdrop-blur-md shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="relative px-3 py-3 sm:px-4 sm:py-4">
              <div class="absolute inset-0 pointer-events-none"
                   style="background: radial-gradient(60% 80% at 50% 0%, rgba(16,185,129,.15), transparent 60%);"></div>
              <div class="relative flex items-center justify-between gap-2">
                <h2 class="text-slate-100 font-black tracking-wide text-sm sm:text-base">Bets</h2>

                <div class="flex items-center gap-1 sm:gap-2">
                  <button class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-100/90 border border-slate-500/30 hover:bg-slate-800/40 transition">Clear</button>
                  <button class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-950 bg-slate-400/90 hover:bg-slate-400 transition border border-slate-300/60">Export</button>
                </div>
              </div>

              <!-- Totals -->
              <div class="mt-3 grid grid-cols-2 gap-2 sm:gap-3">
                <div class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2">
                  <i class="fa-solid fa-coins text-slate-300/90 text-sm sm:text-base"></i>
                  <div>
                    <p class="text-[10px] sm:text-xs text-slate-300/80">Total Staked</p>
                    <p class="font-bold text-slate-100 text-sm sm:text-base">₱ 12,500</p>
                  </div>
                </div>
                <div class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2">
                  <i class="fa-solid fa-gem text-teal-300/90 text-sm sm:text-base"></i>
                  <div>
                    <p class="text-[10px] text-slate-300/80">Potential Payout</p>
                    <p class="font-bold text-slate-100 text-sm sm:text-base">₱ 21,750</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Column headers -->
            <div class="px-3 sm:px-4">
              <div class="text-[10px] sm:text-[11px] text-slate-300/80 font-semibold grid grid-cols-12 border-t border-slate-800/60">
                <div class="col-span-5 py-2">Match</div>
                <div class="col-span-3 py-2 text-center">Bet</div>
                <div class="col-span-2 py-2 text-center">Odds</div>
                <div class="col-span-2 py-2 text-right pr-1.5">Result</div>
              </div>
            </div>

            <!-- List -->
            <div class="max-h-64 sm:max-h-80 2xl:max-h-[520px] overflow-y-auto [scrollbar-width:thin] [scrollbar-color:#10b98133_transparent]">
              <ul class="divide-y divide-slate-800/50">
                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                  <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                    <div class="col-span-5">
                      <p class="text-slate-100 font-semibold leading-tight">#1232131</p>
                      <p class="text-[10px] sm:text-[11px] text-slate-300/70">Strickland vs. Reyes</p>
                    </div>
                    <div class="col-span-3 flex justify-center">
                      <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-slate-100">
                        <i class="fa-solid fa-coins text-slate-300 text-xs sm:text-sm"></i> ₱500
                      </span>
                    </div>
                    <div class="col-span-2 text-center"><span class="text-slate-200 font-semibold">1.90</span></div>
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
                      <p class="text-slate-100 font-semibold leading-tight">#1232132</p>
                      <p class="text-[10px] sm:text-[11px] text-slate-300/70">Orcullo vs. Ko</p>
                    </div>
                    <div class="col-span-3 flex justify-center">
                      <span class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-800/30 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-cyan-100">
                        <i class="fa-solid fa-gem text-xs sm:text-sm"></i> ₱1,000
                      </span>
                    </div>
                    <div class="col-span-2 text-center"><span class="text-slate-200 font-semibold">2.05</span></div>
                    <div class="col-span-2 text-right">
                      <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-slate-200 bg-slate-600/20 border border-slate-400/30">
                        <i class="fa-solid fa-circle-check text-[11px]"></i> Win
                      </span>
                    </div>
                  </div>
                </li>

                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                  <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                    <div class="col-span-5">
                      <p class="text-slate-100 font-semibold leading-tight">#1232133</p>
                      <p class="text-[10px] sm:text-[11px] text-slate-300/70">Filler vs. Ouschan</p>
                    </div>
                    <div class="col-span-3 flex justify-center">
                      <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-slate-100">
                        <i class="fa-solid fa-coins text-slate-300 text-xs sm:text-sm"></i> ₱750
                      </span>
                    </div>
                    <div class="col-span-2 text-center"><span class="text-slate-200 font-semibold">1.75</span></div>
                    <div class="col-span-2 text-right">
                      <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-rose-200 bg-rose-600/20 border border-rose-400/30">
                        <i class="fa-solid fa-circle-xmark text-[11px]"></i> Lost
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>

            <!-- Footer / summary -->
            <div class="px-3 sm:px-5 py-2.5 sm:py-3 border-t border-slate-800/60 bg-slate-950/60">
              <div class="flex items-center justify-between text-[11px] sm:text-[12px]">
                <div class="text-slate-300/80"><span class="mr-2">Open Bets:</span><span class="font-bold text-slate-100">3</span></div>
                <div class="flex items-center gap-3">
                  <div class="text-slate-300/80">Won: <span class="font-bold text-slate-100">2</span></div>
                  <div class="text-slate-300/80">Lost: <span class="font-bold text-slate-100">1</span></div>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>

    <script>
      AOS.init({ once: true });
    </script>
  </body>
</html>
