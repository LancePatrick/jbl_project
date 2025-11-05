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
  [x-cloak]{ display:none !important; }
  tbody[x-cloak], tbody{ will-change: opacity; }

  /* =============== Neon glow for active card =============== */
  .neon{
    position: relative;
    display: inline-block;          /* ensures border radius + shadows wrap tightly */
    border-radius: 0.75rem;         /* match card radius */
    filter: drop-shadow(0 0 6px var(--glow, #22c55e))
            drop-shadow(0 0 16px var(--glow, #22c55e));
  }
  .neon::before{
    content:"";
    position:absolute;
    inset:0;                        /* perfectly even on all sides */
    border-radius: inherit;         /* keep corners identical to wrapper */
    border: 2px solid var(--glow);
    box-shadow: inset 0 0 10px var(--glow, #22c55e),
                0 0 10px var(--glow, #22c55e);
    animation: neonPulse 1.8s ease-in-out infinite;
    pointer-events:none;
  }
  .neon-slate{ --glow:#22c55e; }
  .neon-blue{  --glow:#0090ff; }
  .neon-amber{ --glow:#f59e0b; }

  /* remove baseline gap that caused the bottom offset */
  .sport-card{
    display: grid;                  /* easy centering */
    place-items: center;
    line-height: 0;                 /* kills inline image baseline space */
    border-radius: 0.75rem;         /* match wrapper radius exactly */
  }
  .sport-card img{
    display: block;                 /* removes inline baseline gap */
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  @keyframes neonPulse{
    0%,100%{ opacity:.85; filter:brightness(1); }
    50%{ opacity:1; filter:brightness(1.2); }
  }

  .show-scrollbar{ scrollbar-width:thin; scrollbar-color:#10b981 transparent; }
  .show-scrollbar::-webkit-scrollbar{ height:10px; }
  .show-scrollbar::-webkit-scrollbar-track{ background:transparent; }
  .show-scrollbar::-webkit-scrollbar-thumb{
    background-color:#10b981; /* slate */
    border-radius:9999px; border:2px solid transparent; background-clip:content-box;
  }

  /* =============== Night-Mode slate Table Styles =============== TABLE COLOR */
  :root{
    --card-bg: rgba(2,6,23,.72); /* slate-950 */
    --card-edge: rgba(51,65,85,.8); /* slate-700 */
    --row-odd: rgba(2,6,23,.65); /* slate-950 */
    --row-even: rgba(15,23,42,.7); /* slate-900 */
    --row-hover: rgba(148,163,184,.12); /* slate-400 tint */
    --divider: rgba(100,116,139,.18); /* slate-500 */
    --hdr-grad-1:#0f172a; /* slate-900 */
    --hdr-grad-2:#334155; /* slate-700 */
    --hdr-gloss:rgba(255,255,255,.08);
    --chip-bg:#111827; /* near-slate deep bg */
    --chip-edge:#64748b; /* slate-500 */
    --chip-txt:#cbd5e1; /* slate-300 */
    --txt-strong:#e2e8f0; /* slate-200 */
    --txt-dim:#94a3b8; /* slate-400 */
  }

  .table-card{
    background:linear-gradient(180deg, rgba(2,6,23,.75), rgba(15,23,42,.7)), var(--card-bg);
    backdrop-filter: blur(8px);
    border-radius:14px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.05),
                inset 0 -1px 0 rgba(0,0,0,.35),
                0 8px 28px rgba(0,0,0,.45),
                0 0 0 1px var(--card-edge);
    overflow:hidden;
  }
  .night-table{ width:100%; border-collapse:separate; border-spacing:0; }
  .night-th, .night-td{ border-right:1px solid var(--divider); }
  .night-th:last-child, .night-td:last-child{ border-right:0; }
  .night-thead{
    color:var(--txt-strong);
    background:linear-gradient(180deg, var(--hdr-grad-1), var(--hdr-grad-2));
    position:sticky; top:0; z-index:1;
  }
  .night-thead tr{ position:relative; }
  .night-thead tr::after{
    content:""; position:absolute; left:0; right:0; bottom:0; height:1px;
    background:linear-gradient(90deg, transparent, var(--divider), transparent);
  }
  .night-th{ font-weight:700; letter-spacing:.02em; padding:.25rem .5rem; white-space:nowrap; }

  .night-tbody{ color:var(--txt-strong); }
  .night-row{ background:var(--row-odd); transition: background .2s ease, transform .15s ease; }
  .night-row:nth-child(even){ background:var(--row-even); }
  .night-row:hover{ background: color-mix(in srgb, var(--row-odd) 70%, var(--row-hover)); }
  .night-row:hover .night-td{ box-shadow: inset 0 0 0 9999px rgba(16,185,129,.03); }
  .night-td{ padding:.25rem .25rem; color:var(--txt-dim); border-top:1px solid var(--divider); }
  .night-td .strong, .night-td strong{ color:var(--txt-strong); }

  .chip{
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.15rem .45rem; border-radius:999px;
    background:linear-gradient(180deg,#0b2545,#071a35); /* deep navy → darker navy */
    color:#cfe3ff; border:1px solid rgba(59,130,246,.6); /* blue-500 edge */
    box-shadow:0 0 12px rgba(59,130,246,.18), inset 0 1px 0 rgba(255,255,255,.06);
    font-weight:600;
  }
  .chip i{ opacity:.8; font-size:.7em; }

  .pill-btn{
    display:inline-block; padding:.2rem .6rem; border-radius:999px;
    background:radial-gradient(120% 120% at 50% -20%, #fde047, #ca8a04); /* yellow-300 → yellow-600 */
    color:#0b1220; font-weight:700;
    border:1px solid rgba(234,179,8,.65);
    box-shadow:0 2px 10px rgba(234,179,8,.25),
               0 0 0 1px rgba(234,179,8,.35) inset,
               0 -2px 0 rgba(0,0,0,.25) inset;
    transition: transform .12s ease, filter .12s ease;
  }
  .pill-btn:hover{ transform: translateY(-1px); filter: brightness(1.05); }
  .pill-btn:active{ transform: translateY(0); filter: brightness(.98); }

  .table-glow{ box-shadow: 0 0 0 1px rgba(16,185,129,.25), 0 0 22px rgba(16,185,129,.18); }
  .minh{ min-height:160px; }

  /* ===== Super-compact table on small screens (6 columns) ===== */
  @media (max-width:480px){
    .night-table{ table-layout:fixed; width:100%; }
    .night-th, .night-td{ padding:.18rem .28rem; white-space:normal; word-break:break-word; overflow-wrap:anywhere; }
    .night-table th:nth-child(1), .night-table td:nth-child(1){ width:18%; } /* Event */
    .night-table th:nth-child(2), .night-table td:nth-child(2){ width:16%; } /* Venue */
    .night-table th:nth-child(3), .night-table td:nth-child(3){ width:28%; } /* Participants */
    .night-table th:nth-child(4), .night-table td:nth-child(4){ width:14%; } /* Status */
    .night-table th:nth-child(5), .night-table td:nth-child(5){ width:14%; } /* Odds */
    .night-table th:nth-child(6), .night-table td:nth-child(6){ width:10%; } /* Actions */
    .chip{ transform:scale(.78); transform-origin:left center; padding:.06rem .3rem; border-width:1px; gap:.25rem; }
    .chip i{ display:none; }
    .pill-btn{ transform:scale(.82); transform-origin:right center; padding:.12rem .4rem; border-width:1px; white-space:nowrap; }
    .night-th{ letter-spacing:0; }
    .night-row:hover .night-td{ box-shadow:none; }
  }

  /* ===== 2XL (≥1536px) ===== */
  @media (min-width:1536px){
    .minh{ min-height:420px; }
    .table-card{ border-radius:18px; }
    .night-th, .night-td{ padding:.5rem .75rem; }
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
    class="overflow-x-hidden bg-[url('images/loginPicture2.png')] bg-cover bg-center bg-no-repeat min-h-screen [min-height:100dvh]"
    x-data="{ sport: 'billiards' }"
  >
    <nav class=" inset-x-0 z-50 border-b border-amber-400/20 bg-black/60 backdrop-blur-xl shadow-[0_8px_30px_rgba(251,191,36,.08)]">
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
                  <i class="fa-solid fa-house text-amber-300 mr-1"></i> <span class=" text-white">Home</span>
              </a>

              <div class="relative" x-data="{ open:false }">
                  <button @click="open = !open" @click.away="open = false"
                          class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition border border-white/10 text-sm font-medium">
                      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-400 text-black text-xs font-extrabold ring-1 ring-amber-300/40">
                          {{ strtoupper(substr($user?->username ?? 'U', 0, 1)) }}
                      </span>
                      <span class=" text-white">{{Auth::user()->name}}</span>
                      <i class="fa-solid fa-chevron-down text-white text-[10px]"></i>
                  </button>

                  <div x-show="open" x-transition
                      class="absolute right-0 mt-2 w-56 rounded-xl border border-white/10 bg-black/85 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,.5)] overflow-hidden z-50">
                      <div class="px-4 py-3 border-b border-white/10">
                          <p class="text-sm font-semibold text-amber-300">{{Auth::user()->name}}</p>
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
    <div
      class="overflow-x-hidden bg-gradient-to-b from-slate-950/70 via-slate-800/70 to-slate-700/30 min-h-full"
    >
      <div class="w-full 2xl:max-w-screen-2xl 2xl:mx-auto 2xl:flex 2xl:gap-4">
        <!-- MAIN CONTENT -->
        <main class="flex-1">
          <!-- Sports Cards -->
          <div class="flex space-x-4 justify-center my-2 2xl:my-6">
            <!-- Billiards -->
            <div
              class="rounded-xl"
              :class="sport==='billiards' ? 'neon neon-slate' : ''"
            >
              <button
                class="sport-card relative bg-slate-400 rounded-xl overflow-hidden h-12 w-26 transition 2xl:h-40 2xl:w-85"
                @click="sport='billiards'"
                :aria-pressed="sport==='billiards'"
              >
                <img
                  src="images/billiardscard.png"
                  class="object-contain"
                  alt="Billiards"
                />
              </button>
            </div>

            <!-- Motor -->
            <div
              class="rounded-xl"
              :class="sport==='motor' ? 'neon neon-blue' : ''"
            >
              <button
                class="sport-card relative bg-slate-400 rounded-xl overflow-hidden h-12 w-26 transition 2xl:h-40 2xl:w-85"
                @click="sport='motor'"
                :aria-pressed="sport==='motor'"
              >
                <img
                  src="images/motorcard.png"
                  class="object-contain -translate-y-2 2xl:-translate-y-5"
                  alt="Motor"
                />
              </button>
            </div>

            <!-- Horse -->
            <div
              class="rounded-xl"
              :class="sport==='horse' ? 'neon neon-amber' : ''"
            >
              <button
                class="sport-card relative bg-slate-400 rounded-xl overflow-hidden h-12 w-26 transition 2xl:h-40 2xl:w-85"
                @click="sport='horse'"
                :aria-pressed="sport==='horse'"
              >
                <img
                  src="images/horsecard.png"
                  class="object-contain -translate-y-2 2xl:-translate-y-8"
                  alt="Horse"
                />
              </button>
            </div>
          </div>

          <div class="flex items-center">
            <h1
              class="font-bold text-xs ml-2 my-2 text-slate-100 lg:text-4xl lg:ml-2"
            >
              Available Games:
            </h1>
            <h1 class="font-semibold text-xs ml-2 text-slate-300 lg:text-3xl">
              25 Games
            </h1>
          </div>

          <!-- Games Table -->
          <div class="flex justify-center 2xl:py-4">
            <div
              class="table-card table-glow rounded-lg overflow-hidden border border-slate-900/40 lg:h-87 lg:w-[1200px]"
            >
              <div
                class="show-scrollbar overflow-x-scroll 2xl:overflow-x-visible [scrollbar-width:thin] [scrollbar-gutter:stable_both-edges] [-webkit-overflow-scrolling:touch]"
              >
                <div class="min-w-[800px] whitespace-nowrap">
                  <table
                    class="night-table text-center min-w-[720px] 2xl:min-w-0"
                  >
                    <thead
                      class="night-thead font-semibold text-[9px] 2xl:text-[16px] text-white"
                    >
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
                      <tbody
                        class="night-tbody text-[5px] 2xl:text-[14px]"
                        x-transition.opacity.duration.200ms
                        x-cloak
                      >
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">World Billiards Final</span>
                          </td>
                          <td class="night-td">Manila</td>
                          <td class="night-td">Strickland vs. Reyes</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming / Live / Completed</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              Reyes 1.8 / Strickland 2.0</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Philippine Open QF</span>
                          </td>
                          <td class="night-td">Cebu</td>
                          <td class="night-td">Orcullo vs. Ko</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.9 / 1.9</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">City Invitational</span>
                          </td>
                          <td class="night-td">Davao</td>
                          <td class="night-td">Filler vs. Ouschan</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.85 / 2.05</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Legends Showdown</span>
                          </td>
                          <td class="night-td">Quezon City</td>
                          <td class="night-td">Bustamante vs. Parica</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.75 / 2.20</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Doubles Masters</span>
                          </td>
                          <td class="night-td">Baguio</td>
                          <td class="night-td">Gomez/Moritz vs. Ko/Woodward</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              2.30 / 1.65</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                      </tbody>
                    </template>

                    <!-- MOTOR RACING BODY -->
                    <template x-if="sport==='motor'">
                      <tbody
                        class="night-tbody text-[5px] 2xl:text-[14px]"
                        x-transition.opacity.duration.200ms
                        x-cloak
                      >
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Grand Prix – Heat 1</span>
                          </td>
                          <td class="night-td">Clark International</td>
                          <td class="night-td">Team Apex vs. Velocity</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.90 / 1.95</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Street Circuit Sprint</span>
                          </td>
                          <td class="night-td">Subic</td>
                          <td class="night-td">Santos vs. Nakamura</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              2.10 / 1.75</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Time Attack Series</span>
                          </td>
                          <td class="night-td">Batangas Racing</td>
                          <td class="night-td">Rivera vs. Kim</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.85 / 2.05</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Drag Night Finals</span>
                          </td>
                          <td class="night-td">Cebu SRP</td>
                          <td class="night-td">Hayabusa vs. ZX-14R</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.70 / 2.20</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Endurance 200</span>
                          </td>
                          <td class="night-td">BRC</td>
                          <td class="night-td">TorqueWorks vs. RapidX</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              2.30 / 1.65</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                      </tbody>
                    </template>

                    <!-- HORSE RACING BODY -->
                    <template x-if="sport==='horse'">
                      <tbody
                        class="night-tbody text-[5px] 2xl:text-[14px]"
                        x-transition.opacity.duration.200ms
                        x-cloak
                      >
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">San Lazaro Cup</span>
                          </td>
                          <td class="night-td">San Lazaro</td>
                          <td class="night-td">
                            Thunderstrike vs. Golden Dusk
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              2.40 / 1.60</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Manila Derby Trial</span>
                          </td>
                          <td class="night-td">MetroTurf</td>
                          <td class="night-td">Blue Comet vs. Night Ember</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.95 / 1.95</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Weekend Handicap</span>
                          </td>
                          <td class="night-td">Santa Ana Park</td>
                          <td class="night-td">Silver Arrow vs. Red Lantern</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.80 / 2.05</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Night Sprint Series</span>
                          </td>
                          <td class="night-td">MetroTurf</td>
                          <td class="night-td">Jade Runner vs. Iron Fog</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              2.20 / 1.70</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                        <tr class="night-row">
                          <td class="night-td">
                            <span class="strong">Metro Stakes</span>
                          </td>
                          <td class="night-td">San Lazaro</td>
                          <td class="night-td">Star Harbor vs. Quicksilver</td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-bolt text-yellow-300"></i>
                              Upcoming</span
                            >
                          </td>
                          <td class="night-td">
                            <span class="chip"
                              ><i class="fa-solid fa-coins text-yellow-300"></i>
                              1.65 / 2.30</span
                            >
                          </td>
                          <td class="night-td">
                            <a href="#" class="pill-btn">View Match</a>
                          </td>
                        </tr>
                      </tbody>
                    </template>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </main>
        <!-- BETS BLOCK / RIGHT SIDEBAR (visible on all screens; compact on phones) -->
        @auth
          <aside
            class="w-80 mx-auto 2xl:w-[26rem] shrink-0 my-3 2xl:my-4 2xl:sticky 2xl:top-4">
            <div
              class="rounded-2xl border border-slate-800/50 bg-gradient-to-b from-slate-950/90 to-slate-900/70 backdrop-blur-md shadow-2xl overflow-hidden">
              
              <!-- Header -->
              <div class="relative px-3 py-3 sm:px-4 sm:py-4">
                <div
                  class="absolute inset-0 pointer-events-none"
                  style="
                    background: radial-gradient(
                      60% 80% at 50% 0%,
                      rgba(16, 185, 129, 0.15),
                      transparent 60%
                    );
                  "
                ></div>
                <div class="relative flex items-center justify-between gap-2">
                  <h2
                    class="text-slate-100 font-black tracking-wide text-sm sm:text-base"
                  >
                    Bets
                  </h2>

                  <!-- Quick actions -->
                  <div class="flex items-center gap-1 sm:gap-2">
                    <button
                      class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-100/90 border border-slate-500/30 hover:bg-slate-800/40 transition"
                    >
                      Clear
                    </button>
                    <button
                      class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-950 bg-slate-400/90 hover:bg-slate-400 transition border border-slate-300/60"
                    >
                      Export
                    </button>
                  </div>
                </div>

                <!-- Totals (compact on phones) -->
                <div class="mt-3 grid grid-cols-2 gap-2 sm:gap-3">
                  <div
                    class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2"
                  >
                    <i
                      class="fa-solid fa-coins text-yellow-300 text-slate-300/90 text-sm sm:text-base"
                    ></i>
                    <div>
                      <p class="text-[10px] sm:text-xs text-slate-300/80">
                        Total Staked
                      </p>
                      <p class="font-bold text-slate-100 text-sm sm:text-base">
                        ₱ 12,500
                      </p>
                    </div>
                  </div>
                  <div
                    class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2"
                  >
                    <i
                      class="fa-solid fa-gem text-teal-300/90 text-sm sm:text-base"
                    ></i>
                    <div>
                      <p class="text-[10px] text-slate-300/80">
                        Potential Payout
                      </p>
                      <p class="font-bold text-slate-100 text-sm sm:text-base">
                        ₱ 21,750
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Column headers -->
              <div class="px-3 sm:px-4">
                <div
                  class="text-[10px] sm:text-[11px] text-slate-300/80 font-semibold grid grid-cols-12 border-t border-slate-800/60"
                >
                  <div class="col-span-5 py-2">Match</div>
                  <div class="col-span-3 py-2 text-center">Bet</div>
                  <div class="col-span-2 py-2 text-center">Odds</div>
                  <div class="col-span-2 py-2 text-right pr-1.5">Result</div>
                </div>
              </div>

              <!-- List (scrollable: smaller on phones) -->
              <div
                class="max-h-64 sm:max-h-80 2xl:max-h-[520px] overflow-y-auto [scrollbar-width:thin] [scrollbar-color:#10b98133_transparent]"
              >
                <ul class="divide-y divide-slate-800/50">
                  <!-- Row -->
                  <li
                    class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition"
                  >
                    <div
                      class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm"
                    >
                      <div class="col-span-5">
                        <p class="text-slate-100 font-semibold leading-tight">
                          #1232131
                        </p>
                        <p class="text-[10px] sm:text-[11px] text-slate-300/70">
                          Strickland vs. Reyes
                        </p>
                      </div>
                      <div class="col-span-3 flex justify-center">
                        <span
                          class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-slate-100"
                        >
                          <i
                            class="fa-solid fa-coins text-yellow-300 text-slate-300 text-xs sm:text-sm"
                          ></i>
                          ₱500
                        </span>
                      </div>
                      <div class="col-span-2 text-center">
                        <span class="text-slate-200 font-semibold">1.90</span>
                      </div>
                      <div class="col-span-2 text-right">
                        <span
                          class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-amber-200 bg-amber-600/20 border border-amber-400/30"
                        >
                          <i class="fa-regular fa-clock text-[11px]"></i> Pending
                        </span>
                      </div>
                    </div>
                  </li>

                  <!-- Row -->
                  <li
                    class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition"
                  >
                    <div
                      class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm"
                    >
                      <div class="col-span-5">
                        <p class="text-slate-100 font-semibold leading-tight">
                          #1232132
                        </p>
                        <p class="text-[10px] sm:text-[11px] text-slate-300/70">
                          Orcullo vs. Ko
                        </p>
                      </div>
                      <div class="col-span-3 flex justify-center">
                        <span
                          class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-800/30 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-cyan-100"
                        >
                          <i class="fa-solid fa-gem text-xs sm:text-sm"></i>
                          ₱1,000
                        </span>
                      </div>
                      <div class="col-span-2 text-center">
                        <span class="text-slate-200 font-semibold">2.05</span>
                      </div>
                      <div class="col-span-2 text-right">
                        <span
                          class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-slate-200 bg-slate-600/20 border border-slate-400/30"
                        >
                          <i class="fa-solid fa-circle-check text-[11px]"></i> Win
                        </span>
                      </div>
                    </div>
                  </li>

                  <!-- Row -->
                  <li
                    class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition"
                  >
                    <div
                      class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm"
                    >
                      <div class="col-span-5">
                        <p class="text-slate-100 font-semibold leading-tight">
                          #1232133
                        </p>
                        <p class="text-[10px] sm:text-[11px] text-slate-300/70">
                          Filler vs. Ouschan
                        </p>
                      </div>
                      <div class="col-span-3 flex justify-center">
                        <span
                          class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-slate-100"
                        >
                          <i
                            class="fa-solid fa-coins text-yellow-300 text-slate-300 text-xs sm:text-sm"
                          ></i>
                          ₱750
                        </span>
                      </div>
                      <div class="col-span-2 text-center">
                        <span class="text-slate-200 font-semibold">1.75</span>
                      </div>
                      <div class="col-span-2 text-right">
                        <span
                          class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-rose-200 bg-rose-600/20 border border-rose-400/30"
                        >
                          <i class="fa-solid fa-circle-xmark text-[11px]"></i>
                          Lost
                        </span>
                      </div>
                    </div>
                  </li>

                  <!-- Add more rows as needed -->
                </ul>
              </div>

              <!-- Footer / summary -->
              <div
                class="px-3 sm:px-5 py-2.5 sm:py-3 border-t border-slate-800/60 bg-slate-950/60"
              >
                <div
                  class="flex items-center justify-between text-[11px] sm:text-[12px]"
                >
                  <div class="text-slate-300/80">
                    <span class="mr-2">Open Bets:</span>
                    <span class="font-bold text-slate-100">3</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="text-slate-300/80">
                      Won: <span class="font-bold text-slate-100">2</span>
                    </div>
                    <div class="text-slate-300/80">
                      Lost: <span class="font-bold text-slate-100">1</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </aside>
        @endauth
      </div>
      <footer>
            <div class="flex justify-center items-center my-2 sm:mt-3">
          <p
            class="text-[10px] md:text-[12px] text-gray-800 text-center bg-orange-50/60 rounded px-2 py-0.5 sm:py-1"
          >
            ©2024-2025 BK2025 PLUS ALL RIGHT RESERVED
          </p>
        </div>
          </footer>
    </div>

    <script>
      AOS.init({ once: true });
      // Optional: let bottom "Profile" open the existing menu on phones
      document.addEventListener("open-user", () => {
        // Try to click the top-right avatar to reuse that menu logic
        const avatar = document.querySelector('img[alt="User"]');
        if (avatar) avatar.click();
      });
    </script>
  </body>
</html>
