{{-- resources/views/teller.blade.php --}}
<x-layouts.app :title="__('Teller')">
  <body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>

  <style>
    /* Print only the ticket */
    @media print{
      body *{ visibility:hidden !important; }
      #print-ticket, #print-ticket *{ visibility:visible !important; }
      #print-ticket{ position:fixed; inset:0; padding:24px; background:#fff; }
    }

    /* Bet History: better readability */
    #history-wrap{
      background:#0f172a;
      border:1px solid rgba(255,255,255,.12);
      border-radius:.75rem;
      box-shadow:0 12px 40px rgba(0,0,0,.45);
    }
    #history-head{ position: sticky; top: 0; background:#0f172a; z-index: 2; border-bottom:1px solid rgba(255,255,255,.14); }
    #history-list{
      max-height: 560px;
      overflow:auto;
      scrollbar-width: thin;
      scrollbar-color: #94a3b8 #0b1223;
    }
    #history-list > div{ border-color: rgba(255,255,255,.10); }
    .hist-kv{ font-size:12.5px; color:#cbd5e1; }
    .hist-kv strong{ color:#fff; }
    .hist-pill{ display:inline-flex; align-items:center; justify-content:center; height:24px; min-width:24px; padding:0 8px; border-radius:999px; border:1px solid rgba(255,255,255,.16); font-size:12px; font-weight:600; background:#111827; }
    .hist-pill.red{ background:#7f1d1d; border-color:#ef4444aa; color:#ffe4e6; }
    .hist-pill.blue{ background:#1e3a8a; border-color:#60a5faaa; color:#dbeafe; }
    .hist-status{ font-weight:700; letter-spacing:.2px; }
    .hist-status.win{ color:#22c55e; }
    .hist-status.lose{ color:#f43f5e; }
    .hist-status.pending{ color:#f59e0b; }

    /* Solidify wrappers */
    main > .grid > section:nth-child(1),
    main > .grid > section:nth-child(2){
      background:#0f172a !important;
      border:1px solid rgba(255,255,255,.12) !important;
      box-shadow:0 12px 40px rgba(0,0,0,.45) !important;
      backdrop-filter:none !important;
    }
    .logro-zone{ background:#0b1223 !important; border:1px solid rgba(255,255,255,.12) !important; }
    main > .grid > section:nth-child(2) .rounded-xl{ background:#0b1223 !important; border-color:rgba(255,255,255,.12) !important; }

    .bet-area .name-chip{ background:#0f172a !important; border:1px solid rgba(255,255,255,.14) !important; box-shadow:inset 0 1px 0 rgba(255,255,255,.05); }
    .odds-ribbon{ background:#12203a !important; border:1px solid rgba(255,255,255,.14) !important; padding:.25rem .5rem; border-radius:.5rem; display:inline-block; }
    .bet-btn.red{ background:#b91c1c !important; border:1px solid rgba(255,255,255,.16) !important; }
    .bet-btn.red:hover{ background:#dc2626 !important; }
    .bet-btn.blue{ background:#1d4ed8 !important; border:1px solid rgba(255,255,255,.16) !important; }
    .bet-btn.blue:hover{ background:#2563eb !important; }
    .bet-input{ border:1px solid rgba(255,255,255,.14) !important; background:#0f172a !important; }
    .chip3d{ border:1px solid rgba(255,255,255,.16) !important; }
    .bead-rail{ background:#0f172a !important; border:1px dashed rgba(255,255,255,.12) !important; border-radius:.5rem; padding:.25rem; }
    main > .grid > section:nth-child(2) .h-3{ border:1px solid rgba(255,255,255,.16) !important; }

    /* === Make Road same size as Logrohan === */
    :root{ --rail-h: 220px; } /* adjust if needed */
    .logro-zone #logro-rail-center,
    .logro-zone #logro-rail-mob,
    .bead-rail{
      height: var(--rail-h) !important;
    }
    #logro-strip-center,
    #logro-strip-mob,
    #bead-strip-center{
      height: 100% !important;
    }

    /* Confirm modal */
    #confirm-overlay{ position: fixed; inset: 0; background: rgba(0,0,0,.6); display: none; align-items: center; justify-content: center; z-index: 60; }
    #confirm-modal{ width: 100%; max-width: 420px; background: #0f172a; color:#e5e7eb; border:1px solid rgba(255,255,255,.14); border-radius: .75rem; box-shadow: 0 20px 80px rgba(0,0,0,.6); overflow: hidden; }
    #confirm-modal header{ padding: 12px 16px; background:#0b1223; border-bottom:1px solid rgba(255,255,255,.1); font-weight: 700; letter-spacing: .3px; }
    #confirm-modal .body{ padding: 14px 16px; }
    #confirm-modal .row{ display:grid; grid-template-columns: 120px 1fr; gap:10px; margin:6px 0; font-size:14px;}
    #confirm-modal .row span:first-child{ color:#93c5fd; }
    #confirm-modal footer{ padding: 12px 16px; background:#0b1223; border-top:1px solid rgba(255,255,255,.1); display:flex; gap:8px; justify-content:flex-end;}
    #confirm-cancel{ background:#1f2937; border:1px solid rgba(255,255,255,.16); padding:.5rem .75rem; border-radius:.5rem; }
    #confirm-ok{ background:#16a34a; border:1px solid rgba(255,255,255,.16); padding:.5rem .75rem; border-radius:.5rem; font-weight:700; }
  </style>

  <main class=" mx-auto lg:p-4">
    <div class="grid gap-6 grid-cols-1 lg:grid-cols-12">

      <!-- LEFT: VIDEO + SCAN CARD -->
      <section class="lg:col-span-2 relative z-10 p-4 rounded-lg shadow-lg bg-white/5 border border-white/10">
        <!-- Match header -->
        <div class="grid grid-cols-3 items-center mb-3 text-sm text-gray-300">
          <div id="event-date" class="text-left"></div>
          <div class="text-center font-bold text-yellow-400 text-lg">MATCH# <span id="match-no">—</span></div>
          <div id="event-time" class="text-right"></div>
        </div>

        <!-- Toolbar -->
        <div class="mb-2 flex items-center justify-end">
          <button id="toggle-video"
                  class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-black/30 px-3 py-1.5 text-[13px] text-white/80 hover:bg-black/50">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M15 10l4.55-2.27A1 1 0 0121 8.62v6.76a1 1 0 01-1.45.9L15 14v-4z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <rect x="3" y="6" width="12" height="12" rx="2" stroke-width="1.5"/>
            </svg>
            <span id="toggle-video-label">Hide Video</span>
          </button>
        </div>

        <!-- Video -->
        <div id="video-wrap" class="mb-4 relative">
          <div class="relative aspect-video">
            <div class="absolute inset-0 rounded-xl overflow-hidden z-10">
              <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 animate-[pulse_4s_infinite] mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20 mix-blend-overlay animate-[glow-border_2s_ease-in-out_infinite_alternate]"></div>
            </div>
            <iframe
              id="youtube-video-main"
              class="absolute inset-0 w-full h-full rounded-lg relative z-20 border-4 border-transparent"
              src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
          </div>
        </div>

        <!-- Scan / Enter Card -->
        <div class="mb-0 rounded-lg border border-white/10 bg-black/30 p-3">
          <div class="text-[12px] uppercase tracking-widest text-white/70 mb-2">Scan / Enter Card</div>
          <form id="scan-form" class="space-y-2">
            <input id="scan-input" type="text" placeholder="Enter or scan card code"
                   class="w-full bet-input p-2 text-sm text-white bg-black/30" />
            <div class="flex gap-2">
              <button type="button" id="scan-reset"
                      class="px-3 py-1.5 rounded-lg border border-white/15 bg-[#1f2937] text-[12px]">Reset</button>
              <button type="submit" id="scan-submit"
                      class="px-3 py-1.5 rounded-lg border border-white/15 bg-indigo-600 hover:bg-indigo-500 text-[12px] font-semibold">Submit Card</button>
            </div>
          </form>

          <div class="mt-3 text-[12px] text-white/70 uppercase tracking-widest">Customer Details</div>
          <div class="mt-1 grid grid-cols-2 gap-2 text-[13px]">
            <!-- 4 fields repurposed as requested -->
            <input id="cust-name"  class="bet-input bg-black/30 p-2 col-span-2 lg:col-span-1" placeholder="Bet" readonly/>
            <input id="cust-user"  class="bet-input bg-black/30 p-2 col-span-2 lg:col-span-1" placeholder="Total Payout" readonly/>
            <input id="cust-email" class="bet-input bg-black/30 p-2 col-span-2" placeholder="Time & date" readonly/>
            <input id="cust-phone" class="bet-input bg-black/30 p-2 col-span-2" placeholder="Player bet" readonly/>
              @auth
                @if( auth()->user()->role_id == 1)
                  <button id="btn-win-meron" class="bet-input bg-black/30 p-2">Red Score</button>
                  <button id="btn-win-wala" class="bet-input bg-black/30 p-2">Blue Score</button>
                  <button id="btn-undo" class="bet-input bg-black/30 p-2">Undo</button>
                  <button id="btn-clear" class="bet-input bg-black/30 p-2">Clear</button>
                @endif
              @endauth
          </div>
          <div id="scan-status" class="mt-2 text-[12px] text-emerald-300"></div>
        </div>
      </section>
      <!-- /LEFT -->

      <!-- CENTER: BET + Logrohan & Road -->
      <section class="lg:col-span-8 p-4 rounded-lg shadow-lg bg-white/5 border border-white/10">
        <!-- Bet Percentage Bar -->
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-3">
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

        <!-- Bet Cards -->
        <div id="bet-area" class="bet-area grid grid-cols-1 lg:grid-cols-2 gap-3 mt-0 mb-4">
          <!-- Meron -->
          <div class="bet-card red tilt text-center">
            <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">R</span></div>
            <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name"></div>
            <div class="amount-3d text-3xl md:text-4xl mt-1" id="meron-amount"></div>
            <div>
              <div class="mt-2"><span class="odds-ribbon" id="meron-odds"></span></div>
              @auth
                @if( auth()->user()->role_id == 2)
                  <button class="bet-btn red mt-2 w-full px-3 py-2 text-sm" id="bet-meron">BET</button>
                @endif
              @endauth
              <div id="meron-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
            </div>
          </div>
          <!-- Wala -->
          <div class="bet-card blue tilt text-center">
            <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">B</span></div>
            <div class="mt-2 text-sm font-semibold opacity-90" id="player2-name"></div>
            <div class="amount-3d text-3xl md:text-4xl mt-1" id="wala-amount"></div>
            <div>
              <div class="mt-2"><span class="odds-ribbon" id="wala-odds"></span></div>
              @auth
                @if( auth()->user()->role_id == 2)
                  <button class="bet-btn blue mt-2 w-full px-3 py-2 text-sm" id="bet-wala">BET</button>
                @endif
              @endauth
              <div id="wala-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
            </div>
          </div>
        </div>

        <!-- Bet Amount + Chips (RESTORED) -->
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-3">
        @auth
          @if( auth()->user()->role_id == 2)
          <div class="flex items-center justify-between mb-2">
            <div class="text-[15px] uppercase tracking-widest text-white/70">Bet Amount</div>
            <div class="text-[15px] text-white/60">min ₱100</div>
          </div>

          <div class="flex flex-wrap items-center gap-2 mb-2">
            <input type="number" id="bet-amount" class="bet-input p-2 text-sm text-white bg-black/30 w-[160px]" placeholder="Enter amount" inputmode="numeric" />
            <div class="balance-pill text-yellow-300">
              <svg class="w-5 h-5 opacity-90" viewBox="0 0 64 64" aria-hidden="true">
                <defs>
                  <linearGradient id="gemTop" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#e9f7ff"/><stop offset="40%" stop-color="#c6e6ff"/>
                    <stop offset="70%" stop-color="#9fd3ff"/><stop offset="100%" stop-color="#e6fbff"/>
                  </linearGradient>
                  <linearGradient id="gemSide" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#b5e3ff"/><stop offset="100%" stop-color="#80c3f7"/>
                  </linearGradient>
                  <radialGradient id="gemGlow" cx="50%" cy="50%" r="60%">
                    <stop offset="0%" stop-color="rgba(255,255,255,0.9)"/>
                    <stop offset="60%" stop-color="rgba(255,255,255,0.0)"/>
                  </radialGradient>
                  <linearGradient id="spark" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#ffffff"/>
                    <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
                  </linearGradient>
                </defs>
                <polygon points="32,60 6,24 58,24" fill="url(#gemSide)" stroke="#a7d8ff" stroke-width="1"/>
                <polygon points="12,24 20,8 44,8 52,24 12,24" fill="url(#gemTop)" stroke="#bfe6ff" stroke-width="1"/>
                <polyline points="20,8 32,24 44,8" fill="none" stroke="#d8f1ff" stroke-width="1" opacity=".9"/>
                <polyline points="12,24 32,24 52,24" fill="none" stroke="#cfeaff" stroke-width="1" opacity=".9"/>
                <polyline points="6,24 32,60 58,24" fill="none" stroke="#a7d8ff" stroke-width="1" opacity=".7"/>
                <circle cx="32" cy="30" r="16" fill="url(#gemGlow)" opacity=".35"/>
              </svg>
              <span class="text-[11px] opacity-80 tracking-widest"></span>
              <span id="mid-balance" class="amount text-base">5,000</span>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-1">
            <button class="chip3d chip-emerald chip-outline text-sm bet-chip" data-val="100">♦100</button>
            <button class="chip3d chip-blue chip-outline text-sm bet-chip" data-val="200">♦200</button>
            <button class="chip3d chip-black chip-outline text-sm bet-chip" data-val="500">♦500</button>
            <button class="chip3d chip-amber chip-outline text-sm bet-chip" data-val="1000">♦1000</button>
          </div>
          @endif
        @endauth
        </div>

        <!-- Logrohan + Road (same size) -->
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
          <div class="grid md:grid-cols-2 gap-2">
            <!-- Logrohan -->
            <div class="logro-zone rounded-lg p-2">
              <div class="flex items-center justify-between mb-1">
                <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
                <div class="flex items-center gap-2 text-[10px]">
                  <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
                  <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
                </div>
              </div>
              <div id="logro-rail-center" class="logro-rail">
                <div id="logro-strip-center" class="logro-strip-3d !overflow-x-auto !overflow-y-hidden !overflow-visible !max-w-[220px] lg:!max-w/full"></div>
              </div>
            </div>

            <!-- Road -->
            <div class="rounded-lg p-2 border border-white/10 bg-[#0b1223]">
              <div class="flex items-center justify-between mb-1">
                <div class="text-[11px] uppercase tracking-widest text-white/70">Road</div>
                <div class="flex items-center gap-2 text-[10px]">
                  <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
                  <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
                </div>
              </div>
              <div class="bead-rail !overflow-x-auto ">
                <div id="bead-strip-center" class="bead-strip !overflow-x-auto !overflow-y-hidden !overflow-visible !max-w-[220px] lg:!max-w/full"></div>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- /CENTER -->

      <!-- RIGHT: BET HISTORY -->
      <aside id="history-wrap" class="lg:col-span-2 p-0">
        <div id="history-head" class="px-4 py-3">
          <div class="flex items-center justify-between">
            <h2 class="text-[17px] font-semibold text-white">Bet History</h2>
            <span id="history-dot" class="inline-block w-2 h-2 rounded-full bg-emerald-400 hidden"></span>
          </div>
          <div class="mt-1 text-[12px] text-slate-300">Showing 10 per page</div>
        </div>
        <div id="history-list" class="divide-y divide-white/10 px-4"></div>
        <div id="history-empty" class="px-4 py-6 text-center text-slate-300 hidden">No bets yet.</div>
        <div class="px-4 py-3 border-t border-white/10 bg-[#0d1426] flex items-center justify-between">
          <button id="history-prev" class="px-3 py-1.5 rounded-lg border border-white/20 bg-[#0b1223] text-sm text-slate-200 hover:bg-[#0e1832] disabled:opacity-40 disabled:cursor-not-allowed">Prev</button>
          <div class="text-sm text-slate-200">Page <span id="history-page">1</span> / <span id="history-pages">1</span></div>
          <button id="history-next" class="px-3 py-1.5 rounded-lg border border-white/20 bg-[#0b1223] text-sm text-slate-200 hover:bg-[#0e1832] disabled:opacity-40 disabled:cursor-not-allowed">Next</button>
        </div>
      </aside>

      <!-- MOBILE STACK -->
      <div class="md:hidden space-y-3 ">
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>
          <div id="logro-rail-mob" class="logro-rail">
            <div id="logro-strip-mob" class="logro-strip-3d"></div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Hidden print container -->
  <div id="print-ticket" class="hidden">
    <div id="print-ticket-content" class="mx-auto max-w-[440px] bg-white text-black rounded-lg p-5 shadow"></div>
  </div>

  <!-- Confirm Modal -->
  <div id="confirm-overlay" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
    <div id="confirm-modal">
      <header id="confirm-title">Confirm Bet</header>
      <div class="body">
        <div class="row"><span>Side</span><strong id="c-side">—</strong></div>
        <div class="row"><span>Player</span><span id="c-player">—</span></div>
        <div class="row"><span>Match #</span><span id="c-match">—</span></div>
        <div class="row"><span>Amount</span><span id="c-amount">—</span></div>
        <div class="row"><span>Odds</span><span id="c-odds">—</span></div>
        <div class="row"><span>Potential Payout</span><span id="c-payout">—</span></div>
        <div class="row"><span>Balance After</span><span id="c-balance">—</span></div>
      </div>
      <footer>
        <button id="confirm-cancel">Cancel</button>
        <button id="confirm-ok">Confirm Bet</button>
      </footer>
    </div>
  </div>

  <script>
    /* ===== Code39 BARCODE (SVG) ===== */
    (function(){
      const CODE39 = {
        '0':'nnnwwnwnn','1':'wnnwnnnnw','2':'nnwwnnnnw','3':'wnwwnnnnn','4':'nnnwwnnnw','5':'wnnwwnnnn',
        '6':'nnwwwnnnn','7':'nnnwnnwnw','8':'wnnwnnwnn','9':'nnwwnnwnn',
        'A':'wnnnnwnnw','B':'nnwnnwnnw','C':'wnwnnwnnn','D':'nnnnwwnnw','E':'wnnnwwnnn','F':'nnwnwwnnn',
        'G':'nnnnnwwnw','H':'wnnnnwwnn','I':'nnwnnwwnn','J':'nnnnwwwnn',
        'K':'wnnnnnnww','L':'nnwnnnnww','M':'wnwnnnnwn','N':'nnnnwnnww','O':'wnnnwnnwn','P':'nnwnwnnwn',
        'Q':'nnnnnnwww','R':'wnnnnnwwn','S':'nnwnnnwwn','T':'nnnnwnwwn',
        'U':'wwnnnnnnw','V':'nwwnnnnnw','W':'wwwnnnnnn','X':'nwnnwnnnw','Y':'wwnnwnnnn','Z':'nwwnwnnnn',
        '-':'nwnnnnwnw','.':'wwnnnnwnn',' ':'nwwnnnwnn','$':'nwnwnwnnn','/':'nwnwnnnwn','+':'nwnnnwnwn','%':'nnnwnwnwn','*':'nwnnwnwnn'
      };
      function patternFor(ch){ return CODE39[ch] || CODE39['-']; }
      function encode(text){
        text = ('*' + text.toUpperCase().replace(/[^0-9A-Z\-\.\ \$\/\+\%]/g,'-') + '*');
        return Array.from(text).map(patternFor).join('n');
      }
      window.makeCode39SVG = function(data, opts={}){
        const h = opts.height || 60;
        const m = opts.module || 2;
        const wide = 3*m;
        const patt = encode(data);
        let total = 0; for(const c of patt){ total += (c==='n'?m:wide); }
        let x = 0, svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${total}" height="${h+22}">`;
        let drawBar = true;
        for(const c of patt){
          const w = (c==='n'?m:wide);
          if(drawBar){ svg += `<rect x="${x}" y="0" width="${w}" height="${h}" fill="#000"/>`; }
          x += w; drawBar = !drawBar;
        }
        svg += `<text x="${(total/2)}" y="${h+16}" font-family="monospace" font-size="14" text-anchor="middle">${data}</text>`;
        svg += `</svg>`;
        return svg;
      }
    })();

    /* ===== State & helpers ===== */
    const players=[
      "Efren Reyes","Earl Strickland","Ronnie O'Sullivan","Shane Van Boening",
      "Francisco Bustamante","Alex Pagulayan","Jeanette Lee","Karen Corr",
      "Allison Fisher","Johnny Archer","Mika Immonen","Niels Feijen",
      "Darren Appleton","Ko Pin-Yi","Wu Jiaqing"
    ];
    const BIGROAD_MAX_ROWS=6, BEAD_MAX_ROWS=6; /* Road columns now 8 rows, same as Logrohan */

    let results=[];
    let meronAmount, walaAmount, meronOdds, walaOdds;
    let currentBalance=500000;
    const betHistory=[];
    let pendingBet = null;

    function getRandomPlayer(ex){let n;do{n=players[Math.floor(Math.random()*players.length)];}while(n===ex);return n;}
    function setRandomMatch(){
      const red=getRandomPlayer(); const blue=getRandomPlayer(red);
      const id=Math.floor(Math.random()*900)+100;
      const p1=document.getElementById('player1-name'); if(p1) p1.textContent=red;
      const p2=document.getElementById('player2-name'); if(p2) p2.textContent=blue;
      const mn=document.getElementById('match-no'); if(mn) mn.textContent=id;
      const p1m=document.getElementById('player1-name-mob'); if(p1m) p1m.textContent=red;
      const p2m=document.getElementById('player2-name-mob'); if(p2m) p2m.textContent=blue;
    }
    function setDateTime(){
      const now=new Date();
      const d="EVENT - "+now.toLocaleDateString('en-US',{month:'2-digit',day:'2-digit',year:'numeric'});
      const t=now.toLocaleTimeString('en-US',{weekday:'short',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:true})+" ";
      const ed=document.getElementById('event-date'); if(ed) ed.textContent=d;
      const et=document.getElementById('event-time'); if(et) et.textContent=t;
    }
    setInterval(setDateTime,1000);

    function attachTilt(el){
      const damp=6;
      el.addEventListener('mousemove',(e)=>{
        const r=el.getBoundingClientRect();
        const x=(e.clientX-r.left)/r.width; const y=(e.clientY-r.top)/r.height;
        const rx=(y-0.5)*damp, ry=(0.5-x)*damp;
        el.style.transform=`rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
      });
      el.addEventListener('mouseleave',()=>{ el.style.transform='rotateX(0) rotateY(0) translateY(0)'; });
    }

    const isEmpty=(g,c,r)=>!(g[c]&&g[c][r]);
    const ensureCol=(g,c)=>{ if(!g[c]) g[c]=[]; };
    function streakRuns(seq){ const out=[]; for(const t of seq){ if(!out.length||out[out.length-1].t!==t) out.push({t,n:1}); else out[out.length-1].n++; } return out; }
    function buildBigRoadStrictL(seq,maxRows=BEAD_MAX_ROWS){
      const runs=streakRuns(seq); const grid=[]; let labelNo=1; let prevRunStartCol=-1;
      for(const run of runs){
        const t=run.t; let col,row;
        if(prevRunStartCol<0){ col=0; row=0; }
        else { col=prevRunStartCol+1; row=0; while(!isEmpty(grid,col,row)){ col++; ensureCol(grid,col); } }
        const thisRunStartCol=col;
        let placed=0;
        while(placed<run.n && row<maxRows && isEmpty(grid,col,row)){
          ensureCol(grid,col); grid[col][row]={t,label:labelNo++}; placed++; row++;
        }
        const lockRow=Math.max(0,row-1);
        let remain=run.n-placed; let c=col+1;
        while(remain>0){
          ensureCol(grid,c);
          if(isEmpty(grid,c,lockRow)){ grid[c][lockRow]={t,label:labelNo++}; remain--; }
          c++;
        }
        prevRunStartCol=thisRunStartCol;
      }
      return grid;
    }
    function computeColumnsSequential(seq,maxRows){
      const cols=[]; let col=[]; let labelNo=1;
      for(const t of seq){
        col.push({t,label:labelNo++});
        if(col.length===maxRows){ cols.push(col); col=[]; }
      }
      if(col.length) cols.push(col);
      return cols;
    }
    function renderLogroContinuous(seq, stripId, maxRows=BIGROAD_MAX_ROWS){
      const grid=buildBigRoadStrictL(seq,maxRows);
      const strip=document.getElementById(stripId); if(!strip) return;
      strip.innerHTML='';
      grid.forEach(col=>{
        const colDiv=document.createElement('div');
        colDiv.className='logro-col';
        colDiv.style.gridTemplateRows=`repeat(${maxRows}, var(--logro-bubble))`;
        for(let r=0;r<maxRows;r++){
          const cell=col&&col[r];
          if(cell){
            const b=document.createElement('div');
            b.className=`ring-bubble ${cell.t==='R'?'ring-red':'ring-blue'}`;
            const depth=Math.min(r,maxRows-1);
            b.style.setProperty('--z',`calc(var(--logro-step) * ${depth})`);
            b.style.transform=`translateZ(var(--z))`;
            colDiv.appendChild(b);
          }else{
            const gap=document.createElement('div'); gap.className='ring-gap';
            colDiv.appendChild(gap);
          }
        }
        strip.appendChild(colDiv);
      });
      strip.scrollLeft=strip.scrollWidth;
    }
    function renderRoadStrictL(seq, stripId, maxRows=BEAD_MAX_ROWS){
      const cols=computeColumnsSequential(seq,maxRows);
      const strip=document.getElementById(stripId); if(!strip) return;
      strip.innerHTML='';
      cols.forEach(col=>{
        const colDiv=document.createElement('div'); colDiv.className='bead-col';
        colDiv.style.gridTemplateRows=`repeat(${maxRows}, var(--bead-bubble))`;
        for(let r=0;r<maxRows;r++){
          const cell=col[r];
          const dot=document.createElement('div');
          if(cell){ dot.className='bead-solid '+(cell.t==='R'?'red':'blue'); dot.textContent=cell.label; }
          else { dot.className='bead'; dot.style.opacity='0.12'; dot.style.border='1px dashed rgba(255,255,255,.15)'; }
          colDiv.appendChild(dot);
        }
        strip.appendChild(colDiv);
      });
      strip.scrollLeft=strip.scrollWidth;
    }
    function renderAllRoads(seq){
      renderLogroContinuous(seq,'logro-strip-center',BIGROAD_MAX_ROWS);
      renderRoadStrictL(seq,'bead-strip-center',BEAD_MAX_ROWS);
      renderLogroContinuous(seq,'logro-strip-mob',BIGROAD_MAX_ROWS);
    }

    function computeOdds(){ meronOdds=(Math.random()*(2.0-1.5)+1.5).toFixed(2); walaOdds=(parseFloat(meronOdds)+0.20).toFixed(2); }
    function renderOddsEverywhere(){
      const m=document.getElementById('meron-odds'); if(m) m.textContent='PAYOUT = '+meronOdds;
      const w=document.getElementById('wala-odds');  if(w) w.textContent='PAYOUT = '+walaOdds;
      const mm=document.getElementById('meron-odds-mob'); if(mm) mm.textContent='PAYOUT = '+meronOdds;
      const ww=document.getElementById('wala-odds-mob');  if(ww) ww.textContent='PAYOUT = '+walaOdds;
    }
    function renderBalance(){
      const mid=document.getElementById('mid-balance');
      const head=document.getElementById('header-balance');
      if(mid) mid.textContent=Number(currentBalance).toLocaleString();
      if(head) head.textContent=Number(currentBalance).toLocaleString();
    }
    function adjustBalance(delta){ const next=currentBalance+delta; if(next<0) return false; currentBalance=next; renderBalance(); return true; }
    function updatePercentBar(){
      const red=meronAmount||0, blue=walaAmount||0;
      const total=red+blue; let redPct=50, bluePct=50;
      if(total>0){ redPct=Math.round((red/total)*100); bluePct=100-redPct; }
      const rEl=document.getElementById('pct-red'); const bEl=document.getElementById('pct-blue');
      const rl=document.getElementById('pct-red-label'); const bl=document.getElementById('pct-blue-label'); const tl=document.getElementById('pct-total-label');
      if(rEl) rEl.style.width=redPct+'%';
      if(bEl) bEl.style.width=bluePct+'%';
      if(rl) rl.textContent=`Red ${redPct}%`;
      if(bl) bl.textContent=`Blue ${bluePct}%`;
      if(tl) tl.textContent=`Total: ₱${Number(total).toLocaleString('en-PH')}`;
    }

    function sideBadgeHTML(side){ const cls=side==='MERON'?'side-badge side-meron':'side-badge side-wala'; return `<span class="side-3d"><span class="${cls}">${side}</span></span>`; }
    function badgeClassByStatus(s){ if(s==='WIN') return 'badge-3d badge-win'; if(s==='LOSE') return 'badge-3d badge-lose'; return 'badge-3d badge-pending'; }
    function addToHistory(entry){ betHistory.unshift(entry); renderHeaderHistory(); const dot=document.getElementById('header-history-dot') || document.getElementById('history-dot'); if(dot) dot.classList.toggle('hidden', betHistory.length===0); renderBetHistoryPage(); }
    function renderHeaderHistory(){
      const list=document.getElementById('header-history-list'); const empty=document.getElementById('header-history-empty'); if(!list||!empty) return;
      if(betHistory.length===0){ empty.classList.remove('hidden'); list.classList.add('hidden'); list.innerHTML=''; return; }
      empty.classList.add('hidden'); list.classList.remove('hidden');
      const top=betHistory.slice(0,8);
      list.innerHTML = top.map(item=>{
        const sideChip=sideBadgeHTML(item.side);
        const badge=`<span class="result-3d"><span class="${badgeClassByStatus(item.status)}">${item.status}</span></span>`;
        return `
          <div class="py-2 px-2 text-xs">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">${sideChip}</div>
              <div class="flex items-center gap-2">${badge}<div class="text-white/50">${item.time}</div></div>
            </div>
            <div class="text-white/80 mt-1">${item.player} • Match #${item.matchId}</div>
            <div class="mt-0.5">
              <span class="font-semibold">${Number(item.amount).toLocaleString()}</span>
              @ <span class="font-semibold">${item.odds}</span>
              = <span class="text-yellow-300 font-bold">${Number(item.payout).toLocaleString()}</span>
            </div>
            <div class="text-white/50 mt-0.5">Bal: ${Number(item.balanceBefore).toLocaleString()} → <span class="text-white/80 font-semibold">${Number(item.balanceAfter).toLocaleString()}</span></div>
          </div>`;
      }).join('');
    }
    function resolveLatestBet(winSide){
      const idx=betHistory.findIndex(b=>b.status==='PENDING'); if(idx===-1) return;
      const bet=betHistory[idx];
      if(bet.side===winSide){ bet.status='WIN'; adjustBalance(parseFloat(bet.payout)); bet.balanceAfter=currentBalance; }
      else { bet.status='LOSE'; bet.balanceAfter=currentBalance; }
      renderHeaderHistory(); renderBetHistoryPage();
    }

    function buildTicketId(matchId, side, amount){ const ts=Date.now().toString(36).toUpperCase(); return `BK-${matchId}-${side[0]}-${amount}-${ts}`; }
    function printTicket(ticket){
      const holder=document.getElementById('print-ticket-content'); const wrap=document.getElementById('print-ticket');
      const barSVG = makeCode39SVG(ticket.barcode, {height:70, module:2});
      const html = `
        <div class="text-center">
          <div class="text-[12px] text-gray-600 tracking-widest">BK2025 • Bet Ticket</div>
          <div class="mt-1 text-xl font-bold">MATCH #${ticket.matchId}</div>
          <div class="mt-1 text-[13px]">Ticket: <span class="font-semibold">${ticket.ticketId}</span></div>
          <div class="mt-3 grid grid-cols-2 gap-3 text-left">
            <div class="border border-gray-200 rounded-lg p-3">
              <div class="text-[12px] text-gray-500">Side</div>
              <div class="text-lg font-semibold">${ticket.side}</div>
              <div class="mt-1 text-[12px] text-gray-500">Player</div>
              <div class="font-medium">${ticket.player}</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-3">
              <div class="text-[12px] text-gray-500">Amount</div>
              <div class="text-lg font-semibold">₱${Number(ticket.amount).toLocaleString('en-PH')}</div>
              <div class="mt-1 text-[12px] text-gray-500">Odds</div>
              <div class="font-medium">${ticket.odds}</div>
              <div class="mt-1 text-[12px] text-gray-500">Potential Payout</div>
              <div class="font-semibold text-emerald-700">₱${Number(ticket.payout).toLocaleString('en-PH')}</div>
            </div>
          </div>
          <div class="mt-4 flex items-center justify-center">${barSVG}</div>
          <div class="mt-2 text-[12px] text-gray-600">Printed: ${new Date().toLocaleString('en-PH',{hour12:true})}</div>
        </div>`;
      if(holder && wrap){ holder.innerHTML = html; wrap.classList.remove('hidden'); window.print(); setTimeout(()=>wrap.classList.add('hidden'), 300); }
    }

    /* ====== CUSTOMER DETAILS HELPER ====== */
    function updateCustomerDetails({ amount, payout, time, who }){
      const betEl   = document.getElementById('cust-name');   if(betEl)   betEl.value   = `₱${Number(amount||0).toLocaleString('en-PH')}`;
      const payEl   = document.getElementById('cust-user');   if(payEl)   payEl.value   = `₱${Number(payout||0).toLocaleString('en-PH')}`;
      const timeEl  = document.getElementById('cust-email');  if(timeEl)  timeEl.value  = time || '';
      const whoEl   = document.getElementById('cust-phone');  if(whoEl)   whoEl.value   = who || '';
    }

    /* Confirm helpers */
    function openConfirmModal(details){
      pendingBet = details;
      document.getElementById('c-side').textContent    = details.side;
      document.getElementById('c-player').textContent  = details.player;
      document.getElementById('c-match').textContent   = details.matchId;
      document.getElementById('c-amount').textContent  = `₱${Number(details.amount).toLocaleString('en-PH')}`;
      document.getElementById('c-odds').textContent    = details.odds;
      document.getElementById('c-payout').textContent  = `₱${Number(details.payout).toLocaleString('en-PH')}`;
      document.getElementById('c-balance').textContent = `₱${Number(details.balanceAfter).toLocaleString('en-PH')}`;
      document.getElementById('confirm-overlay').style.display = 'flex';
    }
    function closeConfirmModal(){ pendingBet = null; document.getElementById('confirm-overlay').style.display = 'none'; }

    function placeBet(betType){
      const input=document.getElementById('bet-amount'); let betAmount=parseFloat(input?.value);
      if(isNaN(betAmount)||betAmount<=0){ alert('Please enter a valid bet amount greater than 0.'); return; }
      let odds, chosenPlayer;
      if(betType==='MERON'){ odds=meronOdds; chosenPlayer=document.getElementById('player1-name').textContent; }
      else { odds=walaOdds; chosenPlayer=document.getElementById('player2-name').textContent; }
      const matchId=document.getElementById('match-no').textContent||'—';
      const balanceAfter = currentBalance - betAmount; if(balanceAfter < 0){ alert('Insufficient balance.'); return; }
      const potential = (betAmount * parseFloat(odds)).toFixed(2);
      openConfirmModal({ side: betType, player: chosenPlayer || (betType==='MERON'?'Red':'Blue'), matchId, amount: betAmount, odds, payout: potential, balanceAfter });
    }
    function executeBet(details){
      const { side:betType, player:chosenPlayer, matchId, amount:betAmount, odds } = details;
      const balanceBefore=currentBalance; if(!adjustBalance(-betAmount)){ alert('Insufficient balance.'); return; }
      if(betType==='MERON'){ meronAmount+=betAmount; const el=document.getElementById('meron-amount'); if(el) el.textContent=meronAmount.toLocaleString(); }
      else { walaAmount+=betAmount; const el=document.getElementById('wala-amount'); if(el) el.textContent=walaAmount.toLocaleString(); }
      updatePercentBar();
      const totalWinnings=parseFloat(betAmount)*parseFloat(odds);
      if(betType==='MERON'){ const r=document.getElementById('meron-result'); if(r) r.textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`; const c=document.getElementById('wala-result'); if(c) c.textContent=""; }
      else { const r=document.getElementById('wala-result'); if(r) r.textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`; const c=document.getElementById('meron-result'); if(c) c.textContent=""; }
      const time=new Date().toLocaleString('en-PH',{hour12:true});

      /* >>> Update Customer Details after successful bet <<< */
      updateCustomerDetails({
        amount: betAmount,
        payout: totalWinnings,
        time,
        who: `${betType} — ${chosenPlayer}`
      });

      const entry = { side:betType, player:chosenPlayer, matchId, amount:betAmount, odds, payout:totalWinnings.toFixed(2), time, balanceBefore, balanceAfter:currentBalance, status:'PENDING' };
      addToHistory(entry);
      const ticketId = buildTicketId(matchId, betType, betAmount);
      const barcodeData = `BK|${ticketId}|${betType}|${betAmount}|${odds}|${entry.payout}`;
      printTicket({ ticketId, barcode: barcodeData, matchId, side: betType, player: entry.player, amount: betAmount, odds, payout: entry.payout });
      alert(`You placed a bet of ${betAmount} on ${chosenPlayer}.
Possible payout: ${totalWinnings.toFixed(2)}.
New Balance: ${currentBalance.toLocaleString()}.`);
    }

    function pushResult(side){ 
      results.push(side==='MERON'?'R':'B'); renderAllRoads(results); resolveLatestBet(side); 
    }
    function undoResult(){ results.pop(); renderAllRoads(results); }
    function clearResults(){ results=[]; renderAllRoads(results); }

    /* Pagination */
    let historyPage=1; const pageSize=10;
    function renderBetHistoryPage(){
      const listEl=document.getElementById('history-list');
      const emptyEl=document.getElementById('history-empty');
      const pageEl=document.getElementById('history-page');
      const pagesEl=document.getElementById('history-pages');
      const prevBtn=document.getElementById('history-prev');
      const nextBtn=document.getElementById('history-next');

      const total=betHistory.length;
      const totalPages=Math.max(1, Math.ceil(total/pageSize));
      if(historyPage>totalPages) historyPage=totalPages;
      if(historyPage<1) historyPage=1;

      if(pagesEl) pagesEl.textContent=String(totalPages);
      if(pageEl)  pageEl.textContent=String(historyPage);
      if(prevBtn) prevBtn.disabled = (historyPage<=1);
      if(nextBtn) nextBtn.disabled = (historyPage>=totalPages);

      if(total===0){ if(listEl) listEl.innerHTML=''; if(emptyEl) emptyEl.classList.remove('hidden'); return; }
      else { if(emptyEl) emptyEl.classList.add('hidden'); }

      const start=(historyPage-1)*pageSize;
      const pageItems=betHistory.slice(start, start+pageSize);

      if(listEl){
        listEl.innerHTML = pageItems.map(item=>{
          const sc = item.status==='WIN' ? 'win' : item.status==='LOSE' ? 'lose' : 'pending';
          return `
          <div class="py-3">
            <div class="flex items-center justify-between text-[13px]">
              <div class="flex items-center gap-2">
                <span class="hist-pill ${item.side==='MERON'?'red':'blue'}">${item.side[0]}</span>
                <span class="text-slate-200 font-medium">${item.player}</span>
              </div>
              <span class="text-slate-400">${item.time}</span>
            </div>
            <div class="mt-1 grid grid-cols-3 gap-2 hist-kv">
              <div>Match <strong>#${item.matchId}</strong></div>
              <div>Amt <strong>₱${Number(item.amount).toLocaleString('en-PH')}</strong></div>
              <div class="text-right">Odds <strong>${item.odds}</strong></div>
            </div>
            <div class="mt-1 flex items-center justify-between text-[13px]">
              <div class="hist-status ${sc}">${item.status}</div>
              <div class="text-amber-300">Payout <span class="font-bold">₱${Number(item.payout).toLocaleString('en-PH')}</span></div>
            </div>
          </div>`;
        }).join('');
      }
    }

    /* Scan/Enter handlers */
    (function(){
      const form = document.getElementById('scan-form');
      const input= document.getElementById('scan-input');
      const status= document.getElementById('scan-status');
      const reset = document.getElementById('scan-reset');

      if(form){
        form.addEventListener('submit', (e)=>{
          e.preventDefault();
          const code = (input?.value || '').trim();
          if(!code){ status.textContent = 'Please enter a card code.'; return; }
          // No overwrite of Customer Details; status only
          status.textContent = 'Card accepted: '+code;
        });
      }
      reset?.addEventListener('click', ()=>{
        input.value='';
        ['cust-name','cust-user','cust-email','cust-phone'].forEach(id=>{
          const el=document.getElementById(id); if(el) el.value='';
        });
        status.textContent='';
      });
    })();

    /* Init */
    window.onload=()=>{
      setDateTime(); setRandomMatch();
      let meronAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      let walaAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      meronAmount=meronAmountInit; walaAmount=walaAmountInit;

      computeOdds(); renderOddsEverywhere();
      const ma=document.getElementById('meron-amount'); if(ma) ma.textContent=meronAmount.toLocaleString();
      const wa=document.getElementById('wala-amount'); if(wa) wa.textContent=walaAmount.toLocaleString();
      const mam=document.getElementById('meron-amount-mob'); if(mam) mam.textContent=meronAmount.toLocaleString();
      const wam=document.getElementById('wala-amount-mob'); if(wam) wam.textContent=walaAmount.toLocaleString();

      updatePercentBar();
      document.querySelectorAll('.tilt').forEach(attachTilt);

      // Admin controls (if present in DOM)
      const wm=document.getElementById('btn-win-meron');
      const ww=document.getElementById('btn-win-wala');
      const uu=document.getElementById('btn-undo');
      const cc=document.getElementById('btn-clear');
      if(wm) wm.addEventListener('click',()=>pushResult('MERON'));
      if(ww) ww.addEventListener('click',()=>pushResult('WALA'));
      if(uu) uu.addEventListener('click',undoResult);
      if(cc) cc.addEventListener('click',clearResults);

      renderAllRoads(results);
      renderBalance();

      document.querySelectorAll('.bet-chip').forEach(btn=>{
        btn.addEventListener('click',()=>{
          const raw=parseInt(btn.dataset.val||'0',10);
          const amt=document.getElementById('bet-amount'); if(amt) amt.value=raw;
          btn.animate([{transform:'translateY(-3px)'},{transform:'translateY(0)'}],{duration:120});
        });
      });

      const bm=document.getElementById('bet-meron');
      const bw=document.getElementById('bet-wala');
      if(bm) bm.addEventListener('click',()=>placeBet('MERON'));
      if(bw) bw.addEventListener('click',()=>placeBet('WALA'));

      const videoWrap=document.getElementById('video-wrap');
      const toggleBtn=document.getElementById('toggle-video');
      const toggleLbl=document.getElementById('toggle-video-label');
      try{ const saved=localStorage.getItem('bk_video_hidden'); if(saved==='1'){ videoWrap.classList.add('hidden'); if(toggleLbl) toggleLbl.textContent='Show Video'; } }catch(e){}
      if(toggleBtn&&videoWrap){
        toggleBtn.addEventListener('click',()=>{
          const hidden=videoWrap.classList.toggle('hidden');
          if(toggleLbl) toggleLbl.textContent = hidden ? 'Show Video' : 'Hide Video';
          try{ localStorage.setItem('bk_video_hidden', hidden?'1':'0'); }catch(e){}
        });
      }

      const prevBtn=document.getElementById('history-prev');
      const nextBtn=document.getElementById('history-next');
      prevBtn?.addEventListener('click',()=>{ historyPage=Math.max(1, historyPage-1); renderBetHistoryPage(); });
      nextBtn?.addEventListener('click',()=>{ const totalPages=Math.max(1, Math.ceil(betHistory.length/pageSize)); historyPage=Math.min(totalPages, historyPage+1); renderBetHistoryPage(); });

      document.getElementById('confirm-cancel').addEventListener('click', closeConfirmModal);
      document.getElementById('confirm-overlay').addEventListener('click', (e)=>{ if(e.target.id==='confirm-overlay') closeConfirmModal(); });
      document.getElementById('confirm-ok').addEventListener('click', ()=>{ if(pendingBet){ executeBet(pendingBet); } closeConfirmModal(); });

      renderBetHistoryPage();
    };
  </script>
</body>
</x-layouts.app>
