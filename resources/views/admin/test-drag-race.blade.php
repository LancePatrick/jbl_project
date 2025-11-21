{{-- resources/views/drag-race.blade.php --}}
<x-layouts.app :title="__('Drag Race')">

  <body class="min-h-dvh overflow-x-hidden font-sans text-[13px] text-white bg-black">
    {{-- GLOBAL BG SAME AS BILLIARD --}}
    <div class="bg-animated"></div>

    @php
      /** role_id: 1 = admin, 2 = user */
      $roleId = auth()->user()->role_id ?? 2;
    @endphp

    <!-- PAGE GRID -->
    <div class="relative z-10 w-full max-w-[900px] md:max-w-screen-2xl mx-auto
           grid gap-4 justify-center
           px-2 sm:px-[var(--gutter,12px)] py-3 sm:py-[18px]">

      <!-- MAIN PANEL -->
      <section class="w-full max-w-full md:max-w-none mx-auto
             rounded-xl border border-white/10 bg-gray-900/60
             p-2.5 sm:p-4 lg:p-11 backdrop-blur-[1px]
             shadow-lg" style="--side:clamp(300px,32vw,420px);">
        <div class="flex items-center justify-between gap-3 border-b border-white/10 pb-2">
          <div class="flex gap-1 overflow-auto px-1 sm:px-2">
            <button data-tab="odds" class="rounded-[12px] border border-[rgb(210_225_255_/_0.9)]
                   bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)]
                   px-3 py-1.5 sm:py-2 font-black text-white text-[11px] sm:text-[12px]
                   shadow-[0_6px_14px_rgba(64,120,255,.35)] whitespace-nowrap">TOTALIZATOR</button>

            <button data-tab="total" class="rounded-[12px] border border-[rgb(210_225_255_/_0.8)] bg-[rgba(21,35,71,0.75)]
                   px-3 py-1.5 sm:py-2 font-black text-white text-[11px] sm:text-[12px]
                   whitespace-nowrap">ODDS</button>
          </div>

          @if ($roleId === 1)
            <label class="flex items-center gap-2 text-[11px] sm:text-[12.5px] text-[#d6e2ff]">
              <input id="toggleVideo" type="checkbox" class="size-[14px] sm:size-[16px]" checked>
              <span>Show Video</span>
            </label>
          @endif
        </div>

        <div class="grid grid-cols-1 gap-3 md:grid-cols-[minmax(0,1fr)_var(--side)]">
          <!-- VIDEO (kept link, design similar card style) -->
          <div data-video class="relative aspect-[16/9] overflow-hidden rounded-[16px]
                 border border-white/10 bg-black/80
                 shadow-[0_18px_40px_rgba(0,0,0,.55),0_6px_14px_rgba(0,0,0,.25)]">
            <div class="pointer-events-none absolute inset-0 rounded-[16px]
                      shadow-[inset_0_0_0_3px_rgba(255,255,255,.12),inset_0_0_40px_rgba(15,23,42,.85)]"></div>
            <iframe id="yt" class="absolute inset-0 size-full border-0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
            <div id="videoOverlay"
              class="absolute inset-0 hidden grid place-items-center bg-black/60 text-white text-xs sm:text-sm">
              Video hidden by admin
            </div>
          </div>

          <!-- KIOSK SIDE -->
          <div id="kioskSide" class="flex max-h-[unset] md:max-h-[60svh] lg:max-h-[calc(100svh-140px)] xl:max-h-[calc(100svh-160px)]
                 lg:sticky lg:top-16 xl:top-20
                 flex-col gap-2 overflow-auto rounded-[14px]
                 border border-white/10 bg-gray-900/70 p-2 backdrop-blur-[16px]">

            <!-- ODDS VIEW -->
            <div id="oddsView" class="grid gap-2">
              <div class="grid grid-cols-2 gap-2">
                <!-- RED CARD -->
                <div class="relative rounded-[26px] border border-transparent
                       bg-[radial-gradient(circle_at_0%_0%,rgba(255,255,255,.25),transparent_55%),linear-gradient(180deg,#f97366_0%,#b91c1c_55%,#7f1d1d_100%)]
                       p-3 sm:p-4 text-white shadow-[0_16px_40px_rgba(0,0,0,.55)]">
                  <!-- top chip -->
                  <div class="flex items-start justify-between">
                    <div class="grid size-[30px] sm:size-[34px] place-items-center
                           rounded-full border-2 border-transparent bg-black/25 font-black
                           shadow-[0_4px_10px_rgba(0,0,0,.45)]">
                      R
                    </div>
                  </div>

                  <!-- name + amount -->
                  <div class="mt-5 text-center">
                    <div id="nameRed" class="text-[11px] sm:text-[13px] font-semibold tracking-wide">
                      Rider Red
                    </div>
                    <div id="amtRed" class="mt-1 text-[26px] sm:text-[32px] leading-none font-black tracking-[.08em]">
                      0
                    </div>
                  </div>

                  <!-- payout pill -->
                  <div class="mt-3 flex justify-center">
                    <div class="inline-flex items-center rounded-full border border-transparent
                           bg-black/25 px-4 py-1.5 text-[11px] sm:text-[12px] font-semibold
                           shadow-[0_6px_14px_rgba(0,0,0,.45)]">
                      PAYOUT =
                      <span id="oddsRed" class="ml-1">1.76</span>
                    </div>
                  </div>

                  <!-- choose button -->
                  <div class="mt-3">
                    <button data-bet="red" class="h-[36px] sm:h-[40px] w-full rounded-full border border-transparent
                           bg-white/10 text-[11px] sm:text-[13px] font-black uppercase
                           tracking-[0.22em]
                           shadow-[0_8px_18px_rgba(0,0,0,.55)]
                           hover:bg-white/18 active:scale-[.98] transition">
                      CHOOSE
                    </button>
                  </div>

                  <!-- current / potential bottom -->
                  <div class="mt-4 flex items-center justify-between text-[10px] sm:text-[11px]">
                    <div class="space-y-1">
                      <div class="flex items-center gap-2">


                      </div>
                      <div class="flex items-center gap-2">
                        <span class="opacity-90">Potential payoutzz</span>
                        <span id="potPayRed" class="text-[11px] sm:text-[12px] font-semibold text-white/95 truncate">
                          —
                        </span>
                      </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                      <span class="inline-block h-1.5 w-5 rounded-full bg-[#facc15]"></span>
                      <span class="inline-block h-1.5 w-5 rounded-full bg-[#22c55e]"></span>
                    </div>
                  </div>
                </div>

                <!-- BLUE CARD -->
                <div class="relative rounded-[26px] border border-transparent
                       bg-[radial-gradient(circle_at_0%_0%,rgba(255,255,255,.25),transparent_55%),linear-gradient(180deg,#60a5fa_0%,#1d4ed8_55%,#1e3a8a_100%)]
                       p-3 sm:p-4 text-white shadow-[0_16px_40px_rgba(0,0,0,.55)]">
                  <!-- top chip -->
                  <div class="flex items-start justify-between">
                    <div class="grid size-[30px] sm:size-[34px] place-items-center
                           rounded-full border-2 border-transparent bg-black/25 font-black
                           shadow-[0_4px_10px_rgba(0,0,0,.45)]">
                      B
                    </div>
                  </div>

                  <!-- name + amount -->
                  <div class="mt-5 text-center">
                    <div id="nameBlue" class="text-[11px] sm:text-[13px] font-semibold tracking-wide">
                      Rider Blue
                    </div>
                    <div id="amtBlue" class="mt-1 text-[26px] sm:text-[32px] leading-none font-black tracking-[.08em]">
                      0
                    </div>
                  </div>

                  <!-- payout pill -->
                  <div class="mt-3 flex justify-center">
                    <div class="inline-flex items-center rounded-full border border-transparent
                           bg-black/25 px-4 py-1.5 text-[11px] sm:text-[12px] font-semibold
                           shadow-[0_6px_14px_rgba(0,0,0,.45)]">
                      PAYOUT =
                      <span id="oddsBlue" class="ml-1">1.47</span>
                    </div>
                  </div>

                  <!-- choose button -->
                  <div class="mt-3">
                    <button data-bet="blue" class="h-[36px] sm:h-[40px] w-full rounded-full border border-transparent
                           bg-white/10 text-[11px] sm:text-[13px] font-black uppercase
                           tracking-[0.22em]
                           shadow-[0_8px_18px_rgba(0,0,0,.55)]
                           hover:bg-white/18 active:scale-[.98] transition">
                      CHOOSE
                    </button>
                  </div>

                  <!-- current / potential bottom -->
                  <div class="mt-4 flex items-center justify-between text-[10px] sm:text-[11px]">
                    <div class="space-y-1">
                      <div class="flex items-center gap-2">


                      </div>
                      <div class="flex items-center gap-2">
                        <span class="opacity-90"></span>
                        <span id="potPayBlue" class="text-[11px] sm:text-[12px] font-semibold text-white/95 truncate">
                          —
                        </span>
                      </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                      <span class="inline-block h-1.5 w-5 rounded-full bg-[#facc15]"></span>
                      <span class="inline-block h-1.5 w-5 rounded-full bg-[#22c55e]"></span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- AMOUNT INPUT -->
              <div
                class="grid gap-2 rounded-[14px] border border-white/10 bg-[rgba(18,29,64,0.72)] p-2 backdrop-blur-[14px]">
                <input id="amount" type="number" min="1" placeholder="Enter amount"
                  class="h-[40px] sm:h-[44px] w-full rounded-[12px] border border-[rgb(198_213_255_/_0.85)] bg-[rgba(18,29,64,0.95)] px-3 font-extrabold text-[#e9f3ff] text-[12px] sm:text-[13px] outline-none" />
                <div class="grid grid-cols-2 gap-2">
                  <button id="reset"
                    class="h-[38px] sm:h-[42px] rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] text-[12px]">
                    Reset
                  </button>
                  <button id="maxAmt"
                    class="h-[38px] sm:h-[42px] rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] text-[12px]">
                    Max
                  </button>
                </div>
              </div>

              <!-- CHIPS -->
              <div id="chips" class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <button
                  class="h-[38px] sm:h-[44px] rounded-[14px] border border-[#0f5c30] bg-[linear-gradient(180deg,#38b46a,#1c7b40)] font-black text-[#eef5ff] text-[12px] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦100</button>
                <button
                  class="h-[38px] sm:h-[44px] rounded-[14px] border border-[#163f8f] bg-[linear-gradient(180deg,#4c8cff,#1f55c0)] font-black text-[#eef5ff] text-[12px] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦200</button>
                <button
                  class="h-[38px] sm:h-[44px] rounded-[14px] border border-[#0b0c0f] bg-[linear-gradient(180deg,#3a3f47,#17191f)] font-black text-[#eef5ff] text-[12px] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦500</button>
                <button
                  class="h-[38px] sm:h-[44px] rounded-[14px] border border-[#a76407] bg-[linear-gradient(180deg,#ffb23a,#d48112)] font-black text-[#1b1203] text-[12px]">♦1000</button>
              </div>

              <!-- LAST BET -->
              <div id="lastBet"
                class="mt-1.5 sm:mt-2 rounded-[14px] border border-white/10 bg-[rgba(18,29,64,0.70)] px-3 py-2 text-[11.5px] sm:text-[12.5px] text-[#dce6ff] backdrop-blur-[14px]">
                <div class="mb-1 font-semibold uppercase tracking-wide opacity-90">Current Bet</div>
                <div class="flex flex-wrap gap-x-4 gap-y-1 font-bold">
                  <span>Side:
                    <span data-lb-side class="ml-1 text-[#ffecec]">—</span>
                  </span>
                  <span>Amount:
                    <span data-lb-amt>—</span>
                  </span>
                  <span>Est. Winning:
                    <span data-lb-win>—</span>
                  </span>
                </div>
              </div>

            </div>

            <!-- TOTAL VIEW -->
            <div id="totalView" hidden class="grid gap-2">
              <div class="grid grid-cols-1 gap-1">
                <div
                  class="rounded-[22px] border border-transparent bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-3">
                  <div class="text-[11px] sm:text-[13px] opacity-90">Total Bets — Red</div>
                  <div id="totalRed"
                    class="mt-1 text-[24px] sm:text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">
                    0</div>
                  <div
                    class="mt-1.5 sm:mt-2 grid place-items-center rounded-[14px] border border-transparent bg-black/20 px-3 py-1.5 text-[11px] sm:text-[13px] font-black">
                    Pool Share —
                    <span id="shareRed" class="ml-1">0%</span>
                  </div>
                </div>
                <div
                  class="rounded-[22px] border border-transparent bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-3">
                  <div class="text-[11px] sm:text-[13px] opacity-90">Total Bets — Blue</div>
                  <div id="totalBlue"
                    class="mt-1 text-[24px] sm:text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">
                    0</div>
                  <div
                    class="mt-1.5 sm:mt-2 grid place-items-center rounded-[14px] border border-transparent bg-black/20 px-3 py-1.5 text-[11px] sm:text-[13px] font-black">
                    Pool Share —
                    <span id="shareBlue" class="ml-1">0%</span>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-1 gap-1">
                <div
                  class="rounded-[22px] border border-transparent bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-3">
                  <div class="text-[11px] sm:text-[13px] opacity-90">Odds (x) — Red</div>
                  <div id="txRed"
                    class="mt-1 text-[24px] sm:text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">
                    1.76</div>
                </div>
                <div
                  class="rounded-[22px] border border-transparent bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-3">
                  <div class="text-[11px] sm:text-[13px] opacity-90">Odds (x) — Blue</div>
                  <div id="txBlue"
                    class="mt-1 text-[24px] sm:text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.2px]">
                    1.47</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>


      <section class="w-full max-w-full md:max-w-none mx-auto
             rounded-xl border border-white/10 bg-gray-900/60
             p-2.5 sm:p-4 lg:p-11 backdrop-blur-[1px]
             shadow-lg" style="--side:clamp(300px,32vw,420px);">
        <div class="flex bg-slate-100 rounded-lg">
          <div class="flex flex-col bg-red-400">
            <div class="flex text-center justify-center mx-auto my-auto">
              <h1 class="font-bold text-[10px]">ALL PLAYERS BET</h1>
            </div>
            <div class="flex gap-2 mx-auto text-[10px]">
              <div>
                <h1 class="font-semibold">
                  FIGHT#:
                </h1>
              </div>
              <div>
                <h1 class="font-semibold">
                  STATUS:
                </h1>
              </div>
            </div>
            <table class="bg-white text-black text-center text-[10px]">
              <thead>
                <tr>
                  <th>Meron</th>
                  <th>Odds</th>
                  <th>Wala</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
                <tr class="bg-green-500">
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                </tr>
              </tbody>
            </table>
            <div class="bg-black border border-yellow-200 rounded-sm text-center">
              <h1 class="font-lg">8% PLASADA</h1>
            </div>
          </div>
          <div class="bg-blue-400 w-full">
            <div class="bg-black text-yellow-200 border border-yellow-300 font-semibold text-center rounded-sm">
              <h1>BETTING CONSOLE</h1>
            </div>
            <div class="flex bg-white text-xs text-black">
              <input type="text" class="bg-white border border-yellow-300 rounded-sm w-28 h-4"
                placeholder="Enter Amount to Bet">
              <h1 class="text-yellow-300 font-normal">SB: <span class="font-normal text-black">400</span></h1>
            </div>
            <div class="flex gap-1 text-black text-[5.5px] leading-none">
              <div class="my-1">
                <button class="bg-amber-300 rounded-sm px-1 py-px">200</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">500</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">1,000</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">2,000</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">3,000</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">5,000</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">10,000</button>
                <button class="bg-amber-300 rounded-sm px-1 py-px">All in</button>
              </div>
            </div>
            <div>
              <table class="bg-white text-black text-[12px] mx-auto">
                <thead>
                  <tr>
                    <th class="w-20 font-normal bg-red-400">Meron</th>
                    <th class="w-20 font-normal">Odds</th>
                    <th class="w-20 font-normal bg-blue-500">Wala</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                </tbody>


              </table>
            </div>
          </div>
        </div>

      </section>

      <!-- RESULTS / ROADMAP -->
      <section class="w-full max-w-full md:max-w-none mx-auto
             rounded-xl border border-white/10 bg-gray-900/60
             p-2.5 sm:p-4 lg:p-5 backdrop-blur-[14px]
             shadow-lg">
        <h2
          class="sticky top-2 z-10 mx-1 inline-block rounded-xl bg-[rgba(21,31,57,0.82)] px-3 py-1 text-[11px] sm:text-[12px] text-[#d6e2ff] backdrop-blur">
          Results / Roadmap
        </h2>

        <div
          class="grid gap-3 rounded-[14px] border border-white/10 bg-[rgba(21,31,57,0.78)] p-2.5 sm:p-3 backdrop-blur-[16px]">
          <div class="flex flex-col gap-2">
            <h3 class="m-0 text-[13px] sm:text-[14px]">Roadmap • Results</h3>

            @if ($roleId === 1)
              <!-- MOBILE-FRIENDLY CONTROLS -->
              <div class="flex flex-wrap gap-1.5 sm:gap-2">
                <button id="winRed" class="h-8 sm:h-9 rounded-[12px] border border-[#3a1a1f]
                               bg-[linear-gradient(180deg,#9a1616,#4b0a0a)]
                               px-2.5 sm:px-3 text-[10px] sm:text-[12px] text-[#ffecec]">
                  Record: Red Wins
                </button>
                <button id="winBlue" class="h-8 sm:h-9 rounded-[12px] border border-[#1f2b50]
                               bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)]
                               px-2.5 sm:px-3 text-[10px] sm:text-[12px] text-[#e6f0ff]">
                  Record: Blue Wins
                </button>
                <button id="undo" class="h-8 sm:h-9 rounded-[12px] border border-[rgb(190_205_255_/_0.9)]
                               bg-[rgba(20,32,70,0.95)] px-2.5 sm:px-3 text-[10px] sm:text-[12px]">
                  Undo
                </button>
                <button id="startRound" class="h-8 sm:h-9 rounded-[12px] border border-[rgb(190_205_255_/_0.9)]
                               bg-[rgba(20,32,70,0.95)] px-2.5 sm:px-3 text-[10px] sm:text-[12px]">
                  Start Round
                </button>
                <button id="resetRound" class="h-8 sm:h-9 rounded-[12px] border border-[rgb(190_205_255_/_0.9)]
                               bg-[rgba(20,32,70,0.95)] px-2.5 sm:px-3 text-[10px] sm:text-[12px]">
                  Reset Round
                </button>
                <button id="clearLog" class="h-8 sm:h-9 rounded-[12px] border border-[rgb(190_205_255_/_0.9)]
                               bg-[rgba(24,36,76,.82)] px-2.5 sm:px-3 text-[10px] sm:text-[12px]">
                  Clear Log
                </button>
              </div>
            @endif
          </div>

          <div class="grid gap-3 md:grid-cols-2">
            <div>
              <div class="mb-1.5 sm:mb-2 text-[12px] sm:text-[13px]">Bead Road</div>
              <!-- wrapper: scaled down on mobile -->
              <div
                class="w-full overflow-hidden rounded-[12px] border border-white/10 bg-[rgba(18,29,64,0.80)] px-1.5 py-1 backdrop-blur-[14px]">
                <div class="origin-left scale-[1] sm:scale-100">
                  <div id="bead" class="grid auto-flow-col gap-0
                         grid-rows-[repeat(6,10px)] auto-cols-[10px]
                         sm:grid-rows-[repeat(6,14px)] sm:auto-cols-[14px]
                         md:grid-rows-[repeat(6,18px)] md:auto-cols-[18px]"></div>
                </div>
              </div>
            </div>
            <div>
              <div class="mb-1.5 sm:mb-2 text-[12px] sm:text-[13px]">Big Road</div>
              <div
                class="w-full overflow-hidden rounded-[12px] border border-white/10 bg-[rgba(18,29,64,0.80)] px-1.5 py-1 backdrop-blur-[14px]">
                <div class="origin-left scale-[1] sm:scale-100">
                  <div id="big" class="grid auto-flow-col gap-0
                         grid-rows-[repeat(6,10px)] auto-cols-[10px]
                         sm:grid-rows-[repeat(6,14px)] sm:auto-cols-[14px]
                         md:grid-rows-[repeat(6,18px)] md:auto-cols-[18px]"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- FIXED-HEIGHT LOG TABLE CONTAINER -->
          <div class="flex flex-col h-[260px] sm:h-[280px] md:h-[300px] lg:h-[320px]">
            <!-- scrollable table area -->
            <div class="flex-1 overflow-auto">
              <table class="w-full border-separate border-spacing-0 text-[12px] sm:text-[13px]">
                <thead>
                  <tr class="[&>th]:px-2 [&>th]:py-1.5 [&>th]:text-left text-[#d2e0ff]">
                    <th>Time</th>
                    <th>Winner</th>
                    <th>Pot</th>
                    <th>Odds</th>
                    <th>Payout/₱100</th>
                  </tr>
                </thead>
                <tbody id="logBody"
                  class="[&>tr]:rounded-[10px] [&>tr]:border [&>tr]:border-[rgb(210_222_255_/_0.80)] [&>tr]:bg-[rgba(18,29,64,0.82)] [&>tr>td]:px-3 [&>tr>td]:py-1.5 [&>tr>td]:whitespace-nowrap">
                </tbody>
              </table>
            </div>

            <!-- pagination, always visible, hindi na natutulak pababa -->
            <div
              class="mt-2 shrink-0 flex items-center justify-end gap-1.5 sm:gap-2 py-1 text-[11.5px] sm:text-[12.5px] text-[#d2e0ff]">
              <button id="firstPage"
                class="h-[30px] sm:h-[34px] rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                « First
              </button>
              <button id="prevPage"
                class="h-[30px] sm:h-[34px] rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                ‹ Prev
              </button>
              <span class="font-extrabold">
                <span id="pageNow">1</span> / <span id="pageTotal">1</span>
              </span>
              <button id="nextPage"
                class="h-[30px] sm:h-[34px] rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                Next ›
              </button>
              <button id="lastPage"
                class="h-[30px] sm:h-[34px] rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                Last »
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- BET HISTORY -->
      <section id="historySection" class="w-full max-w-full md:max-w-none mx-auto
             rounded-xl border border-white/10 bg-gray-900/60
             p-2.5 sm:p-4 lg:p-5 backdrop-blur-[14px]
             shadow-lg">
        <div class="flex flex-wrap items-center justify-between gap-2 sm:gap-3">
          <h2 class="m-0 text-[13px] sm:text-[14px] font-bold text-[#d6e2ff]">Bet History</h2>
          <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <label class="text-[11px] sm:text-[12px] text-[#d6e2ff]/90">
              Side
              <select id="hf-side"
                class="ml-1 rounded-[10px] border border-[rgb(200_214_255_/_0.85)] bg-[rgba(18,29,64,0.80)] px-2 py-1 text-[11px] sm:text-[12px]">
                <option value="all">All</option>
                <option value="red">Red</option>
                <option value="blue">Blue</option>
              </select>
            </label>
            <label class="text-[11px] sm:text-[12px] text-[#d6e2ff]/90">
              Min ₱
              <input id="hf-min" type="number" min="0" value="0"
                class="ml-1 w-[80px] sm:w-[90px] rounded-[10px] border border-[rgb(200_214_255_/_0.85)] bg-[rgba(18,29,64,0.80)] px-2 py-1 text-[11px] sm:text-[12px]" />
            </label>
            <button id="hf-apply"
              class="h-8 rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-3 text-[11px] sm:text-[12px]">
              Apply
            </button>
            <button id="hf-reset"
              class="h-8 rounded-[12px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-3 text-[11px] sm:text-[12px]">
              Reset
            </button>
            <button id="hf-clear"
              class="h-8 rounded-[12px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] px-3 text-[11px] sm:text-[12px] text-[#ffecec]">
              Clear
            </button>
          </div>
        </div>

        <div
          class="mt-2.5 sm:mt-3 rounded-[14px] border border-white/10 bg-[rgba(21,31,57,0.78)] p-2 backdrop-blur-[14px]">
          <div class="overflow-auto rounded-[10px] border border-[rgb(210_222_255_/_0.85)] bg-[rgba(18,29,64,0.85)]">
            <table class="w-full border-separate border-spacing-0 text-[12px] sm:text-[13px]">
              <thead class="sticky top-0 bg-[rgba(18,29,64,0.92)] backdrop-blur-[10px]">
                <tr class="[&>th]:px-3 [&>th]:py-2 [&>th]:text-left text-[#d2e0ff]">
                  <th>Time</th>
                  <th>Side</th>
                  <th>Amount</th>
                  <th>Odds (x)</th>
                  <th>Est. Win</th>
                </tr>
              </thead>
              <tbody id="hf-body" class="[&>tr>td]:px-3 [&>tr>td]:py-2"></tbody>
            </table>
          </div>

          <div
            class="mt-2 flex flex-col gap-1.5 sm:flex-row sm:items-center sm:justify-between text-[11.5px] sm:text-[12.5px] text-[#d6e2ff]">
            <div>
              Total: <span id="hf-count">0</span> bets • Sum ₱<span id="hf-sum">0</span>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-2">
              <button id="hf-first"
                class="h-[30px] sm:h-[34px] rounded-[10px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                « First
              </button>
              <button id="hf-prev"
                class="h-[30px] sm:h-[34px] rounded-[10px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                ‹ Prev
              </button>
              <span class="font-extrabold">
                <span id="hf-page-now">1</span> / <span id="hf-page-total">1</span>
              </span>
              <button id="hf-next"
                class="h-[30px] sm:h-[34px] rounded-[10px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                Next ›
              </button>
              <button id="hf-last"
                class="h-[30px] sm:h-[34px] rounded-[10px] border border-[rgb(190_205_255_/_0.9)] bg-[rgba(20,32,70,0.95)] px-2">
                Last »
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- TOASTS -->
    <div id="toast" class="fixed bottom-4 right-4 z-[1500] grid gap-2"></div>

    <!-- RECEIPT MODAL -->
    <div id="receiptModal" class="fixed inset-0 z-[2200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog"
      aria-hidden="true">
      <div
        class="w-[min(520px,calc(100%-24px))] rounded-[16px] border border-[rgb(217_226_255_/_0.25)] bg-white text-slate-900 p-4">
        <div class="flex items-center justify-between">
          <h2 class="m-0 text-lg font-bold">Bet Receipt</h2>
          <button id="rc-close" class="rounded-md border px-3 py-1 text-sm">Close</button>
        </div>
        <div class="mt-3 grid gap-2">
          <div class="grid gap-1">
            <div class="text-xs text-slate-600">Ref</div>
            <div id="rc-ref" class="font-mono text-sm">—</div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <div class="text-xs text-slate-600">Date</div>
              <div id="rc-date" class="font-mono text-sm">—</div>
            </div>
            <div>
              <div class="text-xs text-slate-600">Side</div>
              <div id="rc-side" class="font-bold">—</div>
            </div>
          </div>
          <div class="grid grid-cols-3 gap-3">
            <div>
              <div class="text-xs text-slate-600">Amount</div>
              <div>₱ <span id="rc-amt" class="font-bold">0</span></div>
            </div>
            <div>
              <div class="text-xs text-slate-600">Odds (x)</div>
              <div><span id="rc-odds" class="font-bold">0.00</span></div>
            </div>
            <div>
              <div class="text-xs text-slate-600">Est. Win</div>
              <div>₱ <span id="rc-win" class="font-bold">0</span></div>
            </div>
          </div>
          <div class="mt-2 grid place-items-center">
            <div id="rc-qr" class="size-[160px]"></div>
          </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
          <button onclick="window.print()" class="rounded-md border px-3 py-1 text-sm">Print</button>
        </div>
      </div>
    </div>

    <script>
      const ROLE_ID = {{ $roleId }};

      /* YouTube embed (keep existing link) */
      (function () {
        const url = 'https://youtu.be/mzBv3fUDxRA?si=0X903bZ6UrB-v6UF';
        const embed = url
          .replace('https://youtu.be/', 'https://www.youtube.com/embed/')
          .replace('watch?v=', 'embed/');
        const iframe = document.getElementById('yt');
        iframe.src = embed + (embed.includes('?') ? '&' : '?') + 'rel=0&modestbranding=1&playsinline=1';
        iframe.addEventListener('load', syncSideHeight);
      })();

      /* toggle video */
      (function () {
        const chk = document.getElementById('toggleVideo');
        const frameWrap = document.querySelector('[data-video]');
        const overlay = document.getElementById('videoOverlay');
        if (!chk || !frameWrap) return;
        const apply = () => {
          const on = chk.checked;
          frameWrap.querySelector('iframe').style.display = on ? 'block' : 'none';
          overlay.classList.toggle('hidden', on);
        };
        chk.addEventListener('change', apply);
        apply();
      })();

      /* CORE STATE – default odds 1.76 / 1.47 */
      const state = { red: 0, blue: 0, oddsRed: 1.76, oddsBlue: 1.47, market: '—' };
      const el = id => document.getElementById(id);
      const fmt = n => Number(n).toLocaleString('en-PH', { maximumFractionDigits: 0 });

      const PAGE_SIZE = 5;
      let curPage = 1;
      let logs = [];
      let history = [];

      /* odds helpers */
      function smoothOdds(tR, tB, rate = 0.25) {
        state.oddsRed = +(state.oddsRed + (tR - state.oddsRed) * rate).toFixed(2);
        state.oddsBlue = +(state.oddsBlue + (tB - state.oddsBlue) * rate).toFixed(2);
      }
      function recalcOdds() {
        const pot = state.red + state.blue;
        if (!pot) return;
        const rshare = state.red / pot, bshare = state.blue / pot;
        const base = 1.2, floor = 1.10, cap = 3.50;
        const tR = Math.min(cap, Math.max(floor, 1 + bshare * base));
        const tB = Math.min(cap, Math.max(floor, 1 + rshare * base));
        smoothOdds(tR, tB);
      }

      /* CURRENT BET PANELS (desktop only) */
      function updateCurrentBetPanels() {
        const input = el('amount');
        if (!input) return;

        const amt = Math.max(0, Number(input.value || 0));

        const redName = (document.getElementById('nameRed')?.textContent || 'Red').trim();
        const blueName = (document.getElementById('nameBlue')?.textContent || 'Blue').trim();

        const cbR = document.getElementById('curBetRed');
        const ppR = document.getElementById('potPayRed');
        const cbB = document.getElementById('curBetBlue');
        const ppB = document.getElementById('potPayBlue');

        if (!cbR || !ppR || !cbB || !ppB) return;

        if (!amt) {
          cbR.textContent = '—';
          ppR.textContent = '—';
          cbB.textContent = '—';
          ppB.textContent = '—';
          return;
        }

        const oddsR = state.oddsRed;
        const oddsB = state.oddsBlue;

        const payR = Math.round(amt * oddsR);
        const payB = Math.round(amt * oddsB);

        cbR.textContent = `₱${fmt(amt)} on ${redName} @ ${oddsR.toFixed(2)}x`;
        ppR.textContent = `₱${fmt(payR)}`;

        cbB.textContent = `₱${fmt(amt)} on ${blueName} @ ${oddsB.toFixed(2)}x`;
        ppB.textContent = `₱${fmt(payB)}`;
      }

      /* LAST BET panel */
      function updateLastBet(side, amount, odds) {
        const box = document.getElementById('lastBet');
        if (!box) return;
        const sEl = box.querySelector('[data-lb-side]');
        const aEl = box.querySelector('[data-lb-amt]');
        const wEl = box.querySelector('[data-lb-win]');
        if (!side || !amount) {
          sEl.textContent = '—';
          aEl.textContent = '—';
          wEl.textContent = '—';
          return;
        }
        const est = Math.round(amount * odds);
        sEl.textContent = side.toUpperCase();
        aEl.textContent = '₱' + fmt(amount);
        wEl.textContent = '₱' + fmt(est);
      }

      /* sync UI */
      let lastMilestone = 0;
      function checkMilestones(pot) {
        const step = 1000;
        const m = Math.floor(pot / step);
        if (m > lastMilestone) {
          lastMilestone = m;
          toast(`Pot milestone • Total pot hit ₱${fmt(m * step)}`);
        }
      }

      function sync() {
        const pot = state.red + state.blue;
        const r = pot ? state.red / pot * 100 : 0;
        const b = 100 - r;

        if (el('tR')) el('tR').textContent = fmt(state.red);
        if (el('tB')) el('tB').textContent = fmt(state.blue);
        if (el('pot')) el('pot').textContent = fmt(pot);

        el('amtRed').textContent = fmt(state.red);
        el('amtBlue').textContent = fmt(state.blue);
        el('oddsRed').textContent = state.oddsRed.toFixed(2);
        el('oddsBlue').textContent = state.oddsBlue.toFixed(2);

        if (el('payoutR')) el('payoutR').textContent = '× ' + state.oddsRed.toFixed(2);
        if (el('payoutB')) el('payoutB').textContent = '× ' + state.oddsBlue.toFixed(2);

        if (el('shareRed')) el('shareRed').textContent = (r || 0).toFixed(1) + '%';
        if (el('shareBlue')) el('shareBlue').textContent = (b || 0).toFixed(1) + '%';
        if (el('txRed')) el('txRed').textContent = state.oddsRed.toFixed(2);
        if (el('txBlue')) el('txBlue').textContent = state.oddsBlue.toFixed(2);
        if (el('totalRed')) el('totalRed').textContent = fmt(state.red);
        if (el('totalBlue')) el('totalBlue').textContent = fmt(state.blue);

        checkMilestones(pot);
        syncSideHeight();
        saveAll();
        renderHistorySidebar();
        renderHistoryTable();

        updateCurrentBetPanels();
      }

      function saveAll() {
        try {
          localStorage.setItem('dr_state', JSON.stringify(state));
          localStorage.setItem('dr_seq', JSON.stringify(seq));
          localStorage.setItem('dr_logs', JSON.stringify(logs));
          localStorage.setItem('dr_history', JSON.stringify(history));
        } catch { }
      }

      (function restore() {
        try {
          const s = JSON.parse(localStorage.getItem('dr_state') || 'null');
          const q = JSON.parse(localStorage.getItem('dr_seq') || 'null');
          const lg = JSON.parse(localStorage.getItem('dr_logs') || 'null');
          const hi = JSON.parse(localStorage.getItem('dr_history') || 'null');
          if (s) Object.assign(state, s);
          if (Array.isArray(q)) seq.push(...q);
          if (Array.isArray(lg)) logs = lg;
          if (Array.isArray(hi)) history = hi;
        } catch { }
      })();

      /* chips add to amount */
      document.querySelectorAll('#chips button').forEach(b => {
        b.addEventListener('click', () => {
          const amt = Number(b.textContent.replace(/[^\d]/g, '')) || 0;
          const input = el('amount');
          input.value = Number(input.value || 0) + amt;
          updateCurrentBetPanels();
        });
      });

      /* receipt modal */
      function showReceipt({ side, amount, odds }) {
        const ref = 'BK' + Date.now().toString(36).toUpperCase().slice(-6) + '-' +
          Math.random().toString(36).slice(2, 6).toUpperCase();
        const win = Math.round(amount * odds);

        el('rc-ref').textContent = ref;
        el('rc-date').textContent = new Date().toLocaleString('en-PH', { hour12: false });
        el('rc-side').textContent = side.toUpperCase();
        el('rc-amt').textContent = Number(amount).toLocaleString('en-PH');
        el('rc-odds').textContent = Number(odds).toFixed(2);
        el('rc-win').textContent = Number(win).toLocaleString('en-PH');

        const qrBox = el('rc-qr');
        qrBox.innerHTML = '';
        const payload = JSON.stringify({
          ref,
          side: side.toUpperCase(),
          amount,
          odds: +Number(odds).toFixed(2),
          win
        });

        try {
          if (window.QRCode)
            new QRCode(qrBox, { text: payload, width: 160, height: 160, correctLevel: QRCode.CorrectLevel.M });
          else
            qrBox.innerHTML = '<div class="text-[12px] text-gray-700">QR unavailable. Ref: ' + ref + '</div>';
        } catch {
          qrBox.innerHTML = '<div class="text-[12px] text-gray-700">QR error. Ref: ' + ref + '</div>';
        }

        const modal = document.getElementById('receiptModal');
        modal.style.display = 'grid';
        modal.setAttribute('aria-hidden', 'false');
        document.getElementById('rc-close').onclick = () => {
          modal.style.display = 'none';
          modal.setAttribute('aria-hidden', 'true');
        };
      }

      /* bet history (per bet) */
      function addToHistory({ side, amount, odds }) {
        const ts = Date.now();
        const timeStr = new Date(ts).toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit' });
        const est = Math.round(amount * odds);
        history.unshift({
          ts,
          timeStr,
          side: side === 'red' ? 'Red' : 'Blue',
          amount,
          odds: +Number(odds).toFixed(2),
          est
        });
        if (history.length > 1000) history.length = 1000;
        saveAll();
        renderHistorySidebar();
        renderHistoryTable();
      }

      function renderHistorySidebar() {
        const tbody = el('betHistory');
        if (!tbody) return;
        tbody.innerHTML = '';
        if (history.length === 0) {
          tbody.innerHTML = `<tr><td colspan="5" class="text-center opacity-70 py-3">No bets yet</td></tr>`;
          return;
        }
        history.slice(0, 20).forEach(h => {
          const pill = h.side === 'Red'
            ? 'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]'
            : 'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]';
          const tr = document.createElement('tr');
          tr.innerHTML = `
        <td>${h.timeStr}</td>
        <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${pill}">${h.side}</span></td>
        <td>₱${fmt(h.amount)}</td>
        <td>× ${h.odds.toFixed(2)}</td>
        <td>₱${fmt(h.est)}</td>`;
          tbody.appendChild(tr);
        });
      }

      const HF_PAGE = { size: 12, now: 1 };

      function getHFFilters() {
        return {
          side: (el('hf-side')?.value || 'all'),
          min: Math.max(0, Number(el('hf-min')?.value || 0))
        };
      }

      function filterHistory() {
        const f = getHFFilters();
        return history.filter(h => {
          const sideOk = f.side === 'all' || h.side.toLowerCase() === f.side;
          const amtOk = h.amount >= f.min;
          return sideOk && amtOk;
        });
      }

      function renderHistoryTable() {
        const list = filterHistory();
        const tbody = el('hf-body');
        if (!tbody) return;
        const total = list.length;
        const pages = Math.max(1, Math.ceil(total / HF_PAGE.size));
        if (HF_PAGE.now > pages) HF_PAGE.now = pages;
        const start = (HF_PAGE.now - 1) * HF_PAGE.size;
        const pageList = list.slice(start, start + HF_PAGE.size);
        tbody.innerHTML = '';
        if (!pageList.length) {
          tbody.innerHTML = `<tr><td colspan="5" class="text-center opacity-70 py-4">No bets match filters</td></tr>`;
        } else {
          pageList.forEach(h => {
            const pill = h.side === 'Red'
              ? 'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]'
              : 'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]';
            const tr = document.createElement('tr');
            tr.innerHTML = `
          <td>${h.timeStr}</td>
          <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${pill}">${h.side}</span></td>
          <td>₱${fmt(h.amount)}</td>
          <td>× ${h.odds.toFixed(2)}</td>
          <td>₱${fmt(h.est)}</td>`;
            tbody.appendChild(tr);
          });
        }
        el('hf-page-now').textContent = String(HF_PAGE.now);
        el('hf-page-total').textContent = String(pages);
        el('hf-count').textContent = String(total);
        const sum = list.reduce((a, b) => a + b.amount, 0);
        el('hf-sum').textContent = fmt(sum);
      }

      el('hf-apply')?.addEventListener('click', () => { HF_PAGE.now = 1; renderHistoryTable(); });
      el('hf-reset')?.addEventListener('click', () => {
        if (el('hf-side')) el('hf-side').value = 'all';
        if (el('hf-min')) el('hf-min').value = 0;
        HF_PAGE.now = 1;
        renderHistoryTable();
      });
      el('hf-first')?.addEventListener('click', () => { HF_PAGE.now = 1; renderHistoryTable(); });
      el('hf-prev')?.addEventListener('click', () => {
        HF_PAGE.now = Math.max(1, HF_PAGE.now - 1);
        renderHistoryTable();
      });
      el('hf-next')?.addEventListener('click', () => {
        const pages = Math.max(1, Math.ceil(filterHistory().length / HF_PAGE.size));
        HF_PAGE.now = Math.min(pages, HF_PAGE.now + 1);
        renderHistoryTable();
      });
      el('hf-last')?.addEventListener('click', () => {
        HF_PAGE.now = Math.max(1, Math.ceil(filterHistory().length / HF_PAGE.size));
        renderHistoryTable();
      });
      el('hf-clear')?.addEventListener('click', () => {
        history = [];
        saveAll();
        renderHistorySidebar();
        renderHistoryTable();
        toast('Bet history cleared');
      });

      /* ====== LOGROHAN / ROADS (BILLIARD LOGIC, ADAPTED) ====== */
      const seq = [];
      const ROWS = 6, COLS = 36;

      function cell(div, kind, hollow = false) {
        div.className = 'w-full h-full flex items-center justify-center rounded-full text-[9px] sm:text-[10px] md:text-[11px] font-black';
        div.style.border = '2px solid #2f477a';
        if (kind === 'red') {
          if (hollow) { div.style.background = 'transparent'; div.style.borderColor = '#ff7a70'; }
          else { div.style.background = 'radial-gradient(circle at 30% 30%, #ff7a70, #b71c1c)'; }
        } else if (kind === 'blue') {
          if (hollow) { div.style.background = 'transparent'; div.style.borderColor = '#8fb6ff'; }
          else { div.style.background = 'radial-gradient(circle at 30% 30%, #8fb6ff, #0b3ca8)'; }
        } else {
          div.style.background = 'transparent';
        }
      }

      // BILLIARD-STYLE STREAK LOGIC (Strict L Big Road)
      function streakRuns(seqArr) {
        const out = [];
        for (const t of seqArr) {
          if (!out.length || out[out.length - 1].t !== t) {
            out.push({ t, n: 1 });
          } else {
            out[out.length - 1].n++;
          }
        }
        return out;
      }

      function buildBigRoadStrictL(seqArr, maxRows = ROWS) {
        const runs = streakRuns(seqArr);
        const grid = [];
        let labelNo = 1;
        let prevRunStartCol = -1;

        const isEmpty = (c, r) => !(grid[c] && grid[c][r]);
        const ensureCol = c => { if (!grid[c]) grid[c] = []; };

        for (const run of runs) {
          const t = run.t;
          let col, row;

          if (prevRunStartCol < 0) {
            col = 0; row = 0;
          } else {
            col = prevRunStartCol + 1;
            row = 0;
            ensureCol(col);
            while (!isEmpty(col, row)) {
              col++;
              ensureCol(col);
            }
          }

          const thisRunStartCol = col;
          let placed = 0;

          while (placed < run.n && row < maxRows && isEmpty(col, row)) {
            ensureCol(col);
            grid[col][row] = { t, label: labelNo++ };
            placed++; row++;
          }

          const lockRow = Math.max(0, row - 1);
          let remain = run.n - placed;
          let c = col + 1;

          while (remain > 0) {
            ensureCol(c);
            if (isEmpty(c, lockRow)) {
              grid[c][lockRow] = { t, label: labelNo++ };
              remain--;
            }
            c++;
          }

          prevRunStartCol = thisRunStartCol;
        }
        return grid;
      }

      function computeColumnsSequential(seqArr, maxRows = ROWS) {
        const cols = [];
        let col = [];
        let labelNo = 1;
        for (const t of seqArr) {
          col.push({ t, label: labelNo++ });
          if (col.length === maxRows) {
            cols.push(col);
            col = [];
          }
        }
        if (col.length) cols.push(col);
        return cols;
      }

      // BEAD ROAD: sequential columns, labelled bubbles — WALANG BLANK CIRCLES
      function renderBead() {
        const bead = el('bead');
        if (!bead) return;
        bead.innerHTML = '';

        const cols = computeColumnsSequential(seq, ROWS);

        cols.forEach(col => {
          for (let r = 0; r < ROWS; r++) {
            const d = document.createElement('div');
            d.style.gridRow = String(r + 1);

            const cellData = col[r];
            if (cellData) {
              cell(d, cellData.t === 'R' ? 'red' : 'blue', false);
              d.textContent = String(cellData.label);
            }
            bead.appendChild(d);
          }
        });

        const rail = bead.parentElement;
        if (rail) rail.scrollLeft = rail.scrollWidth;
      }

      // BIG ROAD: Strict L algo — WALANG BLANK CIRCLES
      function renderBig() {
        const big = el('big');
        if (!big) return;
        big.innerHTML = '';

        const grid = buildBigRoadStrictL(seq, ROWS);

        grid.forEach(col => {
          for (let r = 0; r < ROWS; r++) {
            const d = document.createElement('div');
            d.style.gridRow = String(r + 1);

            const cellData = col[r];
            if (cellData) {
              cell(d, cellData.t === 'R' ? 'red' : 'blue', false);
            }
            big.appendChild(d);
          }
        });

        const rail = big.parentElement;
        if (rail) rail.scrollLeft = rail.scrollWidth;
      }

      /* logs under bead/big */
      function addLog(winner) {
        const pot = state.red + state.blue;
        const odds = (winner === 'Red' ? state.oddsRed : state.oddsBlue).toFixed(2);
        const payout = (100 * odds).toFixed(0);
        const time = new Date().toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit' });
        logs.unshift({ time, winner, pot, odds, payout });
        renderLog();
        saveAll();
      }

      function renderLog() {
        const tbody = el('logBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        const totalPages = Math.max(1, Math.ceil(logs.length / PAGE_SIZE));
        if (curPage > totalPages) curPage = totalPages;
        const start = (curPage - 1) * PAGE_SIZE;
        logs.slice(start, start + PAGE_SIZE).forEach(row => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
        <td>${row.time}</td>
        <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${row.winner === 'Red' ? 'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]' : 'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]'}">${row.winner}</span></td>
        <td>₱${fmt(row.pot)}</td>
        <td>× ${row.odds}</td>
        <td>₱${fmt(row.payout)}</td>`;
          tbody.appendChild(tr);
        });
        el('pageNow').textContent = String(curPage);
        el('pageTotal').textContent = String(totalPages);
      }

      document.getElementById('firstPage')?.addEventListener('click', () => { curPage = 1; renderLog(); });
      document.getElementById('prevPage')?.addEventListener('click', () => {
        if (curPage > 1) { curPage--; renderLog(); }
      });
      document.getElementById('nextPage')?.addEventListener('click', () => {
        const t = Math.max(1, Math.ceil(logs.length / PAGE_SIZE));
        if (curPage < t) { curPage++; renderLog(); }
      });
      document.getElementById('lastPage')?.addEventListener('click', () => {
        curPage = Math.max(1, Math.ceil(logs.length / PAGE_SIZE));
        renderLog();
      });

      function mark(v) {
        seq.push(v);
        renderBead();
        renderBig();
        addLog(v === 'R' ? 'Red' : 'Blue');
        toast(`Round result • ${v === 'R' ? 'Red' : 'Blue'} wins`);
      }
      function undo() {
        if (!seq.length) return;
        seq.pop();
        logs.shift();
        renderBead();
        renderBig();
        renderLog();
        saveAll();
      }

      document.getElementById('winRed')?.addEventListener('click', () => mark('R'));
      document.getElementById('winBlue')?.addEventListener('click', () => mark('B'));
      document.getElementById('undo')?.addEventListener('click', undo);

      /* round timer */
      let tHandle = null, tLeft = 0;
      const setTimerText = txt => { const t = el('timer'); if (t) t.textContent = txt; };
      const formatSecs = s => `${String(Math.floor(s / 60)).padStart(2, '0')}:${String(s % 60).padStart(2, '0')}`;

      function startRound(seconds = 60) {
        clearInterval(tHandle);
        tLeft = seconds;
        setTimerText(formatSecs(tLeft));
        toast(`Round started • ${seconds} seconds`);
        tHandle = setInterval(() => {
          tLeft--;
          setTimerText(formatSecs(Math.max(tLeft, 0)));
          if (tLeft <= 0) {
            clearInterval(tHandle);
            tHandle = null;
            setTimerText('00:00');
            toast('Round ended • Place bets closed');
          }
        }, 1000);
      }
      function resetRound() {
        clearInterval(tHandle);
        tHandle = null;
        tLeft = 0;
        setTimerText('—');
        toast('Timer reset • Round timer cleared');
      }
      document.getElementById('startRound')?.addEventListener('click', () => startRound(60));
      document.getElementById('resetRound')?.addEventListener('click', resetRound);

      /* tabs */
      function showTab(name) {
        document.querySelectorAll('[data-tab]').forEach(b => {
          const active = b.dataset.tab === name;
          if (active) {
            b.classList.add(
              'bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)]',
              'shadow-[0_6px_14px_rgba(64,120,255,.35)]'
            );
            b.classList.remove('bg-[rgba(21,35,71,0.75)]');
          } else {
            b.classList.remove(
              'bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)]',
              'shadow-[0_6px_14px_rgba(64,120,255,.35)]'
            );
            b.classList.add('bg-[rgba(21,35,71,0.75)]');
          }
        });
        el('oddsView').hidden = name !== 'odds';
        el('totalView').hidden = name !== 'total';
        syncSideHeight();
      }
      document.querySelectorAll('[data-tab]').forEach(t => t.addEventListener('click', () => showTab(t.dataset.tab)));

      /* toast */
      function toast(msg, ms = 2200) {
        const t = document.createElement('div');
        t.className = 'rounded-[12px] border border-[rgb(225_234_255_/_0.60)] bg-[rgba(13,22,44,0.86)] px-3 py-2 backdrop-blur-[12px] translate-y-[10px] opacity-0 transition-all duration-200';
        t.textContent = msg;
        el('toast').appendChild(t);
        requestAnimationFrame(() => {
          t.style.opacity = '1';
          t.style.transform = 'none';
        });
        setTimeout(() => {
          t.style.opacity = '0';
          t.style.transform = 'translateY(6px)';
          setTimeout(() => t.remove(), 200);
        }, ms);
      }

      /* side height sync */
      function syncSideHeight() {
        const frame = document.querySelector('[data-video]');
        const side = el('kioskSide');
        if (frame && side) {
          const mobile = matchMedia('(max-width:680px)').matches;
          side.style.maxHeight = mobile ? 'unset' : (frame.clientHeight + 'px');
        }
      }
      addEventListener('resize', syncSideHeight);
      addEventListener('load', syncSideHeight);

      /* BET buttons */
      document.querySelectorAll('[data-bet]').forEach(btn => {
        btn.addEventListener('click', () => {
          const side = btn.getAttribute('data-bet');
          const val = Math.max(0, Number(el('amount').value || 0));
          if (!val) return;
          if (val < 10) { toast('Minimum bet is ₱10'); return; }
          state[side] += val;
          el('amount').value = '';
          recalcOdds();
          sync();
          updateCurrentBetPanels();
          toast(`Bet placed • ${side.toUpperCase()} • ₱${fmt(val)}`);

          const odds = side === 'red' ? state.oddsRed : state.oddsBlue;
          updateLastBet(side, val, odds);
          addToHistory({ side, amount: val, odds });

          if (ROLE_ID === 1) showReceipt({ side, amount: val, odds });
        });
      });

      el('amount')?.addEventListener('input', updateCurrentBetPanels);

      el('reset').addEventListener('click', () => {
        el('amount').value = '';
        updateCurrentBetPanels();
      });
      el('maxAmt').addEventListener('click', () => {
        const v = Number(el('amount').value || 0);
        if (v < 1) el('amount').value = 100;
        updateCurrentBetPanels();
      });

      document.getElementById('clearLog')?.addEventListener('click', () => {
        logs = [];
        el('logBody') && (el('logBody').innerHTML = '');
        curPage = 1;
        renderLog();
        toast('Logs cleared • History table emptied');
      });

      function init() {
        renderBead();
        renderBig();
        renderLog();
        renderHistorySidebar();
        renderHistoryTable();
        sync();
      }
      init();
    </script>

    <script>
      (function ensureQR() {
        if (window.QRCode) return;
        const s = document.createElement('script');
        s.src = "https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js";
        s.async = true;
        s.onerror = () => console.warn('QRCode lib failed to load — using fallback.');
        document.head.appendChild(s);
      })();
    </script>

  </body>
</x-layouts.app>