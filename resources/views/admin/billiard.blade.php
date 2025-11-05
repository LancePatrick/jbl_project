{{-- resources/views/billiard.blade.php --}}
<x-layouts.app :title="__('Billiard')">
  <body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>

  <!-- ========================================================
       MAIN: [video+logro | bets]
       NOTE: Left is wider than Right on md+ screens.
  ========================================================= -->
  <main class="max-w-screen-2xl 2xl:max-w-[2400px] mx-auto p-4">
    <div class="grid gap-6 md:grid-cols-[7fr_5fr]">

      <!-- LEFT: Video + Logrohan (WIDER) -->
      <div class="relative z-10 main-panel p-4 rounded-lg shadow-lg mt-17">
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
            <iframe
              id="youtube-video-main"
              class="absolute inset-0 w-full h-full rounded-lg relative z-20 border-4 border-transparent"
              src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
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

          @auth
            @if( auth()->user()->role_id == 1)
              <div class="flex items-center gap-2 mb-2">
                <button id="btn-win-meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-xs font-bold hover:bg-red-700">+ Red win</button>
                <button id="btn-win-wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-xs font-bold hover:bg-blue-700">+ Blue win</button>
                <button id="btn-undo"      class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-xs hover:bg-gray-700">Undo</button>
                <button id="btn-clear"     class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-xs hover:bg-gray-800">Clear</button>
              </div>
            @endif
          @endauth

          <div id="logro-rail" class="logro-rail">
            <div id="logro-strip" class="logro-strip-3d"></div>
          </div>
        </div>
        <!-- /LOGROHAN -->
      </div>

      <!-- RIGHT: Bet cards + Bet Amount (UNCHANGED) -->
      <aside>
        <div class="sticky mt-12 space-y-3">

          <!-- Bet Percentage Bar -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 translate-y-5">
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

          <!-- Cards -->
          <div id="bet-area" class="bet-area grid grid-cols-2 gap-3 mt-0 mb-0 translate-y-3">
            <!-- Meron -->
            <div class="bet-card red tilt text-center">
              <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">R</span></div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name"></div>
              <div class="amount-3d text-3xl md:text-4xl mt-1" id="meron-amount"></div>
              <div class="mt-">
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
              <div class="mt-3">
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

          <!-- Bet Amount + MINI ROAD -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-0 mt-4.5">
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
            @endif
          @endauth

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

      <!-- MOBILE STACK -->
      <div class="md:hidden space-y-3 col-span-2">
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

  <!-- ========================================================
       SCRIPT: betting + roads + helpers (UNCHANGED)
  ========================================================= -->
  <script>
    // A) CONFIG / CONSTANTS
    const players = [
      "Hagdang Bato","King Focus","LeBron James","Kid Molave",
      "JBL","Autumn Blaze","Desert Sage","Hidden Hollow",
      "Pony Punster","Santino","Panday","Hooves of Fury",
      "Golden Hour","Sun Chaser"
    ];
    const BIGROAD_MAX_ROWS = 8;
    const BEAD_MAX_ROWS    = 6;

    // B) STATE
    let results = [];
    let meronAmount, walaAmount, meronOdds, walaOdds;
    let currentBalance = 500000;
    const betHistory = [];

    // C) UTILS
    function getRandomPlayer(exclude){
      let name; do{ name = players[Math.floor(Math.random()*players.length)]; } while(name===exclude);
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
        const x=(e.clientX-r.left)/r.width; const y=(e.clientY-r.top)/r.height;
        const rx=(y-0.5)*damp, ry=(0.5-x)*damp;
        el.style.transform=`rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
      });
      el.addEventListener('mouseleave',()=>{ el.style.transform='rotateX(0) rotateY(0) translateY(0)'; });
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
        const t = run.t; let col, row;
        if(prevRunStartCol < 0){ col = 0; row = 0; }
        else { col = prevRunStartCol + 1; row = 0; while(!isEmpty(grid, col, row)){ col++; ensureCol(grid, col); } }
        const thisRunStartCol = col;
        let placed = 0;
        while(placed < run.n && row < maxRows && isEmpty(grid, col, row)){
          ensureCol(grid, col); grid[col][row] = { t, label: labelNo++ };
          placed++; row++;
        }
        const lockRow = Math.max(0, row - 1);
        let remain = run.n - placed; let c = col + 1;
        while(remain > 0){
          ensureCol(grid, c);
          if(isEmpty(grid, c, lockRow)){ grid[c][lockRow] = { t, label: labelNo++ }; remain--; }
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
        if(col.length === maxRows){ cols.push(col); col=[]; }
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
    function renderRoadStrictL(seq, stripId, maxRows = BEAD_MAX_ROWS){
      const cols = computeColumnsSequential(seq, maxRows);
      const strip = document.getElementById(stripId); if(!strip) return;
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
      strip.scrollLeft = strip.scrollWidth;
    }
    function renderAllRoads(seq){
      renderLogroContinuous(seq, 'logro-strip', BIGROAD_MAX_ROWS);
      renderLogroContinuous(seq, 'logro-strip-mob', BIGROAD_MAX_ROWS);
      renderRoadStrictL(seq, 'bead-strip', BEAD_MAX_ROWS);
    }

    // F) BETTING / BALANCE / ODDS
    function computeOdds(){
      meronOdds=(Math.random()*(2.0-1.5)+1.5).toFixed(2);
      walaOdds=(parseFloat(meronOdds)+0.20).toFixed(2);
    }
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
    function adjustBalance(delta){
      const next=currentBalance+delta;
      if(next<0) return false;
      currentBalance=next;
      renderBalance();
      return true;
    }
    function updatePercentBar(){
      const red = meronAmount||0;
      const blue = walaAmount||0;
      const total = red + blue;
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
    }

    // G) HISTORY UI
    function sideBadgeHTML(side){
      const cls=side==='MERON'?'side-badge side-meron':'side-badge side-wala';
      return `<span class="side-3d"><span class="${cls}">${side}</span></span>`;
    }
    function badgeClassByStatus(s){
      if(s==='WIN') return 'badge-3d badge-win';
      if(s==='LOSE') return 'badge-3d badge-lose';
      return 'badge-3d badge-pending';
    }
    function addToHistory(entry){
      betHistory.unshift(entry);
      renderHeaderHistory();
      const dot=document.getElementById('header-history-dot');
      if(dot) dot.classList.toggle('hidden', betHistory.length===0);
    }
    function renderHeaderHistory(){
      const list=document.getElementById('header-history-list');
      const empty=document.getElementById('header-history-empty');
      if(!list||!empty) return;
      if(betHistory.length===0){
        empty.classList.remove('hidden'); list.classList.add('hidden'); list.innerHTML=''; return;
      }
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

    // H) BET ACTIONS (unchanged)
    function resolveLatestBet(winSide){
      const idx=betHistory.findIndex(b=>b.status==='PENDING');
      if(idx===-1) return;
      const bet=betHistory[idx];
      if(bet.side===winSide){
        bet.status='WIN';
        adjustBalance(parseFloat(bet.payout));
        bet.balanceAfter=currentBalance;
      } else {
        bet.status='LOSE';
        bet.balanceAfter=currentBalance;
      }
      renderHeaderHistory();
    }
    function placeBet(betType){
      const input=document.getElementById('bet-amount');
      let betAmount=parseFloat(input.value);
      if(isNaN(betAmount)||betAmount<=0){
        alert('Please enter a valid bet amount greater than 0.');
        return;
      }
      let odds, chosenPlayer;
      if(betType==='MERON'){
        odds=meronOdds; chosenPlayer=document.getElementById('player1-name').textContent;
      } else {
        odds=walaOdds;  chosenPlayer=document.getElementById('player2-name').textContent;
      }
      const balanceBefore=currentBalance;
      if(!adjustBalance(-betAmount)){ alert('Insufficient balance.'); return; }
      if(betType==='MERON'){
        meronAmount+=betAmount;
        const el=document.getElementById('meron-amount'); if(el) el.textContent=meronAmount.toLocaleString();
      } else {
        walaAmount+=betAmount;
        const el=document.getElementById('wala-amount'); if(el) el.textContent=walaAmount.toLocaleString();
      }
      updatePercentBar();
      const totalWinnings=parseFloat(betAmount)*parseFloat(odds);
      if(betType==='MERON'){
        const r=document.getElementById('meron-result'); if(r) r.textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`;
        const c=document.getElementById('wala-result'); if(c) c.textContent="";
      } else {
        const r=document.getElementById('wala-result'); if(r) r.textContent=`${chosenPlayer} • Winnings: ${totalWinnings.toFixed(2)}`;
        const c=document.getElementById('meron-result'); if(c) c.textContent="";
      }
      const matchId=document.getElementById('match-no').textContent||'—';
      const time=new Date().toLocaleString('en-PH',{hour12:true});
      addToHistory({
        side:betType, player:chosenPlayer||(betType==='MERON'?'Red':'Blue'),
        matchId, amount:betAmount, odds:odds, payout:totalWinnings.toFixed(2),
        time, balanceBefore, balanceAfter:currentBalance, status:'PENDING'
      });
      alert(`You placed a bet of ${betAmount} on ${chosenPlayer}.
Possible payout: ${totalWinnings.toFixed(2)}.
New Balance: ${currentBalance.toLocaleString()}.`);
    }
    function pushResult(side){ results.push(side==='MERON'?'R':'B'); renderAllRoads(results); resolveLatestBet(side); }
    function undoResult(){ results.pop(); renderAllRoads(results); }
    function clearResults(){ results=[]; renderAllRoads(results); }

    // I) INIT
    window.onload = () => {
      setDateTime(); setRandomMatch();
      let meronAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      let walaAmountInit=Math.floor(Math.random()*(50000-10000+1))+10000;
      meronAmount=meronAmountInit; walaAmount=walaAmountInit;
      computeOdds(); renderOddsEverywhere();
      const ma=document.getElementById('meron-amount'); if(ma) ma.textContent=meronAmount.toLocaleString();
      const wa=document.getElementById('wala-amount');  if(wa) wa.textContent=walaAmount.toLocaleString();
      const mam=document.getElementById('meron-amount-mob'); if(mam) mam.textContent=meronAmount.toLocaleString();
      const wam=document.getElementById('wala-amount-mob');  if(wam) wam.textContent=walaAmount.toLocaleString();
      updatePercentBar();
      document.querySelectorAll('.tilt').forEach(attachTilt);
      const name='AMOK';
      const acct=document.getElementById('account-name'); if(acct) acct.textContent=name;
      const acctm=document.getElementById('account-name-menu'); if(acctm) acctm.textContent=name;
      const btn=document.getElementById('account-btn');
      const menu=document.getElementById('account-menu');
      if(btn && menu){
        btn.addEventListener('click',()=>{ menu.classList.toggle('hidden'); });
        document.addEventListener('click',(e)=>{ if(!btn.contains(e.target)&&!menu.contains(e.target)) menu.classList.add('hidden'); });
      }
      const wm=document.getElementById('btn-win-meron');
      const ww=document.getElementById('btn-win-wala');
      const uu=document.getElementById('btn-undo');
      const cc=document.getElementById('btn-clear');
      if(wm) wm.addEventListener('click', ()=> pushResult('MERON'));
      if(ww) ww.addEventListener('click',  ()=> pushResult('WALA'));
      if(uu) uu.addEventListener('click',  undoResult);
      if(cc) cc.addEventListener('click', clearResults);
      results=['R','R','R','R','R','R','R','R','R','B','B','B','B','B','B','B','B','R','R','R','R','R','R','R'];
      renderAllRoads(results); renderBalance();
      const hBtn=document.getElementById('header-history-btn');
      const hMenu=document.getElementById('header-history-menu');
      const hClear=document.getElementById('header-history-clear');
      if(hBtn && hMenu){ hBtn.addEventListener('click',(e)=>{ e.stopPropagation(); hMenu.classList.toggle('hidden'); }); }
      if(hClear){ hClear.addEventListener('click',()=>{ betHistory.length=0; renderHeaderHistory(); const dot=document.getElementById('header-history-dot'); if(dot) dot.classList.add('hidden'); }); }
      document.querySelectorAll('.bet-chip').forEach(btn=>{
        btn.addEventListener('click',()=>{
          const raw=parseInt(btn.dataset.val||'0',10);
          const amt=document.getElementById('bet-amount'); if(amt) amt.value=raw;
          btn.animate([{transform:'translateY(-3px)'},{transform:'translateY(0)'}],{duration:120});
        });
      });
      const bm=document.getElementById('bet-meron');
      const bw=document.getElementById('bet-wala');
      if(bm) bm.addEventListener('click', ()=> placeBet('MERON'));
      if(bw) bw.addEventListener('click',  ()=> placeBet('WALA'));
    };
  </script>
</body>
</x-layouts.app>
