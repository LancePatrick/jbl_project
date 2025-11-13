{{-- resources/views/drag-race-teller.blade.php --}}
<x-layouts.app :title="__('Drag Race — Teller Mode')">
  @php
    /** Teller-only: role_id 1 = admin/teller */
    $roleId = auth()->user()->role_id ?? 2;
  @endphp

  @if ($roleId !== 1)
    <script>location.href='{{ url('/dashboard') }}';</script>
  @else
  <body class="m-0 min-h-dvh overflow-y-auto overflow-x-hidden bg-[#050a15] font-[Inter,system-ui,-apple-system,Segoe_UI,Roboto,Helvetica,Arial] text-[13px] text-slate-100">

    <!-- BG -->
    <div class="fixed inset-0 -z-30 bg-cover bg-center"
         style="background-image:url('https://i.ibb.co/mCnFZSCv/Chat-GPT-Image-Oct-7-2025-03-54-39-PM.png'); filter:blur(2px) brightness(.45) saturate(1)"></div>
    <div class="fixed inset-0 -z-20 pointer-events-none"
         style="background:
           linear-gradient(rgba(6,8,12,.45), rgba(6,8,12,.45)),
           radial-gradient(1200px 1200px at 80% -10%, #141a2b77, transparent 70%),
           radial-gradient(800px 800px at -10% 110%, #0b0f1c66, transparent 60%)"></div>

    <div class="min-h-[100svh] grid place-items-center px-0">
      <div
        class="origin-top rounded-[18px] shadow-[0_20px_60px_rgba(0,0,0,.45)] transform
               scale-[.86] sm:scale-[.90] md:scale-[.94] lg:scale-[.98] xl:scale-100"
        style="width:1320px; height:780px"
      >
        <main class="h-[780px] w-[1320px] p-4 grid gap-4 grid-cols-[300px_minmax(0,1fr)_320px]">

          <!-- LEFT -->
          <aside class="space-y-4 rounded-[16px] border border-white/10 bg-[#0c1326e6] p-4 backdrop-blur-md shadow-[0_10px_30px_rgba(0,0,0,.25),inset_1px_1px_0_rgba(255,255,255,.06)]">
            <div class="grid grid-cols-[1fr_auto] items-center gap-2">
              <div class="text-xs uppercase tracking-wide opacity-80">
                <div>Event –</div>
                <div class="mt-0.5 text-[11px] opacity-70" id="eventDate"></div>
              </div>
              <div class="text-right">
                <div class="text-[13px] font-black text-amber-400">MATCH#</div>
                <div class="leading-none text-2xl font-black text-amber-300" id="matchNo">—</div>
              </div>
            </div>

            <div class="space-y-2">
              <button id="toggleVideo" class="inline-flex h-9 items-center gap-2 rounded-[10px] border border-white/15 bg-[#0d172f] px-3">
                <span class="size-3.5 rounded-full bg-white/60"></span> Hide Video
              </button>
              <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] border border-white/15 bg-black">
                <iframe id="yt" class="absolute inset-0 size-full hidden border-0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                <div id="videoOverlay" class="absolute inset-0 grid place-items-center text-xs">Video hidden</div>
              </div>
            </div>

            <div class="space-y-2 rounded-[12px] border border-white/12 bg-[#0d1529] p-3">
              <div class="text-[11px] tracking-wide opacity-75">SCAN / ENTER CARD</div>
              <input id="cardCode" type="text" placeholder="Enter or scan card code"
                     class="h-10 w-full rounded-[10px] border border-white/15 bg-[#0a1326] px-3 outline-none">
              <div class="grid grid-cols-2 gap-2">
                <button id="cardReset"  class="h-9 rounded-[10px] border border-white/15 bg-[#0c1630]">Reset</button>
                <button id="cardSubmit" class="h-9 rounded-[10px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] text-white">Submit Card</button>
              </div>
            </div>

            <div class="space-y-2 rounded-[12px] border border-white/12 bg-[#0d1529] p-3">
              <div class="text-[11px] tracking-wide opacity-75">CUSTOMER DETAILS</div>
              <div class="grid gap-2">
                <input id="fullName"  placeholder="Full name"      class="h-10 rounded-[10px] border border-white/15 bg-[#0a1326] px-3 outline-none">
                <input id="userName"  placeholder="Username"       class="h-10 rounded-[10px] border border-white/15 bg-[#0a1326] px-3 outline-none">
                <input id="emailAddr" placeholder="Email address"  class="h-10 rounded-[10px] border border-white/15 bg-[#0a1326] px-3 outline-none">
                <input id="contactNo" placeholder="Contact number" class="h-10 rounded-[10px] border border-white/15 bg-[#0a1326] px-3 outline-none">
              </div>
              <div class="grid grid-cols-2 gap-2 pt-1">
                <button id="scoreRed"  class="h-9 rounded-[10px] border border-[#3a1a1f]  bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] text-[#ffecec]">Red Score</button>
                <button id="scoreBlue" class="h-9 rounded-[10px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] text-[#e6f0ff]">Blue Score</button>
                <button id="undoBtn"   class="h-9 rounded-[10px] border border-white/15 bg-[#0c1630]">Undo</button>
                <button id="clearBtn"  class="h-9 rounded-[10px] border border-white/15 bg-[#0c1630]">Clear</button>
              </div>
            </div>
          </aside>

          <!-- CENTER -->
          <section class="space-y-4 rounded-[16px] border border-white/10 bg-[#0c1326e6] p-4 backdrop-blur-md shadow-[0_10px_30px_rgba(0,0,0,.25),inset_1px_1px_0_rgba(255,255,255,.06)]">
            <!-- Bet percentage -->
            <div class="space-y-2 rounded-[12px] border border-white/12 bg-[#0e1730] p-3">
              <div class="text-[11px] tracking-wide opacity-75">BET PERCENTAGE</div>
              <div class="h-3 overflow-hidden rounded-full border border-white/15 bg-[#0b1224]">
                <div id="barRed" class="h-full w-[50%] bg-gradient-to-r from-[#ff3b30] to-[#c12018]"></div>
              </div>
              <div class="flex justify-between text-[11px] opacity-75">
                <div>Red <span id="pctRed">50%</span></div>
                <div>Total: ₱<span id="totalPot">0</span></div>
                <div>Blue <span id="pctBlue">50%</span></div>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <!-- RED CARD -->
              <div class="rounded-[18px] border border-white/10 bg-[linear-gradient(180deg,#f04e41_0%,_#a02121_100%)] p-4 text-white shadow-[0_10px_30px_rgba(0,0,0,.35),inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46)] flex flex-col items-center text-center">
                <div class="flex items-center gap-2">
                  <div class="grid size-9 shrink-0 place-items-center rounded-full border-2 border-white/35 bg-black/20 font-black">R</div>
                  
                </div>
                <div id="amtRed" class="mt-1 text-[44px] leading-[1.05] font-black tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[12px] border border-white/30 bg-black/20 px-3 py-1.5 text-[12px] font-black">
                  PAYOUT = <span id="oddsRed" class="ml-1">1.55</span>
                </div>
                <button id="betRed" class="mt-3 h-10 px-4 rounded-[10px] border border-[#3a1a1f] bg-[linear-gradient(180deg,#9a1616,#4b0a0a)] text-[#ffecec] font-semibold">
                  Bet Red
                </button>
              </div>

              <!-- BLUE CARD -->
              <div class="rounded-[18px] border border-white/10 bg-[linear-gradient(180deg,#4f89ff_0%,_#153b90_100%)] p-4 text-white shadow-[0_10px_30px_rgba(0,0,0,.35),inset_1px_1px_0_rgba(255,255,255,.10),inset_-3px_-3px_0_rgba(0,0,0,.46)] flex flex-col items-center text-center">
                <div class="flex items-center gap-2">
                  <div class="grid size-9 shrink-0 place-items-center rounded-full border-2 border-white/35 bg-black/20 font-black">B</div>
                 
                </div>
                <div id="amtBlue" class="mt-1 text-[44px] leading-[1.05] font-black tracking-[.5px]">0</div>
                <div class="mt-2 grid place-items-center rounded-[12px] border border-white/30 bg-black/20 px-3 py-1.5 text-[12px] font-black">
                  PAYOUT = <span id="oddsBlue" class="ml-1">1.75</span>
                </div>
                <button id="betBlue" class="mt-3 h-10 px-4 rounded-[10px] border border-[#1f2b50] bg-[linear-gradient(180deg,#1a4a9e,#0d2b66)] text-[#e6f0ff] font-semibold">
                  Bet Blue
                </button>
              </div>
            </div>

            <!-- ===== Bet Chips Bar (UNDER cards, ABOVE roads) ===== -->
            <div class="rounded-[14px] border border-white/10 bg-[#0e1730] p-3">
              <div class="flex flex-wrap items-center gap-3">
                <div class="text-[12px] opacity-80 mr-1">Amount:</div>

                <button data-amt="100"  class="chip h-10 px-5 rounded-full bg-green-600/95 hover:bg-green-500 ring-1 ring-green-300/30 text-white font-semibold shadow-[inset_0_1px_0_rgba(255,255,255,.1),0_6px_14px_rgba(0,0,0,.35)]">₱100</button>
                <button data-amt="200"  class="chip h-10 px-5 rounded-full bg-blue-600/95  hover:bg-blue-500  ring-1 ring-blue-300/30  text-white font-semibold shadow-[inset_0_1px_0_rgba(255,255,255,.1),0_6px_14px_rgba(0,0,0,.35)]">₱200</button>
                <button data-amt="500"  class="chip h-10 px-5 rounded-full bg-slate-800/95 hover:bg-slate-700 ring-1 ring-slate-300/20 text-white font-semibold shadow-[inset_0_1px_0_rgba(255,255,255,.1),0_6px_14px_rgba(0,0,0,.35)]">₱500</button>
                <button data-amt="1000" class="chip h-10 px-5 rounded-full bg-amber-500/95 hover:bg-amber-4 00 ring-1 ring-amber-200/40 text-black font-semibold shadow-[inset_0_1px_0_rgba(255,255,255,.1),0_6px_14px_rgba(0,0,0,.35)]">₱1000</button>

                <div class="ml-auto flex items-center gap-2">
                  <div class="text-[12px] opacity-70">Selected:</div>

                  <!-- CUSTOM AMOUNT INPUT (min ₱100) -->
                  <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-white/80">₱</span>
                    <input
                      id="amtInput"
                      type="number"
                      inputmode="numeric"
                      min="100"
                      step="50"
                      value="100"
                      class="w-24 rounded-full border border-white/15 bg-white/10 pl-6 pr-3 py-1.5 text-center text-[12.5px] font-bold outline-none focus:border-white/40"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- ROADS ONLY -->
            <div class="space-y-3 rounded-[14px] border border-white/10 bg-[#0e1730] p-3">
              <div class="grid grid-cols-2 gap-4">
                <div class="rounded-[12px] border border-white/12 bg-[#0f1a33] p-2">
                  <div class="mb-2 text-[13px] font-semibold">Bead Road</div>
                  <div id="beadWrap" class="overflow-x-auto overflow-y-hidden rounded-[10px] border border-[#263553] p-2">
                    <div id="beadGrid" class="grid auto-flow-col grid-rows-[repeat(6,16px)] auto-cols-[16px] gap-[6px]"></div>
                  </div>
                </div>
                <div class="rounded-[12px] border border-white/12 bg-[#0f1a33] p-2">
                  <div class="mb-2 text-[13px] font-semibold">Big Road</div>
                  <div id="bigWrap" class="overflow-x-auto overflow-y-hidden rounded-[10px] border border-[#263553] p-2">
                    <div id="bigGrid" class="grid auto-flow-col grid-rows-[repeat(6,16px)] auto-cols-[16px] gap-[6px]"></div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- RIGHT -->
          <aside class="flex flex-col rounded-[16px] border border-white/10 bg-[#0c1326e6] p-4 backdrop-blur-md shadow-[0_10px_30px_rgba(0,0,0,.25),inset_1px_1px_0_rgba(255,255,255,.06)]">
            <div class="flex items-center justify-between">
              <h3 class="m-0 text-[14px] font-bold">Bet History</h3>
              <span class="size-2.5 rounded-full bg-emerald-400"></span>
            </div>
            <div class="mb-2 text-[11px] opacity-70">Showing 10 per page</div>

            <div class="flex-1 overflow-auto rounded-[12px] border border-white/12 bg-[#0f1a33]">
              <table class="w-full text-[12.5px]">
                <thead class="sticky top-0 bg-[#0f1a33]">
                  <tr class="text-[#bcd1ff] [&>th]:px-2 [&>th]:py-1 [&>th]:text-left">
                    <th>Time</th><th>Side</th><th>Amt</th><th>Odds</th><th>Est.Win</th>
                  </tr>
                </thead>
                <tbody id="histBody" class="[&>tr>td]:px-2 [&>tr>td]:py-1">
                  <tr><td colspan="5" class="py-3 text-center opacity-70">No bets yet.</td></tr>
                </tbody>
              </table>
            </div>

            <div class="pt-2 flex items-center justify-between text-[12.5px]">
              <button id="hPrev" class="h-8 rounded-[10px] border border-white/15 bg-[#0c1630] px-3">Prev</button>
              <div class="font-black">Page <span id="hPageNow">1</span> / <span id="hPageTotal">1</span></div>
              <button id="hNext" class="h-8 rounded-[10px] border border-white/15 bg-[#0c1630] px-3">Next</button>
            </div>
          </aside>
        </main>
      </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-4 right-4 z-[1500] grid gap-2"></div>

    <!-- ===== JS ===== -->
    <script>
      // Utils
      const el = id => document.getElementById(id);
      const fmt = n => Number(n).toLocaleString('en-PH',{maximumFractionDigits:0});
      const toast = (msg,ms=1600)=>{
        const t=document.createElement('div');
        t.className='rounded-[12px] border border-white/15 bg-[#0c1326] px-3 py-2 backdrop-blur translate-y-[10px] opacity-0 transition-all';
        t.textContent=msg; (document.getElementById('toast')||document.body).appendChild(t);
        requestAnimationFrame(()=>{t.style.opacity='1'; t.style.transform='none';});
        setTimeout(()=>{ t.style.opacity='0'; t.style.transform='translateY(8px)'; setTimeout(()=>t.remove(),200); },ms);
      };

      // State
      const state = { red:0, blue:0, oddsRed:1.55, oddsBlue:1.75, history:[], seq:[] };
      const PAGE = { size:10, now:1 };
      let currentAmount = 100; // <- selected/custom amount

      // Restore
      (function(){ try{ const s=JSON.parse(localStorage.getItem('dr_teller_state')||'null'); if(s) Object.assign(state,s); }catch{} })();

      // Video toggle
      (function(){
        const url='https://youtu.be/mzBv3fUDxRA?si=0X903bZ6UrB-v6UF';
        const embed=url.replace('https://youtu.be/','https://www.youtube.com/embed/').replace('watch?v=','embed/');
        const iframe=el('yt'); iframe.src=embed+(embed.includes('?')?'&':'?')+'rel=0&modestbranding=1&playsinline=1';
        const btn=el('toggleVideo'), overlay=el('videoOverlay');
        const apply=()=>{ const show=overlay.classList.contains('hidden'); iframe.classList.toggle('hidden',!show); };
        btn.addEventListener('click',()=>{ overlay.classList.toggle('hidden'); apply(); });
        apply();
      })();

      // Header
      (function(){
        const d=new Date();
        el('eventDate').textContent = d.toLocaleDateString('en-PH')+' • '+d.toLocaleTimeString('en-PH',{weekday:'short',hour:'2-digit',minute:'2-digit',hour12:true});
        el('matchNo').textContent = (Math.floor(Math.random()*300)+100);
      })();

      // Persistence helpers
      function save(){ try{ localStorage.setItem('dr_teller_state', JSON.stringify(state)); }catch{} }
      function recalc(){
        const pot = state.red + state.blue;
        const r = pot ? state.red / pot * 100 : 0; const b = 100 - r;
        el('barRed').style.width = r+'%';
        el('pctRed').textContent = r.toFixed(0)+'%';
        el('pctBlue').textContent = b.toFixed(0)+'%';
        el('totalPot').textContent = fmt(pot);
        el('amtRed').textContent = fmt(state.red);
        el('amtBlue').textContent = fmt(state.blue);
        el('oddsRed').textContent = state.oddsRed.toFixed(2);
        el('oddsBlue').textContent = state.oddsBlue.toFixed(2);
        renderHistory(); save();
      }

      // Roads
      const ROWS=6, COLS=100;
      function dotEmpty(d){ d.className='w-[12px] h-[12px] rounded-full border-[2px] border-[#2b4273]'; }
      function dotFill(d, side){
        d.className='w-[12px] h-[12px] rounded-full border-[2px]';
        if(side==='R'){ d.style.background='radial-gradient(circle at 30% 30%, #ff7a70, #b71c1c)'; d.style.borderColor='#ff7a70'; }
        else{ d.style.background='radial-gradient(circle at 30% 30%, #8fb6ff, #0b3ca8)'; d.style.borderColor='#8fb6ff'; }
      }
      function initGrid(id){
        const g=el(id); g.innerHTML='';
        for(let c=0;c<COLS;c++) for(let r=0;r<ROWS;r++){
          const d=document.createElement('div'); d.style.gridRow=(r+1); dotEmpty(d); g.appendChild(d);
        }
      }
      function renderBead(){
        const g=el('beadGrid'); if(!g) return; [...g.children].forEach(dotEmpty);
        state.seq.forEach((v,i)=>{ const col=Math.floor(i/ROWS), row=i%ROWS; const d=g.children[col*ROWS+row]; if(d) dotFill(d, v); });
      }
      function renderBig(){
        const g=el('bigGrid'); if(!g) return; [...g.children].forEach(dotEmpty);
        let col=0,row=0,last=null;
        const place=(v)=>{ if(last===null){ last=v; col=0; row=0; } else if(v===last){ row++; if(row>=ROWS){ col++; row=ROWS-1; } } else { last=v; col++; row=0; }
          const d=g.children[col*ROWS+row]; if(d) dotFill(d, v); };
        state.seq.forEach(place);
      }
      function addResult(v){ state.seq.push(v); renderBead(); renderBig(); }

      // History
      function renderHistory(){
        const tbody = el('histBody');
        const list = state.history;
        const pages = Math.max(1, Math.ceil(list.length / PAGE.size));
        if(PAGE.now > pages) PAGE.now = pages;
        const start = (PAGE.now-1)*PAGE.size;
        const pageList = list.slice(start, start+PAGE.size);

        tbody.innerHTML = '';
        if(pageList.length===0){
          tbody.innerHTML = `<tr><td colspan="5" class="py-3 text-center opacity-70">No bets yet.</td></tr>`;
        }else{
          pageList.forEach(h=>{
            const pill = h.side==='Red'
              ? 'border-[#b71c1c] bg-[#3b1212] text-[#ffecec]'
              : 'border-[#0b3ca8] bg-[#11244d] text-[#e6f0ff]';
            const tr=document.createElement('tr');
            tr.innerHTML = `
              <td>${h.time}</td>
              <td><span class="inline-flex items-center justify-center rounded-full border-2 px-2 py-0.5 ${pill}">${h.side}</span></td>
              <td>₱${fmt(h.amount)}</td>
              <td>× ${h.odds.toFixed(2)}</td>
              <td>₱${fmt(h.est)}</td>`;
            tbody.appendChild(tr);
          });
        }
        el('hPageNow').textContent = PAGE.now;
        el('hPageTotal').textContent = pages;
      }
      el('hPrev')?.addEventListener('click', ()=>{ PAGE.now=Math.max(1,PAGE.now-1); renderHistory(); });
      el('hNext')?.addEventListener('click', ()=>{ const pages=Math.max(1,Math.ceil(state.history.length/PAGE.size)); PAGE.now=Math.min(pages,PAGE.now+1); renderHistory(); });

      // ----- Amount Chips + Custom Input -----
      const chips = document.querySelectorAll('.chip');
      const amtInput = el('amtInput');

      function setAmount(v, from='custom'){
        let n = Math.floor(Number(v) || 0);
        if(n < 100){
          n = 100;
          if(from==='custom') toast('Minimum bet is ₱100');
        }
        currentAmount = n;
        amtInput.value = n;
      }

      function selectChip(btn){
        chips.forEach(c=>c.classList.remove('ring-2','ring-white/60'));
        btn.classList.add('ring-2','ring-white/60');
        setAmount(parseInt(btn.getAttribute('data-amt'),10), 'chip');
      }
      chips.forEach((c,i)=>{ c.addEventListener('click',()=>selectChip(c)); if(i===0) selectChip(c); });

      // typing / wheel on input
      amtInput.addEventListener('change',  ()=>{ setAmount(amtInput.value); chips.forEach(c=>c.classList.remove('ring-2','ring-white/60')); });
      amtInput.addEventListener('input',   ()=>{ /* live clamp visually */ if(amtInput.value === '') return; if(Number(amtInput.value)<100) amtInput.value = 100; });

      // Record bet
      function recordBet(side, amount){
        if(amount<100){ toast('Minimum bet is ₱100'); setAmount(100); return; }
        if(side==='red'){ state.red+=amount; addResult('R'); } else { state.blue+=amount; addResult('B'); }
        const pot = state.red+state.blue||1;
        state.oddsRed = +(1.2 + (state.blue/pot)*0.8).toFixed(2);
        state.oddsBlue= +(1.2 + (state.red/pot)*0.8).toFixed(2);
        const now=new Date(), time=now.toLocaleTimeString('en-PH',{hour:'2-digit',minute:'2-digit'});
        const sideWord = side==='red'?'Red':'Blue';
        const odds = side==='red' ? state.oddsRed : state.oddsBlue;
        const est = Math.round(amount*odds);
        state.history.unshift({time, side:sideWord, amount, odds, est});
        if(state.history.length>1000) state.history.length=1000;
        recalc(); toast(`Recorded ₱${fmt(amount)} on ${sideWord}`);
      }

      // Keyboard + left-panel buttons use currentAmount
      document.addEventListener('keydown',e=>{
        if(e.key==='r') recordBet('red', currentAmount);
        if(e.key==='b') recordBet('blue', currentAmount);
      });
      el('scoreRed').addEventListener('click', ()=>recordBet('red', currentAmount));
      el('scoreBlue').addEventListener('click',()=>recordBet('blue', currentAmount));

      el('undoBtn').addEventListener('click', ()=>{
        const h = state.history.shift(); if(!h){ toast('Nothing to undo'); return; }
        if(h.side==='Red') state.red=Math.max(0,state.red-h.amount); else state.blue=Math.max(0,state.blue-h.amount);
        state.seq.pop(); renderBead(); renderBig(); recalc(); toast('Undone last bet');
      });
      el('clearBtn').addEventListener('click', ()=>{
        if(!confirm('Clear totals, history & roads?')) return;
        state.red=0; state.blue=0; state.history=[]; state.seq=[]; recalc();
        initGrid('beadGrid'); initGrid('bigGrid'); toast('Cleared');
      });
      el('cardReset').addEventListener('click', ()=>{ el('cardCode').value=''; });
      el('cardSubmit').addEventListener('click', ()=>{ toast('Card captured'); });

      // Init grids & UI
      (function init(){ initGrid('beadGrid'); initGrid('bigGrid'); renderBead(); renderBig(); recalc(); setAmount(amtInput.value); })();
    </script>

    <style>@media print{ body{ background:#fff!important } }</style>
  </body>
  @endif
</x-layouts.app>
