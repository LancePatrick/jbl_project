{{-- resources/views/billiard.blade.php --}}
@php
  // ===== SERVER STATE (pure PHP, no JS) =====
  if(session_status()===PHP_SESSION_NONE) session_start();

  $user   = auth()->user() ?? null;
  $roleId = $user && isset($user->role_id) ? (int)$user->role_id : 2; // 1=teller/admin, 2=player

  date_default_timezone_set('Asia/Manila');
  $now = new DateTime();

  // Seed initial state once
  if (!isset($_SESSION['__billiard_init'])) {
    $_SESSION['players'] = [
      "Efren Reyes","Earl Strickland","Ronnie O'Sullivan","Shane Van Boening",
      "Francisco Bustamante","Alex Pagulayan","Jeanette Lee","Karen Corr",
      "Allison Fisher","Johnny Archer","Mika Immonen","Niels Feijen",
      "Darren Appleton","Ko Pin-Yi","Wu Jiaqing"
    ];
    // random matchup
    $_SESSION['player1'] = $_SESSION['players'][array_rand($_SESSION['players'])];
    do { $_SESSION['player2'] = $_SESSION['players'][array_rand($_SESSION['players'])]; }
    while ($_SESSION['player2'] === $_SESSION['player1']);
    $_SESSION['match_no'] = rand(100,999);

    // starting pots
    $_SESSION['meron_amount'] = rand(10000,50000);
    $_SESSION['wala_amount']  = rand(10000,50000);

    // odds
    $m = number_format(mt_rand(150,200)/100,2);
    $_SESSION['meron_odds'] = $m;
    $_SESSION['wala_odds']  = number_format($m+0.20,2);

    // roads + balance + last chip
    $_SESSION['results'] = ['R','R','R','R','R','R','R','R','R','B','B','B','B','B','B','B','B','R','R','R','R','R','R','R'];
    $_SESSION['current_balance'] = 500000.00;
    $_SESSION['last_amount'] = 100;
    $_SESSION['__billiard_init'] = true;
  }

  // --- helpers ---
  function event_date_label(){ return 'EVENT - '.(new DateTime('now', new DateTimeZone('Asia/Manila')))->format('m/d/Y'); }
  function event_time_label(){ return (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('D h:i:s A'); }

  function streakRuns($seq){ $out=[]; foreach($seq as $t){ if(!$out || $out[count($out)-1]['t']!==$t) $out[]=['t'=>$t,'n'=>1]; else $out[count($out)-1]['n']++; } return $out; }
  function buildBigRoadStrictL($seq,$maxRows=8){
    $runs=streakRuns($seq); $grid=[]; $label=1; $prevStart=-1; $ensure=function(&$g,$c){ if(!isset($g[$c])) $g[$c]=[]; };
    foreach($runs as $run){
      $t=$run['t']; if($prevStart<0){$col=0;$row=0;} else { $col=$prevStart+1;$row=0; while(isset($grid[$col][$row])){$col++;$ensure($grid,$col);} }
      $thisStart=$col; $placed=0;
      while($placed<$run['n'] && $row<$maxRows && !isset($grid[$col][$row])){ $ensure($grid,$col); $grid[$col][$row]=['t'=>$t,'label'=>$label++]; $placed++; $row++; }
      $lock=max(0,$row-1); $remain=$run['n']-$placed; $c=$col+1;
      while($remain>0){ $ensure($grid,$c); if(!isset($grid[$c][$lock])){ $grid[$c][$lock]=['t'=>$t,'label'=>$label++]; $remain--; } $c++; }
      $prevStart=$thisStart;
    }
    return $grid;
  }
  function computeColumnsSequential($seq,$maxRows){
    $cols=[]; $col=[]; $label=1; foreach($seq as $t){ $col[]=['t'=>$t,'label'=>$label++]; if(count($col)===$maxRows){ $cols[]=$col; $col=[]; } } if($col) $cols[]=$col; return $cols;
  }
  function renderLogroHTML($seq,$maxRows=8){
    $g=buildBigRoadStrictL($seq,$maxRows); $o='';
    foreach($g as $col){
      $o.='<div class="logro-col" style="grid-template-rows:repeat('.$maxRows.', var(--logro-bubble))">';
      for($r=0;$r<$maxRows;$r++){
        if(isset($col[$r])){
          $t=$col[$r]['t']; $o.='<div class="ring-bubble '.($t==='R'?'ring-red':'ring-blue').'"></div>';
        } else {
          $o.='<div class="ring-gap"></div>';
        }
      }
      $o.='</div>';
    }
    return $o;
  }
  function renderBeadHTML($seq,$maxRows=8){
    $cols=computeColumnsSequential($seq,$maxRows); $o='';
    foreach($cols as $col){
      $o.='<div class="bead-col" style="grid-template-rows:repeat('.$maxRows.', var(--bead-bubble))">';
      for($r=0;$r<$maxRows;$r++){
        if(isset($col[$r])){ $t=$col[$r]['t']; $lab=$col[$r]['label']; $o.='<div class="bead-solid '.($t==='R'?'red':'blue').'">'.$lab.'</div>'; }
        else { $o.='<div class="bead" style="opacity:.12;border:1px dashed rgba(255,255,255,.15)"></div>'; }
      }
      $o.='</div>';
    }
    return $o;
  }
  function computePercents(){
    $r=(float)($_SESSION['meron_amount']??0); $b=(float)($_SESSION['wala_amount']??0); $t=$r+$b;
    if($t<=0) return [50,50,0];
    $rp=round(($r/$t)*100); return [$rp,100-$rp,$t];
  }

  // --- actions (replace JS with PHP forms) ---
  if(request()->isMethod('post')){
    $act = request('action','');

    if($act==='chip'){
      $_SESSION['last_amount'] = max(0, (int)request('value',0));
    }

    if($act==='place_meron' && $roleId===2){
      $amt = (float)(request('bet_amount', $_SESSION['last_amount']));
      if($amt>0 && $_SESSION['current_balance']-$amt >= 0){
        $_SESSION['current_balance'] -= $amt;
        $_SESSION['meron_amount']    += $amt;
      }
    }
    if($act==='place_wala' && $roleId===2){
      $amt = (float)(request('bet_amount', $_SESSION['last_amount']));
      if($amt>0 && $_SESSION['current_balance']-$amt >= 0){
        $_SESSION['current_balance'] -= $amt;
        $_SESSION['wala_amount']     += $amt;
      }
    }

    if($act==='win_meron' && $roleId===1) $_SESSION['results'][]='R';
    if($act==='win_wala'  && $roleId===1) $_SESSION['results'][]='B';
    if($act==='undo'      && $roleId===1) array_pop($_SESSION['results']);
    if($act==='clear'     && $roleId===1) $_SESSION['results']=[];

    return redirect()->current();
  }

  // view vars
  $player1 = $_SESSION['player1'];
  $player2 = $_SESSION['player2'];
  $matchNo = $_SESSION['match_no'];
  $meronAmount = (float)$_SESSION['meron_amount'];
  $walaAmount  = (float)$_SESSION['wala_amount'];
  $meronOdds = $_SESSION['meron_odds'];
  $walaOdds  = $_SESSION['wala_odds'];
  $balance   = (float)$_SESSION['current_balance'];
  $lastAmount= (int)$_SESSION['last_amount'];
  [$pctR,$pctB,$pctTotal] = computePercents();
  $logroHTML = renderLogroHTML($_SESSION['results'],8);
  $beadHTML  = renderBeadHTML($_SESSION['results'],8);
@endphp

<x-layouts.app :title="__('Billiard')">
  <body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>

  <!-- ====== STYLE (kept as in file; still Tailwind-focused) ====== -->
  <style>
    :root{
      --logro-bubble: 26px; --logro-step: 3px; --bead-bubble: 26px; --col-gap: 6px; --row-gap: 6px;
      --rail-h: calc(var(--logro-bubble) * 9 + (var(--row-gap) * 7));
    }
    @media (max-width: 768px){
      :root{ --logro-bubble: 22px; --bead-bubble: 22px; --rail-h: calc(var(--logro-bubble) * 8 + (var(--row-gap) * 7)); }
    }
    .main-panel{ min-width:0; }
    .logro-zone{ min-width:0; }
    .logro-rail,.bead-rail{ position:relative; overflow-x:auto; overflow-y:hidden; scrollbar-gutter:stable both-edges; padding-bottom:2px; height:var(--rail-h); }
    .logro-strip-3d,.bead-strip{ display:inline-grid; grid-auto-flow:column; grid-auto-columns:max-content; column-gap:var(--col-gap); contain:layout paint; height:100%; }
    .logro-col{ display:grid; grid-auto-rows: var(--logro-bubble); row-gap: var(--row-gap); align-content:start; }
    .ring-gap{ width:var(--logro-bubble); height:var(--logro-bubble); opacity:.08; border:1px dashed rgba(255,255,255,.18); border-radius:999px; }
    .ring-bubble{ width:var(--logro-bubble); height:var(--logro-bubble); border-radius:999px; border:3px solid currentColor; box-shadow:inset 0 2px 0 rgba(0,0,0,.35), inset 0 0 0 2px rgba(255,255,255,.06), 0 6px 16px rgba(0,0,0,.45); background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.18), transparent 55%); }
    .ring-red{ color:#ef4444; } .ring-blue{ color:#3b82f6; }
    .bead-col{ display:grid; grid-auto-rows: var(--bead-bubble); row-gap:4px; align-content:start; }
    .bead, .bead-solid{ width:var(--bead-bubble); height:var(--bead-bubble); border-radius:999px; border:2px solid rgba(255,255,255,.22); display:grid; place-items:center; font-size:10px; line-height:1; font-weight:600; color:#0f172a; }
    .bead-solid.red{ background:#ef4444; border-color:#ef4444; color:white } .bead-solid.blue{ background:#3b82f6; border-color:#3b82f6; color:white }
    .odds-ribbon{ background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,0)); border:1px solid rgba(255,255,255,.15); border-radius:8px; padding:.25rem .5rem; display:inline-block; }
    .bet-card{ background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,0)); border:1px solid rgba(255,255,255,.12); border-radius:16px; padding:.75rem; }
    .bet-card.red{ box-shadow:0 10px 24px rgba(239,68,68,.15) } .bet-card.blue{ box-shadow:0 10px 24px rgba(59,130,246,.15) }
    .bet-btn{ border-radius:10px; border:1px solid rgba(255,255,255,.16); background:rgba(255,255,255,.05); }
    .bet-btn.red:hover{ background:rgba(239,68,68,.25) } .bet-btn.blue:hover{ background:rgba(59,130,246,.25) }
    .name-chip{ display:inline-grid; place-items:center; width:2.2rem; height:2.2rem; border-radius:10px; border:1px solid rgba(255,255,255,.16); background:rgba(255,255,255,.05); }
    .amount-3d{ text-shadow:0 2px 0 rgba(0,0,0,.4),0 10px 30px rgba(0,0,0,.35); }
  </style>

  <!-- ======================================================== MAIN ========================================================= -->
  <main class="max-w-screen-2xl 2xl:max-w-[2400px] mx-auto p-4">
    <div class="grid gap-6 md:grid-cols-[7fr_5fr]">

      <!-- LEFT: Video + Logrohan -->
      <div class="relative z-10 main-panel p-4 rounded-lg shadow-lg mt-2">
        <div class="grid grid-cols-3 items-center mb-3 text-sm text-gray-300">
          <div id="event-date" class="text-left">{{ event_date_label() }}</div>
          <div class="text-center font-bold text-yellow-400 text-lg">MATCH# <span id="match-no">{{ $matchNo }}</span></div>
          <div id="event-time" class="text-right">{{ event_time_label() }}</div>
        </div>

        <div class="mb-3 relative w-full md:max-w-[85%] mx-auto">
          <div class="relative aspect-video">
            <div class="absolute inset-0 rounded-xl overflow-hidden z-10 pointer-events-none select-none">
              <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20 mix-blend-overlay"></div>
            </div>
            <iframe
              class="absolute inset-0 w-full h-full rounded-lg relative z-20 border-4 border-transparent"
              src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
          </div>
        </div>

        <!-- LOGROHAN (desktop only) -->
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone md:max-w-[85%] mx-auto hidden md:block">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>

          @auth
          @if($roleId===1)
            <form method="post" class="flex items-center gap-2 mb-2">
              @csrf
              <button name="action" value="win_meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-xs font-bold hover:bg-red-700">+ Red win</button>
              <button name="action" value="win_wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-xs font-bold hover:bg-blue-700">+ Blue win</button>
              <button name="action" value="undo"      class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-xs hover:bg-gray-700">Undo</button>
              <button name="action" value="clear"     class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-xs hover:bg-gray-800">Clear</button>
            </form>
          @endif
          @endauth

          <div id="logro-rail" class="logro-rail">
            <div id="logro-strip" class="logro-strip-3d">{!! $logroHTML !!}</div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Bet cards + Bet Amount -->
      <aside class="hidden md:block">
        <div class="sticky mt-4 space-y-3">

          <!-- Bet Percentage Bar (DESKTOP) -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 translate-y-0">
            <div class="text-[11px] uppercase tracking-widest text-white/70 mb-1">Bet Percentage</div>
            <div class="relative h-3 rounded-full bg-black/40 border border-white/10 overflow-hidden">
              <div id="pct-red"  class="absolute left-0 top-0 h-full bg-red-600/80" style="width:{{ $pctR }}%"></div>
              <div id="pct-blue" class="absolute right-0 top-0 h-full bg-blue-600/80" style="width:{{ $pctB }}%"></div>
            </div>
            <div class="mt-1 grid grid-cols-3 text-[11px] text-white/70">
              <div id="pct-red-label"  class="text-left">Red {{ $pctR }}%</div>
              <div id="pct-total-label" class="text-center text-white/50">Total: ₱{{ number_format($pctTotal) }}</div>
              <div id="pct-blue-label" class="text-right">Blue {{ $pctB }}%</div>
            </div>
          </div>

          <!-- Cards (keep structure/ids) -->
          <div id="bet-area" class="bet-area grid grid-cols-2 gap-3 mt-0 mb-0 translate-y-0">
            <div class="bet-card red text-center">
              <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">R</span></div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player1-name">{{ $player1 }}</div>
              <div class="amount-3d text-3xl md:text-4xl mt-1" id="meron-amount">{{ number_format($meronAmount) }}</div>
              <div class="mt-2">
                <span class="odds-ribbon" id="meron-odds">PAYOUT = {{ $meronOdds }}</span>
                @auth
                @if($roleId===2)
                  <form method="post" class="mt-2">
                    @csrf
                    <input type="hidden" name="bet_amount" value="{{ $lastAmount }}">
                    <button class="bet-btn red mt-2 w-full px-3 py-2 text-sm" name="action" value="place_meron" id="bet-meron">BET</button>
                  </form>
                @endif
                @endauth
                <div id="meron-result" class="mt-2 text-xs text-yellow-300"></div>
              </div>
            </div>

            <div class="bet-card blue text-center">
              <div class="flex items-center justify-between"><span class="name-chip text-xl md:text-2xl">B</span></div>
              <div class="mt-2 text-sm font-semibold opacity-90" id="player2-name">{{ $player2 }}</div>
              <div class="amount-3d text-3xl md:text-4xl mt-1" id="wala-amount">{{ number_format($walaAmount) }}</div>
              <div class="mt-3">
                <span class="odds-ribbon" id="wala-odds">PAYOUT = {{ $walaOdds }}</span>
                @auth
                @if($roleId===2)
                  <form method="post" class="mt-2">
                    @csrf
                    <input type="hidden" name="bet_amount" value="{{ $lastAmount }}">
                    <button class="bet-btn blue mt-2 w-full px-3 py-2 text-sm" name="action" value="place_wala" id="bet-wala">BET</button>
                  </form>
                @endif
                @endauth
                <div id="wala-result" class="mt-2 text-xs text-yellow-300"></div>
              </div>
            </div>
          </div>

          <!-- Bet Amount + MINI ROAD -->
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2 mb-0 mt-2">
          @auth
          @if($roleId===2)
            <div class="flex items-center justify-between mb-2">
              <div class="text-[15px] uppercase tracking-widest text-white/70">Bet Amount</div>
              <div class="text-[15px] text-white/60">min ₱100</div>
            </div>

            <form method="post" class="flex flex-wrap items-center gap-2 mb-2">
              @csrf
              <input type="number" name="bet_amount" class="bet-input p-2 text-sm text-white bg-black/30 w-[160px]" placeholder="Enter amount" value="{{ $lastAmount }}" />
              <div class="balance-pill text-yellow-300">
                <span class="amount text-base">{{ number_format($balance) }}</span>
              </div>
            </form>

            <div class="grid grid-cols-2 gap-1 mb-2">
              <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="100"><button class="chip3d chip-emerald chip-outline text-sm" type="submit">♦100</button></form>
              <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="200"><button class="chip3d chip-blue chip-outline text-sm" type="submit">♦200</button></form>
              <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="500"><button class="chip3d chip-black chip-outline text-sm" type="submit">♦500</button></form>
              <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="1000"><button class="chip3d chip-amber chip-outline text-sm" type="submit">♦1000</button></form>
            </div>
          @endif
          @endauth

            <div>
              <div class="flex items-center justify-between mt-10">
                <div class="text-[11px] uppercase tracking-widest text-white/70">Road</div>
                <div class="flex items-center gap-2 text-[10px]">
                  <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Red</span></div>
                  <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:12px;height:12px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
                </div>
              </div>
              <div id="bead-rail" class="bead-rail">
                <div id="bead-strip" class="bead-strip">{!! $beadHTML !!}</div>
              </div>
            </div>
          </div>
        </div>
      </aside>

      <!-- ===================== MOBILE STACK ===================== -->
      <div class="md:hidden space-y-3">
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
          <div class="flex items-center justify-between">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Bet %</div>
            <div id="pct-total-label-mob" class="text-[11px] text-white/60">Total: ₱{{ number_format($pctTotal) }}</div>
          </div>
          <div class="relative h-2.5 rounded-full bg-black/40 border border-white/10 overflow-hidden mt-1.5">
            <div id="pct-red-mob"  class="absolute left-0 top-0 h-full bg-red-600/80" style="width:{{ $pctR }}%"></div>
            <div id="pct-blue-mob" class="absolute right-0 top-0 h-full bg-blue-600/80" style="width:{{ $pctB }}%"></div>
          </div>
          <div class="mt-1.5 flex items-center justify-between text-[10px] text-white/70">
            <div id="pct-red-label-mob">Red {{ $pctR }}%</div>
            <div id="pct-blue-label-mob">Blue {{ $pctB }}%</div>
          </div>
        </div>

        <div class="bet-area grid grid-cols-2 gap-2">
          <div class="bet-card red text-center">
            <div class="name-chip text-lg">R</div>
            <div class="mt-1 text-xs font-semibold opacity-90 leading-tight" id="player1-name-mob">{{ $player1 }}</div>
            <div class="amount-3d text-2xl mt-0.5" id="meron-amount-mob">{{ number_format($meronAmount) }}</div>
            <div class="mt-1"><span class="odds-ribbon text-[10px] px-1 py-0.5" id="meron-odds-mob">PAYOUT = {{ $meronOdds }}</span></div>
            @if($roleId===2)
              <form method="post" class="mt-2">@csrf
                <input type="hidden" name="bet_amount" value="{{ $lastAmount }}">
                <button class="bet-btn red mt-2 w-full px-3 py-2 text-xs" name="action" value="place_meron" id="bet-meron-mob">BET</button>
              </form>
            @endif
          </div>

          <div class="bet-card blue text-center">
            <div class="name-chip text-lg">B</div>
            <div class="mt-1 text-xs font-semibold opacity-90 leading-tight" id="player2-name-mob">{{ $player2 }}</div>
            <div class="amount-3d text-2xl mt-0.5" id="wala-amount-mob">{{ number_format($walaAmount) }}</div>
            <div class="mt-1"><span class="odds-ribbon text-[10px] px-1 py-0.5" id="wala-odds-mob">PAYOUT = {{ $walaOdds }}</span></div>
            @if($roleId===2)
              <form method="post" class="mt-2">@csrf
                <input type="hidden" name="bet_amount" value="{{ $lastAmount }}">
                <button class="bet-btn blue mt-2 w-full px-3 py-2 text-xs" name="action" value="place_wala" id="bet-wala-mob">BET</button>
              </form>
            @endif
          </div>
        </div>

        @if($roleId===2)
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
          <div class="flex items-center justify-between mb-2">
            <div class="text-[12px] uppercase tracking-widest text-white/70">Bet Amount</div>
            <div class="text-[12px] text-white/60">min ₱100</div>
          </div>
          <form method="post" class="flex items-center gap-2 mb-2">@csrf
            <input type="number" name="bet_amount" class="bet-input p-2 text-sm text-white bg-black/30 w-full" placeholder="Enter amount" value="{{ $lastAmount }}" />
            <div class="balance-pill text-yellow-300 shrink-0"><span class="amount text-sm">{{ number_format($balance) }}</span></div>
          </form>
          <div class="grid grid-cols-4 gap-1">
            <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="100"><button class="chip3d chip-emerald chip-outline text-xs" type="submit">♦100</button></form>
            <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="200"><button class="chip3d chip-blue chip-outline text-xs" type="submit">♦200</button></form>
            <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="500"><button class="chip3d chip-black chip-outline text-xs" type="submit">♦500</button></form>
            <form method="post">@csrf <input type="hidden" name="action" value="chip"><input type="hidden" name="value" value="1000"><button class="chip3d chip-amber chip-outline text-xs" type="submit">♦1000</button></form>
          </div>
        </div>
        @endif

        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 logro-zone">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1"><span class="bead red inline-block" style="width:10px;height:10px;border-width:2px"></span><span class="opacity-70">Red</span></div>
              <div class="flex items-center gap-1"><span class="bead blue inline-block" style="width:10px;height:10px;border-width:2px"></span><span class="opacity-70">Blue</span></div>
            </div>
          </div>

          @if($roleId===1)
            <form method="post" class="flex items-center gap-2 mb-2">
              @csrf
              <button name="action" value="win_meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-[11px] font-bold hover:bg-red-700">+ Red win</button>
              <button name="action" value="win_wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-[11px] font-bold hover:bg-blue-700">+ Blue win</button>
              <button name="action" value="undo"      class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-[11px] hover:bg-gray-700">Undo</button>
              <button name="action" value="clear"     class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-[11px] hover:bg-gray-800">Clear</button>
            </form>
          @endif

          <div id="logro-rail-mob" class="logro-rail">
            <div id="logro-strip-mob" class="logro-strip-3d">{!! $logroHTML !!}</div>
          </div>
        </div>
      </div>
      <!-- =================== /MOBILE STACK =================== -->

    </div>
  </main>
</body>
</x-layouts.app>
