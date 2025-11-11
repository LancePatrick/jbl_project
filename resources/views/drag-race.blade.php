<x-layouts.app :title="__('Drag Race')">
  <body class="min-h-dvh overflow-x-hidden font-[Inter,system-ui,-apple-system,Segoe_UI,Roboto,Helvetica,Arial] text-[13px] text-[color:var(--tw-text,inherit)]"
      style="--tw-text:#e8f0ff">

  @php
    $roleId = auth()->user()->role_id ?? 2;
  @endphp

  <div
    class="fixed inset-0 -z-30 bg-cover bg-center"
    style="background-image:url('https://i.ibb.co/mCnFZSCv/Chat-GPT-Image-Oct-7-2025-03-54-39-PM.png'); filter:blur(2px) brightness(.45) saturate(1.0); transform:scale(1.03)"
  ></div>
  <div
    class="fixed inset-0 -z-20"
    style="background:
      linear-gradient(rgba(6,8,12,.40), rgba(6,8,12,.40)),
      radial-gradient(1200px 1200px at 80% -10%, #141a2b77, transparent 70%),
      radial-gradient(800px 800px at -10% 110%, #0b0f1c66, transparent 60%),
      radial-gradient(900px 320px at 10% -20%, rgba(255,255,255,.06), transparent 70%),
      radial-gradient(900px 320px at 90% -30%, rgba(255,255,255,.05), transparent 70%)"
  ></div>

  <div class="w-full max-w-screen-2xl 2xl:max-w-[1500px] mx-auto grid gap-4 px-[var(--gutter,12px)] py-[18px] translate-x-1.5 md:translate-x-0 lg:translate-x-[24px] xl:translate-x-[40px]">

    <header class="sticky top-0 z-[1000] hidden flex-wrap items-center gap-3 bg-[linear-gradient(180deg,rgba(7,10,16,.58),rgba(7,10,16,.18))] backdrop-blur-[6px] border-b border-[rgb(208_219_255_/_.35)] px-[var(--gutter,12px)] py-2"></header>

    <section
      class="rounded-[18px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-3 sm:p-4 lg:p-5 backdrop-blur-[10px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)]"
      style="--side:clamp(300px,32vw,420px);"
    >
      <div class="flex items-center justify-between gap-3 border-b border-[rgb(208_219_255_/_0.35)] pb-2">
        <div class="flex gap-1 overflow-auto px-1 sm:px-2">
          <button class="rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)] px-3 py-2 font-black text-white shadow-[0_6px_14px_rgba(64,120,255,.25)] whitespace-nowrap"
                  data-tab="odds">ODDS</button>
          <button class="rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1934] px-3 py-2 font-black text-white whitespace-nowrap" data-tab="total">TOTAL</button>
          <a href="#historySection"
             class="rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1934] px-3 py-2 font-black text-white whitespace-nowrap">HISTORY</a>
        </div>

        @if ($roleId === 1)
        <label class="flex items-center gap-2 text-[12.5px] text-[#bcd1ff]">
          <input id="toggleVideo" type="checkbox" class="size-[16px]" checked>
          <span>Show Video</span>
        </label>
        @endif
      </div>

      <div class="grid grid-cols-1 gap-3 md:grid-cols-[minmax(0,1fr)_var(--side)]">
        <div data-video class="relative aspect-[16/9] overflow-hidden rounded-[16px] border border-[rgb(200_214_255_/_0.45)] bg-black shadow-[0_18px_40px_rgba(0,0,0,.45),0_6px_14px_rgba(0,0,0,.25),inset_0_0_0_1px_rgba(255,255,255,.05)]">
          <div class="pointer-events-none absolute inset-0 rounded-[16px] shadow-[inset_0_0_0_4px_#2a3d6a,inset_0_0_0_6px_rgba(255,255,255,.06)]"></div>
          <iframe id="yt" class="absolute inset-0 size-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          <div id="videoOverlay" class="absolute inset-0 hidden grid place-items-center bg-black/60 text-white text-sm">Video hidden by admin</div>
        </div>

        <div id="kioskSide"
             class="flex max-h-[unset] md:max-h-[60svh] lg:max-h-[calc(100svh-140px)] xl:max-h-[calc(100svh-160px)]
                    lg:sticky lg:top-16 xl:top-20
                    flex-col gap-2 overflow-auto rounded-[14px] border border-[rgb(208_219_255_/_0.35)] bg-[#0d1529] p-2">

          <div id="oddsView" class="grid gap-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-3 text-white shadow-[0_10px_30px_rgba(0,0,0,.35),inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46)]">
                <div class="flex items-center justify-between gap-2 min-w-0">
                  <div class="grid size-[34px] place-items-center rounded-full border-2 border-white/35 bg-black/20 font-black shrink-0">R</div>
                  <div id="nameRed" class="text-[13px] opacity-90 truncate">Rider Red</div>
                </div>
                <div id="amtRed" class="mt-1 leading-[1.05] text-[clamp(28px,6.8vw,38px)] font-black tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[14px] border border-white/30 bg-black/20 px-3 py-1.5 text-[13px] font-black">PAYOUT = <span id="oddsRed" class="ml-1">1.88</span></div>
                <div class="mt-2 grid gap-2">
                  <button data-bet="red" class="h-[42px] rounded-[12px] border border-white/40 bg-black/20 font-black text-white shadow-[inset_0_1px_0_rgba(0,0,0,.3)]">BET</button>
                  <div class="text-[12px] opacity-85">Winnings per ₱100: ₱<span id="payR100">188</span></div>
                </div>
              </div>

              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-3 text-white shadow-[0_10px_30px_rgba(0,0,0,.35),inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46)]">
                <div class="flex items-center justify-between gap-2 min-w-0">
                  <div class="grid size-[34px] place-items-center rounded-full border-2 border-white/35 bg-black/20 font-black shrink-0">B</div>
                  <div id="nameBlue" class="text-[13px] opacity-90 truncate">Rider Blue</div>
                </div>
                <div id="amtBlue" class="mt-1 leading-[1.05] text-[clamp(28px,6.8vw,38px)] font-black tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[14px] border border-white/30 bg-black/20 px-3 py-1.5 text-[13px] font-black">PAYOUT = <span id="oddsBlue" class="ml-1">2.08</span></div>
                <div class="mt-2 grid gap-2">
                  <button data-bet="blue" class="h-[42px] rounded-[12px] border border-white/40 bg-black/20 font-black text-white shadow-[inset_0_1px_0_rgba(0,0,0,.3)]">BET</button>
                  <div class="text-[12px] opacity-85">Winnings per ₱100: ₱<span id="payB100">208</span></div>
                </div>
              </div>
            </div>

            <div class="grid gap-2 rounded-[14px] border border-[rgb(150_170_220_/_0.45)] bg-[#0e1730] p-2">
              <input id="amount" type="number" min="1" placeholder="Enter amount"
                     class="h-[44px] w-full rounded-[12px] border border-[rgb(150_170_220_/_0.45)] bg-[#0a1122] px-3 font-extrabold text-[#e9f3ff] outline-none"/>
              <div class="grid grid-cols-2 gap-2">
                <button id="reset" class="h-[42px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630]">Reset</button>
                <button id="maxAmt" class="h-[42px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630]">Max</button>
              </div>
            </div>

            <div id="chips" class="grid grid-cols-2 sm:grid-cols-4 gap-2">
              <button class="h-[44px] rounded-[14px] border border-[#0f5c30] bg-[linear-gradient(180deg,#2a9d55,#187d3e)] font-black text-[#eef5ff] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦100</button>
              <button class="h-[44px] rounded-[14px] border border-[#163f8f] bg-[linear-gradient(180deg,#2f7cff,#1a4fb5)] font-black text-[#eef5ff] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦200</button>
              <button class="h-[44px] rounded-[14px] border border-[#0b0c0f] bg-[linear-gradient(180deg,#2c2f35,#15171b)] font-black text-[#eef5ff] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦500</button>
              <button class="h-[44px] rounded-[14px] border border-[#a76407] bg-[linear-gradient(180deg,#ffb23a,#d48112)] font-black text-[#1b1203]">♦1000</button>
            </div>
<div id="totalsWidget"
     class="hidden grid gap-2 rounded-[14px] border border-[rgb(150_170_220_/_0.45)] bg-[#0e1426] p-2"
     aria-hidden="true" inert>
  <div class="flex items-center justify-between border-b border-dashed border-[rgb(47_71_122_/_0.8)] py-1"></div>
  <div class="flex items-center justify-between border-b border-dashed border-[rgb(47_71_122_/_0.8)] py-1"></div>
  <div class="flex items-center justify-between border-b border-dashed border-[rgb(47_71_122_/_0.8)] py-1"></div>

  <div class="h-2 overflow-hidden rounded-full border border-[#263553] bg-[#0c1220]">
    <span id="bar" class="block h-full bg-[linear-gradient(90deg,#ff3b30,#2f7cff)] w-0"></span>
  </div>

  <div class="grid grid-cols-3 gap-2">
    <button id="resetTotals" type="button" tabindex="-1" aria-hidden="true"></button>
    <button id="demoBets"   type="button" tabindex="-1" aria-hidden="true"></button>
  </div>
</div>



          <div id="totalView" hidden class="grid gap-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-3">
                <div class="text-[13px] opacity-90">Total Bets — Red</div>
                <div id="totalRed" class="mt-1 text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[14px] border border-white/30 bg-black/20 px-3 py-1.5 text-[13px] font-black">
                  Pool Share — <span id="shareRed" class="ml-1">0%</span>
                </div>
              </div>
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-3">
                <div class="text-[13px] opacity-90">Total Bets — Blue</div>
                <div id="totalBlue" class="mt-1 text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[14px] border border-white/30 bg-black/20 px-3 py-1.5 text-[13px] font-black">
                  Pool Share — <span id="shareBlue" class="ml-1">0%</span>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-3">
                <div class="text-[13px] opacity-90">Odds (x) — Red</div>
                <div id="txRed" class="mt-1 text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">1.88</div>
              </div>
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-3">
                <div class="text-[13px] opacity-90">Odds (x) — Blue</div>
                <div id="txBlue" class="mt-1 text-[clamp(28px,6.8vw,38px)] font-black leading-[1.05] tracking-[.5px]">2.08</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rounded-[18px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-3 sm:p-4 lg:p-5 backdrop-blur-[10px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),_0_10px_30px_rgba(0,0,0,.25)]">
      <h2 class="sticky top-2 z-10 mx-1 inline-block rounded-xl bg-[#0e1426]/80 px-3 py-1 text-[12px] text-[#bcd1ff] backdrop-blur">Results / Roadmap</h2>

      <div class="grid gap-3 rounded-[14px] border border-[rgb(217_226_255_/_0.25)] bg-[#0e1426] p-3">
        <div class="flex flex-wrap items-center justify-between gap-2">
          <h3 class="m-0">Roadmap • Results</h3>

          @if ($roleId === 1)
            <div class="flex gap-2 overflow-auto pb-1">
              <button id="winRed" class="h-10 rounded-[12px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] px-3 text-[#ffecec]">Record: Red Wins</button>
              <button id="winBlue" class="h-10 rounded-[12px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-3 text-[#e6f0ff]">Record: Blue Wins</button>
              <button id="undo" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Undo</button>
              <button id="startRound" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Start Round</button>
              <button id="resetRound" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Reset Round</button>
              <button id="clearLog" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[rgba(12,22,48,.6)] px-3">Clear Log</button>
              <button id="exportCsv" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[rgba(12,22,48,.6)] px-3">Export CSV</button>
            </div>
          @endif
        </div>

        <div class="grid gap-3 md:grid-cols-2">
          <div>
            <div class="mb-2">Bead Road</div>
            <div id="bead"
                 class="grid max-h-[calc(6*14px+12px)] grid-rows-[repeat(6,14px)] auto-cols-[14px] auto-flow-col gap-0 overflow-auto rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0f1a33] p-1.5 md:max-h-[calc(6*18px+16px)] md:grid-rows-[repeat(6,18px)] md:auto-cols-[18px]">
            </div>
          </div>
          <div>
            <div class="mb-2">Big Road</div>
            <div id="big"
                 class="grid max-h-[calc(6*14px+12px)] grid-rows-[repeat(6,14px)] auto-cols-[14px] auto-flow-col gap-0 overflow-auto rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0f1a33] p-1.5 md:max-h-[calc(6*18px+16px)] md:grid-rows-[repeat(6,18px)] md:auto-cols-[18px]">
            </div>
          </div>
        </div>

        <div class="overflow-auto">
          <table class="w-full border-separate border-spacing-0">
            <thead>
            <tr class="[&>th]:px-2 [&>th]:text-left [&>th]:text-[12px] [&>th]:text-[#bcd1ff]">
              <th>Time</th><th>Winner</th><th>Pot</th><th>Odds</th><th>Payout/₱100</th>
            </tr>
            </thead>
            <tbody id="logBody" class="[&>tr]:rounded-[10px] [&>tr]:border [&>tr]:border-[rgb(200_214_255_/_0.45)] [&>tr]:bg-[#0f1a33] [&>tr>td]:px-3 [&>tr>td]:py-2 [&>tr>td]:whitespace-nowrap"></tbody>
          </table>

          <div class="flex items-center justify-end gap-2 py-2 text-[#bcd1ff]">
            <button id="firstPage" class="h-[34px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">« First</button>
            <button id="prevPage" class="h-[34px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">‹ Prev</button>
            <span class="font-extrabold"><span id="pageNow">1</span> / <span id="pageTotal">1</span></span>
            <button id="nextPage" class="h-[34px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">Next ›</button>
            <button id="lastPage" class="h-[34px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">Last »</button>
          </div>
        </div>
      </div>
    </section>

    <section id="historySection" class="rounded-[18px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.88)] p-3 sm:p-4 lg:p-5 backdrop-blur-[10px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),_0_10px_30px_rgba(0,0,0,.25)]">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <h2 class="m-0 text-[14px] font-bold text-[#bcd1ff]">Bet History</h2>
        <div class="flex flex-wrap items-center gap-2">
          <label class="text-[12px] text-[#bcd1ff]/90">Side
            <select id="hf-side" class="ml-1 rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 py-1">
              <option value="all">All</option>
              <option value="red">Red</option>
              <option value="blue">Blue</option>
            </select>
          </label>
          <label class="text-[12px] text-[#bcd1ff]/90">Min ₱
            <input id="hf-min" type="number" min="0" value="0" class="ml-1 w-[90px] rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 py-1"/>
          </label>
          <button id="hf-apply" class="h-9 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Apply</button>
          <button id="hf-reset" class="h-9 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Reset</button>
          <button id="hf-export" class="h-9 rounded-[12px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-3 text-white">Export CSV</button>
          <button id="hf-clear" class="h-9 rounded-[12px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] px-3 text-[#ffecec]">Clear</button>
        </div>
      </div>

      <div class="mt-3 rounded-[14px] border border-[rgb(217_226_255_/_0.25)] bg-[#0e1426] p-2">
        <div class="overflow-auto rounded-[10px] border border-[rgb(200_214_255_/_0.45)] bg-[#0f1a33]">
          <table class="w-full border-separate border-spacing-0 text-[13px]">
            <thead class="sticky top-0 bg-[#0f1a33]">
              <tr class="[&>th]:px-3 [&>th]:py-2 [&>th]:text-left text-[#bcd1ff]">
                <th>Time</th><th>Side</th><th>Amount</th><th>Odds (x)</th><th>Est. Win</th>
              </tr>
            </thead>
            <tbody id="hf-body" class="[&>tr>td]:px-3 [&>tr>td]:py-2"></tbody>
          </table>
        </div>

        <div class="mt-2 flex items-center justify-between text-[#bcd1ff]">
          <div>Total: <span id="hf-count">0</span> bets • Sum ₱<span id="hf-sum">0</span></div>
          <div class="flex items-center gap-2">
            <button id="hf-first" class="h-[34px] rounded-[10px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">« First</button>
            <button id="hf-prev"  class="h-[34px] rounded-[10px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">‹ Prev</button>
            <span class="font-extrabold"><span id="hf-page-now">1</span> / <span id="hf-page-total">1</span></span>
            <button id="hf-next"  class="h-[34px] rounded-[10px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">Next ›</button>
            <button id="hf-last"  class="h-[34px] rounded-[10px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-2 text-[12.5px]">Last »</button>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div id="mbRail"
       class="fixed inset-x-0 bottom-0 z-[2000] hidden gap-2 border-t border-[rgb(200_214_255_/_0.45)] bg-[rgba(10,18,35,.9)] p-2 backdrop-blur-[8px] md:hidden"
  >
    <input id="mbAmount" type="number" min="1" placeholder="₱ Amount"
           class="h-[42px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0a1122] px-2 text-[#e9f3ff]"/>
    <button id="mbBet"
            class="h-[42px] rounded-[10px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-4 font-black text-white">BET</button>
  </div>

  <div id="toast" class="fixed bottom-4 right-4 z-[1500] grid gap-2"></div>

  <div id="receiptModal" class="fixed inset-0 z-[2200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
    <div class="w-[min(520px,calc(100%-24px))] rounded-[16px] border border-[rgb(217_226_255_/_0.25)] bg-white text-slate-900 p-4">
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

  <div id="modal-edit" class="modal fixed inset-0 z-[1200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
    <div class="w-[min(520px,calc(100%-24px))] rounded-[16px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-4">
      <h2 class="m-0 mb-2">Edit Profile</h2>
      <div class="grid gap-2 rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1730] p-3">
        <label class="grid gap-1">Display Name
          <input id="prof-name" type="text" placeholder="Your name" class="h-[44px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 text-[var(--tw-text)]"/>
        </label>
        <label class="grid gap-1">Avatar URL
          <input id="prof-avatar" type="url" placeholder="https://..." class="h-[44px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 text-[var(--tw-text)]"/>
        </label>
      </div>
      <div class="mt-3 flex justify-end gap-2">
        <button class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3" data-close>Back</button>
        <button id="saveProfile" class="h-10 rounded-[12px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-3 text-white">Save</button>
      </div>
    </div>
  </div>

  <div id="modal-cash" class="modal fixed inset-0 z-[1200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
    <div class="w-[min(520px,calc(100%-24px))] rounded-[16px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-4">
      <h2 class="m-0 mb-2">Cash In</h2>
      <div class="grid gap-2 rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1730] p-3">
        <label class="grid gap-1">Amount
          <input id="cash-amt" type="number" min="1" placeholder="₱0" class="h-[44px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 text-[var(--tw-text)]"/>
        </label>
        <label class="grid gap-1">Method
          <select id="cash-method" class="h-[44px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 text-[var(--tw-text)]">
            <option>GCash</option><option>PayMaya</option><option>Bank Transfer</option>
          </select>
        </label>
      </div>
      <div class="mt-3 flex justify-end gap-2">
        <button class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3" data-close>Back</button>
        <button id="cashSubmit" class="h-10 rounded-[12px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] px-3 text-[#ffecec]">Confirm</button>
      </div>
    </div>
  </div>

  <div id="modal-withdraw" class="modal fixed inset-0 z-[1200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
    <div class="w-[min(520px,calc(100%-24px))] rounded-[16px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)]">
      <h2 class="m-0 p-4 pb-2">Withdraw</h2>
      <div class="mx-4 mb-4 grid gap-2 rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1730] p-3">
        <label class="grid gap-1">Amount
          <input id="wd-amt" type="number" min="1" placeholder="₱0" class="h-[44px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 text-[var(--tw-text)]"/>
        </label>
        <label class="grid gap-1">Destination
          <select id="wd-method" class="h-[44px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0f1a33] px-2 text-[var(--tw-text)]">
            <option>GCash</option><option>PayMaya</option><option>Bank Transfer</option>
          </select>
        </label>
      </div>
      <div class="mx-4 mb-4 flex justify-end gap-2">
        <button class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3" data-close>Back</button>
        <button id="wdSubmit" class="h-10 rounded-[12px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-3 text-white">Request</button>
      </div>
    </div>
  </div>

  <script>
  const ROLE_ID = {{ $roleId }};

  (function(){
    const url='https://youtu.be/mzBv3fUDxRA?si=0X903bZ6UrB-v6UF';
    const embed=url.replace('https://youtu.be/','https://www.youtube.com/embed/').replace('watch?v=','embed/');
    const iframe=document.getElementById('yt');
    iframe.src=embed+(embed.includes('?')?'&':'?')+'rel=0&modestbranding=1&playsinline=1';
    iframe.addEventListener('load', syncSideHeight);
  })();

  (function(){
    const chk = document.getElementById('toggleVideo');
    const frameWrap = document.querySelector('[data-video]');
    const overlay = document.getElementById('videoOverlay');
    if(!chk || !frameWrap) return;
    const apply = () => {
      const on = chk.checked;
      frameWrap.querySelector('iframe').style.display = on ? 'block' : 'none';
      overlay.classList.toggle('hidden', on);
    };
    chk.addEventListener('change', apply);
    apply();
  })();

  const state={ red:0, blue:0, oddsRed:1.88, oddsBlue:2.08, market:'—' };
  const el=id=>document.getElementById(id);
  const fmt=n=>Number(n).toLocaleString('en-PH',{maximumFractionDigits:0});

  const PAGE_SIZE=5; let curPage=1; let logs=[];

  let history = [];

  let SOUND_ON=true, HAPTIC_ON=false;
  function beep(type='click', dur=80, freq=440, vol=0.05){
    if(!SOUND_ON || typeof AudioContext==='undefined') return;
    const ctx = beep.ctx || (beep.ctx = new (window.AudioContext||window.webkitAudioContext)());
    const o = ctx.createOscillator(), g = ctx.createGain();
    o.type=(type==='low'?'square':'sine'); o.frequency.value=freq; g.gain.value=vol;
    o.connect(g); g.connect(ctx.destination); o.start();
    setTimeout(()=>{ g.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime+0.02); o.stop(ctx.currentTime+0.03); }, dur);
  }
  function vibe(ms=10){ if(HAPTIC_ON && navigator.vibrate) navigator.vibrate(ms); }

  let DESK_NOTIF=false;
  const notifs=[]; let unread=0;
  const notifUI={btn:el('notifBtn'),panel:el('notifPanel'),list:el('notifList'),badge:el('notifBadge')};
  function renderNotifs(){
    if(!notifUI.list) return;
    notifUI.list.innerHTML='';
    if(!notifs.length){
      const d=document.createElement('div');
      d.className='rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1730] p-3';
      d.innerHTML='<div class="font-bold">No notifications</div><div class="text-sm opacity-80">You are all caught up.</div>';
      notifUI.list.appendChild(d);
    }else{
      notifs.slice().reverse().forEach(n=>{
        const d=document.createElement('div');
        d.className='rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1730] p-3';
        if(!n.read){ d.style.outline='2px solid rgba(64,185,255,.35)'; }
        d.innerHTML=`<div class="font-bold">${n.title}</div><div class="text-sm">${n.body||''}</div><div class="text-xs opacity-70">${new Date(n.ts).toLocaleTimeString('en-PH',{hour:'2-digit',minute:'2-digit'})}</div>`;
        notifUI.list.appendChild(d);
      });
    }
    if(notifUI.badge){
      notifUI.badge.style.display=unread>0?'grid':'none';
      notifUI.badge.textContent=unread>99?'99+':String(unread);
    }
    try{
      localStorage.setItem('dr_notifs', JSON.stringify(notifs));
      localStorage.setItem('dr_unread', String(unread));
    }catch{}
  }
  function panelShow(node, show){ if(node) node.dataset.show = show ? 'true' : 'false'; }
  function addNotif(title, body='', type='info', deskTry=true){
    const n={id:crypto.randomUUID?.()||Math.random().toString(36).slice(2), title, body, type, ts:Date.now(), read:false};
    notifs.push(n); unread++; renderNotifs(); toast(title + (body?` • ${body}`:''), 2400);
    beep(type==='win'?'click':'low', 90, type==='win'?820:520, 0.06); vibe(10);
    if(deskTry && DESK_NOTIF && 'Notification' in window){
      if(Notification.permission==='granted'){ new Notification(title,{body,silent:true}); }
      else if(Notification.permission!=='denied'){
        Notification.requestPermission().then(p=>{ DESK_NOTIF=(p==='granted'); localStorage.setItem('deskn', DESK_NOTIF?'1':'0'); if(p==='granted') addNotif(title, body, type, false); });
      }
    }
  }
  (function(){
    notifUI.btn?.addEventListener('click', (e)=>{ e.stopPropagation(); const show=notifUI.panel?.dataset.show!=='true'; panelShow(notifUI.panel, show); if(show){ notifs.forEach(n=>n.read=true); unread=0; renderNotifs(); }});
    document.addEventListener('click', (e)=>{ if(notifUI.panel && !notifUI.panel.contains(e.target) && !notifUI.btn?.contains(e.target)) panelShow(notifUI.panel,false); });
    try{
      const s=JSON.parse(localStorage.getItem('dr_notifs')||'[]'); const u=Number(localStorage.getItem('dr_unread')||'0');
      if(Array.isArray(s)) notifs.push(...s); unread=u||0; renderNotifs();
    }catch{}
  })();

  function sync(){
    const pot=state.red+state.blue;
    const r = pot? state.red/pot*100 : 0; const b=100-r;

    if(el('tR')) el('tR').textContent=fmt(state.red);
    if(el('tB')) el('tB').textContent=fmt(state.blue);
    if(el('pot')) el('pot').textContent=fmt(pot);

    el('amtRed').textContent=fmt(state.red); el('amtBlue').textContent=fmt(state.blue);
    el('oddsRed').textContent=state.oddsRed.toFixed(2); el('oddsBlue').textContent=state.oddsBlue.toFixed(2);
    el('payR100').textContent=(100*state.oddsRed).toFixed(0); el('payB100').textContent=(100*state.oddsBlue).toFixed(0);
    const ro=document.getElementById('roadOdds'); if(ro) ro.textContent=`Red × ${state.oddsRed.toFixed(2)} • Blue × ${state.oddsBlue.toFixed(2)}`;

    el('pot2').textContent=fmt(pot); el('tR2').textContent=fmt(state.red); el('tB2').textContent=fmt(state.blue);
    el('bar').style.width=(100-r)+'%'; el('payoutR').textContent='× '+state.oddsRed.toFixed(2); el('payoutB').textContent='× '+state.oddsBlue.toFixed(2);

    el('shareRed').textContent=(r||0).toFixed(1)+'%'; el('shareBlue').textContent=(b||0).toFixed(1)+'%';
    el('txRed').textContent=state.oddsRed.toFixed(2); el('txBlue').textContent=state.oddsBlue.toFixed(2);
    el('totalRed').textContent=fmt(state.red); el('totalBlue').textContent=fmt(state.blue);

    checkMilestones(pot); syncSideHeight(); saveAll();
    renderHistorySidebar(); renderHistoryTable();
  }
  function saveAll(){
    try{
      localStorage.setItem('dr_state', JSON.stringify(state));
      localStorage.setItem('dr_seq', JSON.stringify(seq));
      localStorage.setItem('dr_logs', JSON.stringify(logs));
      localStorage.setItem('dr_history', JSON.stringify(history));
    }catch{}
  }
  (function restore(){
    try{
      const s=JSON.parse(localStorage.getItem('dr_state')||'null');
      const q=JSON.parse(localStorage.getItem('dr_seq')||'null');
      const lg=JSON.parse(localStorage.getItem('dr_logs')||'null');
      const hi=JSON.parse(localStorage.getItem('dr_history')||'null');
      const dn=localStorage.getItem('deskn')==='1';
      if(s) Object.assign(state,s);
      if(Array.isArray(q)) seq.push(...q);
      if(Array.isArray(lg)) logs = lg;
      if(Array.isArray(hi)) history = hi;
      DESK_NOTIF=dn;
    }catch{}
  })();

  document.querySelectorAll('#chips button').forEach(b=>{
    b.addEventListener('click',()=>{ const amt=Number(b.textContent.replace(/[^\d]/g,''))||0; const input=el('amount'); input.value=Number(input.value||0)+amt; });
  });
  function smoothOdds(tR,tB,rate=0.25){
    state.oddsRed=+(state.oddsRed+(tR-state.oddsRed)*rate).toFixed(2);
    state.oddsBlue=+(state.oddsBlue+(tB-state.oddsBlue)*rate).toFixed(2);
  }
  function recalcOdds(){
    const pot=state.red+state.blue; if(!pot) return;
    const rshare=state.red/pot, bshare=state.blue/pot;
    const base=1.2,floor=1.10,cap=3.50;
    const tR=Math.min(cap,Math.max(floor,1+bshare*base));
    const tB=Math.min(cap,Math.max(floor,1+rshare*base));
    smoothOdds(tR,tB);
  }

  function showReceipt({side, amount, odds}){
    const ref = 'BK' + Date.now().toString(36).toUpperCase().slice(-6) + '-' + Math.random().toString(36).slice(2,6).toUpperCase();
    const win = Math.round(amount * odds);

    el('rc-ref').textContent  = ref;
    el('rc-date').textContent = new Date().toLocaleString('en-PH',{hour12:false});
    el('rc-side').textContent = side.toUpperCase();
    el('rc-amt').textContent  = Number(amount).toLocaleString('en-PH');
    el('rc-odds').textContent = Number(odds).toFixed(2);
    el('rc-win').textContent  = Number(win).toLocaleString('en-PH');

    const qrBox = el('rc-qr'); qrBox.innerHTML = '';
    const payload = JSON.stringify({ref, side:side.toUpperCase(), amount, odds:+Number(odds).toFixed(2), win});

    try {
      if (window.QRCode) new QRCode(qrBox, { text: payload, width: 160, height: 160, correctLevel: QRCode.CorrectLevel.M });
      else qrBox.innerHTML = '<div class="text-[12px] text-gray-700">QR unavailable. Ref: '+ref+'</div>';
    } catch { qrBox.innerHTML = '<div class="text-[12px] text-gray-700">QR error. Ref: '+ref+'</div>'; }

    const modal = document.getElementById('receiptModal');
    modal.style.display = 'grid'; modal.setAttribute('aria-hidden', 'false');
    document.getElementById('rc-close').onclick = () => { modal.style.display='none'; modal.setAttribute('aria-hidden','true'); };
  }

  function addToHistory({side, amount, odds}){
    const ts = Date.now();
    const timeStr = new Date(ts).toLocaleTimeString('en-PH',{hour:'2-digit',minute:'2-digit'});
    const est = Math.round(amount * odds);
    history.unshift({ ts, timeStr, side: side==='red'?'Red':'Blue', amount, odds: +Number(odds).toFixed(2), est });
    if(history.length > 1000) history.length = 1000;
    saveAll();
    renderHistorySidebar();
    renderHistoryTable();
  }

  function renderHistorySidebar(){
    const tbody = el('betHistory');
    if(!tbody) return;
    tbody.innerHTML = '';
    if(history.length===0){
      tbody.innerHTML = `<tr><td colspan="5" class="text-center opacity-70 py-3">No bets yet</td></tr>`;
      return;
    }
    history.slice(0,20).forEach(h=>{
      const pill = h.side==='Red'
        ? 'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]'
        : 'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]';
      const tr=document.createElement('tr');
      tr.innerHTML = `
        <td>${h.timeStr}</td>
        <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${pill}">${h.side}</span></td>
        <td>₱${fmt(h.amount)}</td>
        <td>× ${h.odds.toFixed(2)}</td>
        <td>₱${fmt(h.est)}</td>`;
      tbody.appendChild(tr);
    });
  }
  function exportHistoryCSV(list){
    const rows=[['Time','Side','Amount','Odds','Est.Win']];
    list.forEach(h=>rows.push([h.timeStr, h.side, h.amount, h.odds, h.est]));
    const csv=rows.map(r=>r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob=new Blob([csv],{type:'text/csv;charset=utf-8;'}); const a=document.createElement('a');
    a.href=URL.createObjectURL(blob); a.download='bet-history.csv'; a.click(); URL.revokeObjectURL(a.href);
    toast('Bet history exported');
  }
  el('histExport')?.addEventListener('click', ()=>exportHistoryCSV(history));
  el('histClear')?.addEventListener('click', ()=>{ history=[]; saveAll(); renderHistorySidebar(); renderHistoryTable(); toast('Bet history cleared'); });

  const HF_PAGE= { size: 12, now: 1 };
  function getHFFilters(){
    return {
      side: (el('hf-side')?.value||'all'),
      min:  Math.max(0, Number(el('hf-min')?.value||0))
    };
  }
  function filterHistory(){
    const f = getHFFilters();
    return history.filter(h=>{
      const sideOk = f.side==='all' || h.side.toLowerCase()===f.side;
      const amtOk  = h.amount >= f.min;
      return sideOk && amtOk;
    });
  }
  function renderHistoryTable(){
    const list = filterHistory();
    const tbody = el('hf-body'); if(!tbody) return;
    const total = list.length;
    const pages = Math.max(1, Math.ceil(total / HF_PAGE.size));
    if(HF_PAGE.now > pages) HF_PAGE.now = pages;
    const start = (HF_PAGE.now-1) * HF_PAGE.size;
    const pageList = list.slice(start, start+HF_PAGE.size);
    tbody.innerHTML = '';
    if(!pageList.length){
      tbody.innerHTML = `<tr><td colspan="5" class="text-center opacity-70 py-4">No bets match filters</td></tr>`;
    }else{
      pageList.forEach(h=>{
        const pill = h.side==='Red'
          ? 'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]'
          : 'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]';
        const tr=document.createElement('tr');
        tr.innerHTML = `
          <td>${h.timeStr}</td>
          <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${pill}">${h.side}</span></td>
          <td>₱${fmt(h.amount)}</td>
          <td>× ${h.odds.toFixed(2)}</td>
          <td>₱${fmt(h.est)}</td>`;
        tbody.appendChild(tr);
      });
    }
    el('hf-page-now').textContent   = String(HF_PAGE.now);
    el('hf-page-total').textContent = String(pages);
    el('hf-count').textContent = String(total);
    const sum = list.reduce((a,b)=>a+b.amount,0);
    el('hf-sum').textContent = fmt(sum);
  }
  el('hf-apply')?.addEventListener('click', ()=>{ HF_PAGE.now=1; renderHistoryTable(); });
  el('hf-reset')?.addEventListener('click', ()=>{ if(el('hf-side')) el('hf-side').value='all'; if(el('hf-min')) el('hf-min').value=0; HF_PAGE.now=1; renderHistoryTable(); });
  el('hf-first')?.addEventListener('click', ()=>{ HF_PAGE.now=1; renderHistoryTable(); });
  el('hf-prev') ?.addEventListener('click', ()=>{ HF_PAGE.now=Math.max(1,HF_PAGE.now-1); renderHistoryTable(); });
  el('hf-next') ?.addEventListener('click', ()=>{ const pages=Math.max(1, Math.ceil(filterHistory().length/HF_PAGE.size)); HF_PAGE.now=Math.min(pages,HF_PAGE.now+1); renderHistoryTable(); });
  el('hf-last') ?.addEventListener('click', ()=>{ HF_PAGE.now=Math.max(1, Math.ceil(filterHistory().length/HF_PAGE.size)); renderHistoryTable(); });
  el('hf-export')?.addEventListener('click', ()=>exportHistoryCSV(filterHistory()));
  el('hf-clear') ?.addEventListener('click', ()=>{ history=[]; saveAll(); renderHistorySidebar(); renderHistoryTable(); toast('Bet history cleared'); });

  document.querySelectorAll('[data-bet]').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const side=btn.getAttribute('data-bet');
      const val=Math.max(0,Number(el('amount').value||0)); if(!val) return;
      if(val<10){ toast('Minimum bet is ₱10'); return; }
      state[side]+=val; el('amount').value='';
      recalcOdds(); sync();
      addNotif('Bet placed', `${side.toUpperCase()} • ₱${fmt(val)}`, 'bet');

      const odds = side==='red'? state.oddsRed : state.oddsBlue;
      addToHistory({side, amount:val, odds});

      if(ROLE_ID===1){ showReceipt({side, amount:val, odds}); }
    });
  });
  el('reset').addEventListener('click',()=>{ el('amount').value=''; });
  el('maxAmt').addEventListener('click',()=>{ const v=Number(el('amount').value||0); if(v<1) el('amount').value=100; });

  (function(){
    const rail=el('mbRail');
    const isMobile=()=>matchMedia('(max-width:680px)').matches;
    const toggle=()=>{ rail.style.display = isMobile() ? 'flex' : 'none'; };
    toggle(); addEventListener('resize', toggle);
    el('mbBet').addEventListener('click', ()=>{
      const v=Number(el('mbAmount').value||0);
      if(v<10){ toast('Minimum bet is ₱10'); return; }
      const side = state.oddsRed>state.oddsBlue ? 'red' : 'blue';
      state[side]+=v; el('mbAmount').value=''; recalcOdds(); sync();
      addNotif('Quick Bet', `${side.toUpperCase()} • ₱${fmt(v)}`, 'bet');

      const odds = side==='red'? state.oddsRed : state.oddsBlue;
      addToHistory({side, amount:v, odds});

      if(ROLE_ID===1){ showReceipt({side, amount:v, odds}); }
    });
  })();

  el('resetTotals').addEventListener('click', ()=>{ state.red=0; state.blue=0; recalcOdds(); sync(); addNotif('Totals reset','All bet totals cleared','alert'); });
  el('demoBets').addEventListener('click', ()=>{ const inc=Math.floor(Math.random()*5+1)*50; if(Math.random()>0.5) state.red+=inc; else state.blue+=inc; recalcOdds(); sync(); toast('Simulated bet: ₱'+fmt(inc)); });

  let lastMilestone=0; function checkMilestones(pot){ const step=1000; const m=Math.floor(pot/step); if(m>lastMilestone){ lastMilestone=m; addNotif('Pot milestone', `Total pot hit ₱${fmt(m*step)}`, 'alert'); } }

  const seq=[]; const ROWS=6, COLS=36;

  function addLog(winner){
    const pot = state.red + state.blue;
    const odds = (winner === 'Red' ? state.oddsRed : state.oddsBlue).toFixed(2);
    const payout = (100 * odds).toFixed(0);
    const time = new Date().toLocaleTimeString('en-PH',{hour:'2-digit', minute:'2-digit'});
    logs.unshift({ time, winner, pot, odds, payout });
    renderLog(); saveAll();
  }
  function renderLog(){
    const tbody = el('logBody');
    if(!tbody) return;
    tbody.innerHTML = '';
    const totalPages = Math.max(1, Math.ceil(logs.length / PAGE_SIZE));
    if (curPage > totalPages) curPage = totalPages;
    const start = (curPage - 1) * PAGE_SIZE;
    logs.slice(start, start + PAGE_SIZE).forEach(row=>{
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${row.time}</td>
        <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${row.winner==='Red'?'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]':'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]'}">${row.winner}</span></td>
        <td>₱${fmt(row.pot)}</td>
        <td>× ${row.odds}</td>
        <td>₱${fmt(row.payout)}</td>`;
      tbody.appendChild(tr);
    });
    el('pageNow').textContent = String(curPage);
    el('pageTotal').textContent = String(totalPages);
  }
  document.getElementById('firstPage')?.addEventListener('click', ()=>{ curPage = 1; renderLog(); });
  document.getElementById('prevPage') ?.addEventListener('click', ()=>{ if (curPage > 1) { curPage--; renderLog(); } });
  document.getElementById('nextPage') ?.addEventListener('click', ()=>{ const t=Math.max(1, Math.ceil(logs.length/PAGE_SIZE)); if (curPage < t) { curPage++; renderLog(); } });
  document.getElementById('lastPage') ?.addEventListener('click', ()=>{ curPage = Math.max(1, Math.ceil(logs.length/PAGE_SIZE)); renderLog(); });

  function cell(div, kind, hollow=false){
    div.className = 'flex items-center justify-center rounded-full text-[11px] font-black';
    div.style.width='calc(14px - 2px)'; div.style.height='calc(14px - 2px)';
    div.style.border = hollow ? '2px solid #2f477a' : '2px solid #2f477a';
    if(kind==='red'){
      if(hollow){ div.style.background='transparent'; div.style.borderColor='#ff7a70'; }
      else{ div.style.background='radial-gradient(circle at 30% 30%, #ff7a70, #b71c1c)'; }
    } else if(kind==='blue'){
      if(hollow){ div.style.background='transparent'; div.style.borderColor='#8fb6ff'; }
      else{ div.style.background='radial-gradient(circle at 30% 30%, #8fb6ff, #0b3ca8)'; }
    }
  }
  function renderBead(){
    const bead=el('bead'); if(!bead) return; bead.innerHTML='';
    for(let c=0;c<COLS;c++) for(let r=0;r<ROWS;r++){
      const d=document.createElement('div'); d.style.gridRow=(r+1); cell(d); bead.appendChild(d);
    }
    seq.forEach((v,i)=>{
      const col=Math.floor(i/ROWS), row=i%ROWS; const idx=col*ROWS+row;
      const d=bead.children[idx]; if(d){ cell(d, v==='R'?'red':'blue'); d.textContent=String(i+1); }
    });
  }
  function renderBig(){
    const big=el('big'); if(!big) return; big.innerHTML='';
    for(let c=0;c<COLS;c++) for(let r=0;r<ROWS;r++){
      const d=document.createElement('div'); d.style.gridRow=(r+1); cell(d, null, true); big.appendChild(d);
    }
    let col=0,row=0,last=null;
    const place=(v)=>{
      if(last===null){ last=v; col=0; row=0; }
      else if(v===last){ row++; if(row>=ROWS){ col++; row=ROWS-1; } }
      else { last=v; col++; row=0; }
      const idx = col*ROWS + row;
      const d = big.children[idx];
      if(d){ cell(d, v==='R'?'red':'blue', false); }
    };
    seq.forEach(v=>place(v));
  }
  function mark(v){ seq.push(v); renderBead(); renderBig(); addLog(v==='R'?'Red':'Blue'); addNotif('Round result', `${v==='R'?'Red':'Blue'} wins`, 'win'); }
  function undo(){
    if(!seq.length) return;
    seq.pop();
    logs.shift();
    renderBead(); renderBig(); renderLog(); saveAll();
  }
  document.getElementById('winRed')?.addEventListener('click',()=>mark('R'));
  document.getElementById('winBlue')?.addEventListener('click',()=>mark('B'));

  let tHandle=null, tLeft=0;
  const setTimerText = (txt)=> { const t=el('timer'); if(t) t.textContent=txt; };
  const formatSecs = (s)=> `${String(Math.floor(s/60)).padStart(2,'0')}:${String(s%60).padStart(2,'0')}`;
  function startRound(seconds=60){
    clearInterval(tHandle); tLeft=seconds; setTimerText(formatSecs(tLeft));
    addNotif('Round started','60 seconds','alert');
    tHandle=setInterval(()=>{ tLeft--; setTimerText(formatSecs(Math.max(tLeft,0))); if(tLeft<=0){ clearInterval(tHandle); tHandle=null; setTimerText('00:00'); addNotif('Round ended','Place bets closed','alert'); } },1000);
  }
  function resetRound(){ clearInterval(tHandle); tHandle=null; tLeft=0; setTimerText('—'); addNotif('Timer reset','Round timer cleared','info'); }
  document.getElementById('startRound')?.addEventListener('click', ()=>startRound(60));
  document.getElementById('resetRound')?.addEventListener('click', resetRound);

  function showTab(name){
    document.querySelectorAll('[data-tab]').forEach(b=>{
      const active = b.dataset.tab===name;
      if(active){
        b.classList.add('bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)]','shadow-[0_6px_14px_rgba(64,120,255,.25)]');
        b.classList.remove('bg-[#0e1934]');
      }else{
        b.classList.remove('bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)]','shadow-[0_6px_14px_rgba(64,120,255,.25)]');
        b.classList.add('bg-[#0e1934]');
      }
    });
    el('oddsView').hidden = name!=='odds';
    el('totalView').hidden = name!=='total';
    syncSideHeight();
  }
  document.querySelectorAll('[data-tab]').forEach(t=>t.addEventListener('click',()=>showTab(t.dataset.tab)));

  function toast(msg,ms=2200){
    const t=document.createElement('div');
    t.className='rounded-[12px] border border-[rgb(208_219_255_/_0.35)] bg-[rgba(11,18,34,0.85)] px-3 py-2 backdrop-blur-[8px] translate-y-[10px] opacity-0 transition-all duration-200';
    t.textContent=msg; el('toast').appendChild(t);
    requestAnimationFrame(()=>{ t.style.opacity='1'; t.style.transform='none'; });
    setTimeout(()=>{ t.style.opacity='0'; t.style.transform='translateY(6px)'; setTimeout(()=>t.remove(),200); }, ms);
  }
  function syncSideHeight(){
    const frame=document.querySelector('[data-video]');
    const side=el('kioskSide');
    if(frame && side){
      const mobile = matchMedia('(max-width:680px)').matches;
      side.style.maxHeight = mobile ? 'unset' : (frame.clientHeight + 'px');
    }
  }
  addEventListener('resize', syncSideHeight);
  addEventListener('load', syncSideHeight);

  document.getElementById('exportCsv')?.addEventListener('click', ()=>{
    const rows=[['Time','Winner','Pot','Odds','Payout per 100']];
    logs.forEach(r => rows.push([r.time, r.winner, '₱'+fmt(r.pot), '× '+r.odds, '₱'+fmt(r.payout)]));
    const csv=rows.map(r=>r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob=new Blob([csv],{type:'text/csv;charset=utf-8;'}); const a=document.createElement('a');
    a.href=URL.createObjectURL(blob); a.download='drag-race-results.csv'; a.click(); URL.revokeObjectURL(a.href);
    toast('CSV exported'); addNotif('CSV exported','Results saved locally','info');
  });
  document.getElementById('clearLog')?.addEventListener('click', ()=>{
    logs = []; el('logBody') && (el('logBody').innerHTML = ''); curPage = 1; renderLog();
    toast('Logs cleared'); addNotif('Logs cleared','History table emptied','alert');
  });

  function init(){ renderBead(); renderBig(); renderLog(); renderHistorySidebar(); renderHistoryTable(); sync(); }
  init();
  </script>

  <script>
  (function ensureQR(){
    if (window.QRCode) return;
    const s=document.createElement('script');
    s.src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js";
    s.async=true;
    s.onerror=()=>console.warn('QRCode lib failed to load — using fallback.');
    document.head.appendChild(s);
  })();
  </script>

</body>
</x-layouts.app>
