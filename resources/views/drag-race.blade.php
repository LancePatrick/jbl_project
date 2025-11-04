<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Drag Race Dashboard • Totalizator Style</title>

  <!-- Tailwind (v4 CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-dvh overflow-x-hidden font-[Inter,system-ui,-apple-system,Segoe_UI,Roboto,Helvetica,Arial] text-[13px] text-[color:var(--tw-text,inherit)]"
      style="--tw-text:#e8f0ff">

  <!-- BG -->
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

  <div class="w-full max-w-[1180px] mx-auto grid gap-4 px-[var(--gutter,12px)] py-[18px] lg:-translate-x-[120px] md:translate-x-0">

    <!-- HEADER -->
    <header class="sticky top-0 z-[1000] flex flex-wrap items-center gap-3 bg-[linear-gradient(180deg,rgba(7,10,16,.58),rgba(7,10,16,.18))] backdrop-blur-[6px] border-b border-[rgb(208_219_255_/_.35)] px-[var(--gutter,12px)] py-2">
      <div class="flex items-center gap-2">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" class="animate-[pulse_2.2s_ease-in-out_infinite]" aria-hidden="true">
          <defs>
            <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#1e3a8a"/><stop offset="100%" stop-color="#7c0a0a"/>
            </linearGradient>
          </defs>
          <path d="M4 17h4l2 3 4-6 2 3h4" stroke="url(#g)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="5" cy="17" r="2" fill="#00ffba"/><circle cx="19" cy="17" r="2" fill="#00ffba"/>
        </svg>
        <h1 class="m-0 text-[clamp(18px,3vw,26px)] relative overflow-hidden">
          <span class="after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(120deg,transparent,rgba(255,255,255,.12),transparent)] after:-translate-x-[120%] after:animate-[shine_4s_linear_infinite]">Drag Race Dashboard</span>
        </h1>
        <span class="hidden sm:inline rounded-full border border-[rgb(217_226_255_/_0.35)] bg-[#0e1730] px-3 py-1 text-[12px] text-[#b8c3d8]">inbose • mobile-first</span>
      </div>

      <div class="flex flex-wrap gap-2">
        <div class="flex items-center gap-2 rounded-full border border-[rgb(208_219_255_/_0.35)] bg-[#0e1934] px-3 py-2 font-extrabold">
          <strong class="opacity-90">TOTAL POT:</strong> <span id="pot">0</span>
        </div>
        <div class="flex items-center gap-2 rounded-full border border-[rgb(208_219_255_/_0.35)] bg-[#0e1934] px-3 py-2 font-extrabold">
          <span class="size-2.5 rounded-full bg-[#ff3b30]"></span> Rider Red: <strong id="tR">0</strong>
        </div>
        <div class="flex items-center gap-2 rounded-full border border-[rgb(208_219_255_/_0.35)] bg-[#0e1934] px-3 py-2 font-extrabold">
          <span class="size-2.5 rounded-full bg-[#2f7cff]"></span> Rider Blue: <strong id="tB">0</strong>
        </div>
        <div class="flex items-center gap-2 rounded-full border border-[rgb(208_219_255_/_0.35)] bg-[#0e1934] px-3 py-2 font-extrabold">
          <span>⏱️ Round:</span> <strong id="timer">—</strong>
        </div>
      </div>

      <div class="ml-auto flex items-center gap-2 relative">
        <button id="drawerOpen"
                class="grid size-[38px] min-w-[38px] place-items-center rounded-[12px] border border-[#263a66] bg-[linear-gradient(180deg,#1a2848,#0f1b37)] text-[#e6f0ff] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)]">⚙️</button>

        <button id="notifBtn"
                class="relative grid size-[38px] min-w-[38px] place-items-center rounded-[12px] border border-[#263a66] bg-[linear-gradient(180deg,#1a2848,#0f1b37)] text-[#e6f0ff] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)]">
          🔔
          <span id="notifBadge"
                class="absolute -right-0.5 -top-0.5 grid min-w-[16px] place-items-center rounded-full border-2 border-[#0c152a] bg-[#ff3b30] px-1 text-[10px] text-white"
                style="display:none">0</span>
        </button>

        <!-- Notif panel -->
        <div id="notifPanel"
             class="absolute right-[52px] top-[46px] w-[300px] scale-[.98] rounded-[14px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-3 opacity-0 backdrop-blur-[14px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)] pointer-events-none transition-all duration-300 [transform:translateY(-8px)] data-[show=true]:opacity-100 data-[show=true]:pointer-events-auto data-[show=true]:translate-y-0"
             data-show="false" role="menu" aria-hidden="true">
          <div class="mb-2 ml-1 text-[12px] text-[#bcd1ff]">Notifications</div>
          <div id="notifList" class="grid max-h-80 gap-2 overflow-auto"></div>
          <div class="my-1 h-px bg-[linear-gradient(90deg,transparent,rgb(208_219_255_/_0.35),transparent)]"></div>
          <div class="flex justify-end gap-2">
            <button id="markAllRead" class="h-9 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0c1630] px-3 text-white">Mark all read</button>
            <button id="clearNotif" class="h-9 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[rgba(12,22,48,.6)] px-3 text-white">Clear</button>
          </div>
        </div>

        <!-- Profile -->
        <div class="relative">
          <button id="profileBtn"
                  class="grid size-[38px] min-w-[38px] place-items-center rounded-[12px] border border-[#263a66] bg-[linear-gradient(180deg,#1a2848,#0f1b37)] text-[#e6f0ff] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)]">
            <div class="size-[38px] rounded-[12px] border-2 border-[#1f2b50] bg-cover bg-center"
                 style="background-image:url('https://i.pravatar.cc/96?img=67')"></div>
          </button>

          <div id="profileMenu"
               class="absolute right-0 top-[46px] w-[300px] scale-[.98] rounded-[14px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-3 opacity-0 backdrop-blur-[14px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)] pointer-events-none transition-all duration-300 [transform:translateY(-8px)] data-[show=true]:opacity-100 data-[show=true]:pointer-events-auto data-[show=true]:translate-y-0"
               aria-hidden="true" data-show="false">
            <div class="mb-2 grid cursor-default gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
              <div class="flex items-center gap-3">
                <div class="size-8 rounded-[8px] bg-cover bg-center"
                     style="background-image:url('https://i.pravatar.cc/96?img=67')"></div>
                <div class="grid">
                  <strong>Wilyonaryo</strong>
                  <small class="text-[#bcd1ff]">Pro Member</small>
                </div>
              </div>
            </div>
            <a href="#" id="cashInBtn" class="mb-2 block rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3 text-white">Cash In</a>
            <a href="#" id="withdrawBtn" class="mb-2 block rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3 text-white">Withdraw</a>
            <a href="#" id="editProfile" class="mb-2 block rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3 text-white">Edit Profile</a>
            <a href="{{ url('/') }}" class="block rounded-[12px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] p-3 text-[#ffecec]">Logout</a>
          </div>
        </div>
      </div>
    </header>

    <!-- SETTINGS (modal) -->
    <div id="settingsModal"
         class="fixed inset-0 z-[1300] hidden place-items-center bg-[rgba(0,0,0,.45)] backdrop-blur-[4px] data-[show=true]:grid"
         aria-label="Settings" role="dialog" aria-hidden="true" data-show="false">
      <div class="w-[min(520px,calc(100%-24px))] rounded-[16px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-4 shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_24px_60px_rgba(0,0,0,.45)]">
        <div class="mb-2 flex items-center justify-between gap-2">
          <h3 class="m-0">Settings</h3>
          <button id="settingsClose"
                  class="grid size-9 min-w-9 place-items-center rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[rgba(12,22,48,.6)]">✕</button>
        </div>

        <!-- Reusable toggle row -->
        <div class="grid gap-2">
          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>Dark Mode</strong><br><small class="text-[#bcd1ff]">Switch theme</small></div>
            <div id="sw-dark" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c] aria-checked:false data-[on=true]:bg-[linear-gradient(90deg,#2f7cff,#ff3b30)]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all data-[on=true]:left-[27px]"></div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>Fancy Animations</strong><br><small class="text-[#bcd1ff]">Glow, pulse, float</small></div>
            <div id="sw-fancy" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all"></div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>Sound Effects</strong><br><small class="text-[#bcd1ff]">Clicks & beeps</small></div>
            <div id="sw-sound" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all"></div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>Compact Mode</strong><br><small class="text-[#bcd1ff]">Tighter paddings</small></div>
            <div id="sw-compact" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all"></div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>High Contrast</strong><br><small class="text-[#bcd1ff]">Stronger borders/text</small></div>
            <div id="sw-contrast" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all"></div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>Haptic Feedback</strong><br><small class="text-[#bcd1ff]">Vibrate on actions</small></div>
            <div id="sw-haptic" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all"></div>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 rounded-[12px] border border-[rgb(208_219_255_/_0.45)] bg-[#0e1730] p-3">
            <div><strong>Desktop Notifications</strong><br><small class="text-[#bcd1ff]">Allow browser alerts</small></div>
            <div id="sw-deskn" class="relative h-[30px] w-[54px] cursor-pointer rounded-full border border-[rgb(208_219_255_/_0.45)] bg-[#18223c]">
              <div class="absolute left-[3px] top-[3px] size-6 rounded-full bg-white shadow-[0_2px_6px_rgba(0,0,0,.35)] transition-all"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- VIDEO + SIDE -->
    <section class="rounded-[18px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-2 backdrop-blur-[10px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)]">
      <!-- Tabs -->
      <div class="flex gap-1 overflow-auto border-b border-[rgb(208_219_255_/_0.35)] px-2 pb-2">
        <button class="rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[linear-gradient(90deg,#1e3a8a_0%,_#7c0a0a_100%)] px-3 py-2 font-black text-white shadow-[0_6px_14px_rgba(64,120,255,.25)]"
                data-tab="odds">ODDS</button>
        <button class="rounded-[12px] border border-[rgb(200_214_255_/_0.45)] bg-[#0e1934] px-3 py-2 font-black text-white" data-tab="total">TOTAL</button>
      </div>

      <div class="grid grid-cols-1 gap-3 md:grid-cols-[minmax(0,1fr)_clamp(300px,30vw,380px)]">
        <!-- Video -->
        <div class="relative aspect-[16/9] overflow-hidden rounded-[16px] border border-[rgb(200_214_255_/_0.45)] bg-black shadow-[0_18px_40px_rgba(0,0,0,.45),0_6px_14px_rgba(0,0,0,.25),inset_0_0_0_1px_rgba(255,255,255,.05)]">
          <div class="pointer-events-none absolute inset-0 rounded-[16px] shadow-[inset_0_0_0_4px_#2a3d6a,inset_0_0_0_6px_rgba(255,255,255,.06)]"></div>
          <iframe id="yt" class="absolute inset-0 size-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>

        <!-- Kiosk -->
        <div id="kioskSide" class="flex max-h-full flex-col gap-2 overflow-auto rounded-[14px] border border-[rgb(208_219_255_/_0.35)] bg-[#0d1529] p-2">
          <!-- ODDS VIEW -->
          <div id="oddsView" class="grid gap-2">
            <!-- Two cards -->
            <div class="grid grid-cols-2 gap-2">
              <!-- Red -->
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-3 text-white shadow-[0_10px_30px_rgba(0,0,0,.35),inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46)]">
                <div class="flex items-center justify-between">
                  <div class="grid size-[34px] place-items-center rounded-full border-2 border-white/35 bg-black/20 font-black">R</div>
                  <div id="nameRed" class="text-[13px] opacity-90">Rider Red</div>
                </div>
                <div id="amtRed" class="mt-1 leading-[1.05] text-[clamp(28px,6.8vw,38px)] font-black tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[14px] border border-white/30 bg-black/20 px-3 py-1.5 text-[13px] font-black">PAYOUT = <span id="oddsRed" class="ml-1">1.88</span></div>
                <div class="mt-2 grid gap-2">
                  <button data-bet="red" class="h-[42px] rounded-[12px] border border-white/40 bg-black/20 font-black text-white shadow-[inset_0_1px_0_rgba(0,0,0,.3)]">BET</button>
                  <div class="text-[12px] opacity-85">Winnings per ₱100: ₱<span id="payR100">188</span></div>
                </div>
              </div>

              <!-- Blue -->
              <div class="rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-3 text-white shadow-[0_10px_30px_rgba(0,0,0,.35),inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46)]">
                <div class="flex items-center justify-between">
                  <div class="grid size-[34px] place-items-center rounded-full border-2 border-white/35 bg-black/20 font-black">B</div>
                  <div id="nameBlue" class="text-[13px] opacity-90">Rider Blue</div>
                </div>
                <div id="amtBlue" class="mt-1 leading-[1.05] text-[clamp(28px,6.8vw,38px)] font-black tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[14px] border border-white/30 bg-black/20 px-3 py-1.5 text-[13px] font-black">PAYOUT = <span id="oddsBlue" class="ml-1">2.08</span></div>
                <div class="mt-2 grid gap-2">
                  <button data-bet="blue" class="h-[42px] rounded-[12px] border border-white/40 bg-black/20 font-black text-white shadow-[inset_0_1px_0_rgba(0,0,0,.3)]">BET</button>
                  <div class="text-[12px] opacity-85">Winnings per ₱100: ₱<span id="payB100">208</span></div>
                </div>
              </div>
            </div>

            <!-- Slip -->
            <div class="grid gap-2 rounded-[14px] border border-[rgb(150_170_220_/_0.45)] bg-[#0e1730] p-2">
              <input id="amount" type="number" min="1" placeholder="Enter amount"
                     class="h-[44px] w-full rounded-[12px] border border-[rgb(150_170_220_/_0.45)] bg-[#0a1122] px-3 font-extrabold text-[#e9f3ff] outline-none"/>
              <div class="grid grid-cols-2 gap-2">
                <button id="reset" class="h-[42px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630]">Reset</button>
                <button id="maxAmt" class="h-[42px] rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630]">Max</button>
              </div>
            </div>

            <!-- Chips -->
            <div id="chips" class="grid grid-cols-2 gap-2">
              <button class="h-[44px] rounded-[14px] border border-[#0f5c30] bg-[linear-gradient(180deg,#2a9d55,#187d3e)] font-black text-[#eef5ff] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦100</button>
              <button class="h-[44px] rounded-[14px] border border-[#163f8f] bg-[linear-gradient(180deg,#2f7cff,#1a4fb5)] font-black text-[#eef5ff] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦200</button>
              <button class="h-[44px] rounded-[14px] border border-[#0b0c0f] bg-[linear-gradient(180deg,#2c2f35,#15171b)] font-black text-[#eef5ff] shadow-[0_1px_0_rgba(0,0,0,.35)]">♦500</button>
              <button class="h-[44px] rounded-[14px] border border-[#a76407] bg-[linear-gradient(180deg,#ffb23a,#d48112)] font-black text-[#1b1203]">♦1000</button>
            </div>

            <!-- Totals -->
            <div id="totalsWidget" class="grid gap-2 rounded-[14px] border border-[rgb(150_170_220_/_0.45)] bg-[#0e1426] p-2">
              <div class="flex items-center justify-between border-b border-dashed border-[rgb(47_71_122_/_0.8)] py-1">
                <strong>POT</strong><strong id="pot2">0</strong>
              </div>
              <div class="flex items-center justify-between border-b border-dashed border-[rgb(47_71_122_/_0.8)] py-1">
                <span>Bets (Rider Red / Rider Blue)</span>
                <strong><span id="tR2">0</span> / <span id="tB2">0</span></strong>
              </div>
              <div class="flex items-center justify-between border-b border-dashed border-[rgb(47_71_122_/_0.8)] py-1">
                <span>Est. Payout (x)</span>
                <strong><span class="text-[#bcd1ff]">Rider Red</span> <span id="payoutR">× 1.88</span> • <span class="text-[#bcd1ff]">Rider Blue</span> <span id="payoutB">× 2.08</span></strong>
              </div>
              <div class="h-2 overflow-hidden rounded-full border border-[#263553] bg-[#0c1220]">
                <span id="bar" class="block h-full bg-[linear-gradient(90deg,#ff3b30,#2f7cff)] w-0"></span>
              </div>
              <div class="grid grid-cols-2 gap-2">
                <button id="resetTotals" class="h-9 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630]">Reset Totals</button>
                <button id="demoBets" class="h-9 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630]">Simulate</button>
              </div>
            </div>
          </div>

          <!-- TOTAL VIEW -->
          <div id="totalView" hidden class="grid gap-2">
            <div class="grid grid-cols-2 gap-2">
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

            <div class="grid grid-cols-2 gap-2">
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

    <!-- RESULTS / ROADMAP -->
    <section class="rounded-[18px] border border-[rgb(217_226_255_/_0.25)] bg-[rgba(11,18,34,0.85)] p-2 backdrop-blur-[10px] shadow-[inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46),0_10px_30px_rgba(0,0,0,.25)]">
      <div class="grid gap-3 rounded-[14px] border border-[rgb(217_226_255_/_0.25)] bg-[#0e1426] p-3">
        <div class="flex flex-wrap items-center justify-between gap-2">
          <h3 class="m-0">Roadmap • Results</h3>
          <div class="flex gap-2 overflow-auto pb-1">
            <button id="winRed" class="h-10 rounded-[12px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] px-3 text-[#ffecec]">Record: Red Wins</button>
            <button id="winBlue" class="h-10 rounded-[12px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-3 text-[#e6f0ff]">Record: Blue Wins</button>
            <button id="undo" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Undo</button>
            <button id="startRound" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Start Round</button>
            <button id="resetRound" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[#0c1630] px-3">Reset Round</button>
            <button id="clearLog" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[rgba(12,22,48,.6)] px-3">Clear Log</button>
            <button id="exportCsv" class="h-10 rounded-[12px] border border-[rgb(150_170_220_/_0.6)] bg-[rgba(12,22,48,.6)] px-3">Export CSV</button>
          </div>
        </div>

        <div class="mx-auto -mt-1 rounded-[10px] border border-[rgb(208_219_255_/_0.35)] bg-[#0d1529] px-3 py-1.5 text-center" id="roadOdds">
          Red × 1.88 • Blue × 2.08
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
  </div>

  <!-- Sticky mobile quick-bet rail -->
  <div id="mbRail"
       class="fixed inset-x-0 bottom-0 z-[2000] hidden gap-2 border-t border-[rgb(200_214_255_/_0.45)] bg-[rgba(10,18,35,.9)] p-2 backdrop-blur-[8px] md:hidden"
  >
    <input id="mbAmount" type="number" min="1" placeholder="₱ Amount"
           class="h-[42px] w-full rounded-[10px] border border-[rgb(150_170_220_/_0.45)] bg-[#0a1122] px-2 text-[#e9f3ff]"/>
    <button id="mbBet"
            class="h-[42px] rounded-[10px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] px-4 font-black text-white">BET</button>
  </div>

  <!-- Toast -->
  <div id="toast" class="fixed bottom-4 right-4 z-[1500] grid gap-2"></div>

  <!-- Modals (Edit/Cash/Withdraw) -->
  <div id="modal-edit" class="fixed inset-0 z-[1200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
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

  <div id="modal-cash" class="fixed inset-0 z-[1200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
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

  <div id="modal-withdraw" class="fixed inset-0 z-[1200] hidden place-items-center bg-[rgba(0,0,0,.45)]" role="dialog" aria-hidden="true">
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

  <!-- ===== JS (same app logic; no CSS needed) ===== -->
  <script>
  // YouTube
  (function(){
    const url='https://youtu.be/mzBv3fUDxRA?si=0X903bZ6UrB-v6UF';
    const embed=url.replace('https://youtu.be/','https://www.youtube.com/embed/').replace('watch?v=','embed/');
    const iframe=document.getElementById('yt');
    iframe.src=embed+(embed.includes('?')?'&':'?')+'rel=0&modestbranding=1&playsinline=1';
    iframe.addEventListener('load', syncSideHeight);
  })();

  // State
  const state={ red:0, blue:0, oddsRed:1.88, oddsBlue:2.08, market:'—' };
  const el=id=>document.getElementById(id);
  const fmt=n=>Number(n).toLocaleString('en-PH',{maximumFractionDigits:0});

  // Logs/pager
  const PAGE_SIZE=5; let curPage=1; let logs=[];

  // Sound/Haptics
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

  // Notifications
  let DESK_NOTIF=false;
  const notifs=[]; let unread=0;
  const notifUI={btn:el('notifBtn'),panel:el('notifPanel'),list:el('notifList'),badge:el('notifBadge')};
  function renderNotifs(){
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
    notifUI.badge.style.display=unread>0?'grid':'none';
    notifUI.badge.textContent=unread>99?'99+':String(unread);
    localStorage.setItem('dr_notifs', JSON.stringify(notifs));
    localStorage.setItem('dr_unread', String(unread));
  }
  function panelShow(node, show){ node.dataset.show = show ? 'true' : 'false'; }
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
    notifUI.btn.addEventListener('click', (e)=>{ e.stopPropagation(); const show=notifUI.panel.dataset.show!=='true'; panelShow(notifUI.panel, show); if(show){ notifs.forEach(n=>n.read=true); unread=0; renderNotifs(); }});
    document.addEventListener('click', (e)=>{ if(!notifUI.panel.contains(e.target) && !notifUI.btn.contains(e.target)) panelShow(notifUI.panel,false); });
    document.getElementById('markAllRead')?.addEventListener('click',()=>{ notifs.forEach(n=>n.read=true); unread=0; renderNotifs(); });
    document.getElementById('clearNotif')?.addEventListener('click',()=>{ notifs.length=0; unread=0; renderNotifs(); });
    try{ const s=JSON.parse(localStorage.getItem('dr_notifs')||'[]'); const u=Number(localStorage.getItem('dr_unread')||'0'); if(Array.isArray(s)) notifs.push(...s); unread=u||0; renderNotifs(); }catch{}
  })();

  // UI Sync/Persist
  function sync(){
    const pot=state.red+state.blue;
    const r = pot? state.red/pot*100 : 0; const b=100-r;

    el('tR').textContent=fmt(state.red); el('tB').textContent=fmt(state.blue); el('pot').textContent=fmt(pot);
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
  }
  function saveAll(){
    localStorage.setItem('dr_state', JSON.stringify(state));
    localStorage.setItem('dr_seq', JSON.stringify(seq));
    localStorage.setItem('dr_logs', JSON.stringify(logs));
  }
  (function restore(){
    try{
      const s=JSON.parse(localStorage.getItem('dr_state')||'null');
      const q=JSON.parse(localStorage.getItem('dr_seq')||'null');
      const lg=JSON.parse(localStorage.getItem('dr_logs')||'null');
      const dn=localStorage.getItem('deskn')==='1';
      if(s) Object.assign(state,s);
      if(Array.isArray(q)) seq.push(...q);
      if(Array.isArray(lg)) logs = lg;
      DESK_NOTIF=dn;
    }catch{}
  })();

  // Chips / Odds
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

  // Bets
  document.querySelectorAll('[data-bet]').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const side=btn.getAttribute('data-bet');
      const val=Math.max(0,Number(el('amount').value||0)); if(!val) return;
      if(val<10){ toast('Minimum bet is ₱10'); return; }
      state[side]+=val; el('amount').value='';
      recalcOdds(); sync();
      addNotif('Bet placed', `${side.toUpperCase()} • ₱${fmt(val)}`, 'bet');
    });
  });
  el('reset').addEventListener('click',()=>{ el('amount').value=''; });
  el('maxAmt').addEventListener('click',()=>{ const v=Number(el('amount').value||0); if(v<1) el('amount').value=100; });

  // Mobile quick rail
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
    });
  })();

  // Totals
  el('resetTotals').addEventListener('click', ()=>{ state.red=0; state.blue=0; recalcOdds(); sync(); addNotif('Totals reset','All bet totals cleared','alert'); });
  el('demoBets').addEventListener('click', ()=>{ const inc=Math.floor(Math.random()*5+1)*50; if(Math.random()>0.5) state.red+=inc; else state.blue+=inc; recalcOdds(); sync(); toast('Simulated bet: ₱'+fmt(inc)); });

  // Milestones
  let lastMilestone=0; function checkMilestones(pot){ const step=1000; const m=Math.floor(pot/step); if(m>lastMilestone){ lastMilestone=m; addNotif('Pot milestone', `Total pot hit ₱${fmt(m*step)}`, 'alert'); } }

  // Roads / Results
  const seq=[]; const ROWS=6, COLS=36;

  // logs + pagination
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
  document.getElementById('firstPage').onclick = ()=>{ curPage = 1; renderLog(); };
  document.getElementById('prevPage').onclick  = ()=>{ if (curPage > 1) { curPage--; renderLog(); } };
  document.getElementById('nextPage').onclick  = ()=>{ const t=Math.max(1, Math.ceil(logs.length/PAGE_SIZE)); if (curPage < t) { curPage++; renderLog(); } };
  document.getElementById('lastPage').onclick  = ()=>{ curPage = Math.max(1, Math.ceil(logs.length/PAGE_SIZE)); renderLog(); };

  // Roads
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
    const bead=el('bead'); bead.innerHTML='';
    for(let c=0;c<COLS;c++) for(let r=0;r<ROWS;r++){
      const d=document.createElement('div'); d.style.gridRow=(r+1); cell(d); bead.appendChild(d);
    }
    seq.forEach((v,i)=>{
      const col=Math.floor(i/ROWS), row=i%ROWS; const idx=col*ROWS+row;
      const d=bead.children[idx]; if(d){ cell(d, v==='R'?'red':'blue'); d.textContent=String(i+1); }
    });
  }
  function renderBig(){
    const big=el('big'); big.innerHTML='';
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
  document.getElementById('winRed').addEventListener('click',()=>mark('R'));
  document.getElementById('winBlue').addEventListener('click',()=>mark('B'));

  // Round Timer
  let tHandle=null, tLeft=0;
  const setTimerText = (txt)=> el('timer').textContent=txt;
  const formatSecs = (s)=> `${String(Math.floor(s/60)).padStart(2,'0')}:${String(s%60).padStart(2,'0')}`;
  function startRound(seconds=60){
    clearInterval(tHandle); tLeft=seconds; setTimerText(formatSecs(tLeft));
    addNotif('Round started','60 seconds','alert');
    tHandle=setInterval(()=>{ tLeft--; setTimerText(formatSecs(Math.max(tLeft,0))); if(tLeft<=0){ clearInterval(tHandle); tHandle=null; setTimerText('00:00'); addNotif('Round ended','Place bets closed','alert'); } },1000);
  }
  function resetRound(){ clearInterval(tHandle); tHandle=null; tLeft=0; setTimerText('—'); addNotif('Timer reset','Round timer cleared','info'); }
  document.getElementById('startRound').addEventListener('click', ()=>startRound(60));
  document.getElementById('resetRound').addEventListener('click', resetRound);

  // Tabs
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

  // Profile dropdown
  const profileBtn=el('profileBtn'), profileMenu=el('profileMenu');
  function toggleMenu(force){
    const show=typeof force==='boolean'?force:profileMenu.dataset.show!=='true';
    profileMenu.dataset.show = show ? 'true' : 'false';
    profileMenu.setAttribute('aria-hidden', show?'false':'true');
  }
  profileBtn.addEventListener('click', e=>{ e.stopPropagation(); toggleMenu(); });
  document.addEventListener('click', e=>{ if(!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) toggleMenu(false); });

  // Settings modal
  const settingsModal = document.getElementById('settingsModal');
  const openSettings  = document.getElementById('drawerOpen');
  const closeSettings = document.getElementById('settingsClose');
  function showSettings(show=true){
    settingsModal.dataset.show = show ? 'true' : 'false';
    settingsModal.style.display = show ? 'grid' : 'none';
    settingsModal.setAttribute('aria-hidden', show ? 'false' : 'true');
  }
  openSettings.addEventListener('click', ()=> showSettings(true));
  closeSettings.addEventListener('click', ()=> showSettings(false));
  settingsModal.addEventListener('click', (e)=>{ if(e.target === settingsModal) showSettings(false); });
  document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') showSettings(false); });

  // Settings toggles
  const switches={ dark:el('sw-dark'), fancy:el('sw-fancy'), sound:el('sw-sound'), compact:el('sw-compact'), contrast:el('sw-contrast'), haptic:el('sw-haptic'), deskn:el('sw-deskn') };
  function setSwitch(elem,on){
    elem.dataset.on = on ? 'true' : 'false';
    elem.setAttribute('aria-checked', on?'true':'false');
    const knob=elem.firstElementChild;
    knob && (knob.style.left = on ? '27px' : '3px');
    elem.style.background = on && elem.id==='sw-dark' ? 'linear-gradient(90deg,#2f7cff,#ff3b30)' : '#18223c';
  }
  function applyFromStorage(){
    const theme=localStorage.getItem('theme')||'dark';
    document.documentElement.setAttribute('data-theme', theme);
    setSwitch(switches.dark, theme==='dark');

    const fancy=localStorage.getItem('fancy')!=='0';
    document.body.classList.toggle('no-fancy', !fancy); setSwitch(switches.fancy, fancy);

    SOUND_ON=localStorage.getItem('sound')!=='0'; setSwitch(switches.sound, SOUND_ON);

    const compact=localStorage.getItem('compact')==='1';
    document.body.classList.toggle('compact', compact); setSwitch(switches.compact, compact);

    const contrast=localStorage.getItem('contrast')==='1';
    document.body.classList.toggle('high-contrast', contrast); setSwitch(switches.contrast, contrast);

    HAPTIC_ON=localStorage.getItem('haptic')==='1'; setSwitch(switches.haptic, HAPTIC_ON);

    DESK_NOTIF=localStorage.getItem('deskn')==='1'; setSwitch(switches.deskn, DESK_NOTIF);
  } applyFromStorage();

  Object.entries(switches).forEach(([key, elem])=>{
    elem.addEventListener('click', async ()=>{
      const isOn = elem.dataset.on !== 'true'; setSwitch(elem, isOn);
      switch(key){
        case 'dark': document.documentElement.setAttribute('data-theme', isOn?'dark':'light'); localStorage.setItem('theme', isOn?'dark':'light'); break;
        case 'fancy': document.body.classList.toggle('no-fancy', !isOn); localStorage.setItem('fancy', isOn?'1':'0'); break;
        case 'sound': SOUND_ON=isOn; localStorage.setItem('sound', isOn?'1':'0'); break;
        case 'compact': document.body.classList.toggle('compact', isOn); localStorage.setItem('compact', isOn?'1':'0'); break;
        case 'contrast': document.body.classList.toggle('high-contrast', isOn); localStorage.setItem('contrast', isOn?'1':'0'); break;
        case 'haptic': HAPTIC_ON=isOn; localStorage.setItem('haptic', isOn?'1':'0'); break;
        case 'deskn':
          if(isOn && 'Notification' in window){
            let perm=Notification.permission; if(perm!=='granted'){ perm=await Notification.requestPermission(); }
            const ok=(perm==='granted'); localStorage.setItem('deskn', ok?'1':'0'); setSwitch(elem, ok);
            addNotif(ok?'Desktop notifications ON':'Desktop notifications OFF','', 'info', false);
          } else { localStorage.setItem('deskn','0'); setSwitch(elem,false); addNotif('Desktop notifications OFF','', 'info', false); }
          break;
      }
    });
  });

  // Toast + layout sync
  function toast(msg,ms=2200){
    const t=document.createElement('div');
    t.className='rounded-[12px] border border-[rgb(208_219_255_/_0.35)] bg-[rgba(11,18,34,0.85)] px-3 py-2 backdrop-blur-[8px] translate-y-[10px] opacity-0 transition-all duration-200';
    t.textContent=msg; el('toast').appendChild(t);
    requestAnimationFrame(()=>{ t.style.opacity='1'; t.style.transform='none'; });
    setTimeout(()=>{ t.style.opacity='0'; t.style.transform='translateY(6px)'; setTimeout(()=>t.remove(),200); }, ms);
  }
  function syncSideHeight(){
    const frame=document.querySelector('.md\\:grid-cols-\\[minmax\\(0\\,1fr\\)_clamp\\(300px\\,30vw\\,380px\\)\\] .relative');
    const side=el('kioskSide');
    if(frame && side){
      const mobile = matchMedia('(max-width:680px)').matches;
      side.style.maxHeight = mobile ? 'unset' : (frame.clientHeight + 'px');
    }
  }
  addEventListener('resize', syncSideHeight);
  addEventListener('load', syncSideHeight);

  // CSV / Clear
  el('exportCsv').addEventListener('click', ()=>{
    const rows=[['Time','Winner','Pot','Odds','Payout per 100']];
    logs.forEach(r => rows.push([r.time, r.winner, '₱'+fmt(r.pot), '× '+r.odds, '₱'+fmt(r.payout)]));
    const csv=rows.map(r=>r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob=new Blob([csv],{type:'text/csv;charset=utf-8;'}); const a=document.createElement('a');
    a.href=URL.createObjectURL(blob); a.download='drag-race-results.csv'; a.click(); URL.revokeObjectURL(a.href);
    toast('CSV exported'); addNotif('CSV exported','Results saved locally','info');
  });
  el('clearLog').addEventListener('click', ()=>{
    logs = []; el('logBody').innerHTML = ''; curPage = 1; renderLog();
    toast('Logs cleared'); addNotif('Logs cleared','History table emptied','alert');
  });

  // Modals
  function showModal(id, show=true){
    const m = document.getElementById(id);
    if(!m) return;
    m.style.display = show ? 'grid' : 'none';
    m.setAttribute('aria-hidden', show ? 'false' : 'true');
  }
  document.getElementById('editProfile').addEventListener('click', (e)=>{ e.preventDefault(); showModal('modal-edit', true); });
  document.getElementById('cashInBtn').addEventListener('click', (e)=>{ e.preventDefault(); showModal('modal-cash', true); });
  document.getElementById('withdrawBtn').addEventListener('click', (e)=>{ e.preventDefault(); showModal('modal-withdraw', true); });

  document.querySelectorAll('.modal [data-close]').forEach(b=>b.addEventListener('click',()=> showModal(b.closest('.modal').id, false)));
  document.getElementById('modal-edit').addEventListener('click',(e)=>{ if(e.target.id==='modal-edit') showModal('modal-edit',false); });
  document.getElementById('modal-cash').addEventListener('click',(e)=>{ if(e.target.id==='modal-cash') showModal('modal-cash',false); });
  document.getElementById('modal-withdraw').addEventListener('click',(e)=>{ if(e.target.id==='modal-withdraw') showModal('modal-withdraw',false); });

  document.getElementById('saveProfile').addEventListener('click', ()=>{
    const name = (document.getElementById('prof-name').value||'Wilyonaryo').trim();
    const avatar = (document.getElementById('prof-avatar').value||'').trim();
    if(name) addNotif('Profile saved', name, 'info');
    if(avatar) document.querySelectorAll('.size-\\[38px\\],.size-8').forEach(a=>a.style.backgroundImage=`url('${avatar}')`);
    showModal('modal-edit', false);
  });
  document.getElementById('cashSubmit').addEventListener('click', ()=>{
    const amt = Number(document.getElementById('cash-amt').value||0);
    if(amt>0){ addNotif('Cash In requested', `₱${fmt(amt)} • ${document.getElementById('cash-method').value}`, 'info'); }
    showModal('modal-cash', false);
  });
  document.getElementById('wdSubmit').addEventListener('click', ()=>{
    const amt = Number(document.getElementById('wd-amt').value||0);
    if(amt>0){ addNotif('Withdraw requested', `₱${fmt(amt)} • ${document.getElementById('wd-method').value}`, 'info'); }
    showModal('modal-withdraw', false);
  });

  // Init
  function init(){ renderBead(); renderBig(); renderLog(); sync(); }
  init();
  </script>

  <script src="https://huggingface.co/deepsite/deepsite-badge.js"></script>
</body>
</html>
