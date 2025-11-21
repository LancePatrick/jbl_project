{{-- resources/views/teller.blade.php --}}
<x-layouts.app :title="__('Teller')">
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/teller.js'])

  <body class="min-h-dvh bg-black text-white font-sans overflow-x-hidden">
    <div class="bg-animated print:hidden"></div>

    <main class="mx-auto lg:p-4 print:hidden">
      <div class="grid gap-6 grid-cols-1 lg:grid-cols-12">

        <!-- LEFT: VIDEO + SCAN CARD -->
        <section
          class="lg:col-span-2 relative z-10 p-4 rounded-xl bg-slate-900/95 border border-white/15 shadow-[0_12px_40px_rgba(0,0,0,0.45)]"
        >
          <!-- Match header -->
          <div class="grid grid-cols-3 items-center mb-3 text-sm text-gray-300">
            <div id="event-date" class="text-left"></div>
            <div class="text-center font-bold text-yellow-400 text-lg">
              MATCH# <span id="match-no">—</span>
            </div>
            <div id="event-time" class="text-right"></div>
          </div>

          <!-- Toolbar -->
          <div class="mb-2 flex items-center justify-end">
            <button
              id="toggle-video"
              class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-black/40 px-3 py-1.5 text-[13px] text-white/80 hover:bg-black/60"
            >
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path
                  d="M15 10l4.55-2.27A1 1 0 0121 8.62v6.76a1 1 0 01-1.45.9L15 14v-4z"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <rect
                  x="3"
                  y="6"
                  width="12"
                  height="12"
                  rx="2"
                  stroke-width="1.5"
                />
              </svg>
              <span id="toggle-video-label">Hide Video</span>
            </button>
          </div>

          <!-- Video -->
          <div id="video-wrap" class="mb-4 relative">
            <div class="relative aspect-video">
              <div class="absolute inset-0 rounded-xl overflow-hidden z-10">
                <div
                  class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 animate-[pulse_4s_infinite] mix-blend-overlay opacity-70"
                ></div>
                <div
                  class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"
                ></div>
                <div
                  class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20 mix-blend-overlay animate-[glow-border_2s_ease-in-out_infinite_alternate]"
                ></div>
              </div>
              <iframe
                id="youtube-video-main"
                class="absolute inset-0 w-full h-full rounded-lg relative z-20 border-4 border-transparent"
                src="https://www.youtube.com/embed/rUC_nHCOUW4?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
              ></iframe>
            </div>
          </div>

          <!-- Scan / Enter Card -->
          <div class="mb-0 rounded-lg border border-white/10 bg-black/40 p-3">
            <div class="text-[12px] uppercase tracking-widest text-white/70 mb-2">
              Scan / Enter Card
            </div>
            <form id="scan-form" class="space-y-2">
              <input
                id="scan-input"
                type="text"
                placeholder="Enter or scan card code"
                class="w-full bet-input p-2 text-sm text-white bg-slate-900/70 border border-white/20 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              />
              <div class="flex gap-2">
                <button
                  type="button"
                  id="scan-reset"
                  class="px-3 py-1.5 rounded-lg border border-white/20 bg-slate-800 text-[12px] hover:bg-slate-700"
                >
                  Reset
                </button>
                <button
                  type="submit"
                  id="scan-submit"
                  class="px-3 py-1.5 rounded-lg border border-indigo-400/60 bg-indigo-600 hover:bg-indigo-500 text-[12px] font-semibold shadow-[0_8px_18px_rgba(37,99,235,0.45)]"
                >
                  Submit Card
                </button>
              </div>
            </form>

            <div class="mt-3 text-[12px] text-white/70 uppercase tracking-widest">
              Customer Details
            </div>
            <div class="mt-1 grid grid-cols-2 gap-2 text-[13px]">
              <!-- 4 fields repurposed as requested -->
              <input
                id="cust-name"
                class="bet-input bg-slate-900/70 border border-white/20 rounded-md p-2 col-span-2 lg:col-span-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Bet"
                readonly
              />
              <input
                id="cust-user"
                class="bet-input bg-slate-900/70 border border-white/20 rounded-md p-2 col-span-2 lg:col-span-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Total Payout"
                readonly
              />
              <input
                id="cust-email"
                class="bet-input bg-slate-900/70 border border-white/20 rounded-md p-2 col-span-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Time & date"
                readonly
              />
              <input
                id="cust-phone"
                class="bet-input bg-slate-900/70 border border-white/20 rounded-md p-2 col-span-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Player bet"
                readonly
              />
            </div>
            <div id="scan-status" class="mt-2 text-[12px] text-emerald-300"></div>
          </div>
        </section>
        <!-- /LEFT -->

        <!-- CENTER: BET + Logrohan & Road -->
        <section
          class="lg:col-span-8 p-4 rounded-xl bg-slate-900/95 border border-white/15 shadow-[0_12px_40px_rgba(0,0,0,0.45)]"
        >
          <!-- Bet Percentage Bar -->
          <div
            class="bg-slate-950/80 border border-white/15 rounded-xl p-2 mb-3 shadow-[0_10px_30px_rgba(0,0,0,0.55)]"
          >
            <div class="text-[11px] uppercase tracking-widest text-white/70 mb-1">
              Bet Percentage
            </div>
            <div
              class="relative h-3 rounded-full bg-black/40 border border-white/20 overflow-hidden"
            >
              <div
                id="pct-red"
                class="absolute left-0 top-0 h-full bg-red-600/80 transition-all duration-300"
                style="width:50%"
              ></div>
              <div
                id="pct-blue"
                class="absolute right-0 top-0 h-full bg-blue-600/80 transition-all duration-300"
                style="width:50%"
              ></div>
            </div>
            <div class="mt-1 grid grid-cols-3 text-[11px] text-white/70">
              <div id="pct-red-label" class="text-left">Red 50%</div>
              <div id="pct-total-label" class="text-center text-white/50">
                Total: ₱0
              </div>
              <div id="pct-blue-label" class="text-right">Blue 50%</div>
            </div>
          </div>

          <!-- Bet Cards -->
          <div
            id="bet-area"
            class="bet-area grid grid-cols-1 lg:grid-cols-2 gap-3 mt-0 mb-4"
          >
            <!-- Meron -->
            <div
              class="bet-card red tilt text-center rounded-xl bg-gradient-to-b from-red-900/80 via-slate-950 to-slate-950 border border-red-500/40 shadow-[0_18px_40px_rgba(127,29,29,0.7)] p-3"
            >
              <div class="flex items-center justify-between">
                <span
                  class="name-chip inline-flex items-center justify-center rounded-full bg-slate-900 border border-white/20 px-3 py-1 text-xl md:text-2xl font-semibold shadow-[0_2px_8px_rgba(0,0,0,0.6)]"
                >
                  R
                </span>
              </div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name"></div>
              <div
                class="amount-3d text-3xl md:text-4xl mt-1 font-black text-amber-300 drop-shadow-[0_0_12px_rgba(251,191,36,0.6)]"
                id="meron-amount"
              ></div>
              <div>
                <div class="mt-2">
                  <span
                    class="odds-ribbon inline-block rounded-md border border-white/20 bg-slate-900/80 px-2 py-1 text-xs font-semibold tracking-wide text-sky-100"
                    id="meron-odds"
                  ></span>
                </div>

                <button
                  class="bet-btn red mt-2 w-full px-3 py-2 text-sm font-semibold rounded-lg border border-red-300/50 bg-red-700 hover:bg-red-600 shadow-[0_10px_26px_rgba(220,38,38,0.70)] active:translate-y-[1px] transition"
                  id="bet-meron"
                >
                  BET
                </button>

                <div
                  id="meron-result"
                  class="mt-2 text-xs text-yellow-300 result-glow"
                ></div>
              </div>
            </div>

            <!-- Wala -->
            <div
              class="bet-card blue tilt text-center rounded-xl bg-gradient-to-b from-blue-900/80 via-slate-950 to-slate-950 border border-sky-500/40 shadow-[0_18px_40px_rgba(30,64,175,0.7)] p-3"
            >
              <div class="flex items-center justify-between">
                <span
                  class="name-chip inline-flex items-center justify-center rounded-full bg-slate-900 border border-white/20 px-3 py-1 text-xl md:text-2xl font-semibold shadow-[0_2px_8px_rgba(0,0,0,0.6)]"
                >
                  B
                </span>
              </div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player2-name"></div>
              <div
                class="amount-3d text-3xl md:text-4xl mt-1 font-black text-amber-300 drop-shadow-[0_0_12px_rgba(251,191,36,0.6)]"
                id="wala-amount"
              ></div>
              <div>
                <div class="mt-2">
                  <span
                    class="odds-ribbon inline-block rounded-md border border-white/20 bg-slate-900/80 px-2 py-1 text-xs font-semibold tracking-wide text-sky-100"
                    id="wala-odds"
                  ></span>
                </div>

                <button
                  class="bet-btn blue mt-2 w-full px-3 py-2 text-sm font-semibold rounded-lg border border-sky-300/50 bg-blue-700 hover:bg-blue-600 shadow-[0_10px_26px_rgba(37,99,235,0.70)] active:translate-y-[1px] transition"
                  id="bet-wala"
                >
                  BET
                </button>

                <div
                  id="wala-result"
                  class="mt-2 text-xs text-yellow-300 result-glow"
                ></div>
              </div>
            </div>
          </div>

          <!-- Bet Amount + Chips -->
          <div
            class="bg-slate-950/80 border border-white/15 rounded-xl p-3 mb-3 shadow-[0_10px_30px_rgba(0,0,0,0.55)]"
          >
            <div class="flex items-center justify-between mb-2">
              <div class="text-[15px] uppercase tracking-widest text-white/70">
                Bet Amount
              </div>
              <div class="text-[15px] text-white/60">min ₱100</div>
            </div>

            <div class="flex flex-wrap items-center gap-2 mb-2">
              <input
                type="number"
                id="bet-amount"
                class="bet-input p-2 text-sm text-white bg-slate-900/70 border border-white/20 rounded-md w-[160px] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Enter amount"
                inputmode="numeric"
              />
              <div
                class="balance-pill inline-flex items-center gap-2 rounded-full border border-sky-300/50 bg-slate-900/90 px-3 py-1 shadow-[0_12px_24px_rgba(56,189,248,0.45)]"
              >
                <svg
                  class="w-5 h-5 opacity-90"
                  viewBox="0 0 64 64"
                  aria-hidden="true"
                >
                  <defs>
                    <linearGradient id="gemTop" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#e9f7ff" />
                      <stop offset="40%" stop-color="#c6e6ff" />
                      <stop offset="70%" stop-color="#9fd3ff" />
                      <stop offset="100%" stop-color="#e6fbff" />
                    </linearGradient>
                    <linearGradient id="gemSide" x1="0%" y1="0%" x2="0%" y2="100%">
                      <stop offset="0%" stop-color="#b5e3ff" />
                      <stop offset="100%" stop-color="#80c3f7" />
                    </linearGradient>
                    <radialGradient id="gemGlow" cx="50%" cy="50%" r="60%">
                      <stop offset="0%" stop-color="rgba(255,255,255,0.9)" />
                      <stop
                        offset="60%"
                        stop-color="rgba(255,255,255,0.0)"
                      />
                    </radialGradient>
                  </defs>
                  <polygon
                    points="32,60 6,24 58,24"
                    fill="url(#gemSide)"
                    stroke="#a7d8ff"
                    stroke-width="1"
                  />
                  <polygon
                    points="12,24 20,8 44,8 52,24 12,24"
                    fill="url(#gemTop)"
                    stroke="#bfe6ff"
                    stroke-width="1"
                  />
                  <polyline
                    points="20,8 32,24 44,8"
                    fill="none"
                    stroke="#d8f1ff"
                    stroke-width="1"
                    opacity=".9"
                  />
                  <polyline
                    points="12,24 32,24 52,24"
                    fill="none"
                    stroke="#cfeaff"
                    stroke-width="1"
                    opacity=".9"
                  />
                  <polyline
                    points="6,24 32,60 58,24"
                    fill="none"
                    stroke="#a7d8ff"
                    stroke-width="1"
                    opacity=".7"
                  />
                  <circle
                    cx="32"
                    cy="30"
                    r="16"
                    fill="url(#gemGlow)"
                    opacity=".35"
                  />
                </svg>
                <span class="text-[11px] opacity-80 tracking-widest uppercase">
                  Balance
                </span>
                <span
                  id="mid-balance"
                  class="amount text-base font-semibold text-yellow-200"
                  >5,000</span
                >
              </div>
            </div>

            <div class="grid grid-cols-2 gap-1">
              <button
                class="chip3d chip-emerald chip-outline text-sm bet-chip inline-flex items-center justify-center rounded-full border border-emerald-300/60 bg-emerald-700/80 px-3 py-1 font-semibold text-emerald-50 shadow-[0_8px_18px_rgba(16,185,129,0.65)]"
                data-val="100"
              >
                ♦100
              </button>
              <button
                class="chip3d chip-blue chip-outline text-sm bet-chip inline-flex items-center justify-center rounded-full border border-sky-300/60 bg-sky-700/80 px-3 py-1 font-semibold text-sky-50 shadow-[0_8px_18px_rgba(59,130,246,0.65)]"
                data-val="200"
              >
                ♦200
              </button>
              <button
                class="chip3d chip-black chip-outline text-sm bet-chip inline-flex items-center justify-center rounded-full border border-slate-300/60 bg-slate-900/90 px-3 py-1 font-semibold text-slate-50 shadow-[0_8px_18px_rgba(15,23,42,0.85)]"
                data-val="500"
              >
                ♦500
              </button>
              <button
                class="chip3d chip-amber chip-outline text-sm bet-chip inline-flex items-center justify-center rounded-full border border-amber-300/70 bg-amber-600/90 px-3 py-1 font-semibold text-amber-50 shadow-[0_8px_18px_rgba(245,158,11,0.75)]"
                data-val="1000"
              >
                ♦1000
              </button>
            </div>
          </div>

          <!-- Logrohan + Road (same size) -->
          <div
            class="bg-slate-950/80 border border-white/15 rounded-xl p-2 shadow-[0_10px_30px_rgba(0,0,0,0.55)]"
          >
            <div class="grid md:grid-cols-2 gap-2">
              <!-- Logrohan -->
              <div
                class="logro-zone rounded-lg p-2 bg-slate-950/90 border border-white/20"
              >
                <div class="flex items-center justify-between mb-1">
                  <div
                    class="text-[11px] uppercase tracking-widest text-white/70"
                  >
                    Logrohan
                  </div>
                  <div class="flex items-center gap-2 text-[10px]">
                    <div class="flex items-center gap-1">
                      <span
                        class="bead red inline-block rounded-full border-2 border-red-400 bg-red-900"
                        style="width:12px;height:12px;"
                      ></span>
                      <span class="opacity-70">Red</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <span
                        class="bead blue inline-block rounded-full border-2 border-sky-400 bg-blue-900"
                        style="width:12px;height:12px;"
                      ></span>
                      <span class="opacity-70">Blue</span>
                    </div>
                  </div>
                </div>
                <div
                  id="logro-rail-center"
                  class="logro-rail h-[220px] overflow-hidden"
                >
                  <div
                    id="logro-strip-center"
                    class="logro-strip-3d h-full !overflow-x-auto !overflow-y-hidden !overflow-visible !max-w-[220px] lg:!max-w-full"
                  ></div>
                </div>
              </div>

              <!-- Road -->
              <div
                class="rounded-lg p-2 border border-white/20 bg-slate-950/90"
              >
                <div class="flex items-center justify-between mb-1">
                  <div
                    class="text-[11px] uppercase tracking-widest text-white/70"
                  >
                    Road
                  </div>
                  <div class="flex items-center gap-2 text-[10px]">
                    <div class="flex items-center gap-1">
                      <span
                        class="bead red inline-block rounded-full border-2 border-red-400 bg-red-900"
                        style="width:12px;height:12px;"
                      ></span>
                      <span class="opacity-70">Red</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <span
                        class="bead blue inline-block rounded-full border-2 border-sky-400 bg-blue-900"
                        style="width:12px;height:12px;"
                      ></span>
                      <span class="opacity-70">Blue</span>
                    </div>
                  </div>
                </div>
                <div
                  class="bead-rail h-[220px] bg-slate-950 border border-dashed border-white/25 rounded-md p-1 overflow-x-auto overflow-y-hidden"
                >
                  <div
                    id="bead-strip-center"
                    class="bead-strip h-full !overflow-x-auto !overflow-y-hidden !overflow-visible !max-w-[220px] lg:!max-w-full"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- /CENTER -->

        <!-- RIGHT: BET HISTORY -->
        <aside
          id="history-wrap"
          class="lg:col-span-2 p-0 bg-slate-900 border border-white/15 rounded-xl shadow-[0_12px_40px_rgba(0,0,0,0.45)]"
        >
          <div
            id="history-head"
            class="px-4 py-3 sticky top-0 bg-slate-900 z-20 border-b border-white/10"
          >
            <div class="flex items-center justify-between">
              <h2 class="text-[17px] font-semibold text-white">Bet History</h2>
              <span
                id="history-dot"
                class="inline-block w-2 h-2 rounded-full bg-emerald-400 hidden"
              ></span>
            </div>
            <div class="mt-1 text-[12px] text-slate-300">
              Showing 10 per page
            </div>
          </div>

          <div
            id="history-list"
            class="px-4 max-h-[560px] overflow-auto scroll-smooth"
          ></div>

          <div
            id="history-empty"
            class="px-4 py-6 text-center text-slate-300 hidden"
          >
            No bets yet.
          </div>

          <div
            class="px-4 py-3 border-t border-white/10 bg-[#0d1426] flex items-center justify-between"
          >
            <button
              id="history-prev"
              class="px-3 py-1.5 rounded-lg border border-white/20 bg-[#0b1223] text-sm text-slate-200 hover:bg-[#0e1832] disabled:opacity-40 disabled:cursor-not-allowed"
            >
              Prev
            </button>
            <div class="text-sm text-slate-200">
              Page <span id="history-page">1</span> /
              <span id="history-pages">1</span>
            </div>
            <button
              id="history-next"
              class="px-3 py-1.5 rounded-lg border border-white/20 bg-[#0b1223] text-sm text-slate-200 hover:bg-[#0e1832] disabled:opacity-40 disabled:cursor-not-allowed"
            >
              Next
            </button>
          </div>
        </aside>

        <!-- MOBILE STACK -->
        <div class="md:hidden space-y-3">
          <div
            class="bg-slate-950/80 border border-white/15 rounded-lg p-2 logro-zone"
          >
            <div class="flex items-center justify-between mb-1">
              <div
                class="text-[11px] uppercase tracking-widest text-white/70"
              >
                Logrohan
              </div>
              <div class="flex items-center gap-2 text-[10px]">
                <div class="flex items-center gap-1">
                  <span
                    class="bead red inline-block rounded-full border-2 border-red-400 bg-red-900"
                    style="width:12px;height:12px;"
                  ></span>
                  <span class="opacity-70">Red</span>
                </div>
                <div class="flex items-center gap-1">
                  <span
                    class="bead blue inline-block rounded-full border-2 border-sky-400 bg-blue-900"
                    style="width:12px;height:12px;"
                  ></span>
                  <span class="opacity-70">Blue</span>
                </div>
              </div>
            </div>
            <div
              id="logro-rail-mob"
              class="logro-rail h-[220px] overflow-hidden"
            >
              <div
                id="logro-strip-mob"
                class="logro-strip-3d h-full"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Hidden print container -->
    <div
      id="print-ticket"
      class="hidden print:flex print:items-center print:justify-center print:fixed print:inset-0 print:bg-white"
    >
      <div
        id="print-ticket-content"
        class="mx-auto max-w-[440px] bg-white text-black rounded-lg p-5 shadow print:shadow-none"
      ></div>
    </div>

    <!-- Confirm Modal -->
    <div
      id="confirm-overlay"
      role="dialog"
      aria-modal="true"
      aria-labelledby="confirm-title"
      class="fixed inset-0 bg-black/60 z-[60] flex items-center justify-center print:hidden"
      style="display:none;"
    >
      <div
        id="confirm-modal"
        class="w-full max-w-[420px] bg-slate-900 text-slate-200 border border-white/15 rounded-xl shadow-[0_20px_80px_rgba(0,0,0,0.6)] overflow-hidden"
      >
        <header
          id="confirm-title"
          class="px-4 py-3 bg-slate-950 border-b border-white/10 font-bold tracking-[0.03em]"
        >
          Confirm Bet
        </header>
        <div class="body px-4 py-3 space-y-1.5">
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Side</span>
            <strong id="c-side" class="font-semibold text-slate-100">—</strong>
          </div>
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Player</span>
            <span id="c-player" class="text-slate-100">—</span>
          </div>
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Match #</span>
            <span id="c-match" class="text-slate-100">—</span>
          </div>
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Amount</span>
            <span id="c-amount" class="text-slate-100">—</span>
          </div>
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Odds</span>
            <span id="c-odds" class="text-slate-100">—</span>
          </div>
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Potential Payout</span>
            <span id="c-payout" class="text-emerald-300 font-semibold">—</span>
          </div>
          <div
            class="row grid grid-cols-[120px_minmax(0,1fr)] gap-2 text-sm"
          >
            <span class="text-sky-300">Balance After</span>
            <span id="c-balance" class="text-slate-100 font-semibold">—</span>
          </div>
        </div>
        <footer
          class="px-4 py-3 bg-slate-950 border-t border-white/10 flex gap-2 justify-end"
        >
          <button
            id="confirm-cancel"
            class="px-3 py-1.5 rounded-md bg-slate-800 border border-white/20 text-sm hover:bg-slate-700"
          >
            Cancel
          </button>
          <button
            id="confirm-ok"
            class="px-3 py-1.5 rounded-md bg-emerald-600 border border-emerald-400/80 text-sm font-semibold text-white hover:bg-emerald-500 shadow-[0_10px_30px_rgba(16,185,129,0.7)]"
          >
            Confirm Bet
          </button>
        </footer>
      </div>
    </div>


  
    <script>
    </script>
  </body>
</x-layouts.app>
