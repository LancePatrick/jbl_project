<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Drag Race Dashboard • Totalizator Style</title>
<style>
/* ============== TOKENS / THEME ============== */
:root{
  --radius:18px; --speed:260ms; --e:cubic-bezier(.2,.8,.2,1);
  --emboss-hi:rgba(255,255,255,.10); --emboss-lo:rgba(0,0,0,.46); --emboss-edge:rgba(255,255,255,.06);
  --red:#ff3b30; --blue:#2f7cff; --accent:#00ffba;
  --stroke-1:#15203a; --stroke-2:#1a2746; --stroke-3:#203155; --stroke-4:#263963; --stroke-5:#2f477a;
  --h:44px; --fs-12:12px; --fs-14:13px; --fs-24:20px;
  --cell:18px; --gutter:12px;
}
@media (max-width:1100px){ :root{ --h:46px; --fs-24:19px; --fs-14:14px; } }
@media (max-width:680px){ :root{ --cell:14px; --gutter:10px; } }

/* THEMES */
[data-theme="dark"]{
  --bg:url('https://i.ibb.co/mCnFZSCv/Chat-GPT-Image-Oct-7-2025-03-54-39-PM.png');
  --dark:#070a10; --card:#0e1426; --glass:#0b1222da; --muted:#b8c3d8; --text:#e8f0ff; --text-muted:#bcd1ff;
  --panel:#0b1326; --panel-2:#0d1529; --panel-3:#0f1a33;
  --glare:radial-gradient(900px 320px at 10% -20%, rgba(255,255,255,.06), transparent 70%),
          radial-gradient(900px 320px at 90% -30%, rgba(255,255,255,.05), transparent 70%);
  --blur-bg:brightness(.45) saturate(1.0);
}
[data-theme="light"]{
  --bg:url('https://i.ibb.co/mCnFZSCv/Chat-GPT-Image-Oct-7-2025-03-54-39-PM.png');
  --dark:#eef3ff; --card:#ffffff; --glass:#ffffffcc; --muted:#51607e; --text:#0b1222; --text-muted:#40507a;
  --panel:#ffffff; --panel-2:#f7f9ff; --panel-3:#f2f6ff;
  --glare:radial-gradient(900px 320px at 10% -20%, rgba(0,0,0,.03), transparent 70%),
          radial-gradient(900px 320px at 90% -30%, rgba(0,0,0,.03), transparent 70%);
  --blur-bg:brightness(.9) saturate(1.05);
  --stroke-1:#d9e2ff; --stroke-2:#d0dbff; --stroke-3:#c8d6ff; --stroke-4:#c0d0ff; --stroke-5:#b6caff;
}

*{box-sizing:border-box}
html{ scrollbar-gutter: stable both-edges; }
html,body{height:100%; overflow-x:hidden}
body{margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; background:var(--dark); color:var(--text); font-size:var(--fs-14)}
.bg::before{content:""; position:fixed; inset:0; z-index:-3; background-image:var(--bg); background-size:cover; background-position:center; filter:blur(2px) var(--blur-bg); transform:scale(1.03)}
.bg::after{content:""; position:fixed; inset:0; z-index:-2; background:
  linear-gradient( rgba(6,8,12,.40), rgba(6,8,12,.40) ),
  radial-gradient(1200px 1200px at 80% -10%, #141a2b77, transparent 70%),
  radial-gradient( 800px  800px at -10% 110%, #0b0f1c66, transparent 60%),
  var(--glare)}

/* WRAP (left nudge per your last request) */
.wrap{
  max-width:1180px; width:100%;
  margin-inline:auto;
  padding:18px var(--gutter);
  display:grid; gap:16px;
  transform: translateX(-120px);
}
@media (max-width:980px){ .wrap{ transform:none; } }

.emboss{box-shadow: inset 1px 1px 0 var(--emboss-hi), inset -3px -3px 0 var(--emboss-lo), 0 12px 30px rgba(0,0,0,.35); border-color:var(--emboss-edge)!important}
.pulse{animation:pulse 2200ms ease-in-out infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(64,185,255,.0)}50%{box-shadow:0 0 0 6px rgba(64,185,255,.08)}}
.shine{position:relative; overflow:hidden}
.shine::after{content:""; position:absolute; inset:0; background:linear-gradient(120deg,transparent,rgba(255,255,255,.12),transparent); transform:translateX(-120%); animation:shine 4s linear infinite}

/* HEADER */
header{display:flex; align-items:center; gap:12px; flex-wrap:wrap; position:sticky; top:0; z-index:1000; backdrop-filter:saturate(1.1) blur(6px); background:linear-gradient(180deg, rgba(7,10,16,.58), rgba(7,10,16,.18)); border-bottom:1px solid var(--stroke-2)}
.brand{display:flex; align-items:center; gap:10px}
.brand h1{margin:0; font-size:clamp(18px,3vw,26px)}
.chip{padding:6px 10px; border-radius:999px; background:#0e1730; color:#b8c3d8; font-size:12px; border:1px solid var(--stroke-1)}
.topbar{display:flex; gap:8px; flex-wrap:wrap}
.pill{display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px; background:#0e1934; border:1px solid var(--stroke-2); font-weight:700}
.dot{width:10px;height:10px;border-radius:50%}.dot.red{background:#ff3b30}.dot.blue{background:#2f7cff}
.user{margin-left:auto; display:flex; align-items:center; gap:8px; position:relative}
.iconbtn{height:38px; min-width:38px; border-radius:12px; display:grid; place-items:center; cursor:pointer; background:linear-gradient(180deg,#1a2848,#0f1b37); border:1px solid #263a66; color:#e6f0ff}
.avatar{width:38px;height:38px;border-radius:12px;border:2px solid #1f2b50;background-size:cover;background-position:center}
.menu,.notifpanel{position:absolute; top:46px; right:0; width:300px; padding:12px; border-radius:14px; background:var(--glass); border:1px solid var(--stroke-1); backdrop-filter:blur(14px); z-index:1200; opacity:0; transform:translateY(-8px) scale(.98); pointer-events:none; transition:all var(--speed) var(--e)}
.menu.show,.notifpanel.show{opacity:1; transform:translateY(0) scale(1); pointer-events:auto}
.menu .row{display:flex; align-items:center; gap:10px; padding:10px 12px; margin:8px 0; border-radius:12px; text-decoration:none; color:var(--text); background:var(--panel-2); border:1px solid var(--stroke-3)}
.notiflist{max-height:320px; overflow:auto; display:grid; gap:8px}
.notif{display:grid; gap:4px; padding:10px 12px; border-radius:12px; background:var(--panel-2); border:1px solid var(--stroke-3)} .notif.unread{outline:2px solid rgba(64,185,255,.35)}
.badge-dot{position:absolute; top:-2px; right:-2px; min-width:16px; height:16px; padding:0 5px; border-radius:999px; background:#ff3b30; color:#fff; font-size:10px; display:grid; place-items:center; border:2px solid #0c152a}

/* PANELS / TABS */
.panel{background:var(--glass); border:1px solid var(--stroke-1); border-radius:var(--radius); backdrop-filter:blur(10px); padding:10px}
.tabs{display:flex; gap:6px; padding:6px 10px; border-bottom:1px solid var(--stroke-2); overflow:auto; scroll-snap-type:x mandatory; margin-bottom:8px}
.tab{cursor:pointer; padding:8px 12px; border-radius:12px; font-weight:900; letter-spacing:.3px; color:#fff; background:#0e1934; border:1px solid var(--stroke-3); white-space:nowrap; scroll-snap-align:start}
.tab.active{background:linear-gradient(90deg,#1e3a8a 0%, #7c0a0a 100%)}

/* VIDEO FRAME */
.frame{ position:relative; aspect-ratio:16/9; border-radius:16px; overflow:hidden; background:#000; border:1px solid var(--stroke-3); box-shadow:0 18px 40px rgba(0,0,0,.45),0 6px 14px rgba(0,0,0,.25),inset 0 0 0 1px rgba(255,255,255,.05) }
.frame::after{content:""; position:absolute; inset:0; border-radius:16px; pointer-events:none; box-shadow:inset 0 0 0 4px #2a3d6a,inset 0 0 0 6px rgba(255,255,255,.06)}
@media (hover:hover){ .frame:hover{ transform:translateY(-1px); transition:transform .18s ease; } }
iframe{position:absolute; inset:0; width:100%; height:100%; border:0}

/* GRID: video + kiosk */
.videogrid{display:grid; grid-template-columns:minmax(0,1fr) clamp(300px, 30vw, 380px); gap:12px; align-items:start; margin:0}
@media (max-width:980px){.videogrid{grid-template-columns:1fr}}
.kiosk-side{display:flex; flex-direction:column; gap:10px; padding:8px; background:var(--panel-2); border:1px solid var(--stroke-2); border-radius:14px; overflow:auto}

/* CARD LOOK FOR ODDS */
.cards{display:grid; grid-template-columns:1fr 1fr; gap:12px}
.betcard{position:relative; border-radius:22px; padding:14px; color:#fff; box-shadow:0 10px 30px rgba(0,0,0,.35), inset 1px 1px 0 var(--emboss-hi), inset -3px -3px 0 var(--emboss-lo); border:1px solid rgba(255,255,255,.06)}
.betcard .top{display:flex; align-items:center; justify-content:space-between}
.badge{width:34px;height:34px;border-radius:50%; display:grid;place-items:center;font-weight:900;background:#00000033;border:2px solid #ffffff55}
.name{font-size:13px; opacity:.9}
.big{font-size:clamp(28px,6.8vw,38px); font-weight:900; letter-spacing:.5px; line-height:1.05; margin:6px 0 10px}
.pill{display:flex; align-items:center; justify-content:center; font-weight:900; border-radius:14px; padding:6px 10px; font-size:13px; background:#0000002e; border:1px solid #ffffff30; text-shadow:0 1px 0 rgba(0,0,0,.35)}
.betcard .cta{margin-top:10px; display:grid; gap:8px}
.betcard .cta .betbtn{height:42px; border-radius:12px; font-weight:900; border:1px solid #ffffff40; background:#00000026; color:#fff; cursor:pointer; text-shadow:0 1px 0 rgba(0,0,0,.3)}
.sub{font-size:12px; opacity:.85}
.betcard.red{ background:linear-gradient(180deg,#f04e41 0%, #a02121 100%); }
.betcard.blue{ background:linear-gradient(180deg,#4f89ff 0%, #153b90 100%); }

/* CONTROLS / TOTALS */
.pad{background:var(--panel-2); border:1px solid var(--stroke-4); border-radius:14px; padding:8px; display:grid; grid-template-columns:repeat(2,1fr); gap:8px}
.chipbtn{height:var(--h); display:flex; align-items:center; justify-content:center; border-radius:12px; font-weight:900; letter-spacing:.3px; cursor:pointer; color:#eef5ff; text-shadow:0 1px 0 rgba(0,0,0,.35); font-size:13px; white-space:nowrap}
#chips{ grid-template-columns:repeat(2,1fr); }
.chipbtn{ height:var(--h); border-radius:14px; font-weight:900; border:1px solid transparent; font-size:14px; }
.chipbtn.chip-green{ background:linear-gradient(180deg,#2a9d55,#187d3e); border-color:#0f5c30; }
.chipbtn.chip-blue2{ background:linear-gradient(180deg,#2f7cff,#1a4fb5); border-color:#163f8f; }
.chipbtn.chip-black{ background:linear-gradient(180deg,#2c2f35,#15171b); border-color:#0b0c0f; }
.chipbtn.chip-orange{ background:linear-gradient(180deg,#ffb23a,#d48112); border-color:#a76407; color:#1b1203; text-shadow:none; }

.slip{background:var(--panel-2); border:1px solid var(--stroke-4); border-radius:14px; padding:10px; display:grid; gap:8px}
.slip input{width:100%; height:calc(var(--h) - 4px); background:#0a1122; color:#e9f3ff; border:1px solid var(--stroke-4); padding:0 12px; border-radius:12px; font-weight:800}
.btn{height:var(--h); display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-weight:900; letter-spacing:.3px; cursor:pointer; text-shadow:0 1px 0 rgba(0,0,0,.25); font-size:13px}
.btn.red{background:linear-gradient(180deg,#9a1616,#4b0a0a); border:1px solid #3a1a1f; color:#ffecec}
.btn.blue{background:linear-gradient(180deg,#1a4a9e,#0d2b66); border:1px solid #1f2b50; color:#e6f0ff}
.btn.ghost{background:#0c1630; border:1px solid var(--stroke-5); color:#fff}

/* TOTALS WIDGET */
.totbox{background:#0e1426; border:1px solid var(--stroke-3); border-radius:14px; padding:10px; display:grid; gap:8px}
.totbox .row{display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px dashed var(--stroke-5)}
.totbox .row:last-child{border-bottom:0}
.meter{height:10px; background:#0c1220; border:1px solid #263553; border-radius:999px; overflow:hidden}
.meter>span{display:block; height:100%; background:linear-gradient(90deg,var(--red),var(--blue))}

/* RESULTS / ROADS */
.results{background:var(--panel); border:1px solid var(--stroke-1); border-radius:14px; padding:12px; display:grid; gap:12px}
.rhead{display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap}
.rhead .bar{display:flex; gap:8px; flex-wrap:nowrap; overflow:auto; padding-bottom:4px}
.rhead .bar::-webkit-scrollbar{height:6px}

.roadsRow{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.roadgrid{
  display:grid;
  grid-template-rows:repeat(6, var(--cell));
  grid-auto-columns:var(--cell);
  grid-auto-flow:column;
  padding:8px;
  border:1px solid var(--stroke-3);
  border-radius:12px;
  background:var(--panel-3);
  overflow:auto;
  max-height:calc(var(--cell)*6 + 16px);
}
.cell{width:calc(var(--cell) - 2px); height:calc(var(--cell) - 2px); border-radius:50%; border:2px solid var(--stroke-5); display:flex; align-items:center; justify-content:center; font-size:11px; color:#fff; font-weight:900}
.cell.red{background:radial-gradient(circle at 30% 30%, #ff7a70, #b71c1c)} .cell.blue{background:radial-gradient(circle at 30% 30%, #8fb6ff, #0b3ca8)}
.cell.hollow{ background:transparent !important; } .cell.red.hollow{ border-color:#ff7a70; } .cell.blue.hollow{ border-color:#8fb6ff; }

.table{width:100%; border-collapse:separate; border-spacing:0 8px; overflow:auto}
.table thead th{font-size:12px; color:#bcd1ff; text-align:left; padding:0 10px; white-space:nowrap}
.table tbody tr{background:var(--panel-3); border:1px solid var(--stroke-3)}
.table td{padding:10px; font-weight:700; white-space:nowrap}
.b-red{background:#3b1212; color:#ffecec} .b-blue{background:#11244d; color:#e6f0ff}

/* PAGINATION */
.pager{ display:flex; gap:8px; align-items:center; justify-content:flex-end; padding:6px 0 }
.btn.sm{ height:34px; padding:0 10px; font-size:12.5px }
.pageinfo{ font-weight:800; color:#bcd1ff }

/* SETTINGS POPUP */
.settings-backdrop{ position:fixed; inset:0; z-index:1300; display:none; place-items:center; background:rgba(0,0,0,.45); backdrop-filter:blur(4px) }
.settings-backdrop.show{ display:grid }
.settings-card{ width:min(520px, calc(100% - 24px)); background:var(--glass); border:1px solid var(--stroke-1); border-radius:16px; padding:16px; box-shadow:0 24px 60px rgba(0,0,0,.45),0 8px 20px rgba(0,0,0,.25),inset 1px 1px 0 var(--emboss-hi),inset -3px -3px 0 var(--emboss-lo) }
.settings-card h3{ margin:0 0 10px }
.drow{background:var(--panel-2); border:1px solid var(--stroke-3); border-radius:12px; padding:10px; display:flex; align-items:center; justify-content:space-between; margin:10px 0}
.switch{position:relative; width:54px; height:30px; border-radius:999px; border:1px solid var(--stroke-4); background:#18223c; cursor:pointer}
.switch .knob{position:absolute; top:3px; left:3px; width:24px; height:24px; border-radius:50%; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,.35); transition:left var(--speed) var(--e)}
.switch.on{background:linear-gradient(90deg,var(--blue),var(--red))} .switch.on .knob{left:27px}

/* MOBILE */
@media (max-width:680px){
  body{padding-bottom:64px; padding-left:env(safe-area-inset-left); padding-right:env(safe-area-inset-right)}
  .wrap{padding:12px var(--gutter); gap:10px}
  header{gap:6px; padding:8px var(--gutter)}
  .brand h1{font-size:17px}
  .chip{display:none}
  .topbar{order:3; width:100%; overflow:auto; padding-bottom:1px; margin-top:2px}
  .pill{padding:5px 10px; font-size:11.5px; border-color:var(--stroke-3)}
  .tabs{position:sticky; top:64px; z-index:900; background:linear-gradient(180deg, rgba(7,10,16,.78), rgba(7,10,16,.28)); backdrop-filter:blur(6px)}
  .tab{padding:8px 12px; border-radius:999px; font-size:12.5px}

  .frame{border-radius:12px}
  .videogrid{gap:8px}

  .cards{grid-template-columns:1fr; gap:10px}
  #chips{grid-auto-flow:column; grid-auto-columns:minmax(110px,1fr); overflow-x:auto; padding:6px; scroll-snap-type:x mandatory}
  #chips .chipbtn{scroll-snap-align:center; height:44px; font-size:14px}
  #chips::-webkit-scrollbar{height:5px}

  :root{ --h:42px; }
  .slip input{height:44px; font-size:15px}
  .chipbtn,.btn{height:44px; font-size:14px}

  .rhead .bar{width:100%; gap:6px}
  .rhead .bar .btn{height:40px; padding:0 10px; white-space:nowrap; font-size:12.5px}

  .roadsRow{grid-template-columns:1fr; gap:8px}
  .cell{font-size:0}
}

/* polish */
.panel, .kiosk-side, .totbox, .results, .menu, .notifpanel, .settings-card, .emboss {
  box-shadow: inset 1px 1px 0 var(--emboss-hi), inset -3px -3px 0 var(--emboss-lo), 0 10px 30px rgba(0,0,0,.25), 0 0 0 1px var(--emboss-edge);
}
.tab.active { filter: drop-shadow(0 6px 14px rgba(64,120,255,.25)); }
#oddsRed, #oddsBlue, #txRed, #txBlue { transition: color .2s ease, text-shadow .2s ease; }
.flash{ color:#fff !important; text-shadow:0 0 10px rgba(47,124,255,.55); }

/* sticky mobile quick bet rail */
.mb-rail{position:fixed;left:0;right:0;bottom:0;background:rgba(10,18,35,.9);backdrop-filter:blur(8px);border-top:1px solid var(--stroke-3);padding:8px;display:flex;gap:8px;z-index:1200}
.mb-rail input{flex:1;height:42px;border-radius:10px;border:1px solid var(--stroke-4);background:#0a1122;color:#e9f3ff;padding:0 10px}
.mb-rail .bet{height:42px;border-radius:10px;border:1px solid #1f2b50;background:linear-gradient(180deg,#1a4a9e,#0d2b66);color:#fff;font-weight:900;padding:0 16px}
</style>
</head>
<body>
<div class="bg"></div>
<div class="wrap">
  <!-- HEADER -->
  <header>
    <div class="brand">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" class="pulse" aria-hidden="true">
        <defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#1e3a8a"/><stop offset="100%" stop-color="#7c0a0a"/></linearGradient></defs>
        <path d="M4 17h4l2 3 4-6 2 3h4" stroke="url(#g)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="5" cy="17" r="2" fill="var(--accent)"/><circle cx="19" cy="17" r="2" fill="var(--accent)"/></svg>
      <h1 class="shine">Drag Race Dashboard</h1>
      <span class="chip">inbose • mobile-first</span>
    </div>

    <div class="topbar">
      <div class="pill emboss"><strong>TOTAL POT:</strong> <span id="pot">0</span></div>
      <div class="pill emboss"><span class="dot red"></span> Rider Red: <strong id="tR">0</strong></div>
      <div class="pill emboss"><span class="dot blue"></span> Rider Blue: <strong id="tB">0</strong></div>
      <div class="pill emboss"><span>⏱️ Round:</span> <strong id="timer">—</strong></div>
    </div>

    <div class="user">
      <button id="drawerOpen" class="iconbtn emboss" title="Settings">⚙️</button>
      <button id="notifBtn" class="iconbtn emboss" title="Notifications">🔔<span id="notifBadge" class="badge-dot" style="display:none">0</span></button>
      <div id="notifPanel" class="notifpanel emboss" role="menu" aria-hidden="true" style="right:52px">
        <div class="title" style="font-size:12px;color:#bcd1ff;margin:4px 6px 8px">Notifications</div>
        <div class="notiflist" id="notifList"></div>
        <div class="divider" style="height:1px;background:linear-gradient(90deg,transparent,var(--stroke-3),transparent);margin:6px 4px"></div>
        <div style="display:flex; gap:8px; justify-content:flex-end">
          <button id="markAllRead" class="btn ghost emboss" style="height:36px">Mark all read</button>
          <button id="clearNotif" class="btn emboss" style="height:36px">Clear</button>
        </div>
      </div>

      <div style="position:relative">
        <button id="profileBtn" class="iconbtn emboss" title="Profile"><div class="avatar" style="background-image:url('https://i.pravatar.cc/96?img=67')"></div></button>
        <div id="profileMenu" class="menu emboss" aria-hidden="true">
          <div class="row emboss" style="cursor:default; gap:12px">
            <div class="avatar" style="width:32px;height:32px;border-radius:8px;background-image:url('https://i.pravatar.cc/96?img=67')"></div>
            <div style="display:grid"><strong>Wilyonaryo</strong><small style="color:#bcd1ff">Pro Member</small></div>
          </div>
          <a href="#" class="row emboss" id="cashInBtn">Cash In</a>
          <a href="#" class="row emboss" id="withdrawBtn">Withdraw</a>
          <a href="#" class="row emboss" id="editProfile">Edit Profile</a>
          <a href="{{ url('/') }}" class="row emboss" style="background:linear-gradient(180deg,#9a1616,#4b0a0a); color:#ffecec; border-color:#3a1a1f">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <!-- SETTINGS MODAL -->
  <div id="settingsModal" class="settings-backdrop" aria-label="Settings" role="dialog" aria-hidden="true">
    <div class="settings-card emboss">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:6px">
        <h3 style="margin:0">Settings</h3>
        <button class="iconbtn emboss" id="settingsClose" title="Close" style="height:36px; min-width:36px">✕</button>
      </div>

      <div class="drow emboss"><div><strong>Dark Mode</strong><br><small style="color:#bcd1ff)">Switch theme</small></div><div id="sw-dark" class="switch"><div class="knob"></div></div></div>
      <div class="drow emboss"><div><strong>Fancy Animations</strong><br><small style="color:#bcd1ff)">Glow, pulse, float</small></div><div id="sw-fancy" class="switch"><div class="knob"></div></div></div>
      <div class="drow emboss"><div><strong>Sound Effects</strong><br><small style="color:#bcd1ff)">Clicks & beeps</small></div><div id="sw-sound" class="switch"><div class="knob"></div></div></div>
      <div class="drow emboss"><div><strong>Compact Mode</strong><br><small style="color:#bcd1ff)">Tighter paddings</small></div><div id="sw-compact" class="switch"><div class="knob"></div></div></div>
      <div class="drow emboss"><div><strong>High Contrast</strong><br><small style="color:#bcd1ff)">Stronger borders/text</small></div><div id="sw-contrast" class="switch"><div class="knob"></div></div></div>
      <div class="drow emboss"><div><strong>Haptic Feedback</strong><br><small style="color:#bcd1ff)">Vibrate on actions</small></div><div id="sw-haptic" class="switch"><div class="knob"></div></div></div>
      <div class="drow emboss"><div><strong>Desktop Notifications</strong><br><small style="color:#bcd1ff)">Allow browser alerts</small></div><div id="sw-deskn" class="switch"><div class="knob"></div></div></div>
    </div>
  </div>

  <!-- VIDEO + SIDE KIOSK -->
  <section class="panel emboss">
    <div class="tabs">
      <button class="tab emboss active" data-tab="odds">ODDS</button>
      <button class="tab emboss" data-tab="total">TOTAL</button>
    </div>

    <div class="videogrid">
      <div class="frame emboss"><iframe id="yt" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>

      <div class="kiosk-side emboss" id="kioskSide">
        <div id="oddsView">
          <div class="cards">
            <div class="betcard red">
              <div class="top">
                <div class="badge">R</div>
                <div class="name" id="nameRed">Rider Red</div>
              </div>
              <div class="big" id="amtRed">0</div>
              <div class="pill">PAYOUT = <span id="oddsRed">1.88</span></div>
              <div class="cta">
                <button class="betbtn" data-bet="red">BET</button>
                <div class="sub">Winnings per ₱100: ₱<span id="payR100">188</span></div>
              </div>
            </div>

            <div class="betcard blue">
              <div class="top">
                <div class="badge">B</div>
                <div class="name" id="nameBlue">Rider Blue</div>
              </div>
              <div class="big" id="amtBlue">0</div>
              <div class="pill">PAYOUT = <span id="oddsBlue">2.08</span></div>
              <div class="cta">
                <button class="betbtn" data-bet="blue">BET</button>
                <div class="sub">Winnings per ₱100: ₱<span id="payB100">208</span></div>
              </div>
            </div>
          </div>

          <div class="slip emboss">
            <input id="amount" type="number" min="1" placeholder="Enter amount" class="emboss"/>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px">
              <button class="btn ghost emboss" id="reset">Reset</button>
              <button class="btn ghost emboss" id="maxAmt">Max</button>
            </div>
          </div>

          <div class="pad emboss" id="chips" style="margin-top:2px">
            <button class="chipbtn chip-green emboss">♦100</button>
            <button class="chipbtn chip-blue2 emboss">♦200</button>
            <button class="chipbtn chip-black emboss">♦500</button>
            <button class="chipbtn chip-orange emboss">♦1000</button>
          </div>

          <div class="totbox emboss" id="totalsWidget">
            <div class="row"><strong>POT</strong><strong id="pot2">0</strong></div>
            <div class="row"><span>Bets (Rider Red / Rider Blue)</span><strong><span id="tR2">0</span> / <span id="tB2">0</span></strong></div>
            <div class="row"><span>Est. Payout (x)</span><strong><span style="color:#bcd1ff">Rider Red</span> <span id="payoutR">× 1.88</span> • <span style="color:#bcd1ff">Rider Blue</span> <span id="payoutB">× 2.08</span></strong></div>
            <div class="meter emboss"><span id="bar" style="width:0%"></span></div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px">
              <button id="resetTotals" class="btn ghost emboss" style="height:36px">Reset Totals</button>
              <button id="demoBets" class="btn ghost emboss" style="height:36px">Simulate</button>
            </div>
          </div>
        </div>

        <div id="totalView" hidden>
          <div class="cards">
            <div class="betcard red"><div class="name">Total Bets — Red</div><div class="big" id="totalRed">0</div><div class="pill">Pool Share — <span id="shareRed">0%</span></div></div>
            <div class="betcard blue"><div class="name">Total Bets — Blue</div><div class="big" id="totalBlue">0</div><div class="pill">Pool Share — <span id="shareBlue">0%</span></div></div>
          </div>
          <div class="cards" style="margin-top:8px">
            <div class="betcard red"><div class="name">Odds (x) — Red</div><div class="big" id="txRed">1.88</div></div>
            <div class="betcard blue"><div class="name">Odds (x) — Blue</div><div class="big" id="txBlue">2.08</div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- RESULTS / ROADMAP -->
  <section class="panel emboss">
    <div class="results emboss">
      <div class="rhead">
        <h3 style="margin:0">Roadmap • Results</h3>
        <div class="bar">
          <button class="btn red emboss" id="winRed">Record: Red Wins</button>
          <button class="btn blue emboss" id="winBlue">Record: Blue Wins</button>
          <button class="btn ghost emboss" id="undo">Undo</button>
          <button class="btn ghost emboss" id="startRound">Start Round</button>
          <button class="btn ghost emboss" id="resetRound">Reset Round</button>
          <button class="btn emboss" id="clearLog">Clear Log</button>
          <button class="btn ghost emboss" id="exportCsv">Export CSV</button>
        </div>
      </div>

      <div class="center" style="margin-top:-4px"><div class="roadodds emboss" id="roadOdds" style="padding:6px 10px; border-radius:10px; text-align:center">Red × 1.88 • Blue × 2.08</div></div>

      <div class="roadsRow">
        <div>
          <div class="roadhead">Bead Road</div>
          <div id="bead" class="roadgrid emboss"></div>
        </div>
        <div>
          <div class="roadhead">Big Road</div>
          <div id="big" class="roadgrid emboss"></div>
        </div>
      </div>

      <div style="overflow:auto">
        <table class="table">
          <thead>
            <tr><th>Time</th><th>Winner</th><th>Pot</th><th>Odds</th><th>Payout/₱100</th></tr>
          </thead>
          <tbody id="logBody"></tbody>
        </table>
        <div class="pager">
          <button class="btn ghost sm emboss" id="firstPage">« First</button>
          <button class="btn ghost sm emboss" id="prevPage">‹ Prev</button>
          <span class="pageinfo"><span id="pageNow">1</span> / <span id="pageTotal">1</span></span>
          <button class="btn ghost sm emboss" id="nextPage">Next ›</button>
          <button class="btn ghost sm emboss" id="lastPage">Last »</button>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Sticky mobile quick-bet rail -->
<div class="mb-rail" id="mbRail" hidden>
  <input id="mbAmount" type="number" min="1" placeholder="₱ Amount"/>
  <button class="bet" id="mbBet">BET</button>
</div>

<!-- Toast placeholder -->
<div id="toast" style="position:fixed;right:16px;bottom:16px;z-index:1500;display:grid;gap:8px"></div>

<!-- ===== Modals: Edit / Cash In / Withdraw ===== -->
<div id="modal-edit" class="menu modal emboss" role="dialog" aria-hidden="true" style="position:fixed; inset:0; display:none; place-items:center; background:rgba(0,0,0,.45)">
  <div class="emboss" style="width:min(520px, calc(100% - 24px)); background:var(--glass); border:1px solid var(--stroke-1); border-radius:16px; padding:16px">
    <h2 style="margin:0 0 8px">Edit Profile</h2>
    <div class="emboss" style="background:var(--panel-2); border:1px solid var(--stroke-3); border-radius:12px; padding:12px; display:grid; gap:10px">
      <label>Display Name <input id="prof-name" type="text" placeholder="Your name" style="width:100%; height:44px; border-radius:10px; border:1px solid var(--stroke-4); background:var(--panel-3); color:var(--text); padding:0 10px"/></label>
      <label>Avatar URL <input id="prof-avatar" type="url" placeholder="https://..." style="width:100%; height:44px; border-radius:10px; border:1px solid var(--stroke-4); background:var(--panel-3); color:var(--text); padding:0 10px"/></label>
    </div>
    <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px">
      <button class="btn ghost emboss" data-close style="height:40px">Back</button>
      <button class="btn blue emboss" id="saveProfile" style="height:40px">Save</button>
    </div>
  </div>
</div>

<div id="modal-cash" class="menu modal emboss" role="dialog" aria-hidden="true" style="position:fixed; inset:0; display:none; place-items:center; background:rgba(0,0,0,.45)">
  <div class="emboss" style="width:min(520px, calc(100% - 24px)); background:var(--glass); border:1px solid var(--stroke-1); border-radius:16px; padding:16px">
    <h2 style="margin:0 0 8px">Cash In</h2>
    <div class="emboss" style="background:var(--panel-2); border:1px solid var(--stroke-3); border-radius:12px; padding:12px; display:grid; gap:10px">
      <label>Amount <input id="cash-amt" type="number" min="1" placeholder="₱0" style="width:100%; height:44px; border-radius:10px; border:1px solid var(--stroke-4); background:var(--panel-3); color:var(--text); padding:0 10px"/></label>
      <label>Method
        <select id="cash-method" style="width:100%; height:44px; border-radius:10px; border:1px solid var(--stroke-4); background:var(--panel-3); color:var(--text); padding:0 10px">
          <option>GCash</option><option>PayMaya</option><option>Bank Transfer</option>
        </select>
      </label>
    </div>
    <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px">
      <button class="btn ghost emboss" data-close style="height:40px">Back</button>
      <button class="btn red emboss" id="cashSubmit" style="height:40px">Confirm</button>
    </div>
  </div>
</div>

<div id="modal-withdraw" class="menu modal emboss" role="dialog" aria-hidden="true" style="position:fixed; inset:0; display:none; place-items:center; background:rgba(0,0,0,.45)">
  <div class="emboss" style="width:min(520px, calc(100% - 24px)); background:var(--glass); border:1px solid var(--stroke-1); border-radius:16px">
    <h2 style="margin:16px 16px 8px">Withdraw</h2>
    <div class="emboss" style="background:var(--panel-2); border:1px solid var(--stroke-3); border-radius:12px; padding:12px; display:grid; gap:10px; margin:0 16px 16px">
      <label>Amount <input id="wd-amt" type="number" min="1" placeholder="₱0" style="width:100%; height:44px; border-radius:10px; border:1px solid var(--stroke-4); background:var(--panel-3); color:var(--text); padding:0 10px"/></label>
      <label>Destination
        <select id="wd-method" style="width:100%; height:44px; border-radius:10px; border:1px solid var(--stroke-4); background:var(--panel-3); color:var(--text); padding:0 10px">
          <option>GCash</option><option>PayMaya</option><option>Bank Transfer</option>
        </select>
      </label>
    </div>
    <div style="display:flex; justify-content:flex-end; gap:8px; margin:0 16px 16px">
      <button class="btn ghost emboss" data-close style="height:40px">Back</button>
      <button class="btn blue emboss" id="wdSubmit" style="height:40px">Request</button>
    </div>
  </div>
</div>

<script>
/* ============ YouTube embed ============ */
(function(){
  const url='https://youtu.be/mzBv3fUDxRA?si=0X903bZ6UrB-v6UF';
  const embed=url.replace('https://youtu.be/','https://www.youtube.com/embed/').replace('watch?v=','embed/');
  const iframe=document.getElementById('yt');
  iframe.src=embed+(embed.includes('?')?'&':'?')+'rel=0&modestbranding=1';
  iframe.addEventListener('load', syncSideHeight);
})();

/* ============ App State ============ */
const state={ red:0, blue:0, oddsRed:1.88, oddsBlue:2.08, market:'—' };
const el=id=>document.getElementById(id);
const fmt=n=>Number(n).toLocaleString('en-PH',{maximumFractionDigits:0});

/* Logs pagination */
const PAGE_SIZE = 5;
let curPage = 1;
let logs = [];

/* Sound / Haptics */
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

/* Notifications */
let DESK_NOTIF=false;
const notifs=[]; let unread=0;
const notifUI={btn:el('notifBtn'),panel:el('notifPanel'),list:el('notifList'),badge:el('notifBadge')};
function renderNotifs(){
  notifUI.list.innerHTML='';
  if(!notifs.length){
    const d=document.createElement('div'); d.className='notif emboss'; d.innerHTML='<div class="title">No notifications</div><div class="meta">You are all caught up.</div>'; notifUI.list.appendChild(d);
  }else{
    notifs.slice().reverse().forEach(n=>{
      const d=document.createElement('div'); d.className='notif emboss '+(n.read?'':'unread');
      d.innerHTML=`<div class="title">${n.title}</div><div class="body">${n.body||''}</div><div class="meta">${new Date(n.ts).toLocaleTimeString('en-PH',{hour:'2-digit',minute:'2-digit'})}</div>`;
      notifUI.list.appendChild(d);
    });
  }
  notifUI.badge.style.display=unread>0?'grid':'none';
  notifUI.badge.textContent=unread>99?'99+':String(unread);
  localStorage.setItem('dr_notifs', JSON.stringify(notifs));
  localStorage.setItem('dr_unread', String(unread));
}
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
  notifUI.btn.addEventListener('click', (e)=>{ e.stopPropagation(); const show=!notifUI.panel.classList.contains('show'); notifUI.panel.classList.toggle('show', show); if(show){ notifs.forEach(n=>n.read=true); unread=0; renderNotifs(); }});
  document.addEventListener('click', (e)=>{ if(!notifUI.panel.contains(e.target) && !notifUI.btn.contains(e.target)) notifUI.panel.classList.remove('show'); });
  document.getElementById('markAllRead')?.addEventListener('click',()=>{ notifs.forEach(n=>n.read=true); unread=0; renderNotifs(); });
  document.getElementById('clearNotif')?.addEventListener('click',()=>{ notifs.length=0; unread=0; renderNotifs(); });
  try{ const s=JSON.parse(localStorage.getItem('dr_notifs')||'[]'); const u=Number(localStorage.getItem('dr_unread')||'0'); if(Array.isArray(s)) notifs.push(...s); unread=u||0; renderNotifs(); }catch{}
})();

/* UI Sync / Persist */
function sync(){
  const pot=state.red+state.blue;
  const r = pot? state.red/pot*100 : 0; const b=100-r;

  el('tR').textContent=fmt(state.red); el('tB').textContent=fmt(state.blue); el('pot').textContent=fmt(pot);

  el('amtRed').textContent=fmt(state.red);
  el('amtBlue').textContent=fmt(state.blue);
  el('oddsRed').textContent=state.oddsRed.toFixed(2);
  el('oddsBlue').textContent=state.oddsBlue.toFixed(2);
  el('payR100').textContent=(100*state.oddsRed).toFixed(0);
  el('payB100').textContent=(100*state.oddsBlue).toFixed(0);
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

/* Chips / Odds */
document.querySelectorAll('#chips .chipbtn').forEach(b=>{
  b.addEventListener('click',()=>{ const amt=Number(b.textContent.replace(/[^\d]/g,''))||0; const input=el('amount'); input.value=Number(input.value||0)+amt; beep('click',70,660,0.05); vibe(6); });
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

/* Bets */
document.querySelectorAll('[data-bet]').forEach(btn=>{
  btn.addEventListener('click',()=>{
    const side=btn.getAttribute('data-bet');
    const val=Math.max(0,Number(el('amount').value||0)); if(!val) return;
    if(val<10){ toast('Minimum bet is ₱10'); return; }
    state[side]+=val; el('amount').value='';
    recalcOdds(); sync(); beep('click',90,760,0.06); vibe(10);
    addNotif('Bet placed', `${side.toUpperCase()} • ₱${fmt(val)}`, 'bet');
  });
});
el('reset').addEventListener('click',()=>{ el('amount').value=''; beep('low',60,220,0.05); vibe(6); });
el('maxAmt').addEventListener('click',()=>{ const v=Number(el('amount').value||0); if(v<1) el('amount').value=100; beep('click',70,560,0.05); vibe(6); });

/* Mobile quick-bet rail */
(function(){
  const rail=el('mbRail');
  const isMobile=()=>window.matchMedia('(max-width:680px)').matches;
  const toggle=()=>rail.hidden=!isMobile();
  toggle(); addEventListener('resize', toggle);
  el('mbBet').addEventListener('click', ()=>{
    const v=Number(el('mbAmount').value||0);
    if(v<10){ toast('Minimum bet is ₱10'); return; }
    const side = state.oddsRed>state.oddsBlue ? 'red' : 'blue';
    state[side]+=v; el('mbAmount').value=''; recalcOdds(); sync();
    addNotif('Quick Bet', `${side.toUpperCase()} • ₱${fmt(v)}`, 'bet');
  });
})();

/* Totals quick actions */
el('resetTotals').addEventListener('click', ()=>{ state.red=0; state.blue=0; recalcOdds(); sync(); addNotif('Totals reset','All bet totals cleared','alert'); });
el('demoBets').addEventListener('click', ()=>{ const inc=Math.floor(Math.random()*5+1)*50; if(Math.random()>0.5) state.red+=inc; else state.blue+=inc; recalcOdds(); sync(); toast('Simulated bet: ₱'+fmt(inc)); });

/* Milestones */
let lastMilestone=0; function checkMilestones(pot){ const step=1000; const m=Math.floor(pot/step); if(m>lastMilestone){ lastMilestone=m; addNotif('Pot milestone', `Total pot hit ₱${fmt(m*step)}`, 'alert'); } }

/* Roads / Results */
const seq=[]; const ROWS=6, COLS=36;

/* logs + pagination */
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
      <td><span class="b-${row.winner==='Red'?'red':'blue'} badge">${row.winner}</span></td>
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

/* Roads renderers */
function renderBead(){
  const bead=el('bead'); bead.innerHTML='';
  for(let c=0;c<COLS;c++) for(let r=0;r<ROWS;r++){
    const d=document.createElement('div'); d.style.gridRow=(r+1); d.className='cell'; bead.appendChild(d);
  }
  seq.forEach((v,i)=>{
    const col=Math.floor(i/ROWS), row=i%ROWS; const idx=col*ROWS+row;
    const cell=bead.children[idx]; if(cell){ cell.classList.add(v==='R'?'red':'blue'); cell.textContent=String(i+1); }
  });
}
function renderBig(){
  const big=el('big'); big.innerHTML='';
  for(let c=0;c<COLS;c++) for(let r=0;r<ROWS;r++){
    const slot=document.createElement('div'); slot.style.gridRow=(r+1); slot.className='cell hollow'; big.appendChild(slot);
  }
  let col=0,row=0,last=null;
  const place=(v)=>{ 
    if(last===null){ last=v; col=0; row=0; }
    else if(v===last){ row++; if(row>=ROWS){ col++; row=ROWS-1; } }
    else { last=v; col++; row=0; }
    const idx = col*ROWS + row;
    const cell = big.children[idx];
    if(cell){ cell.classList.add(v==='R'?'red':'blue'); }
  };
  seq.forEach(v=>place(v));
}
function mark(v){ seq.push(v); renderBead(); renderBig(); addLog(v==='R'?'Red':'Blue'); beep('click',80,640,0.05); vibe(8); addNotif('Round result', `${v==='R'?'Red':'Blue'} wins`, 'win'); }
function undo(){
  if(!seq.length) return;
  seq.pop();
  logs.shift();
  renderBead(); renderBig(); renderLog(); saveAll();
  beep('low',70,260,0.05); vibe(8);
}
document.getElementById('winRed').addEventListener('click',()=>mark('R'));
document.getElementById('winBlue').addEventListener('click',()=>mark('B'));

/* Round Timer */
let tHandle=null, tLeft=0;
function formatSecs(s){ const mm=String(Math.floor(s/60)).padStart(2,'0'); const ss=String(s%60).padStart(2,'0'); return `${mm}:${ss}`; }
function setTimerText(txt){ el('timer').textContent=txt; }
function startRound(seconds=60){
  clearInterval(tHandle); tLeft=seconds; setTimerText(formatSecs(tLeft));
  addNotif('Round started','60 seconds','alert');
  tHandle=setInterval(()=>{ tLeft--; setTimerText(formatSecs(Math.max(tLeft,0))); if(tLeft<=0){ clearInterval(tHandle); tHandle=null; setTimerText('00:00'); addNotif('Round ended','Place bets closed','alert'); } },1000);
}
function resetRound(){ clearInterval(tHandle); tHandle=null; tLeft=0; setTimerText('—'); addNotif('Timer reset','Round timer cleared','info'); }
document.getElementById('startRound').addEventListener('click', ()=>startRound(60));
document.getElementById('resetRound').addEventListener('click', resetRound);

/* Tabs */
function showTab(name){
  document.querySelectorAll('.tab').forEach(x=>x.classList.toggle('active', x.dataset.tab===name));
  el('oddsView').hidden = name!=='odds';
  el('totalView').hidden = name!=='total';
  beep('click',60,520,0.045); syncSideHeight();
}
document.querySelectorAll('.tab').forEach(t=>t.addEventListener('click',()=>showTab(t.dataset.tab)));

/* Profile dropdown */
const profileBtn=el('profileBtn'), profileMenu=el('profileMenu');
function toggleMenu(force){ const show=typeof force==='boolean'?force:!profileMenu.classList.contains('show'); profileMenu.classList.toggle('show', show); }
profileBtn.addEventListener('click', e=>{ e.stopPropagation(); toggleMenu(); });
document.addEventListener('click', e=>{ if(!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) toggleMenu(false); });

/* SETTINGS MODAL */
const settingsModal = document.getElementById('settingsModal');
const openSettings  = document.getElementById('drawerOpen');
const closeSettings = document.getElementById('settingsClose');
function showSettings(show=true){
  settingsModal.classList.toggle('show', !!show);
  settingsModal.setAttribute('aria-hidden', show ? 'false' : 'true');
}
openSettings.addEventListener('click', ()=> showSettings(true));
closeSettings.addEventListener('click', ()=> showSettings(false));
settingsModal.addEventListener('click', (e)=>{ if(e.target === settingsModal) showSettings(false); });
document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') showSettings(false); });

/* Settings (persistent toggles) */
const switches={ dark:el('sw-dark'), fancy:el('sw-fancy'), sound:el('sw-sound'), compact:el('sw-compact'), contrast:el('sw-contrast'), haptic:el('sw-haptic'), deskn:el('sw-deskn') };
function setSwitch(elem,on){ elem.classList.toggle('on', !!on); elem.setAttribute('aria-checked', on?'true':'false'); }
function applyFromStorage(){
  const theme=localStorage.getItem('theme')||'dark'; document.documentElement.setAttribute('data-theme', theme); setSwitch(switches.dark, theme==='dark');
  const fancy=localStorage.getItem('fancy')!=='0'; document.body.classList.toggle('no-fancy', !fancy); setSwitch(switches.fancy, fancy);
  SOUND_ON=localStorage.getItem('sound')!=='0'; setSwitch(switches.sound, SOUND_ON);
  const compact=localStorage.getItem('compact')==='1'; document.body.classList.toggle('compact', compact); setSwitch(switches.compact, compact);
  const contrast=localStorage.getItem('contrast')==='1'; document.body.classList.toggle('high-contrast', contrast); setSwitch(switches.contrast, contrast);
  HAPTIC_ON=localStorage.getItem('haptic')==='1'; setSwitch(switches.haptic, HAPTIC_ON);
  DESK_NOTIF=localStorage.getItem('deskn')==='1'; setSwitch(switches.deskn, DESK_NOTIF);
} applyFromStorage();

Object.entries(switches).forEach(([key, elem])=>{
  elem.addEventListener('click', async ()=>{
    const isOn=!elem.classList.contains('on'); setSwitch(elem, isOn);
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
          DESK_NOTIF=(perm==='granted'); localStorage.setItem('deskn', DESK_NOTIF?'1':'0');
          setSwitch(elem, DESK_NOTIF);
          addNotif(DESK_NOTIF?'Desktop notifications ON':'Desktop notifications OFF','', 'info', false);
        } else { DESK_NOTIF=false; localStorage.setItem('deskn','0'); addNotif('Desktop notifications OFF','', 'info', false); }
        break;
    }
    beep('click',60,540,0.045); vibe(5);
  });
});

/* Toast + Layout sync */
function toast(msg,ms=2200){
  const t=document.createElement('div'); t.className='emboss';
  t.style.cssText='background:var(--glass);border:1px solid var(--stroke-2);padding:10px 12px;border-radius:12px;backdrop-filter:blur(8px);transform:translateY(10px);opacity:.0;transition:all 220ms cubic-bezier(.2,.8,.2,1)';
  t.textContent=msg; el('toast').appendChild(t);
  requestAnimationFrame(()=>{ t.style.opacity='1'; t.style.transform='none'; });
  setTimeout(()=>{ t.style.opacity='.0'; t.style.transform='translateY(6px)'; setTimeout(()=>t.remove(),220); }, ms);
}
function syncSideHeight(){
  const frame=document.querySelector('.videogrid .frame');
  const side=el('kioskSide');
  if(frame && side){
    const mobile = window.matchMedia('(max-width:680px)').matches;
    side.style.maxHeight = mobile ? 'unset' : (frame.clientHeight + 'px');
  }
}
window.addEventListener('resize', syncSideHeight);
window.addEventListener('load', syncSideHeight);

/* CSV / Clear */
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

/* Modals wiring */
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
  if(avatar) document.querySelectorAll('.avatar').forEach(a=>a.style.backgroundImage=`url('${avatar}')`);
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

/* Init */
function init(){ renderBead(); renderBig(); renderLog(); sync(); }
init();
</script>
<script src="https://huggingface.co/deepsite/deepsite-badge.js"></script>
</body>
</html>
