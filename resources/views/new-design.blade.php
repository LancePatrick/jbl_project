{{-- resources/views/billiard.blade.php --}}
<x-layouts.app :title="__('Billiard')">
  <body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>

  <style>
    :root{
      --logro-bubble: 26px;      /* logro ring size */
      --bead-bubble: 26px;       /* road bead size */
      --col-gap: 6px;            /* column spacing */
      --row-gap: 6px;            /* row spacing */
      --rail-h: calc(var(--logro-bubble) * 8 + (var(--row-gap) * 5)); /* 6 rows tall */
      --logro-step: 3px;         /* faux 3D z-step */
    }
    @media (max-width: 768px){
      :root{
        --logro-bubble: 16px;
        --bead-bubble: 16px;
        --rail-h: calc(var(--logro-bubble) * 6 + (var(--row-gap) * 5));
      }
    }

    .main-panel{ min-width:0; }

    /* ===== LOGRO (Big Road look) ===== */
    .logro-rail{
      position:relative; height: var(--rail-h);
      overflow-x:auto; overflow-y:hidden; -webkit-overflow-scrolling: touch;
      padding-bottom: 2px; scrollbar-gutter: stable both-edges;
      min-width:0;
    }
    .logro-rail::-webkit-scrollbar{ height:8px }
    .logro-rail::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.2); border-radius:8px }

    .logro-strip-3d{
      display:inline-grid; grid-auto-flow: column; grid-auto-columns: max-content;
      column-gap: var(--col-gap); height:100%; contain: layout paint;
    }
    .logro-col{
      display:grid; grid-auto-rows: var(--logro-bubble); row-gap: var(--row-gap); align-content:start;
    }
    .ring-gap{
      width: var(--logro-bubble); height: var(--logro-bubble);
      opacity:.10; border:1px dashed rgba(255,255,255,.18); border-radius:999px;
    }
    .ring-bubble{
      width: var(--logro-bubble); height: var(--logro-bubble); border-radius:999px;
      border:3px solid currentColor;
      box-shadow: 0 2px 0 rgba(0,0,0,.35) inset, 0 0 0 2px rgba(255,255,255,.06) inset, 0 6px 16px rgba(0,0,0,.45);
      transform-style: preserve-3d;
    }
    .ring-red{
      color:#ef4444;
      background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.18), transparent 55%);
    }
    .ring-blue{
      color:#3b82f6;
      background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.18), transparent 55%);
    }
    .ring-green{
      color:#22c55e;
      background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.18), transparent 55%);
    }

    /* ===== ROAD (Bead) ===== */
    .bead-rail{
      position:relative; height: var(--rail-h);
      overflow-x:auto; overflow-y:hidden; -webkit-overflow-scrolling: touch;
      padding-bottom: 2px; scrollbar-gutter: stable both-edges; min-width:0;
    }
    .bead-rail::-webkit-scrollbar{ height:8px }
    .bead-rail::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.2); border-radius:8px }

    .bead-strip{
      display:inline-grid; grid-auto-flow:column; grid-auto-columns:max-content;
      column-gap:6px; height:100%; contain: layout paint;
    }
    .bead-col{
      display:grid; grid-auto-rows: var(--bead-bubble); row-gap:4px; align-content:start;
    }
    .bead, .bead-solid{
      width: var(--bead-bubble); height: var(--bead-bubble); border-radius:999px;
      border:2px solid rgba(255,255,255,.22); display:grid; place-items:center;
      font-size:10px; line-height:1; font-weight:600; color:#0f172a;
    }
    .bead-solid.red{ background:#ef4444; border-color:#ef4444; color:white; }
    .bead-solid.blue{ background:#3b82f6; border-color:#3b82f6; color:white; }
    .bead-solid.green{ background:#22c55e; border-color:#22c55e; color:white; }

    /* Chips / Cards */
    .odds-ribbon{
      background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,0));
      border:1px solid rgba(255,255,255,.15); border-radius:8px;
      padding:.25rem .5rem; display:inline-block;
    }
    .bet-card{
      background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,0));
      border:1px solid rgba(255,255,255,.12);
      border-radius:16px; padding:.75rem;
    }
    .bet-card.red{ box-shadow:0 10px 24px rgba(239,68,68,.15) }
    .bet-card.blue{ box-shadow:0 10px 24px rgba(59,130,246,.15) }
    .bet-card.green{ box-shadow:0 10px 24px rgba(16,185,129,.18) }

    .bet-btn{
      border-radius:10px; border:1px solid rgba(255,255,255,.16);
      background:rgba(255,255,255,.05);
    }
    .bet-btn.red:hover{ background:rgba(239,68,68,.25) }
    .bet-btn.blue:hover{ background:rgba(59,130,246,.25) }
    .bet-btn.green:hover{ background:rgba(16,185,129,.25) }

    .name-chip{
      display:inline-grid; place-items:center;
      width:2.2rem; height:2.2rem;
      border-radius:10px; border:1px solid rgba(255,255,255,.16);
      background:rgba(255,255,255,.05);
    }
    .amount-3d{
      text-shadow: 0 2px 0 rgba(0,0,0,.4), 0 10px 30px rgba(0,0,0,.35);
    }
    .video-shell{ contain: layout paint; }
  </style>

  <main class="max-w-screen-2xl 2xl:max-w-[2400px] mx-auto px-3 md:px-4 py-4">
    <div class="grid gap-6 md:grid-cols-[7fr_5fr]">

      <!-- LEFT: Video + (Logrohan + Road together) -->
      <div class="relative z-10 main-panel p-4 rounded-lg shadow-lg mt-2 bg-black/40 backdrop-blur-sm">
        <!-- Header (date / match / time) -->
        <div class="grid grid-cols-3 items-center mb-3 text-xs md:text-sm text-gray-300">
          <div id="event-date" class="text-left truncate pr-1"></div>
          <div class="text-center font-bold text-yellow-400 text-base md:text-lg">
            MATCH# <span id="match-no">—</span>
          </div>
          <div id="event-time" class="text-right truncate pl-1"></div>
        </div>

        <!-- Video -->
        <div class="mb-2 md:mb-3 relative -mx-4 md:mx-auto md:max-w-[85%] video-shell">
          <div class="relative aspect-[4/3] md:aspect-video rounded-2xl overflow-hidden">
            <div class="absolute inset-0 rounded-xl overflow-hidden z-10 pointer-events-none select-none">
              <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 animate-[pulse_4s_infinite] mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20 mix-blend-overlay animate-[glow-border_2s_ease-in-out_infinite_alternate]"></div>
            </div>
            <iframe
              id="youtube-video-main"
              class="absolute inset-0 w-full h-full rounded-xl relative z-20 border-4 border-transparent"
              src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
          </div>
        </div>

        <!-- MOBILE: All under video (Bet %, Draw, Cards, Bet Amount, Logro/Road) -->
        <div class="md:hidden space-y-[2px] mt-0 -mx-4 px-4">
          <!-- Bet % -->
          <div class="bg-gray-900/70 border border-white/10 rounded-2xl p-3 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
              <div class="text-[11px] uppercase tracking-[0.2em] text-white/70">Bet %</div>
              <div id="pct-total-label-mob" class="text-[11px] text-white/60">Total: ₱0</div>
            </div>
            <div class="relative h-2.5 rounded-full bg-black/60 border border-white/10 overflow-hidden mt-2">
              <div id="pct-red-mob"  class="absolute left-0 top-0 h-full bg-red-600/80" style="width:50%"></div>
              <div id="pct-blue-mob" class="absolute right-0 top-0 h-full bg-blue-600/80" style="width:50%"></div>
            </div>
            <div class="mt-1.5 flex items-center justify-between text-[10px] text-white/70">
              <div id="pct-red-label-mob">Red 50%</div>
              <div id="pct-blue-label-mob">Blue 50%</div>
            </div>
          </div>

          <!-- GREEN DRAW CARD (MOBILE) – COMPACT HEIGHT, FULL WIDTH -->
          <div class="bet-card green text-center rounded-2xl px-3 py-2 shadow-lg">
            <div class="flex items-center justify-between gap-3">
              <div class="flex items-center gap-2">
                <div class="name-chip text-sm w-8 h-8 rounded-lg">D</div>
                <div class="flex flex-col items-start leading-tight">
                  <div class="text-[10px] uppercase tracking-[0.24em] text-emerald-100/90">Draw</div>
                  <div class="text-[11px] font-semibold opacity-80">Any tie / even result</div>
                </div>
              </div>
              <div class="text-right leading-tight">
                <div class="amount-3d text-lg" id="draw-amount-mob"></div>
                <div class="mt-0.5">
                  <span class="odds-ribbon text-[10px] px-1.5 py-0.5" id="draw-odds-mob"></span>
                </div>
              </div>
            </div>
            @auth
              @if( auth()->user()->role_id == 2)
                <button class="bet-btn green mt-1.5 w-full px-3 py-1.5 text-[11px] font-semibold tracking-wide" id="bet-draw-mob">
                  BET DRAW
                </button>
              @endif
            @endauth
          </div>

          <!-- Cards (Red / Blue) SIDE-BY-SIDE -->
          <div class="bet-area grid grid-cols-2 gap-3">
            <div class="bet-card red text-center rounded-2xl px-3 py-3 shadow-lg">
              <div class="flex items-center justify-between gap-2">
                <div class="name-chip text-lg">R</div>
                <div class="text-[10px] uppercase tracking-[0.2em] text-red-100/80">Red side</div>
              </div>
              <div class="mt-1 text-xs font-semibold opacity-90 leading-tight min-h-[1.5rem]" id="player1-name-mob"></div>
              <div class="amount-3d text-2xl mt-0.5" id="meron-amount-mob"></div>
              <div class="mt-1">
                <span class="odds-ribbon text-[10px] px-1 py-0.5" id="meron-odds-mob"></span>
              </div>
              @auth
                @if( auth()->user()->role_id == 2)
                  <button class="bet-btn red mt-2 w-full px-3 py-2 text-xs font-semibold tracking-wide" id="bet-meron-mob">BET RED</button>
                @endif
              @endauth
            </div>

            <div class="bet-card blue text-center rounded-2xl px-3 py-3 shadow-lg">
              <div class="flex items-center justify-between gap-2">
                <div class="name-chip text-lg">B</div>
                <div class="text-[10px] uppercase tracking-[0.2em] text-sky-100/80">Blue side</div>
              </div>
              <div class="mt-1 text-xs font-semibold opacity-90 leading-tight min-h-[1.5rem]" id="player2-name-mob"></div>
              <div class="amount-3d text-2xl mt-0.5" id="wala-amount-mob"></div>
              <div class="mt-1">
                <span class="odds-ribbon text-[10px] px-1 py-0.5" id="wala-odds-mob"></span>
              </div>
              @auth
                @if( auth()->user()->role_id == 2)
                  <button class="bet-btn blue mt-2 w-full px-3 py-2 text-xs font-semibold tracking-wide" id="bet-wala-mob">BET BLUE</button>
                @endif
              @endauth
            </div>
          </div>

          <!-- Bet Amount + Chips (MOBILE) -->
          @auth
            @if( auth()->user()->role_id == 2)
            <div class="bg-gray-900/70 border border-white/10 rounded-2xl p-3 shadow-xl backdrop-blur-xl">
              <div class="flex items-center justify-between mb-2">
                <div class="text-[12px] uppercase tracking-[0.22em] text-white/70">Bet Amount</div>
                <div class="text-[11px] text-white/60">min ₱100</div>
              </div>
              <div class="flex flex-wrap items-center gap-2 mb-2">
                <input
                  type="number"
                  id="bet-amount-mob"
                  class="bet-input flex-1 min-w-[0] p-2 text-sm text-white bg-black/40 rounded-lg border border-white/15"
                  placeholder="Enter amount"
                  inputmode="numeric"
                />
                <div class="balance-pill text-yellow-300 text-xs px-2 py-1 rounded-full bg-black/40 border border-yellow-500/40">
                  Bal: ₱<span id="mid-balance-mob" class="amount">5,000</span>
                </div>
              </div>
              <div class="grid grid-cols-4 gap-1.5">
                <button class="chip3d chip-emerald chip-outline text-[11px] bet-chip" data-val="100" type="button">♦100</button>
                <button class="chip3d chip-blue chip-outline text-[11px] bet-chip" data-val="200" type="button">♦200</button>
                <button class="chip3d chip-black chip-outline text-[11px] bet-chip" data-val="500" type="button">♦500</button>
                <button class="chip3d chip-amber chip-outline text-[11px] bet-chip" data-val="1000" type="button">♦1000</button>
              </div>
            </div>
            @endif
          @endauth

          <!-- Combined (stacked) Logrohan + Road on mobile -->
          <div class="bg-[#0d1426]/80 border border-white/10 rounded-2xl p-2.5 shadow-xl backdrop-blur-xl">
            <div class="space-y-[6px]">
              <section class="rounded-xl border border-white/10 p-2">
                <div class="flex items-center justify-between mb-1">
                  <div class="text-[11px] uppercase tracking-[0.18em] text-white/70">Logrohan</div>
                  <div class="flex items-center gap-2 text-[10px]">
                    <div class="flex items-center gap-1">
                      <span class="inline-block rounded-full border-2 border-red-500 w-2.5 h-2.5"></span>
                      <span class="opacity-70">Red</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <span class="inline-block rounded-full border-2 border-blue-500 w-2.5 h-2.5"></span>
                      <span class="opacity-70">Blue</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <span class="inline-block rounded-full border-2 border-emerald-400 w-2.5 h-2.5"></span>
                      <span class="opacity-70">Draw</span>
                    </div>
                  </div>
                </div>

                @auth
                  @if( auth()->user()->role_id == 1)
                  <div class="flex flex-wrap items-center gap-2 mb-2">
                    <button id="btn-win-meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-[11px] font-bold hover:bg-red-700">+ Red win</button>
                    <button id="btn-win-wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-[11px] font-bold hover:bg-blue-700">+ Blue win</button>
                    <button id="btn-draw"      class="px-2 py-1 rounded bg-emerald-700/70 border border-white/10 text-[11px] font-bold hover:bg-emerald-600">+ Draw</button>
                    <button id="btn-cancel"    class="px-2 py-1 rounded bg-gray-900/70 border border-white/10 text-[11px] hover:bg-gray-900">Cancel fight</button>
                    <button id="btn-undo"      class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-[11px] hover:bg-gray-700">Undo</button>
                    <button id="btn-clear"     class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-[11px] hover:bg-gray-800">Clear</button>
                  </div>
                  @endif
                @endauth

                <div id="logro-rail-mob" class="logro-rail">
                  <div id="logro-strip-mob" class="logro-strip-3d"></div>
                </div>
              </section>

              <section class="rounded-xl border border-white/10 p-2">
                <div class="flex items-center justify-between mb-1">
                  <div class="text-[11px] uppercase tracking-[0.18em] text-white/70">Road</div>
                  <div class="flex items-center gap-2 text-[10px]">
                    <div class="flex items-center gap-1">
                      <span class="inline-block rounded-full border-2 border-red-500 w-2.5 h-2.5"></span>
                      <span class="opacity-70">Red</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <span class="inline-block rounded-full border-2 border-blue-500 w-2.5 h-2.5"></span>
                      <span class="opacity-70">Blue</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <span class="inline-block rounded-full border-2 border-emerald-400 w-2.5 h-2.5"></span>
                      <span class="opacity-70">Draw</span>
                    </div>
                  </div>
                </div>
                <div class="rounded-lg border border-dashed border-white/20 p-1.5">
                  <div id="bead-rail-mob" class="bead-rail">
                    <div id="bead-strip-mob" class="bead-strip"></div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>

        <!-- ======= COMBINED PANEL: Logrohan + Road (DESKTOP ONLY) ======= -->
        <div class="hidden md:block bg-[#0d1426]/70 border border-white/10 rounded-2xl p-3 md:max-w-[85%] mx-auto mt-3">
          <div class="grid gap-3 md:grid-cols-2">
            <!-- Logrohan -->
            <section class="rounded-xl border border-white/10 p-2">
              <div class="flex items-center justify-between mb-1">
                <div class="text-[11px] tracking-widest uppercase text-white/70">Logrohan</div>
                <div class="flex items-center gap-3 text-[10px]">
                  <div class="flex items-center gap-1">
                    <span class="inline-block rounded-full border-2 border-red-500 w-3 h-3"></span>
                    <span class="opacity-70">Red</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <span class="inline-block rounded-full border-2 border-blue-500 w-3 h-3"></span>
                    <span class="opacity-70">Blue</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <span class="inline-block rounded-full border-2 border-emerald-400 w-3 h-3"></span>
                    <span class="opacity-70">Draw</span>
                  </div>
                </div>
              </div>

              @auth
                @if( auth()->user()->role_id == 1)
                <div class="flex flex-wrap items-center gap-2 mb-2">
                  <button id="btn-win-meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-xs font-bold hover:bg-red-700">+ Red win</button>
                  <button id="btn-win-wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-xs font-bold hover:bg-blue-700">+ Blue win</button>
                  <button id="btn-draw"      class="px-2 py-1 rounded bg-emerald-700/70 border border-white/10 text-xs font-bold hover:bg-emerald-600">+ Draw</button>
                  <button id="btn-cancel"    class="px-2 py-1 rounded bg-gray-900/70 border border-white/10 text-xs hover:bg-gray-900">Cancel fight</button>
                  <button id="btn-undo"      class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-xs hover:bg-gray-700">Undo</button>
                  <button id="btn-clear"     class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-xs hover:bg-gray-800">Clear</button>
                </div>
                @endif
              @endauth

              <div id="logro-rail" class="logro-rail">
                <div id="logro-strip" class="logro-strip-3d"></div>
              </div>
            </section>

            <!-- Road -->
            <section class="rounded-xl border border-white/10 p-2">
              <div class="flex items-center justify-between mb-1">
                <div class="text-[11px] tracking-widest uppercase text-white/70">Road</div>
                <div class="flex items-center gap-3 text-[10px]">
                  <div class="flex items-center gap-1">
                    <span class="inline-block rounded-full border-2 border-red-500 w-3 h-3"></span>
                    <span class="opacity-70">Red</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <span class="inline-block rounded-full border-2 border-blue-500 w-3 h-3"></span>
                    <span class="opacity-70">Blue</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <span class="inline-block rounded-full border-2 border-emerald-400 w-3 h-3"></span>
                    <span class="opacity-70">Draw</span>
                  </div>
                </div>
              </div>
              <div class="rounded-lg border border-dashed border-white/20 p-1">
                <div id="bead-rail" class="bead-rail">
                  <div id="bead-strip" class="bead-strip"></div>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- ======= /COMBINED PANEL ======= -->
      </div>

      <!-- RIGHT: Bet cards + Bet Amount (DESKTOP) -->
      <aside class="hidden md:block">
        <div class="sticky mt-2 space-y-3">
          <!-- GROUPED: Bet % + Green Draw + Red/Blue Cards -->
          <div class="space-y-[4px]">
            <!-- Bet Percentage -->
            <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 translate-y-0">
              <div class="text-[11px] uppercase tracking-widest text-white/70 mb-1">Bet Percentage</div>
              <div class="relative h-3 rounded-full bg-black/40 border border-white/10 overflow-hidden">
                <div id="pct-red"  class="absolute left-0 top-0 h-full bg-red-600/80" style="width:50%"></div>
                <div id="pct-blue" class="absolute right-0 top-0 h-full bg-blue-600/80" style="width:50%"></div>
              </div>
              <div class="mt-1 grid grid-cols-3 text-[11px] text-white/70">
                <div id="pct-red-label"  class="text-left">Red 50%</div>
                <div id="pct-total-label" class="text-center text-white/50">Total: ₱0</div>
                <div id="pct-blue-label" class="text-right">Blue 50%</div>
              </div>
            </div>

            <!-- DRAW CARD (green) – COMPACT HEIGHT -->
            <div>
              <div class="bet-card green tilt text-center py-2 px-3">
                <div class="flex items-center justify-between gap-3">
                  <div class="flex items-center gap-2">
                    <span class="name-chip w-8 h-8 text-sm md:text-base rounded-lg">D</span>
                    <div class="flex flex-col items-start leading-tight">
                      <span class="text-[10px] uppercase tracking-[0.24em] text-emerald-300/90">Draw</span>
                      <span class="text-[11px] opacity-80">Any tie / even result</span>
                    </div>
                  </div>
                  <div class="text-right leading-tight">
                    <div class="amount-3d text-xl" id="draw-amount"></div>
                    <div class="mt-0.5">
                      <span class="odds-ribbon text-[10px] px-1.5 py-0.5" id="draw-odds"></span>
                    </div>
                  </div>
                </div>
                @auth
                  @if( auth()->user()->role_id == 2)
                    <button class="bet-btn green mt-2 w-full px-3 py-1.5 text-xs font-semibold tracking-wide" id="bet-draw">
                      BET DRAW
                    </button>
                  @endif
                @endauth
              </div>
            </div>

            <!-- Cards -->
            <div id="bet-area" class="bet-area grid grid-cols-2 gap-3 mt-0 mb-0 translate-y-0">
              <div class="bet-card red tilt text-center">
                <div class="flex items-center justify-between">
                  <span class="name-chip text-xl md:text-2xl">R</span>
                </div>
                <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name"></div>
                <div class="amount-3d text-3xl md:text-4xl mt-1" id="meron-amount"></div>
                <div class="mt-">
                  <div class="mt-2">
                    <span class="odds-ribbon" id="meron-odds"></span>
                  </div>
                  @auth
                    @if( auth()->user()->role_id == 2)
                      <button class="bet-btn red mt-2 w-full px-3 py-2 text-sm" id="bet-meron">BET</button>
                    @endif
                  @endauth
                  <div id="meron-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
                </div>
              </div>
              <div class="bet-card blue tilt text-center">
                <div class="flex items-center justify-between">
                  <span class="name-chip text-xl md:text-2xl">B</span>
                </div>
                <div class="mt-2 text-sm font-semibold opacity-90" id="player2-name"></div>
                <div class="amount-3d text-3xl md:text-4xl mt-1" id="wala-amount"></div>
                <div class="mt-3">
                  <div class="mt-2">
                    <span class="odds-ribbon" id="wala-odds"></span>
                  </div>
                  @auth
                    @if( auth()->user()->role_id == 2)
                      <button class="bet-btn blue mt-2 w-full px-3 py-2 text-sm" id="bet-wala">BET</button>
                    @endif
                  @endauth
                  <div id="wala-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Bet Amount -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-0 mt-2">
          @auth
            @if( auth()->user()->role_id == 2)
            <div class="flex items-center justify-between mb-2">
              <div class="text-[15px] uppercase tracking-widest text-white/70">Bet Amount</div>
              <div class="text-[15px] text-white/60">min ₱100</div>
            </div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
              <input
                type="number"
                id="bet-amount-desktop"
                class="bet-input p-2 text-sm text-white bg-black/30 w-[160px]"
                placeholder="Enter amount"
                inputmode="numeric"
              />
              <div class="balance-pill text-yellow-300">
                <span id="mid-balance" class="amount text-base">5,000</span>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 mb-2">
              <button class="chip3d chip-emerald chip-outline text-sm bet-chip" data-val="100" type="button">♦100</button>
              <button class="chip3d chip-blue chip-outline text-sm bet-chip" data-val="200" type="button">♦200</button>
              <button class="chip3d chip-black chip-outline text-sm bet-chip" data-val="500" type="button">♦500</button>
              <button class="chip3d chip-amber chip-outline text-sm bet-chip" data-val="1000" type="button">♦1000</button>
            </div>
            @endif
          @endauth
          </div>
        </div>
      </aside>

    </div>
  </main>

  <script>
    // A) CONFIG
    const players = [
      "Hagdang Bato","King Focus","LeBron James","Kid Molave",
      "JBL","Autumn Blaze","Desert Sage","Hidden Hollow",
      "Pony Punster","Santino","Panday","Hooves of Fury",
      "Golden Hour","Sun Chaser"
    ];
    const BIGROAD_MAX_ROWS = 6;
    const BEAD_MAX_ROWS    = 6;

    // B) STATE
    let results = [];
    let meronAmount, walaAmount, drawAmount;
    let meronOdds, walaOdds, drawOdds;
    let currentBalance = 500000;
    const betHistory = [];

    // C) UTILS
    function getRandomPlayer(exclude){
      let name;
      do { name = players[Math.floor(Math.random()*players.length)]; }
      while(name===exclude);
      return name;
    }
    function setRandomMatch(){
      const red = getRandomPlayer();
      const blue = getRandomPlayer(red);
      const id = Math.floor(Math.random()*900)+100;
      const p1 = document.getElementById('player1-name'); if(p1) p1.textContent = red;
      const p2 = document.getElementById('player2-name'); if(p2) p2.textContent = blue;
      const mn = document.getElementById('match-no');    if(mn) mn.textContent = id;
      const p1m = document.getElementById('player1-name-mob'); if(p1m) p1m.textContent = red;
      const p2m = document.getElementById('player2-name-mob'); if(p2m) p2m.textContent = blue;
    }
    function setDateTime(){
      const now=new Date();
      const optionsDate={month:'2-digit', day:'2-digit', year:'numeric'};
      const optionsTime={weekday:'short', hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true};
      const d = "EVENT - "+now.toLocaleDateString('en-US',optionsDate);
      const t = now.toLocaleTimeString('en-US',optionsTime)+" ";
      const ed = document.getElementById('event-date'); if(ed) ed.textContent = d;
      const et = document.getElementById('event-time'); if(et) et.textContent = t;
    }
    setInterval(setDateTime,1000);

    function attachTilt(el){
      const damp=6;
      el.addEventListener('mousemove',(e)=>{
        const r=el.getBoundingClientRect();
        const x=(e.clientX-r.left)/r.width;
        const y=(e.clientY-r.top)/r.height;
        const rx=(y-0.5)*damp, ry=(0.5-x)*damp;
        el.style.transform=`rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
      });
      el.addEventListener('mouseleave',()=>{
        el.style.transform='rotateX(0) rotateY(0) translateY(0)';
      });
    }

    // Pick the visible "Enter amount" input; also update both for consistency
    function getBetInput(){
      return document.querySelector('#bet-amount-mob')
          || document.querySelector('#bet-amount-desktop')
          || document.querySelector('#bet-amount');
    }
    function setBetAmount(val){
      const mob = document.getElementById('bet-amount-mob');
      const desk = document.getElementById('bet-amount-desktop');
      if(mob)  mob.value  = val;
      if(desk) desk.value = val;

      const active = getBetInput();
      if(active){
        active.focus();
        active.style.transition = 'box-shadow 120ms ease';
        const prev = active.style.boxShadow;
        active.style.boxShadow = '0 0 0 3px rgba(250,204,21,.45)';
        setTimeout(()=>{ active.style.boxShadow = prev; }, 160);
        active.dispatchEvent(new Event('input', { bubbles:true }));
        active.dispatchEvent(new Event('change', { bubbles:true }));
      }
    }

    // D) ROAD HELPERS
    const isEmpty = (grid, c, r) => !(grid[c] && grid[c][r]);
    const ensureCol = (grid, c) => { if(!grid[c]) grid[c] = []; };
    function streakRuns(seq){
      const out = [];
      for(const t of seq){
        if(!out.length || out[out.length-1].t!==t) out.push({t, n:1});
        else out[out.length-1].n++;
      }
      return out;
    }
    function buildBigRoadStrictL(seq, maxRows = BEAD_MAX_ROWS){
      const runs = streakRuns(seq);
      const grid = [];
      let labelNo = 1;
      let prevRunStartCol = -1;
      for(const run of runs){
        const t = run.t;
        let col, row;
        if(prevRunStartCol < 0){ col = 0; row = 0; }
        else {
          col = prevRunStartCol + 1; row = 0;
          while(!isEmpty(grid, col, row)){ col++; ensureCol(grid, col); }
        }
        const thisRunStartCol = col;
        let placed = 0;
        while(placed < run.n && row < maxRows && isEmpty(grid, col, row)){
          ensureCol(grid, col);
          grid[col][row] = { t, label: labelNo++ };
          placed++; row++;
        }
        const lockRow = Math.max(0, row - 1);
        let remain = run.n - placed;
        let c = col + 1;
        while(remain > 0){
          ensureCol(grid, c);
          if(isEmpty(grid, c, lockRow)){
            grid[c][lockRow] = { t, label: labelNo++ };
            remain--;
          }
          c++;
        }
        prevRunStartCol = thisRunStartCol;
      }
      return grid;
    }
    function computeColumnsSequential(seq, maxRows){
      const cols=[]; let col=[]; let labelNo=1;
      for(const t of seq){
        col.push({ t, label: labelNo++ });
        if(col.length === maxRows){
          cols.push(col); col=[];
        }
      }
      if(col.length) cols.push(col);
      return cols;
    }

    // E) RENDERERS
    function renderLogroContinuous(seq, stripId, maxRows = BIGROAD_MAX_ROWS){
      const grid = buildBigRoadStrictL(seq, maxRows);
      const strip = document.getElementById(stripId); if(!strip) return;
      strip.innerHTML='';
      grid.forEach(col=>{
        const colDiv=document.createElement('div');
        colDiv.className='logro-col';
        colDiv.style.gridTemplateRows=`repeat(${maxRows}, var(--logro-bubble))`;
        for(let r=0;r<maxRows;r++){
          const cell = col && col[r];
          if(cell){
            const b=document.createElement('div');
            let ringClass =
              cell.t === 'R' ? 'ring-red' :
              cell.t === 'B' ? 'ring-blue' : 'ring-green';
            b.className=`ring-bubble ${ringClass}`;
            const depth=Math.min(r,maxRows-1);
            b.style.setProperty('--z',`calc(var(--logro-step) * ${depth})`);
            b.style.transform=`translateZ(var(--z))`;
            colDiv.appendChild(b);
          }else{
            const gap=document.createElement('div');
            gap.className='ring-gap';
            colDiv.appendChild(gap);
          }
        }
        strip.appendChild(colDiv);
      });
      const rail = strip.parentElement; if(rail) rail.scrollLeft = rail.scrollWidth;
    }

    function renderRoadStrictL(seq, stripId, maxRows = BEAD_MAX_ROWS){
      const cols = computeColumnsSequential(seq, maxRows);
      const strip = document.getElementById(stripId); if(!strip) return;
      strip.innerHTML='';
      cols.forEach(col=>{
        const colDiv=document.createElement('div');
        colDiv.className='bead-col';
        colDiv.style.gridTemplateRows=`repeat(${maxRows}, var(--bead-bubble))`;
        for(let r=0;r<maxRows;r++){
          const cell=col[r];
          const dot=document.createElement('div');
          if(cell){
            let beadClass =
              cell.t === 'R' ? 'red' :
              cell.t === 'B' ? 'blue' : 'green';
            dot.className='bead-solid '+beadClass;
            dot.textContent=cell.label;
          } else {
            dot.className='bead';
            dot.style.opacity='0.12';
            dot.style.border='1px dashed rgba(255,255,255,.15)';
          }
          colDiv.appendChild(dot);
        }
        strip.appendChild(colDiv);
      });
      const rail = strip.parentElement; if(rail) rail.scrollLeft = rail.scrollWidth;
    }

    function renderAllRoads(seq){
      renderLogroContinuous(seq, 'logro-strip', BIGROAD_MAX_ROWS);
      renderLogroContinuous(seq, 'logro-strip-mob', BIGROAD_MAX_ROWS);
      renderRoadStrictL(seq, 'bead-strip', BEAD_MAX_ROWS);
      renderRoadStrictL(seq, 'bead-strip-mob', BEAD_MAX_ROWS);
    }

    // F) BETTING / BALANCE / ODDS
    function computeOdds(){
      meronOdds = (Math.random()*(2.0-1.5)+1.5).toFixed(2);
      walaOdds  = (parseFloat(meronOdds)+0.20).toFixed(2);
      drawOdds  = (Math.random()*(3.0-2.2)+2.2).toFixed(2);
    }
    function renderOddsEverywhere(){
      const m=document.getElementById('meron-odds'); if(m) m.textContent='PAYOUT = '+meronOdds;
      const w=document.getElementById('wala-odds');  if(w) w.textContent='PAYOUT = '+walaOdds;
      const d=document.getElementById('draw-odds');  if(d) d.textContent='PAYOUT = '+drawOdds;

      const mm=document.getElementById('meron-odds-mob'); if(mm) mm.textContent='PAYOUT = '+meronOdds;
      const ww=document.getElementById('wala-odds-mob');  if(ww) ww.textContent='PAYOUT = '+walaOdds;
      const dm=document.getElementById('draw-odds-mob');  if(dm) dm.textContent='PAYOUT = '+drawOdds;
    }
    function renderBalance(){
      const mid=document.getElementById('mid-balance');
      const head=document.getElementById('header-balance');
      const midMob=document.getElementById('mid-balance-mob');
      if(mid) mid.textContent=Number(currentBalance).toLocaleString();
      if(head) head.textContent=Number(currentBalance).toLocaleString();
      if(midMob) midMob.textContent=Number(currentBalance).toLocaleString();
    }

    function updatePercentBar(){
      const red = meronAmount||0;
      const blue = walaAmount||0;
      const total = red + blue; // draw not included in bar by design

      let redPct = 50, bluePct = 50;
      if(total > 0){
        redPct  = Math.round((red / total) * 100);
        bluePct = 100 - redPct;
      }

      const rEl = document.getElementById('pct-red');
      const bEl = document.getElementById('pct-blue');
      const rl  = document.getElementById('pct-red-label');
      const bl  = document.getElementById('pct-blue-label');
      const tl  = document.getElementById('pct-total-label');
      if(rEl){ rEl.style.width = redPct + '%'; }
      if(bEl){ bEl.style.width = bluePct + '%'; }
      if(rl){ rl.textContent = `Red ${redPct}%`; }
      if(bl){ bl.textContent = `Blue ${bluePct}%`; }
      if(tl){ tl.textContent = `Total: ₱${Number(total).toLocaleString('en-PH')}`; }

      const rEm = document.getElementById('pct-red-mob');
      const bEm = document.getElementById('pct-blue-mob');
      const rlm = document.getElementById('pct-red-label-mob');
      const blm = document.getElementById('pct-blue-label-mob');
      const tlm = document.getElementById('pct-total-label-mob');
      if(rEm){ rEm.style.width = redPct + '%'; }
      if(bEm){ bEm.style.width = bluePct + '%'; }
      if(rlm){ rlm.textContent = `Red ${redPct}%`; }
      if(blm){ blm.textContent = `Blue ${bluePct}%`; }
      if(tlm){ tlm.textContent = `Total: ₱${Number(total).toLocaleString('en-PH')}`; }
    }

    function adjustBalance(delta){
      const next=currentBalance+delta;
      if(next<0) return false;
      currentBalance=next;
      renderBalance();
      return true;
    }

    function placeBet(betType){
      const input = getBetInput();
      let betAmount = input ? parseFloat(input.value) : NaN;
      if(isNaN(betAmount)||betAmount<=0){
        alert('Please enter a valid bet amount greater than 0.');
        return;
      }

      let odds, chosenPlayer, resultFieldId;

      if(betType==='MERON'){
        odds = meronOdds;
        chosenPlayer=(document.getElementById('player1-name')?.textContent
          || document.getElementById('player1-name-mob')?.textContent || 'Red');
        resultFieldId = 'meron-result';
      } else if(betType==='WALA'){
        odds = walaOdds;
        chosenPlayer=(document.getElementById('player2-name')?.textContent
          || document.getElementById('player2-name-mob')?.textContent || 'Blue');
        resultFieldId = 'wala-result';
      } else {
        odds = drawOdds;
        chosenPlayer = 'Draw';
        resultFieldId = 'draw-result'; // optional if you want to add display
      }

      if(!adjustBalance(-betAmount)){
        alert('Insufficient balance.');
        return;
      }

      if(betType==='MERON'){
        meronAmount += betAmount;
        const el=document.getElementById('meron-amount'); if(el) el.textContent=meronAmount.toLocaleString();
        const elm=document.getElementById('meron-amount-mob'); if(elm) elm.textContent=meronAmount.toLocaleString();
      } else if(betType==='WALA'){
        walaAmount += betAmount;
        const el=document.getElementById('wala-amount'); if(el) el.textContent=walaAmount.toLocaleString();
        const elm=document.getElementById('wala-amount-mob'); if(elm) elm.textContent=walaAmount.toLocaleString();
      } else {
        drawAmount += betAmount;
        const el=document.getElementById('draw-amount'); if(el) el.textContent=drawAmount.toLocaleString();
        const elm=document.getElementById('draw-amount-mob'); if(elm) elm.textContent=drawAmount.toLocaleString();
      }

      updatePercentBar();

      const totalWinnings = parseFloat(betAmount)*parseFloat(odds);
      if(betType==='MERON'){
        const r1=document.getElementById('meron-result');
        if(r1) r1.textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`;
        const r2=document.getElementById('wala-result'); if(r2) r2.textContent="";
      } else if(betType==='WALA'){
        const r1=document.getElementById('wala-result');
        if(r1) r1.textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`;
        const r2=document.getElementById('meron-result'); if(r2) r2.textContent="";
      }

      alert(`You placed a bet of ${betAmount} on ${chosenPlayer}.
Possible payout: ${totalWinnings.toFixed(2)}.
New Balance: ${currentBalance.toLocaleString()}.`);
    }

    // Admin controls
    function pushResult(side){
      if(side === 'MERON'){
        results.push('R');
      } else if(side === 'WALA'){
        results.push('B');
      } else if(side === 'DRAW'){
        results.push('D');
      }
      renderAllRoads(results);
    }
    function undoResult(){
      results.pop();
      renderAllRoads(results);
    }
    function clearResults(){
      results=[];
      renderAllRoads(results);
    }

    function cancelFight(){
      // clear roads & amounts (fight cancelled)
      results = [];
      renderAllRoads(results);

      meronAmount = 0;
      walaAmount  = 0;
      drawAmount  = 0;

      const ma=document.getElementById('meron-amount'); if(ma) ma.textContent='0';
      const wa=document.getElementById('wala-amount');  if(wa) wa.textContent='0';
      const mam=document.getElementById('meron-amount-mob'); if(mam) mam.textContent='0';
      const wam=document.getElementById('wala-amount-mob');  if(wam) wam.textContent='0';
      const da=document.getElementById('draw-amount'); if(da) da.textContent='0';
      const dam=document.getElementById('draw-amount-mob'); if(dam) dam.textContent='0';

      updatePercentBar();
      alert('Fight has been cancelled.');
    }

    // INIT
    window.onload = () => {
      setDateTime();
      setRandomMatch();

      let meronAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      let walaAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      let drawAmountInit=Math.floor(Math.random()*(20000-5000+1))+5000;

      meronAmount=meronAmountInit;
      walaAmount=walaAmountInit;
      drawAmount=drawAmountInit;

      computeOdds();
      renderOddsEverywhere();

      const ma=document.getElementById('meron-amount'); if(ma) ma.textContent=meronAmount.toLocaleString();
      const wa=document.getElementById('wala-amount');  if(wa) wa.textContent=walaAmount.toLocaleString();
      const mam=document.getElementById('meron-amount-mob'); if(mam) mam.textContent=meronAmount.toLocaleString();
      const wam=document.getElementById('wala-amount-mob'); if(wam) wam.textContent=walaAmount.toLocaleString();
      const da=document.getElementById('draw-amount'); if(da) da.textContent=drawAmount.toLocaleString();
      const dam=document.getElementById('draw-amount-mob'); if(dam) dam.textContent=drawAmount.toLocaleString();

      updatePercentBar();

      document.querySelectorAll('.tilt').forEach(attachTilt);

      // admin buttons
      const wm=document.getElementById('btn-win-meron');
      const ww=document.getElementById('btn-win-wala');
      const wd=document.getElementById('btn-draw');
      const uu=document.getElementById('btn-undo');
      const cc=document.getElementById('btn-clear');
      const cf=document.getElementById('btn-cancel');

      if(wm) wm.addEventListener('click', ()=> pushResult('MERON'));
      if(ww) ww.addEventListener('click', ()=> pushResult('WALA'));
      if(wd) wd.addEventListener('click', ()=> pushResult('DRAW'));
      if(uu) uu.addEventListener('click',  undoResult);
      if(cc) cc.addEventListener('click',  clearResults);
      if(cf) cf.addEventListener('click',  cancelFight);

      // seed some results to show the rails
      results=['R','R','R','R','R','R','R','R','R','B','B','B','B','B','B','B','B','R','R','R','R','R','R','R'];
      renderAllRoads(results);

      // chips write amount
      document.querySelectorAll('.bet-chip').forEach(btn=>{
        btn.addEventListener('click',()=>{
          const raw=parseInt(btn.dataset.val||'0',10);
          setBetAmount(raw);
          btn.animate(
            [{transform:'translateY(-3px)'},{transform:'translateY(0)'}],
            {duration:120}
          );
        });
      });

      // Desktop / Mobile bet buttons
      const bm=document.getElementById('bet-meron');
      const bw=document.getElementById('bet-wala');
      const bd=document.getElementById('bet-draw');

      if(bm) bm.addEventListener('click', ()=> placeBet('MERON'));
      if(bw) bw.addEventListener('click', ()=> placeBet('WALA'));
      if(bd) bd.addEventListener('click', ()=> placeBet('DRAW'));

      const bmm=document.getElementById('bet-meron-mob');
      const bwm=document.getElementById('bet-wala-mob');
      const bdm=document.getElementById('bet-draw-mob');
      if(bmm) bmm.addEventListener('click', ()=> placeBet('MERON'));
      if(bwm) bwm.addEventListener('click', ()=> placeBet('WALA'));
      if(bdm) bdm.addEventListener('click', ()=> placeBet('DRAW'));

      // balance
      renderBalance();
    };
  </script>
</body>
</x-layouts.app>
