{{-- resources/views/billiard.blade.php --}}
<x-layouts.app :title="__('Billiard')">
  <head>
  <style>
    :root{
      --gloss: linear-gradient(to bottom, rgba(255,255,255,.28), rgba(255,255,255,0) 45%);
      --inner-shadow: inset 0 1px 2px rgba(0,0,0,.35), inset 0 -2px 4px rgba(0,0,0,.25);
      --card-radius: 18px;
      --logro-bubble: 22px;
      --logro-step: 10px;
      --logro-rail-h: 48px;

      /* Mini bead road (vertical columns) */
      --bead-bubble: 18px;   /* readable numbers */
      --bead-gap-x: 6px;     /* gap between columns */
      --bead-gap-y: 4px;     /* gap between rows */
      --bead-rows: 8;        /* 1..8 per column → 9th goes next column */
    }

    html, body { margin:0; padding:0; height:100%; overflow-x:hidden; }

    .bg-animated{
      position:fixed; top:0; left:0; width:110%; height:110%;
      background:url('https://i.ibb.co/NdjyN48p/download.jpg') center/cover no-repeat;
      opacity:.85; z-index:-1; animation:moveBg 30s infinite alternate ease-in-out; will-change:transform;
    }
    @keyframes moveBg{
      0%{transform:translate3d(0,0,0)}
      50%{transform:translate3d(-2%,-2%,0)}
      100%{transform:translate3d(0,-1%,0)}
    }
    @keyframes glow-border {
      0%   { box-shadow:0 0 10px -6px rgba(16,185,129,.9), 0 0 24px -10px rgba(239,68,68,.8), 0 0 28px -12px rgba(59,130,246,.8); }
      50%  { box-shadow:0 0 16px -4px rgba(16,185,129,1), 0 0 28px -9px rgba(239,68,68,.9), 0 0 34px -10px rgba(59,130,246,.9); }
      100% { box-shadow:0 0 20px -2px rgba(16,185,129,1), 0 0 32px -8px rgba(239,68,68,1), 0 0 40px -9px rgba(59,130,246,1); }
    }

    .bet-area{ perspective:1200px; }
    .bet-card{
      position:relative; border-radius:var(--card-radius); overflow:hidden; padding:14px; color:#fff;
      transform-style:preserve-3d; will-change:transform, box-shadow;
      transition:transform .2s, box-shadow .2s, filter .2s;
      border:1px solid rgba(255,255,255,.12); backdrop-filter:saturate(120%) blur(2px);
      box-shadow:0 18px 30px rgba(0,0,0,.35), 0 4px 10px rgba(0,0,0,.35);
    }
    .bet-card::before{
      content:""; position:absolute; inset:0;
      background: radial-gradient(100% 60% at -10% -10%, rgba(255,255,255,.35), rgba(255,255,255,0) 60%), var(--gloss);
      mix-blend-mode:screen; pointer-events:none; transform:translateZ(20px);
    }
    .bet-card::after{
      content:""; position:absolute; left:8%; right:8%; bottom:0; height:2px;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent); filter:blur(.5px);
      transform:translateZ(22px); opacity:.7;
    }
    .bet-card:hover{ transform:translateY(-6px) scale(1.01); filter:saturate(110%); }

    .bet-card.compact{ padding:10px !important; }
    .bet-card.compact .name-chip{ padding:1px 10px !important; font-size:.95rem !important; }
    .bet-card.compact .amount-3d{ font-size:1.6rem !important; line-height:1.2 !important; }
    .bet-card.compact .odds-ribbon{ padding:4px 8px !important; font-size:.8rem !important; }
    .bet-card.compact .bet-btn{ padding:.4rem .5rem !important; font-size:.85rem !important; }

    #bet-area.bet-area{ gap:.5rem !important; }

    .bet-card.green{
      background:
        radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%),
        linear-gradient(180deg,#10b981 0%,#047857 55%,#064e3b 100%);
      box-shadow:0 18px 32px rgba(16,185,129,.45), 0 8px 18px rgba(0,0,0,.45);
    }
    .bet-card.red{
      background:
        radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%),
        linear-gradient(180deg,#ef4444 0%,#b91c1c 55%,#7f1d1d 100%);
      box-shadow:0 18px 32px rgba(185,28,28,.45), 0 8px 18px rgba(0,0,0,.45);
    }
    .bet-card.blue{
      background:
        radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%),
        linear-gradient(180deg,#3b82f6 0%,#1d4ed8 55%,#1e3a8a 100%);
      box-shadow:0 18px 32px rgba(29,78,216,.45), 0 8px 18px rgba(0,0,0,.45);
    }

    .name-chip{
      display:inline-block; padding:6px 12px; border-radius:9999px; font-weight:900; letter-spacing:.3px;
      background:rgba(0,0,0,.25); box-shadow:var(--inner-shadow); transform:translateZ(24px);
    }
    .amount-3d{
      font-weight:900; text-shadow:0 2px 0 rgba(0,0,0,.35), 0 8px 18px rgba(0,0,0,.35); transform:translateZ(26px);
    }
    .odds-ribbon{
      display:inline-block; padding:6px 12px; border-radius:10px; font-weight:800; background:rgba(0,0,0,.25);
      border:1px solid rgba(255,255,255,.12); box-shadow:var(--inner-shadow); transform:translateZ(22px);
    }
    .bet-input{
      border-radius:12px; border:1px solid rgba(255,255,255,.18); outline:none; box-shadow:var(--inner-shadow);
      transition:transform .15s, box-shadow .15s; transform:translateZ(18px); background:rgba(0,0,0,.35);
    }
    .bet-input:focus{ box-shadow:inset 0 2px 4px rgba(0,0,0,.3), 0 0 0 3px rgba(255,255,255,.08); transform:translateZ(20px); }

    .bet-btn{
      border-radius:12px; font-weight:900; letter-spacing:.5px; border:1px solid rgba(255,255,255,.18);
      box-shadow:0 10px 18px rgba(0,0,0,.35), inset 0 1px 2px rgba(255,255,255,.25);
      transition:transform .12s, box-shadow .12s, filter .12s; transform:translateZ(24px);
    }
    .bet-btn:hover{ filter:brightness(1.05); }
    .bet-btn:active{ transform:translateZ(20px) translateY(2px); box-shadow:0 6px 12px rgba(0,0,0,.35), inset 0 2px 4px rgba(0,0,0,.35); }
    .bet-btn.green{ background:linear-gradient(180deg,#047857 0%,#064e3b 100%); }
    .bet-btn.red{ background:linear-gradient(180deg,#b91c1c 0%,#7f1d1d 100%); }
    .bet-btn.blue{ background:linear-gradient(180deg,#1d4ed8 0%,#1e3a8a 100%); }

    .result-glow{ text-shadow:0 0 10px rgba(250,204,21,.55); }
    .tilt{ transform:rotateX(0) rotateY(0); transition:transform .12s; }

    .side-panel{ background:rgba(6,10,8,.45); }
    .main-panel{ background:rgba(6,10,8,.65); }

    .glass-header{
      background:linear-gradient(to right, rgba(6,10,8,.75), rgba(6,10,8,.55));
      backdrop-filter:blur(8px) saturate(120%);
      border-bottom:1px solid rgba(255,255,255,.12);
    }
    .header-gloss:before{
      content:""; position:absolute; inset:0;
      background:radial-gradient(120% 80% at -10% -40%, rgba(255,255,255,.25), rgba(255,255,255,0) 60%); pointer-events:none;
    }

    .menu-card{
      background:rgba(3,7,5,.96); border:1px solid rgba(255,255,255,.12);
      border-radius:14px; box-shadow:0 18px 30px rgba(0,0,0,.35);
    }
    .shine-3d{
      font-weight:900; letter-spacing:.3px;
      background:linear-gradient(90deg, rgba(255,255,255,.75) 0%, #ffffff 25%, #b7ffdf 45%, #ffffff 60%, rgba(255,255,255,.75) 100%);
      background-size:200% auto; -webkit-background-clip:text; background-clip:text; color:transparent;
      animation:shineMove 2.6s linear infinite;
      text-shadow:0 1px 0 rgba(0,0,0,.35), 0 2px 0 rgba(0,0,0,.35), 0 8px 18px rgba(0,0,0,.5), 0 0 18px rgba(16,185,129,.35);
    }
    @keyframes shineMove{ 0%{background-position:0% center} 100%{background-position:200% center} }
    .brand-logo{ filter:drop-shadow(0 0 8px rgba(16,185,129,.75)); }

    .balance-pill{
      display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:9999px;
      background:rgba(16,185,129,.12); border:1px solid rgba(16,185,129,.45); box-shadow:var(--inner-shadow);
      backdrop-filter: blur(2px) saturate(120%); transform: translateZ(24px);
    }
    .balance-pill .amount{ font-weight:900; letter-spacing:.5px; text-shadow:0 1px 0 rgba(0,0,0,.35), 0 8px 16px rgba(0,0,0,.35); }

    /* ======= Big Logro (below video) – pa-L grid (existing) ======= */
    .logro-zone{ perspective:1100px; overflow:visible; }
    .logro-rail{
      position:relative; transform-style:preserve-3d; transform-origin:bottom center;
      transition:transform .25s ease, box-shadow .25s ease; padding:12px 10px 18px 10px;
      background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
      border:1px solid rgba(255,255,255,.10); border-radius:14px;
      box-shadow:0 20px 40px rgba(0,0,0,.45), inset 0 4px 10px rgba(255,255,255,.04); will-change:transform;
    }
    .logro-rail:hover{ transform:rotateX(0deg) translateY(0); box-shadow:0 16px 28px rgba(0,0,0,.38), inset 0 4px 10px rgba(255,255,255,.05); }
    .logro-rail::before{
      content:""; position:absolute; inset:0; border-radius:14px;
      background:radial-gradient(120% 80% at 0% -30%, rgba(255,255,255,.18), transparent 60%);
      mix-blend-mode:screen; pointer-events:none; transform:translateZ(1px);
    }
    .logro-rail::after{
      content:""; position:absolute; left:6px; right:6px; bottom:-18px; height:26px; border-radius:20px;
      filter:blur(10px); background:radial-gradient(60% 100% at 50% 0%, rgba(0,0,0,.45), transparent 60%);
      transform:translateZ(-2px); pointer-events:none;
    }
    .logro-strip-3d{
      display:flex; gap:8px; min-height:var(--logro-rail-h); transform-style:preserve-3d;
      overflow-x:auto; overflow-y:visible; padding-bottom:10px; scrollbar-width:thin; scrollbar-color:rgba(255,255,255,.25) transparent;
    }
    .logro-strip-3d::-webkit-scrollbar{ height:8px }
    .logro-strip-3d::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.25); border-radius:8px }
    .logro-col{
      position:relative; display:grid; gap:2px; align-content:start; justify-items:center;
      min-width:calc(var(--logro-bubble) + 2px); transform-style:preserve-3d;
    }
    .logro-col::after{
      content:""; position:absolute; bottom:-6px; width:80%; height:6px; border-radius:999px;
      background:radial-gradient(100% 100% at 50% 50%, rgba(0,0,0,.55), rgba(0,0,0,0) 70%);
      transform:translateZ(-2px); pointer-events:none;
    }
    .logro-bubble{
      width:var(--logro-bubble); height:var(--logro-bubble); border-radius:9999px;
      display:flex; align-items:center; justify-content:center; position:relative; transform-style:preserve-3d;
      box-shadow: inset 0 1px 2px rgba(0,0,0,.35), inset 0 -4px 6px rgba(0,0,0,.35), 0 2px 4px rgba(0,0,0,.45);
      will-change: transform, filter; transition: transform .15s ease, filter .15s ease;
      font-size:11px; font-weight:900; color:#fff;
      text-shadow: 0 1px 0 rgba(0,0,0,.4), 0 1px 4px rgba(0,0,0,.6);
    }
    .logro-bubble::before{
      content:""; position:absolute; inset:-1px; border-radius:inherit;
      background:radial-gradient(100% 100% at 30% 25%, rgba(255,255,255,.45), transparent 55%);
      mix-blend-mode:screen; pointer-events:none; transform:translateZ(2px);
    }
    .logro-bubble::after{
      content:""; position:absolute; inset:0; border-radius:inherit; border:1px solid rgba(255,255,255,.25);
      box-shadow:inset 0 0 0 1.5px rgba(0,0,0,.25); pointer-events:none; transform:translateZ(1px);
    }
    .logro-red{   background:radial-gradient(100% 120% at 30% 20%, #ff7a7a, #ef4444 55%, #7f1d1d 100%); border:1px solid #7f1d1d; }
    .logro-blue{  background:radial-gradient(100% 120% at 30% 20%, #7fb0ff, #3b82f6 55%, #1e3a8a 100%); border:1px solid #1e3a8a; }
    .logro-green{ background:radial-gradient(100% 120% at 30% 20%, #7fffd6, #10b981 55%, #065f46 100%); border:1px solid #065f46; }
    .logro-bubble:hover{ filter:brightness(1.05) saturate(1.05); transform:translateZ(calc(var(--logro-step) * 1 + 3px)) scale(1.03); }

    .logro-legend .logro-chip{ width:16px; height:16px; border-radius:9999px; box-shadow:inset 0 1px 2px rgba(0,0,0,.35), 0 1px 2px rgba(0,0,0,.35); }
    .logro-chip.red{   background:#ef4444; border:1px solid #7f1d1d; }
    .logro-chip.green{ background:#10b981; border:1px solid #065f46; }
    .logro-chip.blue{  background:#3b82f6; border:1px solid #1e3a8a; }

    .matches-pill{ white-space:nowrap; }
    .matches-pill.active{ outline:2px solid rgba(16,185,129,.9); background:rgba(16,185,129,.15); }

    .chip3d{
      position:relative; display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:14px;
      font-weight:900; letter-spacing:.4px; user-select:none; border:1px solid rgba(255,255,255,.18);
      background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.02));
      box-shadow:0 14px 28px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.25);
      transform:translateZ(12px); transition:transform .12s, box-shadow .12s, filter .12s; backdrop-filter: blur(2px) saturate(120%);
    }
    .chip3d::before{
      content:""; position:absolute; inset:0; border-radius:14px; background:var(--gloss); mix-blend-mode:screen; pointer-events:none; transform:translateZ(14px);
    }
    .chip3d:hover{ transform:translateY(-3px) translateZ(14px); filter:saturate(110%); }
    .chip3d:active{ transform:translateY(1px) translateZ(8px); box-shadow:0 10px 18px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.35); }
    .chip-emerald{ background:linear-gradient(180deg,#059669,#065f46); }
    .chip-blue{    background:linear-gradient(180deg,#1d4ed8,#1e3a8a); }
    .chip-amber{   background:linear-gradient(180deg,#d97706,#92400e); }
    .chip-outline{ border:1px solid rgba(16,185,129,.55); }

    .result-3d { perspective:900px; display:inline-block; }
    .badge-3d{
      display:inline-flex; align-items:center; justify-content:center; min-width:72px;
      padding:6px 10px; border-radius:12px; font-weight:900; letter-spacing:.6px;
      transform-style:preserve-3d; transform:rotateX(0deg) translateZ(8px);
      box-shadow:0 14px 24px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.25);
      border:1px solid rgba(255,255,255,.22); position:relative; user-select:none;
      text-shadow:0 1px 0 rgba(0,0,0,.45), 0 6px 14px rgba(0,0,0,.45);
      transition:transform .18s ease, filter .18s ease, box-shadow .18s ease;
    }
    .badge-3d::before{
      content:""; position:absolute; inset:0; border-radius:inherit; pointer-events:none;
      background:radial-gradient(120% 80% at 10% -30%, rgba(255,255,255,.35), rgba(255,255,255,0) 60%), var(--gloss);
      transform:translateZ(12px);
    }
    .badge-3d:hover{ transform:rotateX(6deg) translateZ(12px); filter:saturate(1.08); box-shadow:0 18px 30px rgba(0,0,0,.5), inset 0 1px 2px rgba(255,255,255,.28); }
    .badge-win{     background:linear-gradient(180deg,#16a34a,#065f46); color:#fff; }
    .badge-lose{    background:linear-gradient(180deg,#991b1b,#3f0d0d); color:#ffd0d0; }
    .badge-pending{ background:linear-gradient(180deg,#374151,#111827); color:#e5e7eb; }

    .side-3d { perspective:900px; display:inline-block; }
    .side-badge{
      display:inline-flex; align-items:center; justify-content:center; min-width:80px;
      padding:6px 12px; border-radius:12px; font-weight:900; letter-spacing:.6px;
      transform-style:preserve-3d; transform:rotateX(0deg) translateZ(10px);
      border:1px solid rgba(255,255,255,.22);
      box-shadow:0 14px 24px rgba(0,0,0,.5), inset 0 1px 2px rgba(255,255,255,.22);
      text-shadow:0 1px 0 rgba(0,0,0,.55), 0 8px 16px rgba(0,0,0,.55);
      position:relative; user-select:none; transition:transform .18s, filter .18s, box-shadow .18s;
    }
    .side-badge::before{
      content:""; position:absolute; inset:0; border-radius:inherit; pointer-events:none;
      background:radial-gradient(120% 80% at 10% -30%, rgba(255,255,255,.32), rgba(255,255,255,0) 60%), var(--gloss);
      transform:translateZ(14px);
    }
    .side-green{ background:linear-gradient(180deg,#10b981,#065f46); color:#eafff6; }
    .side-red{   background:linear-gradient(180deg,#ef4444,#7f1d1d); color:#fff; }
    .side-blue{  background:linear-gradient(180deg,#3b82f6,#1e3a8a); color:#eaf2ff; }

    /* ======= Mini Bead Road — VERTICAL (1..8 down, 9th new column) ======= */
    .bead-rail{
      position:relative; padding:2px; border-radius:10px;
      background:linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
      border:1px solid rgba(255,255,255,.08);

      /* Fixed visible height = rows * size + gaps; horizontal scroll for many columns */
      height: calc(var(--bead-rows) * var(--bead-bubble) + (var(--bead-rows) - 1) * var(--bead-gap-y) + 4px);
      overflow-x:auto; overflow-y:hidden;
    }
    .bead-strip{
      display:grid;

      /* KEY: fill TOP→BOTTOM first, then NEXT COLUMN */
      grid-auto-flow: column;
      grid-auto-columns: var(--bead-bubble);

      /* 8 rows tall, so items 1..8 stack vertically; 9th starts next column */
      grid-template-rows: repeat(var(--bead-rows), var(--bead-bubble));

      gap: var(--bead-gap-y) var(--bead-gap-x);
      align-content:start;
      padding-bottom:2px;
      scrollbar-width:thin;
    }
    .bead-strip::-webkit-scrollbar{ height:6px }
    .bead-strip::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.25); border-radius:8px }

    .bead{
      width:var(--bead-bubble); height:var(--bead-bubble); border-radius:9999px;
      display:flex; align-items:center; justify-content:center; position:relative;
      font-size:11px; font-weight:900; color:#fff;
      box-shadow: inset 0 1px 2px rgba(0,0,0,.35), inset 0 -4px 6px rgba(0,0,0,.35), 0 2px 4px rgba(0,0,0,.45);
      text-shadow:0 1px 0 rgba(0,0,0,.45), 0 2px 6px rgba(0,0,0,.45);
    }
    .bead::before{
      content:""; position:absolute; inset:-1px; border-radius:inherit;
      background:radial-gradient(100% 100% at 30% 25%, rgba(255,255,255,.55), transparent 55%);
      mix-blend-mode:screen; pointer-events:none;
    }
    .bead::after{
      content:""; position:absolute; inset:0; border-radius:inherit; border:1px solid rgba(255,255,255,.25);
      box-shadow:inset 0 0 0 1.5px rgba(0,0,0,.25); pointer-events:none;
    }
    .bead.red{   background:radial-gradient(100% 120% at 30% 20%, #ff8a8a, #ef4444 55%, #7f1d1d 100%); border:1px solid #7f1d1d; }
    .bead.green{ background:radial-gradient(100% 120% at 30% 20%, #98ffe1, #10b981 55%, #065f46 100%); border:1px solid #065f46; }
    .bead.blue{  background:radial-gradient(100% 120% at 30% 20%, #98baff, #3b82f6 55%, #1e3a8a 100%); border:1px solid #1e3a8a; }
  </style>
</head>

<body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>


  <!-- 4-column layout (Desktop): [slideL | video(+logro) | bets | slideR] -->
  <main class="max-w-7xl mx-auto p-4">
    <div class="grid gap-4 md:grid-cols-[180px_minmax(0,1fr)_360px_180px]">

      <!-- LEFT SLIDE -->
      <div class="hidden md:block">
        <div class="w-full h-[600px] side-panel rounded-lg overflow-hidden relative">
          <img id="left-slide-desktop" class="w-full h-full object-cover transition-all duration-700" src="" alt="slide left">
        </div>
      </div>

      <!-- CENTER: Video + Logrohan + Road -->
      <div class="relative z-10 main-panel p-4 rounded-lg shadow-lg">
        <div class="grid grid-cols-3 items-center mb-3 text-sm text-gray-300">
          <div id="event-date" class="text-left"></div>
          <div class="text-center font-bold text-emerald-300 text-lg">RACE # <span id="match-no">—</span></div>
          <div id="event-time" class="text-right"></div>
        </div>

        <!-- Video -->
        <div class="mb-4 relative">
          <div class="relative aspect-video">
            <div class="absolute inset-0 rounded-xl overflow-hidden z-10">
              <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-emerald-500 via-red-500 to-blue-500 animate-[pulse_4s_infinite] mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-emerald-500/60 via-red-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-emerald-500/20 via-red-500/20 to-blue-500/20 mix-blend-overlay animate-[glow-border_2s_ease-in-out_infinite_alternate]"></div>
            </div>
            <iframe
              id="youtube-video-main"
              class="w-full h-64 md:h-[250px] rounded-lg relative z-20 border-4 border-transparent"
              src="https://www.youtube.com/embed/rUC_nHCOUW4?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen>
            </iframe>
          </div>
        </div>

        <!-- Logrohan (3-color) -->
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px] logro-legend">
              <div class="flex items-center gap-1"><span class="logro-chip green"></span><span class="opacity-70">Green</span></div>
              <div class="flex items-center gap-1"><span class="logro-chip red"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="logro-chip blue"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>

          <div class="flex items-center gap-2 mb-2">
            <button id="btn-win-green" class="px-2 py-1 rounded bg-emerald-700/70 border border-white/10 text-xs font-bold hover:bg-emerald-700">+ Green win</button>
            <button id="btn-win-red"   class="px-2 py-1 rounded bg-red-700/70    border border-white/10 text-xs font-bold hover:bg-red-700">+ Red win</button>
            <button id="btn-win-blue"  class="px-2 py-1 rounded bg-blue-700/70   border border-white/10 text-xs font-bold hover:bg-blue-700">+ Blue win</button>
            <button id="btn-undo"      class="px-2 py-1 rounded bg-gray-700/70   border border-white/10 text-xs hover:bg-gray-700">Undo</button>
            <button id="btn-clear"     class="px-2 py-1 rounded bg-gray-800/70   border border-white/10 text-xs hover:bg-gray-800">Clear</button>
          </div>

          <div id="logro-rail" class="logro-rail">
            <div id="logro-strip" class="logro-strip-3d"></div>
          </div>
        </div>

        <!-- Mini Bead Road (VERTICAL) -->
        <div class="mt-3 bg-gray-900/50 border border-white/10 rounded-lg p-2">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Road</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1"><span class="bead green inline-block" style="width:12px;height:12px"></span><span class="opacity-70">Green</span></div>
              <div class="flex items-center gap-1"><span class="bead red   inline-block" style="width:12px;height:12px"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="bead blue  inline-block" style="width:12px;height:12px"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>
          <div class="bead-rail">
            <div id="bead-strip" class="bead-strip"></div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Bet cards + Bet Amount (sticky) -->
      <aside class="hidden md:block">
        <div class="sticky top-16 space-y-3">
          <div id="bet-area" class="bet-area grid grid-cols-1 gap-2 mt-0 mb-0">
            <!-- GREEN -->
            <div class="bet-card compact green tilt text-center">
              <div class="flex items-center justify-between">
                <span class="name-chip text-xl md:text-2xl">G</span>
                <span class="text-xs opacity-70 tracking-widest">Horse #<span id="horseG-no">—</span></span>
              </div>
              <div id="green-name"   class="mt-2 text-sm font-semibold opacity-90"></div>
              <div id="green-amount" class="amount-3d text-3xl md:text-4xl mt-1"></div>
              <div class="mt-3">
                <div class="mt-2"><span id="green-odds" class="odds-ribbon"></span></div>
                <button id="bet-green" class="bet-btn green mt-2 w-full px-3 py-2 text-sm">BET</button>
                <div id="green-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
              </div>
            </div>

            <!-- RED -->
            <div class="bet-card compact red tilt text-center">
              <div class="flex items-center justify-between">
                <span class="name-chip text-xl md:text-2xl">R</span>
                <span class="text-xs opacity-70 tracking-widest">Horse #<span id="horseR-no">—</span></span>
              </div>
              <div id="red-name"   class="mt-2 text-sm font-semibold opacity-90"></div>
              <div id="red-amount" class="amount-3d text-3xl md:text-4xl mt-1"></div>
              <div class="mt-3">
                <div class="mt-2"><span id="red-odds" class="odds-ribbon"></span></div>
                <button id="bet-red" class="bet-btn red mt-2 w-full px-3 py-2 text-sm">BET</button>
                <div id="red-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
              </div>
            </div>

            <!-- BLUE -->
            <div class="bet-card compact blue tilt text-center">
              <div class="flex items-center justify-between">
                <span class="name-chip text-xl md:text-2xl">B</span>
                <span class="text-xs opacity-70 tracking-widest">Horse #<span id="horseB-no">—</span></span>
              </div>
              <div id="blue-name"   class="mt-2 text-sm font-semibold opacity-90"></div>
              <div id="blue-amount" class="amount-3d text-3xl md:text-4xl mt-1"></div>
              <div class="mt-3">
                <div class="mt-2"><span id="blue-odds" class="odds-ribbon"></span></div>
                <button id="bet-blue" class="bet-btn blue mt-2 w-full px-3 py-2 text-sm">BET</button>
                <div id="blue-result" class="mt-2 text-xs text-yellow-300 result-glow"></div>
              </div>
            </div>
          </div>

          <!-- Bet Amount -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-0">
            <div class="flex items-center justify-between mb-2">
              <div class="text-[15px] uppercase tracking-widest text-white/70">Bet Amount</div>
              <div class="text-[15px] text-white/60">min ♦100</div>
            </div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
              <input
                type="number"
                id="bet-amount"
                class="bet-input p-2 text-sm text-white w-[160px]"
                placeholder="Enter amount"
                inputmode="numeric"
              />
              <div class="balance-pill text-emerald-300">
                <svg class="w-5 h-5 opacity-90" viewBox="0 0 64 64" aria-hidden="true">
                  <defs>
                    <linearGradient id="gemTop" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#e9ffe9"/><stop offset="40%" stop-color="#c6ffd9"/>
                      <stop offset="70%" stop-color="#9fffc8"/><stop offset="100%" stop-color="#e6fff0"/>
                    </linearGradient>
                    <linearGradient id="gemSide" x1="0%" y1="0%" x2="0%" y2="100%">
                      <stop offset="0%" stop-color="#b5ffd0"/><stop offset="100%" stop-color="#80f7b3"/>
                    </linearGradient>
                    <radialGradient id="gemGlow" cx="50%" cy="50%" r="60%">
                      <stop offset="0%" stop-color="rgba(255,255,255,0.9)"/><stop offset="60%" stop-color="rgba(255,255,255,0.0)"/>
                    </radialGradient>
                  </defs>
                  <polygon points="32,60 6,24 58,24" fill="url(#gemSide)" stroke="#a7ffd8" stroke-width="1"/>
                  <polygon points="12,24 20,8 44,8 52,24 12,24" fill="url(#gemTop)" stroke="#bfffe6" stroke-width="1"/>
                  <polyline points="20,8 32,24 44,8" fill="none" stroke="#d8ffe8" stroke-width="1" opacity=".9"/>
                  <polyline points="12,24 32,24 52,24" fill="none" stroke="#cfe" stroke-width="1" opacity=".9"/>
                  <polyline points="6,24 32,60 58,24" fill="none" stroke="#a7ffd8" stroke-width="1" opacity=".7"/>
                  <circle cx="32" cy="30" r="16" fill="url(#gemGlow)" opacity=".35"/>
                </svg>
                <span class="text-[11px] opacity-80 tracking-widest"></span>
                <span id="mid-balance" class="amount text-base">5,000</span>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 mb-2">
              <button class="chip3d chip-emerald chip-outline text-sm bet-chip" data-val="100">♦100</button>
              <button class="chip3d chip-amber   chip-outline text-sm bet-chip" data-val="200">♦200</button>
              <button class="chip3d chip-black  chip-outline text-sm bet-chip" data-val="500">♦500</button>
              <button class="chip3d chip-blue   chip-outline text-sm bet-chip" data-val="1000">♦1000</button>
            </div>
          </div>
        </div>
      </aside>

      <!-- RIGHTMOST SLIDE -->
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

        <!-- Bet area (mobile): G → R → B -->
        <div class="bet-area grid grid-cols-1 gap-2">
          <div class="bet-card green text-center">
            <div class="name-chip text-xl">G</div>
            <div id="green-name-mob"   class="mt-2 text-sm font-semibold opacity-90"></div>
            <div id="green-amount-mob" class="amount-3d text-3xl mt-1"></div>
            <div class="mt-2"><span id="green-odds-mob" class="odds-ribbon"></span></div>
          </div>
          <div class="bet-card red text-center">
            <div class="name-chip text-xl">R</div>
            <div id="red-name-mob"   class="mt-2 text-sm font-semibold opacity-90"></div>
            <div id="red-amount-mob" class="amount-3d text-3xl mt-1"></div>
            <div class="mt-2"><span id="red-odds-mob" class="odds-ribbon"></span></div>
          </div>
          <div class="bet-card blue text-center">
            <div class="name-chip text-xl">B</div>
            <div id="blue-name-mob"   class="mt-2 text-sm font-semibold opacity-90"></div>
            <div id="blue-amount-mob" class="amount-3d text-3xl mt-1"></div>
            <div class="mt-2"><span id="blue-odds-mob" class="odds-ribbon"></span></div>
          </div>
        </div>

        <!-- Logrohan (mobile) -->
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1"><span class="logro-chip green"></span><span class="opacity-70">Green</span></div>
              <div class="flex items-center gap-1"><span class="logro-chip red"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="logro-chip blue"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>
          <div id="logro-rail-mob" class="logro-rail">
            <div id="logro-strip-mob" class="logro-strip-3d"></div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <script>
    /* ---------- Data ---------- */
    const horseNames = [
      "Emerald Comet","Green Thunder","Forest Dash","Scarlet Blaze","Red Riptide","Crimson Arrow",
      "Blue Tempest","Azure Bolt","Sapphire Sprint","Golden Spur","Night Runner","Silver Streak"
    ];
    const slides = [
      "https://i.ibb.co/GvKcMGqT/kabayo7.webp",
      "https://i.ibb.co/20Gphj6d/kabayo2.jpg",
      "https://i.ibb.co/nsHTHK3M/kabayo3.webp",
      "https://i.ibb.co/KjN9SdS8/kabayo4.jpg",
      "https://i.ibb.co/Gv99W94c/kabayo5.jpg",
      "https://i.ibb.co/Xr943DJw/kabayo6.jpg"
    ];
    let slideIndex = 0;

    function setSrcIf(el, src){ if(el) el.src = src; }
    function updateSlides(){
      const a = slides[slideIndex];
      const b = slides[(slideIndex + 3) % slides.length];
      setSrcIf(document.getElementById("left-slide-desktop"),  a);
      setSrcIf(document.getElementById("right-slide-desktop"), b);
      setSrcIf(document.getElementById("left-slide-mobile"),   a);
      setSrcIf(document.getElementById("right-slide-mobile"),  b);
      slideIndex = (slideIndex + 1) % slides.length;
    }
    setInterval(updateSlides, 3000);

    /* ---------- Helpers ---------- */
    function pickName(exclude1, exclude2){
      let n;
      do { n = horseNames[Math.floor(Math.random() * horseNames.length)]; }
      while (n === exclude1 || n === exclude2);
      return n;
    }

    function setRandomRace(){
      // Three horses: G, R, B
      const nameG = pickName();
      const nameR = pickName(nameG);
      const nameB = pickName(nameG, nameR);
      const id = Math.floor(Math.random() * 900) + 100;

      const setTxt = (id, val) => { const el = document.getElementById(id); if(el) el.textContent = val; };

      setTxt('green-name', nameG); setTxt('green-name-mob', nameG);
      setTxt('red-name',   nameR); setTxt('red-name-mob',   nameR);
      setTxt('blue-name',  nameB); setTxt('blue-name-mob',  nameB);
      setTxt('match-no', id);

      // Horse numbers
      setTxt('horseG-no', Math.floor(Math.random() * 9) + 1);
      setTxt('horseR-no', Math.floor(Math.random() * 9) + 1);
      setTxt('horseB-no', Math.floor(Math.random() * 9) + 1);
    }

    const BIGROAD_MAX_ROWS = 8; // ilalim ng video

    /* ========= PA-L Logro Grid (unchanged) ========= */
    function streaks(seq){
      const out=[]; for(let i=0;i<seq.length;){
        const c=seq[i]; let j=i+1; while(j<seq.length && seq[j]===c) j++;
        out.push([c, j-i]); i=j;
      } return out;
    }
    function buildLGrid(seq, maxRows){
      const cols=[]; const ensure=c=>{ if(!cols[c]) cols[c]=[]; };
      const isEmpty=(c,r)=>!cols[c]||!cols[c][r];

      let startCol=0;
      for(const [color,count] of streaks(seq)){
        let remaining=count;

        // vertical leg
        let col=startCol, row=0; ensure(col);
        while(remaining>0 && row<maxRows && isEmpty(col,row)){
          cols[col][row]={t:color}; remaining--; row++;
        }
        // elbow row
        let elbowRow = Math.max(0, Math.min(maxRows-1, row-1));

        // horizontal leg to the right on elbowRow
        col = startCol + 1;
        while(remaining>0){
          while(!isEmpty(col, elbowRow)) col++; // skip occupied
          ensure(col); cols[col][elbowRow]={t:color}; remaining--; col++;
        }

        // next streak starts beside the first bubble
        startCol += 1;
      }
      return cols;
    }
    const bubbleClass = (t) => t==='R' ? 'logro-red' : (t==='B' ? 'logro-blue' : 'logro-green');

    function renderBigRoadToGrid(seq, stripId, maxRows = BIGROAD_MAX_ROWS){
      const grid = buildLGrid(seq, maxRows);
      const strip = document.getElementById(stripId);
      if(!strip) return;
      strip.innerHTML = '';

      grid.forEach(col=>{
        const colDiv = document.createElement('div');
        colDiv.className = 'logro-col';
        colDiv.style.gridTemplateRows = `repeat(${maxRows}, var(--logro-bubble))`;

        for(let r=0;r<maxRows;r++){
          const cell = col && col[r];
          if(!cell) continue;
          const b = document.createElement('div');
          b.className = `logro-bubble ${bubbleClass(cell.t)}`;
          b.style.gridRow = `${r+1}`;
          const depth = Math.min(r, maxRows-1);
          b.style.setProperty('--z', `calc(var(--logro-step) * ${depth})`);
          b.style.transform = `translateZ(var(--z))`;
          colDiv.appendChild(b);
        }
        strip.appendChild(colDiv);
      });

      strip.scrollLeft = strip.scrollWidth;
    }

    /* ===== STRAIGHT VERTICAL BEAD ROAD (1..8 down, 9th new column) ===== */
    function renderBeadRoad(seq, stripId){
      const strip = document.getElementById(stripId);
      if(!strip) return;
      strip.innerHTML = '';

      // Append in order — CSS Grid handles vertical fill then next column
      seq.forEach((t, i) => {
        const dot = document.createElement('div');
        dot.className = 'bead ' + (t==='R' ? 'red' : (t==='B' ? 'blue' : 'green'));
        dot.textContent = (i + 1); // number in the center (sequence index)
        strip.appendChild(dot);
      });

      // Auto-scroll to newest column on the right
      const rail = strip.parentElement;
      rail.scrollLeft = rail.scrollWidth;
    }

    function renderAllRoads(seq){
      renderBigRoadToGrid(seq, 'logro-strip',     BIGROAD_MAX_ROWS); // desktop/video
      renderBigRoadToGrid(seq, 'logro-strip-mob', BIGROAD_MAX_ROWS); // mobile
      renderBeadRoad(seq, 'bead-strip');                               // vertical road
    }

    /* ---------- Betting State ---------- */
    let results = []; // sequence of 'G'|'R'|'B'
    let greenAmount, redAmount, blueAmount;
    let greenOdds, redOdds, blueOdds;
    let currentBalance = 500000;
    const betHistory = [];

    function getRandomAmount(){ return Math.floor(Math.random() * (80000 - 12000 + 1)) + 12000; }

    function setDateTime(){
      const now = new Date();
      const optionsDate = {month:'2-digit', day:'2-digit', year:'numeric'};
      const optionsTime = {weekday:'short', hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true};
      const d = "EVENT - " + now.toLocaleDateString('en-US', optionsDate);
      const t = now.toLocaleTimeString('en-US', optionsTime) + " ";
      const ed = document.getElementById('event-date'); if(ed) ed.textContent = d;
      const et = document.getElementById('event-time'); if(et) et.textContent = t;
    }
    setInterval(setDateTime, 1000);

    function computeOdds(){
      greenOdds = (Math.random() * (2.3 - 1.4) + 1.4).toFixed(2);
      redOdds   = (Math.random() * (2.3 - 1.4) + 1.4).toFixed(2);
      blueOdds  = (Math.random() * (2.3 - 1.4) + 1.4).toFixed(2);
    }
    function renderOddsEverywhere(){
      const put = (id,val)=>{ const el = document.getElementById(id); if(el) el.textContent = "PAYOUT = " + val; };
      put('green-odds', greenOdds); put('green-odds-mob', greenOdds);
      put('red-odds',   redOdds);   put('red-odds-mob',   redOdds);
      put('blue-odds',  blueOdds);  put('blue-odds-mob',  blueOdds);
    }

    function attachTilt(el){
      const damp = 6;
      el.addEventListener('mousemove',(e)=>{
        const r = el.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width;
        const y = (e.clientY - r.top) / r.height;
        const rx = (y - 0.5) * damp, ry = (0.5 - x) * damp;
        el.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
      });
      el.addEventListener('mouseleave',()=>{ el.style.transform = 'rotateX(0) rotateY(0) translateY(0)'; });
    }

    function renderBalance(){
      const mid  = document.getElementById('mid-balance');
      const head = document.getElementById('header-balance');
      if(mid)  mid.textContent  = Number(currentBalance).toLocaleString();
      if(head) head.textContent = Number(currentBalance).toLocaleString();
    }
    function adjustBalance(delta){
      const next = currentBalance + delta; if(next < 0) return false;
      currentBalance = next; renderBalance(); return true;
    }

    function addToHistory(entry){
      betHistory.unshift(entry);
      renderHeaderHistory();
      const dot = document.getElementById('header-history-dot');
      if(dot) dot.classList.toggle('hidden', betHistory.length === 0);
    }

    function sideBadgeHTML(side){
      const cls = side==='GREEN' ? 'side-badge side-green' : (side==='RED' ? 'side-badge side-red' : 'side-badge side-blue');
      return `<span class="side-3d"><span class="${cls}">${side}</span></span>`;
    }
    function badgeClassByStatus(s){
      if(s==='WIN')   return 'badge-3d badge-win';
      if(s==='LOSE')  return 'badge-3d badge-lose';
      return 'badge-3d badge-pending';
    }

    function renderHeaderHistory(){
      const list  = document.getElementById('header-history-list');
      const empty = document.getElementById('header-history-empty');
      if(!list || !empty) return;

      if(betHistory.length === 0){
        empty.classList.remove('hidden');
        list.classList.add('hidden'); list.innerHTML = '';
        return;
      }
      empty.classList.add('hidden'); list.classList.remove('hidden');

      const top = betHistory.slice(0,8);
      list.innerHTML = top.map(item=>{
        const sideChip = sideBadgeHTML(item.side);
        const badge = `<span class="result-3d"><span class="${badgeClassByStatus(item.status)}">${item.status}</span></span>`;
        return `
          <div class="py-2 px-2 text-xs">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">${sideChip}</div>
              <div class="flex items-center gap-2">
                ${badge}
                <div class="text-white/50">${item.time}</div>
              </div>
            </div>
            <div class="text-white/80 mt-1">${item.player} • Race #${item.matchId}</div>
            <div class="mt-0.5">
              <span class="font-semibold">${Number(item.amount).toLocaleString()}</span>
              @ <span class="font-semibold">${item.odds}</span>
              = <span class="text-yellow-300 font-bold">${Number(item.payout).toLocaleString()}</span>
            </div>
            <div class="text-white/50 mt-0.5">Bal: ${Number(item.balanceBefore).toLocaleString()} → <span class="text-white/80 font-semibold">${Number(item.balanceAfter).toLocaleString()}</span></div>
          </div>`;
      }).join('');
    }

    function resolveLatestBets(winSide){
      betHistory.forEach(bet=>{
        if(bet.status !== 'PENDING') return;
        if(bet.side === winSide){
          bet.status = 'WIN';
          adjustBalance(parseFloat(bet.payout));
          bet.balanceAfter = currentBalance;
        }else{
          bet.status = 'LOSE';
          bet.balanceAfter = currentBalance;
        }
      });
      renderHeaderHistory();
    }

    function placeBet(which){
      const input = document.getElementById('bet-amount');
      let betAmount = parseFloat(input.value);
      if(isNaN(betAmount) || betAmount <= 0){ alert("Please enter a valid bet amount greater than 0."); return; }

      const elTxt = (id)=> (document.getElementById(id)?.textContent || '');

      let odds, chosen;
      if(which==='GREEN'){ odds = greenOdds; chosen = elTxt('green-name'); }
      if(which==='RED'){   odds = redOdds;   chosen = elTxt('red-name'); }
      if(which==='BLUE'){  odds = blueOdds;  chosen = elTxt('blue-name'); }

      const balanceBefore = currentBalance;
      if(!adjustBalance(-betAmount)){ alert('Insufficient balance.'); return; }

      if(which==='GREEN'){ greenAmount += betAmount; document.getElementById('green-amount').textContent = greenAmount.toLocaleString(); }
      if(which==='RED'){   redAmount   += betAmount; document.getElementById('red-amount').textContent   = redAmount.toLocaleString(); }
      if(which==='BLUE'){  blueAmount  += betAmount; document.getElementById('blue-amount').textContent  = blueAmount.toLocaleString(); }

      const payout = parseFloat(betAmount) * parseFloat(odds);
      const matchId = document.getElementById('match-no').textContent || '—';
      const time = new Date().toLocaleString('en-PH', { hour12: true });

      addToHistory({
        side: which,
        player: chosen || which,
        matchId,
        amount: betAmount,
        odds: odds,
        payout: payout.toFixed(2),
        time,
        balanceBefore,
        balanceAfter: currentBalance,
        status: 'PENDING'
      });

      const resId = which==='GREEN' ? 'green-result' : which==='RED' ? 'red-result' : 'blue-result';
      document.getElementById('green-result').textContent = '';
      document.getElementById('red-result').textContent   = '';
      document.getElementById('blue-result').textContent  = '';
      const label = chosen || which;
      document.getElementById(resId).textContent = `${label} • Winnings: ${payout.toFixed(2)}`;

      alert(`Bet ${betAmount} on ${label}.\nPossible payout: ${payout.toFixed(2)}.\nNew Balance: ${currentBalance.toLocaleString()}.`);
    }

    function pushResult(side){
      // side: 'GREEN' | 'RED' | 'BLUE' -> map to 'G' | 'R' | 'B'
      const sym = side==='GREEN' ? 'G' : (side==='RED' ? 'R' : 'B');
      results.push(sym);
      renderAllRoads(results);
      resolveLatestBets(side);
    }
    function undoResult(){ results.pop(); renderAllRoads(results); }
    function clearResults(){ results = []; renderAllRoads(results); }

    // Init
    window.onload = () => {
      setDateTime();
      setRandomRace();

      // Seed amounts
      greenAmount = getRandomAmount();
      redAmount   = getRandomAmount();
      blueAmount  = getRandomAmount();
      document.getElementById('green-amount').textContent     = greenAmount.toLocaleString();
      document.getElementById('red-amount').textContent       = redAmount.toLocaleString();
      document.getElementById('blue-amount').textContent      = blueAmount.toLocaleString();
      document.getElementById('green-amount-mob').textContent = greenAmount.toLocaleString();
      document.getElementById('red-amount-mob').textContent   = redAmount.toLocaleString();
      document.getElementById('blue-amount-mob').textContent  = blueAmount.toLocaleString();

      computeOdds();
      renderOddsEverywhere();

      updateSlides();
      document.querySelectorAll('.tilt').forEach(attachTilt);

      const name = 'AMOK';
      const acct  = document.getElementById('account-name');       if(acct)  acct.textContent  = name;
      const acctm = document.getElementById('account-name-menu');  if(acctm) acctm.textContent = name;

      const btn  = document.getElementById('account-btn');
      const menu = document.getElementById('account-menu');
      if(btn && menu){
        btn.addEventListener('click',()=>{ menu.classList.toggle('hidden'); });
        document.addEventListener('click',(e)=>{ if(!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden'); });
      }

      // Logro buttons
      document.getElementById('btn-win-green')?.addEventListener('click', ()=> pushResult('GREEN'));
      document.getElementById('btn-win-red')  ?.addEventListener('click', ()=> pushResult('RED'));
      document.getElementById('btn-win-blue') ?.addEventListener('click', ()=> pushResult('BLUE'));
      document.getElementById('btn-undo')     ?.addEventListener('click',  undoResult);
      document.getElementById('btn-clear')    ?.addEventListener('click',  clearResults);

      // Seed initial pattern
      results = ['G','G','R','R','B','B','G','R','R','G','B','G','G','R','B','G','G','G','G','G','G','G','R','R','R','B','B','B','B','G','G','R','R','R'];
      renderAllRoads(results);

      // Balance init
      renderBalance();

      // Quick chips
      document.querySelectorAll('.bet-chip').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const raw = parseInt(btn.dataset.val || '0', 10);
          const amt = document.getElementById('bet-amount'); if(amt) amt.value = raw;
          btn.animate([{transform:'translateY(-3px)'},{transform:'translateY(0)'}], {duration:120});
        });
      });

      // Bet buttons
      document.getElementById('bet-green')?.addEventListener('click', ()=> placeBet('GREEN'));
      document.getElementById('bet-red')  ?.addEventListener('click', ()=> placeBet('RED'));
      document.getElementById('bet-blue') ?.addEventListener('click', ()=> placeBet('BLUE'));
    };
  </script>
</body>
</x-layouts.app>

