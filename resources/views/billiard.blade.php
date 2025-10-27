<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bilyaran</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* ==========================================================
       1) CSS VARIABLES (TOKENS)
    ========================================================== */
    :root {
      --gloss: linear-gradient(to bottom, rgba(255,255,255,.28), rgba(255,255,255,0) 45%);
      --inner-shadow: inset 0 1px 2px rgba(0,0,0,.35), inset 0 -2px 4px rgba(0,0,0,.25);
      --card-radius: 18px;
      --logro-bubble: 22px;
      --logro-step: 10px;
      --logro-rail-h: 48px;
      /* mini bead road (sidebar) */
      --bead-bubble: 14px;
      --bead-rail-h: 96px;
      --bead-gap-x: 6px;
      --bead-gap-y: 4px;
    }

    /* ==========================================================
       2) BASE / GLOBAL
    ========================================================== */
    html, body { margin:0; padding:0; height:100%; overflow-x:hidden; }
    .bg-animated {
      position:fixed; inset:0; width:110%; height:110%;
      background:url('https://i.ibb.co/BKQvKBXG/dffa7d34-4988-4aaa-802f-7fb649a8f8f5.png') center/cover no-repeat;
      opacity:.85; z-index:-1; animation:moveBg 30s infinite alternate ease-in-out; will-change:transform;
    }

    /* ==========================================================
       3) HEADER / NAV
    ========================================================== */
    .glass-header { background:linear-gradient(to right, rgba(17,24,39,.75), rgba(17,24,39,.55)); backdrop-filter:blur(8px) saturate(120%); border-bottom:1px solid rgba(255,255,255,.12); }
    .header-gloss:before { content:""; position:absolute; inset:0; background:radial-gradient(120% 80% at -10% -40%, rgba(255,255,255,.25), rgba(255,255,255,0) 60%); pointer-events:none; }
    .brand-logo { filter:drop-shadow(0 0 6px rgba(16,185,129,.7)); }
    .menu-card { background:rgba(17,24,39,.95); border:1px solid rgba(255,255,255,.12); border-radius:14px; box-shadow:0 18px 30px rgba(0,0,0,.35); }
    .shine-3d { font-weight:900; letter-spacing:.3px; background:linear-gradient(90deg, rgba(255,255,255,.75) 0%, #ffffff 25%, #ffe08a 45%, #ffffff 60%, rgba(255,255,255,.75) 100%); background-size:200% auto; -webkit-background-clip:text; background-clip:text; color:transparent; animation:shineMove 2.6s linear infinite; text-shadow:0 1px 0 rgba(0,0,0,.35), 0 2px 0 rgba(0,0,0,.35), 0 8px 18px rgba(0,0,0,.5), 0 0 18px rgba(255,232,133,.35); }

    /* ==========================================================
       4) PANELS / LAYOUT
    ========================================================== */
    .side-panel { background:rgba(17,24,39,.35); }
    .main-panel { background:rgba(17,24,39,.55); }

    /* ==========================================================
       5) BET CARDS / INPUTS / BUTTONS / CHIPS
    ========================================================== */
    .bet-area { perspective:1200px; }
    .bet-card { position:relative; border-radius:var(--card-radius); overflow:hidden; padding:14px; color:#fff; transform-style:preserve-3d; will-change:transform, box-shadow; transition:transform .2s, box-shadow .2s, filter .2s; border:1px solid rgba(255,255,255,.12); backdrop-filter:saturate(120%) blur(2px); box-shadow:0 18px 30px rgba(0,0,0,.35), 0 4px 10px rgba(0,0,0,.35); }
    .bet-card::before { content:""; position:absolute; inset:0; background: radial-gradient(100% 60% at -10% -10%, rgba(255,255,255,.35), rgba(255,255,255,0) 60%), var(--gloss); mix-blend-mode:screen; pointer-events:none; }
    .bet-card::after { content:""; position:absolute; left:8%; right:8%; bottom:0; height:2px; background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent); filter:blur(.5px); transform:translateZ(22px); opacity:.7; }
    .bet-card:hover { transform:translateY(-6px) scale(1.01); filter:saturate(110%); }
    .bet-card.red { background: radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%), linear-gradient(180deg,#ef4444 0%,#b91c1c 55%,#7f1d1d 100%); box-shadow:0 18px 32px rgba(185,28,28,.45), 0 8px 18px rgba(0,0,0,.45); }
    .bet-card.blue{ background: radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%), linear-gradient(180deg,#3b82f6 0%,#1d4ed8 55%,#1e3a8a 100%); box-shadow:0 18px 32px rgba(29,78,216,.45), 0 8px 18px rgba(0,0,0,.45); }
    .name-chip { display:inline-block; padding:6px 12px; border-radius:9999px; font-weight:900; letter-spacing:.3px; background:rgba(0,0,0,.25); box-shadow:var(--inner-shadow); transform:translateZ(24px); }
    .amount-3d { font-weight:900; text-shadow:0 2px 0 rgba(0,0,0,.35), 0 8px 18px rgba(0,0,0,.35); transform:translateZ(26px); }
    .odds-ribbon { display:inline-block; padding:6px 12px; border-radius:10px; font-weight:800; background:rgba(0,0,0,.25); border:1px solid rgba(255,255,255,.12); box-shadow:var(--inner-shadow); transform:translateZ(22px); }
    .bet-input { border-radius:12px; border:1px solid rgba(255,255,255,.18); outline:none; box-shadow:var(--inner-shadow); transition:transform .15s, box-shadow .15s; transform:translateZ(18px); }
    .bet-input:focus { box-shadow:inset 0 2px 4px rgba(0,0,0,.3), 0 0 0 3px rgba(255,255,255,.08); transform:translateZ(20px); }
    .bet-btn { border-radius:12px; font-weight:900; letter-spacing:.5px; border:1px solid rgba(255,255,255,.18); box-shadow:0 10px 18px rgba(0,0,0,.35), inset 0 1px 2px rgba(255,255,255,.25); transition:transform .12s, box-shadow .12s, filter .12s; transform:translateZ(24px); }
    .bet-btn:hover { filter:brightness(1.05); }
    .bet-btn:active { transform:translateZ(20px) translateY(2px); box-shadow:0 6px 12px rgba(0,0,0,.35), inset 0 2px 4px rgba(0,0,0,.35); }
    .bet-btn.red { background:linear-gradient(180deg,#b91c1c 0%,#7f1d1d 100%); }
    .bet-btn.blue{ background:linear-gradient(180deg,#1d4ed8 0%,#1e3a8a 100%); }
    .result-glow { text-shadow:0 0 10px rgba(250,204,21,.55); }
    .tilt { transform:rotateX(0) rotateY(0); transition:transform .12s; }
    .balance-pill { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:9999px; background:rgba(250,204,21,.12); border:1px solid rgba(250,204,21,.35); box-shadow: var(--inner-shadow); backdrop-filter: blur(2px) saturate(120%); transform: translateZ(24px); }
    .balance-pill .amount { font-weight:900; letter-spacing:.5px; text-shadow:0 1px 0 rgba(0,0,0,.35), 0 8px 16px rgba(0,0,0,.35); }

    /* Quick bet chips */
    .chip3d{ position:relative; display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:14px; font-weight:900; letter-spacing:.4px; user-select:none; border:1px solid rgba(255,255,255,.18); background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.02)); box-shadow:0 14px 28px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.25); transform:translateZ(12px); transition:transform .12s, box-shadow .12s, filter .12s; backdrop-filter: blur(2px) saturate(120%); }
    .chip3d::before{ content:""; position:absolute; inset:0; border-radius:14px; background:var(--gloss); mix-blend-mode:screen; pointer-events:none; transform:translateZ(14px); }
    .chip3d:hover{ transform:translateY(-3px) translateZ(14px); filter:saturate(110%); }
    .chip3d:active{ transform:translateY(1px) translateZ(8px); box-shadow:0 10px 18px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.35); }
    .chip-red{ background:linear-gradient(180deg,#b91c1c,#7f1d1d); }
    .chip-blue{ background:linear-gradient(180deg,#1d4ed8,#1e3a8a); }
    .chip-amber{ background:linear-gradient(180deg,#d97706,#92400e); }
    .chip-emerald{ background:linear-gradient(180deg,#059669,#065f46); }
    .chip-slate{ background:linear-gradient(180deg,#1f2937,#0f172a); }
    .chip-black{ background:linear-gradient(180deg,#111827,#0b0f14); } /* added for ₱500 */
    .chip-outline{ border:1px solid rgba(250,204,21,.45); }

    /* ==========================================================
       6) BADGES / STATUS CHIPS
    ========================================================== */
    .result-3d { perspective:900px; display:inline-block; }
    .badge-3d { display:inline-flex; align-items:center; justify-content:center; min-width:72px; padding:6px 10px; border-radius:12px; font-weight:900; letter-spacing:.6px; transform-style:preserve-3d; transform:rotateX(0deg) translateZ(8px); box-shadow:0 14px 24px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.25); border:1px solid rgba(255,255,255,.22); position:relative; user-select:none; text-shadow:0 1px 0 rgba(0,0,0,.45), 0 6px 14px rgba(0,0,0,.45); transition: transform .18s ease, filter .18s ease, box-shadow .18s ease; }
    .badge-3d::before { content:""; position:absolute; inset:0; border-radius:inherit; pointer-events:none; background: radial-gradient(120% 80% at 10% -30%, rgba(255,255,255,.35), rgba(255,255,255,0) 60%), var(--gloss); transform: translateZ(12px); }
    .badge-3d:hover{ transform: rotateX(6deg) translateZ(12px); filter:saturate(1.08); box-shadow:0 18px 30px rgba(0,0,0,.5), inset 0 1px 2px rgba(255,255,255,.28); }
    .badge-win{ background: linear-gradient(180deg,#16a34a,#065f46); color:#fff; }
    .badge-lose{ background: linear-gradient(180deg,#991b1b,#3f0d0d); color:#ffd0d0; }
    .badge-pending{ background: linear-gradient(180deg,#374151,#111827); color:#e5e7eb; }

    .side-3d { perspective:900px; display:inline-block; }
    .side-badge{ display:inline-flex; align-items:center; justify-content:center; min-width:80px; padding:6px 12px; border-radius:12px; font-weight:900; letter-spacing:.6px; transform-style:preserve-3d; transform:rotateX(0deg) translateZ(10px); border:1px solid rgba(255,255,255,.22); box-shadow:0 14px 24px rgba(0,0,0,.5), inset 0 1px 2px rgba(255,255,255,.22); text-shadow:0 1px 0 rgba(0,0,0,.55), 0 8px 16px rgba(0,0,0,.55); position:relative; user-select:none; transition:transform .18s, filter .18s, box-shadow .18s; }
    .side-badge::before{ content:""; position:absolute; inset:0; border-radius:inherit; pointer-events:none; background: radial-gradient(120% 80% at 10% -30%, rgba(255,255,255,.32), rgba(255,255,255,0) 60%), var(--gloss); transform: translateZ(14px); }
    .side-badge:hover{ transform: rotateX(6deg) translateZ(14px); filter:saturate(1.08); box-shadow:0 18px 32px rgba(0,0,0,.55), inset 0 1px 2px rgba(255,255,255,.28); }
    .side-meron{ background: linear-gradient(180deg,#ef4444,#7f1d1d); color:#fff; }
    .side-wala { background: linear-gradient(180deg,#3b82f6,#1e3a8a); color:#eaf2ff; }

    /* ==========================================================
       7) LOGROHAN (HOLLOW RINGS)
    ========================================================== */
    .logro-zone { perspective:1100px; overflow:visible; }
    .logro-rail { position:relative; transform-style:preserve-3d; transform-origin:bottom center; transition: transform .25s ease, box-shadow .25s ease; padding:12px 10px 18px; background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02)); border:1px solid rgba(255,255,255,.10); border-radius:14px; box-shadow:0 20px 40px rgba(0,0,0,.45), inset 0 4px 10px rgba(255,255,255,.04); will-change:transform; }
    .logro-rail:hover { transform:rotateX(0deg) translateY(0); box-shadow:0 16px 28px rgba(0,0,0,.38), inset 0 4px 10px rgba(255,255,255,.05); }
    .logro-rail::before { content:""; position:absolute; inset:0; border-radius:14px; background:radial-gradient(120% 80% at 0% -30%, rgba(255,255,255,.18), transparent 60%); mix-blend-mode:screen; pointer-events:none; transform:translateZ(1px); }
    .logro-rail::after  { content:""; position:absolute; left:6px; right:6px; bottom:-18px; height:26px; border-radius:20px; filter:blur(10px); background:radial-gradient(60% 100% at 50% 0%, rgba(0,0,0,.45), transparent 60%); transform:translateZ(-2px); pointer-events:none; }
    .logro-strip-3d { display:flex; gap:8px; min-height:var(--logro-rail-h); transform-style:preserve-3d; overflow-x:auto; overflow-y:visible; padding-bottom:10px; scrollbar-width:thin; scrollbar-color:rgba(255,255,255,.25) transparent; }
    .logro-strip-3d::-webkit-scrollbar{ height:8px }
    .logro-strip-3d::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.25); border-radius:8px }
    .logro-col { position:relative; display:grid; gap:2px; align-content:start; justify-items:center; min-width:calc(var(--logro-bubble) + 2px); transform-style:preserve-3d; }
    .logro-col::after { content:""; position:absolute; bottom:-6px; width:80%; height:6px; border-radius:999px; background:radial-gradient(100% 100% at 50% 50%, rgba(0,0,0,.55), rgba(0,0,0,0) 70%); transform:translateZ(-2px); pointer-events:none; }
    .ring-bubble { width:var(--logro-bubble); height:var(--logro-bubble); border-radius:9999px; background:transparent; position:relative; box-shadow: inset 0 1px 2px rgba(0,0,0,.35); border:2px solid; }
    .ring-bubble::before { content:""; position:absolute; inset:0; border-radius:inherit; background:radial-gradient(100% 100% at 30% 25%, rgba(255,255,255,.35), transparent 55%); mix-blend-mode:screen; }
    .ring-bubble::after  { content:""; position:absolute; inset:0; border-radius:inherit; border:1px solid rgba(255,255,255,.2); pointer-events:none; }
    .ring-red { border-color:#ef4444; }
    .ring-blue{ border-color:#3b82f6; }
    /* invisible gap to mirror strict-L grid spacing without changing design */
    .ring-gap { width:var(--logro-bubble); height:var(--logro-bubble); border-radius:9999px; }

    /* ==========================================================
       8) MINI BEAD ROAD (SOLID + NUMBER)
    ========================================================== */
    .bead-rail { position:relative; padding:8px; border-radius:10px; background:linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02)); border:1px solid rgba(255,255,255,.08); }
    .bead-strip{ display:flex; gap:var(--bead-gap-x); overflow-x:auto; overflow-y:hidden; scrollbar-width:thin; min-height:var(--bead-rail-h); padding-bottom:4px; }
    .bead-strip::-webkit-scrollbar{ height:6px }
    .bead-strip::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.25); border-radius:8px }
    .bead-col{ display:grid; grid-auto-rows:var(--bead-bubble); grid-template-rows:repeat(6, var(--bead-bubble)); align-content:start; gap:var(--bead-gap-y); min-width:calc(var(--bead-bubble)); justify-items:center; }
    .bead      { width:var(--bead-bubble); height:var(--bead-bubble); border-radius:9999px; background:transparent; box-shadow: inset 0 1px 2px rgba(0,0,0,.35); }
    .bead.red  { border:2px solid #ef4444; }
    .bead.blue { border:2px solid #3b82f6; }
    .bead-solid{ width:var(--bead-bubble); height:var(--bead-bubble); border-radius:9999px; display:flex; align-items:center; justify-content:center; position:relative; font-size:9px; font-weight:900; color:#fff; box-shadow: inset 0 1px 2px rgba(0,0,0,.35), inset 0 -3px 5px rgba(0,0,0,.35), 0 1px 2px rgba(0,0,0,.45); }
    .bead-solid::before{ content:""; position:absolute; inset:-1px; border-radius:inherit; background: radial-gradient(100% 100% at 30% 25%, rgba(255,255,255,.45), transparent 55%); mix-blend-mode:screen; }
    .bead-solid::after { content:""; position:absolute; inset:0; border-radius:inherit; border:1px solid rgba(255,255,255,.25); pointer-events:none; }
    .bead-solid.red  { background: radial-gradient(100% 120% at 30% 20%, #ff7a7a, #ef4444 55%, #7f1d1d 100%); border:1px solid #7f1d1d; }
    .bead-solid.blue { background: radial-gradient(100% 120% at 30% 20%, #7fb0ff, #3b82f6 55%, #1e3a8a 100%); border:1px solid #1e3a8a; }

    /* ==========================================================
       9) KEYFRAMES
    ========================================================== */
    @keyframes moveBg { 0%{transform:translate3d(0,0,0)} 50%{transform:translate3d(-2%,-2%,0)} 100%{transform:translate3d(0,-1%,0)} }
    @keyframes glow-border { 0% { box-shadow: 0 0 10px -5px rgba(255,0,0,0.8), 0 0 20px -10px rgba(255,255,0,0.8), 0 0 30px -15px rgba(0,0,255,0.8); } 50% { box-shadow: 0 0 15px -3px rgba(255,0,0,0.9), 0 0 25px -8px rgba(255,255,0,0.9), 0 0 35px -13px rgba(0,0,255,0.9); } 100% { box-shadow: 0 0 20px 0 rgba(255,0,0,1), 0 0 30px -5px rgba(255,255,0,1), 0 0 40px -10px rgba(0,0,255,1); } }
    @keyframes shineMove { 0%{background-position:0% center} 100%{background-position:200% center} }
  </style>
</head>

<body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>

  <!-- ========================================================
       HEADER
  ========================================================= -->
  <header class="glass-header sticky top-0 z-50">
    <div class="relative header-gloss">
      <div class="max-w-7xl mx-auto px-4">
        <div class="h-14 flex items-center justify-between">
          <!-- Brand -->
          <div class="flex items-center gap-3">
            <svg class="brand-logo w-8 h-8" viewBox="0 0 100 100" aria-label="Bilyaran logo">
              <path d="M50 10 L90 80 H10 Z" fill="none" stroke="#10b981" stroke-width="8" />
              <rect x="58" y="14" width="8" height="42" rx="2" fill="#f59e0b" transform="rotate(35 62 35)"/>
              <circle cx="84" cy="40" r="4" fill="#10b981" />
              <circle cx="50" cy="50" r="22" fill="#0b0f14" stroke="#10b981" stroke-width="3"/>
              <circle cx="50" cy="50" r="12" fill="#ffffff"/>
              <text x="50" y="54" text-anchor="middle" font-size="12" font-weight="700" fill="#0b0f14">8</text>
            </svg>
            <div class="leading-tight">
              <div class="text-sm uppercase tracking-widest text-white/70">BILYARAN</div>
            </div>
          </div>

          <!-- Nav -->
          <nav class="hidden md:flex items-center gap-4 text-sm text-gray-200">
            <a href="/dashboard" class="px-3 py-1.5 rounded-lg hover:bg-white/10 transition">Home</a>
            <a href="#" class="px-3 py-1.5 rounded-lg hover:bg-white/10 transition">Matches</a>
            <a href="#" class="px-3 py-1.5 rounded-lg hover:bg-white/10 transition">Support</a>
          </nav>

          <!-- Right actions -->
          <div class="flex items-center gap-2 relative">
            <div class="hidden sm:flex items-center gap-1 px-2 py-1 rounded-full border border-yellow-300/30 bg-yellow-500/10">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 opacity-90" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3 5 5 3-5 3-3 5-3-5-5-3 5-3 3-5z"/></svg>
              <span id="header-balance" class="text-xs font-bold">—</span>
            </div>

            <button class="relative p-2 rounded-lg hover:bg-white/10 transition" aria-label="Notifications">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 18.75a1.5 1.5 0 11-3 0m8.25-1.5H4.5l1.2-1.2a2.25 2.25 0 00.66-1.59V10.5a5.25 5.25 0 1110.5 0v2.46c0 .6.24 1.18.66 1.6l1.29 1.19z"/>
              </svg>
              <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-gray-900"></span>
            </button>

            <!-- History -->
            <div class="relative">
              <button id="header-history-btn" class="relative p-2 rounded-lg hover:bg-white/10 transition" aria-label="Bet History">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-90" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M7 4h10a2 2 0 012 2v1H5V6a2 2 0 012-2zm-2 5h14v9a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm4 2v2h6v-2H9z"/>
                </svg>
                <span id="header-history-dot" class="hidden absolute -top-0.5 -right-0.5 w-2 h-2 bg-yellow-400 rounded-full ring-2 ring-gray-900"></span>
              </button>

              <div id="header-history-menu" class="menu-card absolute right-0 mt-2 w-80 p-2 hidden">
                <div class="px-3 py-2 flex items-center justify-between">
                  <div>
                    <div class="text-xs opacity-70">Recent Bets</div>
                    <div class="text-sm font-bold">Last 8</div>
                  </div>
                  <button id="header-history-clear" class="text-[11px] px-2 py-1 rounded bg-gray-800/70 border border-white/10 hover:bg-gray-700">Clear</button>
                </div>
                <div id="header-history-empty" class="px-3 pb-2 text-xs text-white/60 italic">No bets yet.</div>
                <div id="header-history-list" class="max-h-72 overflow-auto divide-y divide-white/10 hidden"></div>
              </div>
            </div>

            <!-- Account -->
            <div class="relative">
              <button id="account-btn" class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-white/10 transition">
                <div class="text-left">
                  <div class="text-[11px] leading-tight opacity-80 hidden sm:block">Signed in as</div>
                  <div id="account-name" class="shine-3d text-base leading-tight">Account Name</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.206l3.71-3.975a.75.75 0 111.08 1.04l-4.24 4.54a.75.75 0 01-1.08 0l-4.24-4.54a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
              </button>
              <div id="account-menu" class="menu-card absolute right-0 mt-2 w-56 p-2 hidden">
                <div class="px-3 py-2">
                  <div class="text-xs opacity-70">Logged in as</div>
                  <div class="shine-3d text-lg" id="account-name-menu">Account Name</div>
                </div>
                <hr class="border-white/10 my-1" />
                <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10 text-sm"><span>Profile</span></a>
                <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10 text-sm"><span>Settings</span></a>
                <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10 text-sm text-red-300"><span>Logout</span></a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </header>

  <!-- ========================================================
       MAIN: [slideL | video+logro | bets | slideR]
  ========================================================= -->
  <main class="max-w-7xl mx-auto p-4">
    <div class="grid gap-4 md:grid-cols-[180px_minmax(0,1fr)_360px_180px]">

      <!-- LEFT SLIDE -->
      <div class="hidden md:block">
        <div class="w-full h-[600px] side-panel rounded-lg overflow-hidden relative">
          <img id="left-slide-desktop" class="w-full h-full object-cover transition-all duration-700" src="" alt="slide left">
        </div>
      </div>

      <!-- CENTER: Video + Logrohan -->
      <div class="relative z-10 main-panel p-4 rounded-lg shadow-lg">
        <!-- Match header -->
        <div class="grid grid-cols-3 items-center mb-3 text-sm text-gray-300">
          <div id="event-date" class="text-left"></div>
          <div class="text-center font-bold text-yellow-400 text-lg">MATCH# <span id="match-no">—</span></div>
          <div id="event-time" class="text-right"></div>
        </div>

        <!-- Video -->
        <div class="mb-4 relative">
          <div class="relative aspect-video">
            <div class="absolute inset-0 rounded-xl overflow-hidden z-10">
              <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 animate-[pulse_4s_infinite] mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20 mix-blend-overlay animate-[glow-border_2s_ease-in-out_infinite_alternate]"></div>
            </div>
            <iframe id="youtube-video-main" class="w-full h-64 md:h-[250px] rounded-lg relative z-20 border-4 border-transparent" src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          </div>
        </div>

        <!-- LOGROHAN -->
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>

          <div class="flex items-center gap-2 mb-2">
            <button id="btn-win-meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-xs font-bold hover:bg-red-700">+ Red win</button>
            <button id="btn-win-wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-xs font-bold hover:bg-blue-700">+ Blue win</button>
            <button id="btn-undo"      class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-xs hover:bg-gray-700">Undo</button>
            <button id="btn-clear"     class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-xs hover:bg-gray-800">Clear</button>
          </div>

          <div id="logro-rail" class="logro-rail">
            <div id="logro-strip" class="logro-strip-3d"></div>
          </div>
        </div>
        <!-- /LOGROHAN -->
      </div>

      <!-- RIGHT: Bet cards + Bet Amount -->
      <aside class="hidden md:block">
        <div class="sticky mt-12 space-y-3">
          <!-- Cards -->
          <div id="bet-area" class="bet-area grid grid-cols-2 gap-3 mt-0 mb-0 translate-y-2">
            <!-- Meron -->
            <div class="bet-card red tilt text-center">
              <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">R</span></div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name"></div>
              <div class="amount-3d text-3xl md:text-4xl mt-1" id="meron-amount"></div>
              <div class="mt-">
                <div class="mt-2"><span class="odds-ribbon" id="meron-odds"></span></div>
                <button class="bet-btn red mt-2 w-full px-3 py-2 text-sm" id="bet-meron">BET</button>
                <div id="meron-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
              </div>
            </div>
            <!-- Wala -->
            <div class="bet-card blue tilt text-center">
              <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">B</span></div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player2-name"></div>
              <div class="amount-3d text-3xl md:text-4xl mt-1" id="wala-amount"></div>
              <div class="mt-3">
                <div class="mt-2"><span class="odds-ribbon" id="wala-odds"></span></div>
                <button class="bet-btn blue mt-2 w-full px-3 py-2 text-sm" id="bet-wala">BET</button>
                <div id="wala-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
              </div>
            </div>
          </div>

          <!-- Bet Amount + MINI ROAD -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-0">
            <div class="flex items-center justify-between mb-2">
              <div class="text-[15px] uppercase tracking-widest text-white/70">Bet Amount</div>
              <div class="text-[15px] text-white/60">min ₱100</div>
            </div>

            <div class="flex flex-wrap items-center gap-2 mb-2">
              <input type="number" id="bet-amount" class="bet-input p-2 text-sm text-white bg-black/30 w-[160px]" placeholder="Enter amount" inputmode="numeric" />
              <div class="balance-pill text-yellow-300">
                <!-- gem icon -->
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
                  <g opacity=".95">
                    <polygon points="32,14 34,20 40,22 34,24 32,30 30,24 24,22 30,20" fill="url(#spark)" opacity=".85">
                      <animateTransform attributeName="transform" type="rotate" from="-10 32 22" to="10 32 22" dur="1.8s" repeatCount="indefinite" />
                      <animate attributeName="opacity" values="0.2;1;0.2" dur="1.8s" repeatCount="indefinite"/>
                    </polygon>
                    <polygon points="46,32 47,34 50,35 47,36 46,38 45,36 42,35 45,34" fill="#ffffff" opacity=".9">
                      <animateTransform attributeName="transform" type="scale" values="1;1.4;1" dur="1.6s" repeatCount="indefinite" additive="sum"/>
                      <animate attributeName="opacity" values="0.3;0.9;0.3" dur="1.6s" repeatCount="indefinite"/>
                    </polygon>
                  </g>
                </svg>
                <span class="text-[11px] opacity-80 tracking-widest"></span>
                <span id="mid-balance" class="amount text-base">5,000</span>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-1 mb-2">
              <button class="chip3d chip-emerald chip-outline text-sm bet-chip" data-val="100">♦100</button>
              <button class="chip3d chip-blue chip-outline text-sm bet-chip" data-val="200">♦200</button>
              <button class="chip3d chip-black chip-outline text-sm bet-chip" data-val="500">♦500</button>
              <button class="chip3d chip-amber chip-outline text-sm bet-chip" data-val="1000">♦1000</button>
            </div>

            <!-- MINI ROAD -->
            <div>
              <div class="flex items-center justify-between mb-1">
                <div class="text-[11px] uppercase tracking-widest text-white/70">Road</div>
                <div class="flex items-center gap-2 text-[10px]">
                  <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
                  <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
                </div>
              </div>
              <div class="bead-rail">
                <div id="bead-strip" class="bead-strip"></div>
              </div>
            </div>
            <!-- /MINI ROAD -->
          </div>
        </div>
      </aside>

      <!-- RIGHT SLIDE -->
      <div class="hidden md:block">
        <div class="w-full h-[600px] side-panel rounded-lg overflow-hidden relative">
          <img id="right-slide-desktop" class="w-full h-full object-cover transition-all duration-700" src="" alt="slide right">
        </div>
      </div>

      <!-- MOBILE STACK -->
      <div class="md:hidden space-y-3 col-span-4">
        <div class="w-full h-40 side-panel rounded-lg overflow-hidden">
          <img id="left-slide-mobile" class="w-full h-full object-cover transition-all duration-700" src="" alt="slide L">
        </div>
        <div class="w-full h-40 side-panel rounded-lg overflow-hidden">
          <img id="right-slide-mobile" class="w-full h-full object-cover transition-all duration-700" src="" alt="slide R">
        </div>

        <!-- Mobile bet cards -->
        <div class="bet-area grid grid-cols-2 gap-2">
          <div class="bet-card red text-center">
            <div class="name-chip text-xl">R</div>
            <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name-mob"></div>
            <div class="amount-3d text-3xl mt-1" id="meron-amount-mob"></div>
            <div class="mt-2"><span class="odds-ribbon" id="meron-odds-mob"></span></div>
          </div>
          <div class="bet-card blue text-center">
            <div class="name-chip text-xl">B</div>
            <div class="mt-2 text-sm font-semibold opacity-90" id="player2-name-mob"></div>
            <div class="amount-3d text-3xl mt-1" id="wala-amount-mob"></div>
            <div class="mt-2"><span class="odds-ribbon" id="wala-odds-mob"></span></div>
          </div>
        </div>

        <!-- Mobile logrohan -->
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text:[10px] text-[10px]">
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

  <!-- ========================================================
       SCRIPT: Grouped by purpose (logic swap only)
  ========================================================= -->
  <script>
    // ----------------------------------------------------------
    // A) CONFIG / CONSTANTS
    // ----------------------------------------------------------
    const players = [
      "Efren Reyes","Earl Strickland","Ronnie O'Sullivan","Shane Van Boening",
      "Francisco Bustamante","Alex Pagulayan","Jeanette Lee","Karen Corr",
      "Allison Fisher","Johnny Archer","Mika Immonen","Niels Feijen",
      "Darren Appleton","Ko Pin-Yi","Wu Jiaqing"
    ];
    const slides = [
      "https://i.ibb.co/jPjC9YqC/raga.jpg","https://i.ibb.co/fd26jLNQ/de-luna.webp",
      "https://i.ibb.co/TBS7P8Cd/mika.jpg","https://i.ibb.co/4nMYxQFp/biado.jpg",
      "https://i.ibb.co/7dSvjwRK/amoroto.jpg","https://i.ibb.co/Q7cQ30tS/efren.webp"
    ];
    const BIGROAD_MAX_ROWS = 8;   // ilalim ng video
    const BEAD_MAX_ROWS    = 6;   // sidebar mini road

    // ----------------------------------------------------------
    // B) STATE
    // ----------------------------------------------------------
    let slideIndex = 0;
    let results = [];
    let meronAmount, walaAmount, meronOdds, walaOdds;
    let currentBalance = 500000;
    const betHistory = [];

    // ----------------------------------------------------------
    // C) SMALL DOM / UTILS
    // ----------------------------------------------------------
    function setSrcIf(el, src){ if(el) el.src = src; }
    function updateSlides(){
      const a = slides[slideIndex];
      const b = slides[(slideIndex+3)%slides.length];
      setSrcIf(document.getElementById("left-slide-desktop"), a);
      setSrcIf(document.getElementById("right-slide-desktop"), b);
      setSrcIf(document.getElementById("left-slide-mobile"), a);
      setSrcIf(document.getElementById("right-slide-mobile"), b);
      slideIndex=(slideIndex+1)%slides.length;
    }
    setInterval(updateSlides,3000);

    function getRandomPlayer(exclude){ let name; do{ name = players[Math.floor(Math.random()*players.length)]; } while(name===exclude); return name; }
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
        const x=(e.clientX-r.left)/r.width; const y=(e.clientY-r.top)/r.height;
        const rx=(y-0.5)*damp, ry=(0.5-x)*damp;
        el.style.transform=`rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
      });
      el.addEventListener('mouseleave',()=>{ el.style.transform='rotateX(0) rotateY(0) translateY(0)'; });
    }

    // ----------------------------------------------------------
    // D) ROAD HELPERS / ALGORITHMS
    // ----------------------------------------------------------
    const isEmpty = (grid, c, r) => !(grid[c] && grid[c][r]);
    const ensureCol = (grid, c) => { if(!grid[c]) grid[c] = []; };
    function streakRuns(seq){
      const out = [];
      for(const t of seq){ if(!out.length || out[out.length-1].t!==t) out.push({t, n:1}); else out[out.length-1].n++; }
      return out;
    }
    // Strict L-only builder (for Logrohan under video)
    function buildBigRoadStrictL(seq, maxRows = BEAD_MAX_ROWS){
      const runs = streakRuns(seq);
      const grid = [];
      let labelNo = 1;
      let prevRunStartCol = -1;
      for(const run of runs){
        const t = run.t; let col, row;
        if(prevRunStartCol < 0){ col = 0; row = 0; }
        else { col = prevRunStartCol + 1; row = 0; while(!isEmpty(grid, col, row)){ col++; ensureCol(grid, col); } }
        const thisRunStartCol = col;
        let placed = 0;
        while(placed < run.n && row < maxRows && isEmpty(grid, col, row)){
          ensureCol(grid, col); grid[col][row] = { t, label: labelNo++ }; placed++; row++;
        }
        const lockRow = Math.max(0, row - 1);
        let remain = run.n - placed; let c = col + 1;
        while(remain > 0){ ensureCol(grid, c); if(isEmpty(grid, c, lockRow)){ grid[c][lockRow] = { t, label: labelNo++ }; remain--; } c++; }
        prevRunStartCol = thisRunStartCol;
      }
      return grid;
    }
    // (OLD) Continuous column splitter by runs — kept for reference
    function computeColumnsContinuous(seq, maxRows){
      const runs = streakRuns(seq); const cols=[]; let labelNo=1;
      for(const run of runs){ let left=run.n; while(left>0){ const take=Math.min(maxRows,left); const col=[]; for(let i=0;i<take;i++) col.push({t:run.t,label:labelNo++}); cols.push(col); left-=take; } }
      return cols;
    }
    // ⭐ NEW: Pure sequential chunking (fills top→bottom to maxRows, then next column)
    function computeColumnsSequential(seq, maxRows){
      const cols=[]; let col=[]; let labelNo=1;
      for(const t of seq){
        col.push({ t, label: labelNo++ });
        if(col.length === maxRows){ cols.push(col); col=[]; }
      }
      if(col.length) cols.push(col);
      return cols;
    }

    // ----------------------------------------------------------
    // E) RENDERERS
    // ----------------------------------------------------------
    // 1) LOGROHAN (under video): keep Strict-L logic, rings visual
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
            b.className=`ring-bubble ${cell.t==='R'?'ring-red':'ring-blue'}`;
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
      strip.scrollLeft = strip.scrollWidth;
    }

    // 2) MINI ROAD (under Bet Amount): ⭐ now uses sequential filling (not runs)
    function renderRoadStrictL(seq, stripId, maxRows = BEAD_MAX_ROWS){
      // const cols = computeColumnsContinuous(seq, maxRows); // OLD
      const cols = computeColumnsSequential(seq, maxRows);   // NEW: tuloy-tuloy pababa
      const strip = document.getElementById(stripId); if(!strip) return; strip.innerHTML='';
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
      strip.scrollLeft = strip.scrollWidth;
    }

    // Master render
    function renderAllRoads(seq){
      renderLogroContinuous(seq, 'logro-strip', BIGROAD_MAX_ROWS);       // video area
      renderLogroContinuous(seq, 'logro-strip-mob', BIGROAD_MAX_ROWS);   // mobile video area
      renderRoadStrictL(seq, 'bead-strip', BEAD_MAX_ROWS);               // mini road beside bet amount (sequential)
    }

    // ----------------------------------------------------------
    // F) BETTING / BALANCE / ODDS
    // ----------------------------------------------------------
    function computeOdds(){ meronOdds=(Math.random()*(2.0-1.5)+1.5).toFixed(2); walaOdds=(parseFloat(meronOdds)+0.20).toFixed(2); }
    function renderOddsEverywhere(){
      const m=document.getElementById('meron-odds'); if(m) m.textContent='PAYOUT = '+meronOdds;
      const w=document.getElementById('wala-odds');  if(w) w.textContent='PAYOUT = '+walaOdds;
      const mm=document.getElementById('meron-odds-mob'); if(mm) mm.textContent='PAYOUT = '+meronOdds;
      const ww=document.getElementById('wala-odds-mob');  if(ww) ww.textContent='PAYOUT = '+walaOdds;
    }
    function renderBalance(){ const mid=document.getElementById('mid-balance'); const head=document.getElementById('header-balance'); if(mid) mid.textContent=Number(currentBalance).toLocaleString(); if(head) head.textContent=Number(currentBalance).toLocaleString(); }
    function adjustBalance(delta){ const next=currentBalance+delta; if(next<0) return false; currentBalance=next; renderBalance(); return true; }

    // ----------------------------------------------------------
    // G) HISTORY UI
    // ----------------------------------------------------------
    function sideBadgeHTML(side){ const cls=side==='MERON'?'side-badge side-meron':'side-badge side-wala'; return `<span class="side-3d"><span class="${cls}">${side}</span></span>`; }
    function badgeClassByStatus(s){ if(s==='WIN') return 'badge-3d badge-win'; if(s==='LOSE') return 'badge-3d badge-lose'; return 'badge-3d badge-pending'; }
    function addToHistory(entry){ betHistory.unshift(entry); renderHeaderHistory(); const dot=document.getElementById('header-history-dot'); if(dot) dot.classList.toggle('hidden', betHistory.length===0); }
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

    // ----------------------------------------------------------
    // H) BET ACTIONS
    // ----------------------------------------------------------
    function resolveLatestBet(winSide){
      const idx=betHistory.findIndex(b=>b.status==='PENDING'); if(idx===-1) return; const bet=betHistory[idx];
      if(bet.side===winSide){ bet.status='WIN'; adjustBalance(parseFloat(bet.payout)); bet.balanceAfter=currentBalance; }
      else { bet.status='LOSE'; bet.balanceAfter=currentBalance; }
      renderHeaderHistory();
    }
    function placeBet(betType){
      const input=document.getElementById('bet-amount'); let betAmount=parseFloat(input.value);
      if(isNaN(betAmount)||betAmount<=0){ alert('Please enter a valid bet amount greater than 0.'); return; }
      let odds, chosenPlayer;
      if(betType==='MERON'){ odds=meronOdds; chosenPlayer=document.getElementById('player1-name').textContent; }
      else { odds=walaOdds; chosenPlayer=document.getElementById('player2-name').textContent; }
      const balanceBefore=currentBalance; if(!adjustBalance(-betAmount)){ alert('Insufficient balance.'); return; }
      if(betType==='MERON'){ meronAmount+=betAmount; document.getElementById('meron-amount').textContent=meronAmount.toLocaleString(); }
      else { walaAmount+=betAmount; document.getElementById('wala-amount').textContent=walaAmount.toLocaleString(); }
      let totalWinnings=parseFloat(betAmount)*parseFloat(odds);
      if(betType==='MERON'){ document.getElementById('meron-result').textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`; document.getElementById('wala-result').textContent=""; }
      else { document.getElementById('wala-result').textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`; document.getElementById('meron-result').textContent=""; }
      const matchId=document.getElementById('match-no').textContent||'—'; const time=new Date().toLocaleString('en-PH',{hour12:true});
      addToHistory({ side:betType, player:chosenPlayer||(betType==='MERON'?'Red':'Blue'), matchId, amount:betAmount, odds:odds, payout:totalWinnings.toFixed(2), time, balanceBefore, balanceAfter:currentBalance, status:'PENDING' });
      alert(`You placed a bet of ${betAmount} on ${chosenPlayer}.
Possible payout: ${totalWinnings.toFixed(2)}.
New Balance: ${currentBalance.toLocaleString()}.`);
    }
    function pushResult(side){ results.push(side==='MERON'?'R':'B'); renderAllRoads(results); resolveLatestBet(side); }
    function undoResult(){ results.pop(); renderAllRoads(results); }
    function clearResults(){ results=[]; renderAllRoads(results); }

    // ----------------------------------------------------------
    // I) INIT
    // ----------------------------------------------------------
    window.onload = () => {
      setDateTime();
      setRandomMatch();
      // seed amounts + odds
      let meronAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      let walaAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      meronAmount=meronAmountInit; walaAmount=walaAmountInit;
      computeOdds(); renderOddsEverywhere();
      const ma=document.getElementById('meron-amount'); if(ma) ma.textContent=meronAmount.toLocaleString();
      const wa=document.getElementById('wala-amount');  if(wa) wa.textContent=walaAmount.toLocaleString();
      const mam=document.getElementById('meron-amount-mob'); if(mam) mam.textContent=meronAmount.toLocaleString();
      const wam=document.getElementById('wala-amount-mob');  if(wam) wam.textContent=walaAmount.toLocaleString();

      updateSlides();
      document.querySelectorAll('.tilt').forEach(attachTilt);

      // account name
      const name='AMOK';
      const acct=document.getElementById('account-name'); if(acct) acct.textContent=name;
      const acctm=document.getElementById('account-name-menu'); if(acctm) acctm.textContent=name;

      // account menu toggle
      const btn=document.getElementById('account-btn');
      const menu=document.getElementById('account-menu');
      if(btn && menu){
        btn.addEventListener('click',()=>{ menu.classList.toggle('hidden'); });
        document.addEventListener('click',(e)=>{ if(!btn.contains(e.target)&&!menu.contains(e.target)) menu.classList.add('hidden'); });
      }

      // logro buttons
      document.getElementById('btn-win-meron').addEventListener('click', ()=> pushResult('MERON'));
      document.getElementById('btn-win-wala').addEventListener('click',  ()=> pushResult('WALA'));
      document.getElementById('btn-undo').addEventListener('click',  undoResult);
      document.getElementById('btn-clear').addEventListener('click', clearResults);

      // seed para makita agad ang pattern
      results=['R','R','R','R','R','R','R','R','R','B','B','B','B','B','B','B','B','R','R','R','R','R','R','R'];
      renderAllRoads(results);
      renderBalance();

      // header history
      const hBtn=document.getElementById('header-history-btn');
      const hMenu=document.getElementById('header-history-menu');
      const hClear=document.getElementById('header-history-clear');
      hBtn.addEventListener('click',(e)=>{ e.stopPropagation(); hMenu.classList.toggle('hidden'); });
      hClear.addEventListener('click',()=>{ betHistory.length=0; renderHeaderHistory(); const dot=document.getElementById('header-history-dot'); if(dot) dot.classList.add('hidden'); });

      // quick amount chips
      document.querySelectorAll('.bet-chip').forEach(btn=>{
        btn.addEventListener('click',()=>{ const raw=parseInt(btn.dataset.val||'0',10); const amt=document.getElementById('bet-amount'); if(amt) amt.value=raw; btn.animate([{transform:'translateY(-3px)'},{transform:'translateY(0)'}],{duration:120}); });
      });

      // bet buttons
      document.getElementById('bet-meron').addEventListener('click', ()=> placeBet('MERON'));
      document.getElementById('bet-wala').addEventListener('click',  ()=> placeBet('WALA'));
    };
  </script>
</body>
</html>
