{{-- resources/views/components/head.blade.php (or inline in your layout) --}}

@php
  $pageTitle = $title ?? config('app.name');
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $pageTitle }}</title>

{{-- Tailwind/CSS only (no JS). Make sure resources/css/app.css includes Tailwind. --}}
@vite(['resources/css/app.css'])

{{-- Icons & Fonts (CSS-only) --}}
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      crossorigin="anonymous" />

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

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
    --bead-bubble: 22px;
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
    background:url('{{ asset('images/betting_background.png') }}') center/cover no-repeat;
    opacity:.85; z-index:-1;
    animation: moveBg 30s infinite alternate ease-in-out;
    will-change:transform;
  }

  /* ==========================================================
     3) HEADER / NAV
  ========================================================== */
  .glass-header {
    background:linear-gradient(to right, rgba(17,24,39,.75), rgba(17,24,39,.55));
    backdrop-filter:blur(8px) saturate(120%);
    border-bottom:1px solid rgba(255,255,255,.12);
  }
  .header-gloss:before {
    content:""; position:absolute; inset:0;
    background:radial-gradient(120% 80% at -10% -40%, rgba(255,255,255,.25), rgba(255,255,255,0) 60%);
    pointer-events:none;
  }
  .brand-logo { filter:drop-shadow(0 0 6px rgba(16,185,129,.7)); }
  .menu-card {
    background:rgba(17,24,39,.95);
    border:1px solid rgba(255,255,255,.12);
    border-radius:14px;
    box-shadow:0 18px 30px rgba(0,0,0,.35);
  }
  .shine-3d {
    font-weight:900; letter-spacing:.3px;
    background:linear-gradient(90deg, rgba(255,255,255,.75) 0%, #ffffff 25%, #ffe08a 45%, #ffffff 60%, rgba(255,255,255,.75) 100%);
    background-size:200% auto;
    -webkit-background-clip:text; background-clip:text; color:transparent;
    animation:shineMove 2.6s linear infinite;
    text-shadow:0 1px 0 rgba(0,0,0,.35), 0 2px 0 rgba(0,0,0,.35), 0 8px 18px rgba(0,0,0,.5), 0 0 18px rgba(255,232,133,.35);
  }

  /* ==========================================================
     4) PANELS / LAYOUT
  ========================================================== */
  .side-panel { background:rgba(17,24,39,.35); }
  .main-panel { background:rgba(17,24,39,.55); }

  /* ==========================================================
     5) BET CARDS / INPUTS / BUTTONS / CHIPS
  ========================================================== */
  .bet-area { perspective:1200px; }
  .bet-card {
    position:relative; border-radius:var(--card-radius); overflow:hidden; padding:14px; color:#fff;
    transform-style:preserve-3d; will-change:transform, box-shadow;
    transition:transform .2s, box-shadow .2s, filter .2s;
    border:1px solid rgba(255,255,255,.12); backdrop-filter:saturate(120%) blur(2px);
    box-shadow:0 18px 30px rgba(0,0,0,.35), 0 4px 10px rgba(0,0,0,.35);
  }
  .bet-card::before {
    content:""; position:absolute; inset:0;
    background: radial-gradient(100% 60% at -10% -10%, rgba(255,255,255,.35), rgba(255,255,255,0) 60%), var(--gloss);
    mix-blend-mode:screen; pointer-events:none;
  }
  .bet-card::after {
    content:""; position:absolute; left:8%; right:8%; bottom:0; height:2px;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent);
    filter:blur(.5px); transform:translateZ(22px); opacity:.7;
  }
  .bet-card:hover { transform:translateY(-6px) scale(1.01); filter:saturate(110%); }
  .bet-card.red {
    background: radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%),
                linear-gradient(180deg,#ef4444 0%,#b91c1c 55%,#7f1d1d 100%);
    box-shadow:0 18px 32px rgba(185,28,28,.45), 0 8px 18px rgba(0,0,0,.45);
  }
  .bet-card.blue{
    background: radial-gradient(120% 140% at 100% -10%, rgba(255,255,255,.10), rgba(255,255,255,0) 60%),
                linear-gradient(180deg,#3b82f6 0%,#1d4ed8 55%,#1e3a8a 100%);
    box-shadow:0 18px 32px rgba(29,78,216,.45), 0 8px 18px rgba(0,0,0,.45);
  }
  .name-chip {
    display:inline-block; padding:6px 12px; border-radius:9999px; font-weight:900; letter-spacing:.3px;
    background:rgba(0,0,0,.25); box-shadow:var(--inner-shadow); transform:translateZ(24px);
  }
  .amount-3d { font-weight:900; text-shadow:0 2px 0 rgba(0,0,0,.35), 0 8px 18px rgba(0,0,0,.35); transform:translateZ(26px); }
  .odds-ribbon {
    display:inline-block; padding:6px 12px; border-radius:10px; font-weight:800;
    background:rgba(0,0,0,.25); border:1px solid rgba(255,255,255,.12); box-shadow:var(--inner-shadow);
    transform:translateZ(22px);
  }
  .bet-input {
    border-radius:12px; border:1px solid rgba(255,255,255,.18); outline:none; box-shadow:var(--inner-shadow);
    transition:transform .15s, box-shadow .15s; transform:translateZ(18px);
  }
  .bet-input:focus {
    box-shadow:inset 0 2px 4px rgba(0,0,0,.3), 0 0 0 3px rgba(255,255,255,.08);
    transform:translateZ(20px);
  }
  .bet-btn {
    border-radius:12px; font-weight:900; letter-spacing:.5px;
    border:1px solid rgba(255,255,255,.18);
    box-shadow:0 10px 18px rgba(0,0,0,.35), inset 0 1px 2px rgba(255,255,255,.25);
    transition:transform .12s, box-shadow .12s, filter .12s; transform:translateZ(24px);
  }
  .bet-btn:hover { filter:brightness(1.05); }
  .bet-btn:active { transform:translateZ(20px) translateY(2px); box-shadow:0 6px 12px rgba(0,0,0,.35), inset 0 2px 4px rgba(0,0,0,.35); }
  .bet-btn.red  { background:linear-gradient(180deg,#b91c1c 0%,#7f1d1d 100%); }
  .bet-btn.blue { background:linear-gradient(180deg,#1d4ed8 0%,#1e3a8a 100%); }
  .result-glow { text-shadow:0 0 10px rgba(250,204,21,.55); }
  .tilt { transform:rotateX(0) rotateY(0); transition:transform .12s; }
  .balance-pill {
    display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:9999px;
    background:rgba(250,204,21,.12); border:1px solid rgba(250,204,21,.35);
    box-shadow: var(--inner-shadow); backdrop-filter: blur(2px) saturate(120%);
    transform: translateZ(24px);
  }
  .balance-pill .amount { font-weight:900; letter-spacing:.5px; text-shadow:0 1px 0 rgba(0,0,0,.35), 0 8px 16px rgba(0,0,0,.35); }

  /* Quick bet chips */
  .chip3d{
    position:relative; display:inline-flex; align-items:center; justify-content:center; padding:10px 14px;
    border-radius:14px; font-weight:900; letter-spacing:.4px; user-select:none;
    border:1px solid rgba(255,255,255,.18);
    background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.02));
    box-shadow:0 14px 28px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.25);
    transform:translateZ(12px);
    transition:transform .12s, box-shadow .12s, filter .12s;
    backdrop-filter: blur(2px) saturate(120%);
  }
  .chip3d::before{
    content:""; position:absolute; inset:0; border-radius:14px; background:var(--gloss);
    mix-blend-mode:screen; pointer-events:none; transform:translateZ(14px);
  }
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
  .badge-3d {
    display:inline-flex; align-items:center; justify-content:center; min-width:72px; padding:6px 10px;
    border-radius:12px; font-weight:900; letter-spacing:.6px; transform-style:preserve-3d;
    transform:rotateX(0deg) translateZ(8px);
    box-shadow:0 14px 24px rgba(0,0,0,.45), inset 0 1px 2px rgba(255,255,255,.25);
    border:1px solid rgba(255,255,255,.22); position:relative; user-select:none;
    text-shadow:0 1px 0 rgba(0,0,0,.45), 0 6px 14px rgba(0,0,0,.45);
    transition: transform .18s ease, filter .18s ease, box-shadow .18s ease;
  }
  .badge-3d::before {
    content:""; position:absolute; inset:0; border-radius:inherit; pointer-events:none;
    background: radial-gradient(120% 80% at 10% -30%, rgba(255,255,255,.35), rgba(255,255,255,0) 60%), var(--gloss);
    transform: translateZ(12px);
  }
  .badge-3d:hover{ transform: rotateX(6deg) translateZ(12px); filter:saturate(1.08); box-shadow:0 18px 30px rgba(0,0,0,.5), inset 0 1px 2px rgba(255,255,255,.28); }
  .badge-win{ background: linear-gradient(180deg,#16a34a,#065f46); color:#fff; }
  .badge-lose{ background: linear-gradient(180deg,#991b1b,#3f0d0d); color:#ffd0d0; }
  .badge-pending{ background: linear-gradient(180deg,#374151,#111827); color:#e5e7eb; }

  .side-3d { perspective:900px; display:inline-block; }
  .side-badge{
    display:inline-flex; align-items:center; justify-content:center; min-width:80px; padding:6px 12px;
    border-radius:12px; font-weight:900; letter-spacing:.6px; transform-style:preserve-3d;
    transform:rotateX(0deg) translateZ(10px); border:1px solid rgba(255,255,255,.22);
    box-shadow:0 14px 24px rgba(0,0,0,.5), inset 0 1px 2px rgba(255,255,255,.22);
    text-shadow:0 1px 0 rgba(0,0,0,.55), 0 8px 16px rgba(0,0,0,.55);
    position:relative; user-select:none; transition:transform .18s, filter .18s, box-shadow .18s;
  }
  .side-badge::before{
    content:""; position:absolute; inset:0; border-radius:inherit; pointer-events:none;
    background: radial-gradient(120% 80% at 10% -30%, rgba(255,255,255,.32), rgba(255,255,255,0) 60%), var(--gloss);
    transform: translateZ(14px);
  }
  .side-badge:hover{ transform: rotateX(6deg) translateZ(14px); filter:saturate(1.08); box-shadow:0 18px 32px rgba(0,0,0,.55), inset 0 1px 2px rgba(255,255,255,.28); }
  .side-meron{ background: linear-gradient(180deg,#ef4444,#7f1d1d); color:#fff; }
  .side-wala { background: linear-gradient(180deg,#3b82f6,#1e3a8a); color:#eaf2ff; }

  /* ==========================================================
     7) LOGROHAN (HOLLOW RINGS)
  ========================================================== */
  .logro-zone { perspective:1100px; overflow:visible; }
  .logro-rail {
    position:relative; transform-style:preserve-3d; transform-origin:bottom center;
    transition: transform .25s ease, box-shadow .25s ease; padding:12px 10px 18px;
    background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
    border:1px solid rgba(255,255,255,.10); border-radius:14px;
    box-shadow:0 20px 40px rgba(0,0,0,.45), inset 0 4px 10px rgba(255,255,255,.04);
    will-change:transform;
  }
  .logro-rail:hover { transform:rotateX(0deg) translateY(0); box-shadow:0 16px 28px rgba(0,0,0,.38), inset 0 4px 10px rgba(255,255,255,.05); }
  .logro-rail::before {
    content:""; position:absolute; inset:0; border-radius:14px;
    background:radial-gradient(120% 80% at 0% -30%, rgba(255,255,255,.18), transparent 60%);
    mix-blend-mode:screen; pointer-events:none; transform:translateZ(1px);
  }
  .logro-rail::after  {
    content:""; position:absolute; left:6px; right:6px; bottom:-18px; height:26px; border-radius:20px; filter:blur(10px);
    background:radial-gradient(60% 100% at 50% 0%, rgba(0,0,0,.45), transparent 60%);
    transform:translateZ(-2px); pointer-events:none;
  }
  .logro-strip-3d {
    display:flex; gap:8px; min-height:var(--logro-rail-h); transform-style:preserve-3d;
    overflow-x:auto; overflow-y:visible; padding-bottom:10px; scrollbar-width:thin;
    scrollbar-color:rgba(255,255,255,.25) transparent;
  }
  .logro-strip-3d::-webkit-scrollbar{ height:8px }
  .logro-strip-3d::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.25); border-radius:8px }
  .logro-col {
    position:relative; display:grid; gap:2px; align-content:start; justify-items:center;
    min-width:calc(var(--logro-bubble) + 2px); transform-style:preserve-3d;
  }
  .logro-col::after {
    content:""; position:absolute; bottom:-6px; width:80%; height:6px; border-radius:999px;
    background:radial-gradient(100% 100% at 50% 50%, rgba(0,0,0,.55), rgba(0,0,0,0) 70%);
    transform:translateZ(-2px); pointer-events:none;
  }
  .ring-bubble {
    width:var(--logro-bubble); height:var(--logro-bubble); border-radius:9999px; background:transparent; position:relative;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.35); border:2px solid;
  }
  .ring-bubble::before {
    content:""; position:absolute; inset:0; border-radius:inherit;
    background:radial-gradient(100% 100% at 30% 25%, rgba(255,255,255,.35), transparent 55%);
    mix-blend-mode:screen;
  }
  .ring-bubble::after  { content:""; position:absolute; inset:0; border-radius:inherit; border:1px solid rgba(255,255,255,.2); pointer-events:none; }
  .ring-red { border-color:#ef4444; }
  .ring-blue{ border-color:#3b82f6; }
  .ring-gap { width:var(--logro-bubble); height:var(--logro-bubble); border-radius:9999px; }

  /* ==========================================================
     8) MINI BEAD ROAD (SOLID + NUMBER)
  ========================================================== */
  .bead-rail {
    position:relative; padding:8px; border-radius:10px;
    background:linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
    border:1px solid rgba(255,255,255,.08);
  }
  .bead-strip{
    display:flex; gap:var(--bead-gap-x); overflow-x:auto; overflow-y:hidden; scrollbar-width:thin;
    min-height:var(--bead-rail-h); padding-bottom:4px;
  }
  .bead-strip::-webkit-scrollbar{ height:6px }
  .bead-strip::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.25); border-radius:8px }
  .bead-col{
    display:grid; grid-auto-rows:var(--bead-bubble); grid-template-rows:repeat(6, var(--bead-bubble));
    align-content:start; gap:var(--bead-gap-y); min-width:calc(var(--bead-bubble)); justify-items:center;
  }
  .bead      { width:var(--bead-bubble); height:var(--bead-bubble); border-radius:9999px; background:transparent; box-shadow: inset 0 1px 2px rgba(0,0,0,.35); }
  .bead.red  { border:2px solid #ef4444; }
  .bead.blue { border:2px solid #3b82f6; }
  .bead-solid{
    width:var(--bead-bubble); height:var(--bead-bubble); border-radius:9999px; display:flex; align-items:center; justify-content:center;
    position:relative; font-size:9px; font-weight:900; color:#fff;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.35), inset 0 -3px 5px rgba(0,0,0,.35), 0 1px 2px rgba(0,0,0,.45);
  }
  .bead-solid::before{
    content:""; position:absolute; inset:-1px; border-radius:inherit;
    background: radial-gradient(100% 100% at 30% 25%, rgba(255,255,255,.45), transparent 55%);
    mix-blend-mode:screen;
  }
  .bead-solid::after { content:""; position:absolute; inset:0; border-radius:inherit; border:1px solid rgba(255,255,255,.25); pointer-events:none; }
  .bead-solid.red  { background: radial-gradient(100% 120% at 30% 20%, #ff7a7a, #ef4444 55%, #7f1d1d 100%); border:1px solid #7f1d1d; }
  .bead-solid.blue { background: radial-gradient(100% 120% at 30% 20%, #7fb0ff, #3b82f6 55%, #1e3a8a 100%); border:1px solid #1e3a8a; }

  /* ==========================================================
     9) KEYFRAMES
  ========================================================== */
  @keyframes moveBg {
    0%{transform:translate3d(0,0,0)}
    50%{transform:translate3d(-2%,-2%,0)}
    100%{transform:translate3d(0,-1%,0)}
  }
  @keyframes glow-border {
    0% { box-shadow: 0 0 10px -5px rgba(255,0,0,0.8), 0 0 20px -10px rgba(255,255,0,0.8), 0 0 30px -15px rgba(0,0,255,0.8); }
    50% { box-shadow: 0 0 15px -3px rgba(255,0,0,0.9), 0 0 25px -8px rgba(255,255,0,0.9), 0 0 35px -13px rgba(0,0,255,0.9); }
    100% { box-shadow: 0 0 20px 0 rgba(255,0,0,1), 0 0 30px -5px rgba(255,255,0,1), 0 0 40px -10px rgba(0,0,255,1); }
  }
  @keyframes shineMove {
    0%{background-position:0% center}
    100%{background-position:200% center}
  }
</style>

{{-- Appearance (server-controlled) --}}
@fluxAppearance
