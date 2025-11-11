<?php
// billiard.php — PURE PHP + Tailwind only (no custom JS). State via SESSION.
session_start();

// ---- AUTH / ROLE (Laravel-friendly if auth() exists) ----
$user   = function_exists('auth') && auth() ? auth()->user() : null;
$roleId = $user && isset($user->role_id) ? (int) $user->role_id : 2; // 1=teller/admin, 2=player

// ---- INIT (first load) ----
if (!isset($_SESSION['__billiard_init'])) {
  $_SESSION['players'] = [
    "Efren Reyes","Earl Strickland","Ronnie O'Sullivan","Shane Van Boening",
    "Francisco Bustamante","Alex Pagulayan","Jeanette Lee","Karen Corr",
    "Allison Fisher","Johnny Archer","Mika Immonen","Niels Feijen",
    "Darren Appleton","Ko Pin-Yi","Wu Jiaqing"
  ];
  // Random match-up
  $_SESSION['player1'] = $_SESSION['players'][array_rand($_SESSION['players'])];
  do { $_SESSION['player2'] = $_SESSION['players'][array_rand($_SESSION['players'])]; }
  while ($_SESSION['player2'] === $_SESSION['player1']);

  $_SESSION['match_no'] = rand(100, 999);

  // Starting pots
  $_SESSION['meron_amount'] = rand(10000, 50000);
  $_SESSION['wala_amount']  = rand(10000, 50000);

  // Odds
  $m = number_format(mt_rand(150, 200)/100, 2);     // 1.50–2.00
  $_SESSION['meron_odds'] = $m;
  $_SESSION['wala_odds']  = number_format($m + 0.20, 2);

  // Bank + roads + history
  $_SESSION['current_balance'] = 500000.00;
  $_SESSION['results'] = ['R','R','R','R','R','R','R','R','R','B','B','B','B','B','B','B','B','R','R','R','R','R','R','R'];
  $_SESSION['bet_history'] = []; // side/player/matchId/amount/odds/payout/time/balBefore/balAfter/status

  $_SESSION['last_amount'] = 100; // default chip
  $_SESSION['flash'] = null;
  $_SESSION['__billiard_init'] = true;
}

// ---- HELPERS ----
date_default_timezone_set('Asia/Manila');
function now_ph(){ return new DateTime(); }
function event_date_label(){ return 'EVENT - '.now_ph()->format('m/d/Y'); }
function event_time_label(){ return now_ph()->format('D h:i:s A'); }

function streakRuns($seq){
  $out=[]; foreach($seq as $t){
    if(empty($out) || $out[count($out)-1]['t']!==$t) $out[]=['t'=>$t,'n'=>1];
    else $out[count($out)-1]['n']++;
  } return $out;
}
function buildBigRoadStrictL($seq, $maxRows=8){
  $runs = streakRuns($seq);
  $grid = []; $labelNo=1; $prevStart=-1;
  $ensure = function(&$g,$c){ if(!isset($g[$c])) $g[$c]=[]; };

  foreach($runs as $run){
    $t=$run['t']; $col=0; $row=0;
    if($prevStart<0){ $col=0; $row=0; }
    else { $col=$prevStart+1; $row=0; while(isset($grid[$col][$row])){ $col++; $ensure($grid,$col); } }
    $thisStart=$col;

    $placed=0;
    while($placed < $run['n'] && $row<$maxRows && !isset($grid[$col][$row])){
      $ensure($grid,$col);
      $grid[$col][$row]=['t'=>$t,'label'=>$labelNo++]; $placed++; $row++;
    }
    $lockRow=max(0,$row-1); $remain=$run['n']-$placed; $c=$col+1;
    while($remain>0){
      $ensure($grid,$c);
      if(!isset($grid[$c][$lockRow])){ $grid[$c][$lockRow]=['t'=>$t,'label'=>$labelNo++]; $remain--; }
      $c++;
    }
    $prevStart=$thisStart;
  }
  return $grid;
}
function computeColumnsSequential($seq, $maxRows){
  $cols=[]; $col=[]; $labelNo=1;
  foreach($seq as $t){ $col[]=['t'=>$t,'label'=>$labelNo++]; if(count($col)===$maxRows){ $cols[]=$col; $col=[]; } }
  if($col) $cols[]=$col; return $cols;
}

function renderLogroHTML($seq, $maxRows=8){
  $g = buildBigRoadStrictL($seq,$maxRows); $o='';
  foreach($g as $col){
    $o.='<div class="grid content-start [grid-auto-rows:var(--logro-bubble)] gap-y-[6px]" style="grid-template-rows:repeat('.$maxRows.',var(--logro-bubble))">';
    for($r=0;$r<$maxRows;$r++){
      if(isset($col[$r])){
        $type=$col[$r]['t']; $color = ($type==='R') ? 'text-red-500' : 'text-blue-500';
        $o.='<div class="w-[var(--logro-bubble)] h-[var(--logro-bubble)] rounded-full border-[3px] border-current '.$color.' shadow-[inset_0_2px_0_rgba(0,0,0,.35),inset_0_0_0_2px_rgba(255,255,255,.06),0_6px_16px_rgba(0,0,0,.45)] bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,.18),transparent_55%)]"></div>';
      } else {
        $o.='<div class="w-[var(--logro-bubble)] h-[var(--logro-bubble)] rounded-full opacity-10 border border-white/20 border-dashed"></div>';
      }
    }
    $o.='</div>';
  }
  return $o;
}
function renderBeadHTML($seq, $maxRows=6){
  $cols = computeColumnsSequential($seq,$maxRows); $o='';
  foreach($cols as $col){
    $o.='<div class="grid content-start [grid-auto-rows:var(--bead-bubble)] gap-y-1" style="grid-template-rows:repeat('.$maxRows.',var(--bead-bubble))">';
    for($r=0;$r<$maxRows;$r++){
      if(isset($col[$r])){
        $t=$col[$r]['t']; $label=$col[$r]['label'];
        $o.='<div class="grid place-items-center w-[var(--bead-bubble)] h-[var(--bead-bubble)] rounded-full border-2 text-[10px] font-semibold '.($t==='R'?'bg-red-600 border-red-600 text-white':'bg-blue-600 border-blue-600 text-white').'">'.$label.'</div>';
      } else {
        $o.='<div class="w-[var(--bead-bubble)] h-[var(--bead-bubble)] rounded-full opacity-15 border border-white/20 border-dashed"></div>';
      }
    }
    $o.='</div>';
  }
  return $o;
}

function computePercents(){
  $r=(float)($_SESSION['meron_amount']??0); $b=(float)($_SESSION['wala_amount']??0); $t=$r+$b;
  if($t<=0) return [50,50,0];
  $rp=round(($r/$t)*100); return [$rp, 100-$rp, $t];
}

function placeBet($side,$amount){
  $amount = floatval($amount);
  if($amount<=0){ $_SESSION['flash']='Enter a valid amount.'; return; }
  $bal = (float)$_SESSION['current_balance'];
  if($bal - $amount < 0){ $_SESSION['flash']='Insufficient balance.'; return; }

  $player = ($side==='MERON') ? ($_SESSION['player1']??'Red') : ($_SESSION['player2']??'Blue');
  $odds   = ($side==='MERON') ? $_SESSION['meron_odds'] : $_SESSION['wala_odds'];
  $payout = $amount * (float)$odds;

  $_SESSION['current_balance'] = $bal - $amount;
  if($side==='MERON') $_SESSION['meron_amount'] += $amount;
  else                $_SESSION['wala_amount']  += $amount;

  array_unshift($_SESSION['bet_history'], [
    'side'=>$side,'player'=>$player,'matchId'=>($_SESSION['match_no']??'—'),
    'amount'=>$amount,'odds'=>$odds,'payout'=>number_format($payout,2,'.',''),
    'time'=>now_ph()->format('Y-m-d h:i:s A'),'balanceBefore'=>$bal,'balanceAfter'=>$_SESSION['current_balance'],'status'=>'PENDING'
  ]);
  $_SESSION['flash'] = "Bet placed: ₱".number_format($amount)." on $player ($side)";
}
function pushResult($winSide){
  $_SESSION['results'][] = ($winSide==='MERON'?'R':'B');
  if(!empty($_SESSION['bet_history'])){
    foreach($_SESSION['bet_history'] as $i=>$bet){
      if($bet['status']==='PENDING'){
        if($bet['side']===$winSide){
          $_SESSION['current_balance'] = (float)$_SESSION['current_balance'] + (float)$bet['payout'];
          $_SESSION['bet_history'][$i]['status']='WIN';
        } else {
          $_SESSION['bet_history'][$i]['status']='LOSE';
        }
        $_SESSION['bet_history'][$i]['balanceAfter']=$_SESSION['current_balance'];
        break;
      }
    }
  }
}
function undoResult(){ if(!empty($_SESSION['results'])) array_pop($_SESSION['results']); }
function clearResults(){ $_SESSION['results'] = []; }

// ---- POST ACTIONS (PRG) ----
if($_SERVER['REQUEST_METHOD']==='POST'){
  $act = $_POST['action'] ?? '';
  if($act==='chip'){ $_SESSION['last_amount'] = max(0, (int)($_POST['value']??0)); }
  if($act==='place_meron' && $roleId===2){ placeBet('MERON', $_POST['bet_amount'] ?? ($_SESSION['last_amount']??0)); }
  if($act==='place_wala'  && $roleId===2){ placeBet('WALA',  $_POST['bet_amount'] ?? ($_SESSION['last_amount']??0)); }

  if($act==='win_meron' && $roleId===1) pushResult('MERON');
  if($act==='win_wala'  && $roleId===1) pushResult('WALA');
  if($act==='undo'      && $roleId===1) undoResult();
  if($act==='clear'     && $roleId===1) clearResults();

  header('Location: '.$_SERVER['REQUEST_URI']); exit;
}

// ---- VIEW VARS ----
$player1 = $_SESSION['player1']; $player2 = $_SESSION['player2']; $matchNo = $_SESSION['match_no'];
$meronAmount=(float)$_SESSION['meron_amount']; $walaAmount=(float)$_SESSION['wala_amount'];
$meronOdds=$_SESSION['meron_odds']; $walaOdds=$_SESSION['wala_odds'];
list($pctR,$pctB,$pctTotal)=computePercents();
$logroHTML = renderLogroHTML($_SESSION['results'],8);
$beadHTML  = renderBeadHTML($_SESSION['results'],6);
$balance   = (float)$_SESSION['current_balance'];
$lastAmount= $_SESSION['last_amount'] ?? '';
$flash     = $_SESSION['flash']; $_SESSION['flash']=null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Billiard — Pure PHP</title>

  <!-- Tailwind v4 (browser CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <!-- Icons (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous"/>
</head>
<body class="m-0 min-h-dvh overflow-x-hidden bg-[#050a15] text-slate-100 font-[Inter,system-ui,-apple-system,Segoe_UI,Roboto,Helvetica,Arial]">

  <!-- BACKGROUND -->
  <div class="fixed inset-0 -z-30 bg-cover bg-center"
       style="background-image:url('https://i.ibb.co/mCnFZSCv/Chat-GPT-Image-Oct-7-2025-03-54-39-PM.png'); filter:blur(2px) brightness(.45) saturate(1.0); transform:scale(1.03)"></div>
  <div class="fixed inset-0 -z-20 bg-[radial-gradient(60%_40%_at_50%_20%,rgba(59,130,246,0.25),transparent),radial-gradient(40%_30%_at_20%_80%,rgba(16,185,129,0.18),transparent)]"></div>

  <main class="max-w-screen-2xl 2xl:max-w-[2400px] mx-auto p-4
               [--logro-bubble:22px] md:[--logro-bubble:26px]
               [--bead-bubble:16px] md:[--bead-bubble:18px]
               [--col-gap:6px]">

    <?php if($flash): ?>
      <div class="mb-4 rounded-xl border border-emerald-400/30 bg-emerald-500/10 text-emerald-200 px-3 py-2"><?=htmlspecialchars($flash)?></div>
    <?php endif; ?>

    <div class="grid gap-6 md:grid-cols-[7fr_5fr]">

      <!-- LEFT: Video + Logrohan -->
      <section class="relative z-10 min-w-0 rounded-2xl p-4 shadow-xl ring-1 ring-white/10 bg-white/5 backdrop-blur-sm">

        <!-- Match header -->
        <div class="grid grid-cols-3 items-center mb-3 text-sm text-slate-200">
          <div class="text-left"><?=htmlspecialchars(event_date_label())?></div>
          <div class="text-center font-bold text-yellow-400 text-lg tracking-widest">MATCH# <span><?=htmlspecialchars($matchNo)?></span></div>
          <div class="text-right"><?=htmlspecialchars(event_time_label())?></div>
        </div>

        <!-- Video frame with glow border -->
        <div class="mb-3 relative w-full md:max-w-[85%] mx-auto">
          <div class="relative aspect-video">
            <div class="pointer-events-none select-none absolute inset-0 rounded-2xl overflow-hidden">
              <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-2xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 rounded-2xl box-content border-[6px] border-transparent bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20"></div>
            </div>
            <iframe class="absolute inset-0 w-full h-full rounded-xl relative z-10 border-4 border-white/10"
              src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          </div>
        </div>

        <!-- LOGROHAN rail (desktop only) -->
        <div class="hidden md:block md:max-w-[85%] mx-auto rounded-2xl p-3 bg-black/30 border border-white/10">
          <div class="flex items-center justify-between mb-2">
            <div class="text-[11px] uppercase tracking-[0.2em] text-white/70">Logrohan</div>
            <div class="flex items-center gap-3 text-[10px]">
              <span class="inline-flex items-center gap-1"><i class="fa-solid fa-circle text-red-400 text-[8px]"></i> <span class="opacity-70">Red</span></span>
              <span class="inline-flex items-center gap-1"><i class="fa-solid fa-circle text-blue-400 text-[8px]"></i> <span class="opacity-70">Blue</span></span>
            </div>
          </div>

          <?php if($roleId===1): ?>
            <form method="post" class="flex items-center gap-2 mb-2">
              <button name="action" value="win_meron" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-xs font-bold hover:bg-red-700 shadow-[0_10px_24px_rgba(239,68,68,0.35)]">+ Red win</button>
              <button name="action" value="win_wala"  class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-xs font-bold hover:bg-blue-700 shadow-[0_10px_24px_rgba(59,130,246,0.35)]">+ Blue win</button>
              <button name="action" value="undo"      class="px-2 py-1 rounded bg-slate-700/70 border border-white/10 text-xs hover:bg-slate-700">Undo</button>
              <button name="action" value="clear"     class="px-2 py-1 rounded bg-slate-800/70 border border-white/10 text-xs hover:bg-slate-800">Clear</button>
            </form>
          <?php endif; ?>

          <div class="relative overflow-x-auto overflow-y-hidden pb-1 [scrollbar-gutter:stable_both-edges]">
            <div class="inline-grid [grid-auto-flow:column] [grid-auto-columns:max-content] [column-gap:var(--col-gap)] [contain:layout_paint]">
              <?=$logroHTML?>
            </div>
          </div>
        </div>
      </section>

      <!-- RIGHT: Cards + Bet Amount + Mini Road (desktop/tablet) -->
      <aside class="hidden md:block space-y-3 mt-1">
        <!-- Percent bar -->
        <div class="rounded-2xl p-3 bg-white/5 border border-white/10">
          <div class="text-[11px] uppercase tracking-[0.2em] text-white/70 mb-1">Bet Percentage</div>
          <div class="relative h-3 rounded-full bg-black/40 border border-white/10 overflow-hidden">
            <div class="absolute left-0 top-0 h-full bg-red-600/80" style="width:<?=$pctR?>%"></div>
            <div class="absolute right-0 top-0 h-full bg-blue-600/80" style="width:<?=$pctB?>%"></div>
          </div>
          <div class="mt-1 grid grid-cols-3 text-[11px] text-white/70">
            <div class="text-left">Red <?=$pctR?>%</div>
            <div class="text-center text-white/50">Total: ₱<?=number_format($pctTotal)?></div>
            <div class="text-right">Blue <?=$pctB?>%</div>
          </div>
        </div>

        <!-- ====== STRONGLY COLORED 3D BET CARDS (PURE TAILWIND LAYERS) ====== -->
        <div class="grid grid-cols-2 gap-3">
          <!-- RED CARD -->
          <div class="relative overflow-hidden rounded-2xl p-3 border border-red-400/30 ring-1 ring-red-400/20 shadow-[0_18px_32px_rgba(185,28,28,.45),0_8px_18px_rgba(0,0,0,.45)]">
            <!-- color + depth layers -->
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[linear-gradient(180deg,#ef4444_0%,#b91c1c_55%,#7f1d1d_100%)]"></div>
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[radial-gradient(120%_140%_at_100%_-10%,rgba(255,255,255,.10),transparent_60%)]"></div>
            <div class="absolute inset-0 pointer-events-none rounded-2xl mix-blend-screen bg-[radial-gradient(100%_60%_at_-10%_-10%,rgba(255,255,255,.35),transparent_60%)]"></div>

            <div class="relative">
              <div class="flex items-center justify-between">
                <span class="grid place-items-center w-9 h-9 rounded-[12px] border border-white/20 bg-white/10 text-xl font-black shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">R</span>
              </div>
              <div class="mt-2 text-sm font-semibold opacity-90"><?=$player1?></div>
              <div class="text-4xl mt-1 font-black drop-shadow-[0_2px_0_rgba(0,0,0,.4),0_10px_30px_rgba(0,0,0,.35)]"><?=number_format($meronAmount)?></div>

              <div class="mt-2">
                <div class="inline-block rounded-lg px-2 py-1 border border-white/20 bg-gradient-to-b from-white/20 to-white/0 text-xs font-bold tracking-wide shadow-[inset_0_1px_2px_rgba(0,0,0,.25)]">PAYOUT = <?=$meronOdds?></div>
              </div>

              <?php if($roleId===2): ?>
                <!-- Chips row (each a small form) -->
                <div class="grid grid-cols-4 gap-1 mt-2">
                  <?php foreach([100,200,500,1000] as $chip): ?>
                    <form method="post">
                      <input type="hidden" name="action" value="chip">
                      <input type="hidden" name="value" value="<?=$chip?>">
                      <button class="w-full rounded-md border border-amber-300/40 bg-white/10 px-2 py-1 text-sm font-black tracking-wide hover:bg-white/15 shadow-[0_14px_28px_rgba(0,0,0,.45),inset_0_1px_2px_rgba(255,255,255,.25)]">♦<?=$chip?></button>
                    </form>
                  <?php endforeach; ?>
                </div>

                <!-- Bet form -->
                <form method="post" class="mt-2 flex flex-col gap-2">
                  <input type="number" name="bet_amount" value="<?=htmlspecialchars($lastAmount)?>" placeholder="Enter amount"
                        class="p-2 text-sm text-white bg-black/30 w-[160px] rounded border border-white/15 focus:outline-none shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">
                  <button name="action" value="place_meron"
                          class="w-full px-3 py-2 text-sm font-black rounded-[12px] border border-white/20 bg-white/10 hover:bg-red-600/25 hover:shadow-[0_0_20px_3px_rgba(239,68,68,0.45)]">
                    BET
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </div>

          <!-- BLUE CARD -->
          <div class="relative overflow-hidden rounded-2xl p-3 border border-blue-400/30 ring-1 ring-blue-400/20 shadow-[0_18px_32px_rgba(29,78,216,.45),0_8px_18px_rgba(0,0,0,.45)]">
            <!-- color + depth layers -->
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[linear-gradient(180deg,#3b82f6_0%,#1d4ed8_55%,#1e3a8a_100%)]"></div>
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[radial-gradient(120%_140%_at_100%_-10%,rgba(255,255,255,.10),transparent_60%)]"></div>
            <div class="absolute inset-0 pointer-events-none rounded-2xl mix-blend-screen bg-[radial-gradient(100%_60%_at_-10%_-10%,rgba(255,255,255,.35),transparent_60%)]"></div>

            <div class="relative">
              <div class="flex items-center justify-between">
                <span class="grid place-items-center w-9 h-9 rounded-[12px] border border-white/20 bg-white/10 text-xl font-black shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">B</span>
              </div>
              <div class="mt-2 text-sm font-semibold opacity-90"><?=$player2?></div>
              <div class="text-4xl mt-1 font-black drop-shadow-[0_2px_0_rgba(0,0,0,.4),0_10px_30px_rgba(0,0,0,.35)]"><?=number_format($walaAmount)?></div>

              <div class="mt-2">
                <div class="inline-block rounded-lg px-2 py-1 border border-white/20 bg-gradient-to-b from-white/20 to-white/0 text-xs font-bold tracking-wide shadow-[inset_0_1px_2px_rgba(0,0,0,.25)]">PAYOUT = <?=$walaOdds?></div>
              </div>

              <?php if($roleId===2): ?>
                <!-- Chips row -->
                <div class="grid grid-cols-4 gap-1 mt-2">
                  <?php foreach([100,200,500,1000] as $chip): ?>
                    <form method="post">
                      <input type="hidden" name="action" value="chip">
                      <input type="hidden" name="value" value="<?=$chip?>">
                      <button class="w-full rounded-md border border-amber-300/40 bg-white/10 px-2 py-1 text-sm font-black tracking-wide hover:bg-white/15 shadow-[0_14px_28px_rgba(0,0,0,.45),inset_0_1px_2px_rgba(255,255,255,.25)]">♦<?=$chip?></button>
                    </form>
                  <?php endforeach; ?>
                </div>

                <!-- Bet form -->
                <form method="post" class="mt-2 flex flex-col gap-2">
                  <input type="number" name="bet_amount" value="<?=htmlspecialchars($lastAmount)?>" placeholder="Enter amount"
                        class="p-2 text-sm text-white bg-black/30 w-[160px] rounded border border-white/15 focus:outline-none shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">
                  <button name="action" value="place_wala"
                          class="w-full px-3 py-2 text-sm font-black rounded-[12px] border border-white/20 bg-white/10 hover:bg-blue-600/25 hover:shadow-[0_0_20px_3px_rgba(59,130,246,0.45)]">
                    BET
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- MINI ROAD + Balance -->
        <div class="rounded-2xl p-3 bg-white/5 border border-white/10">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-[0.2em] text-white/70">Road</div>
            <div class="text-[11px] text-white/70">Bal: ₱<?=number_format($balance)?></div>
          </div>
          <div class="relative overflow-x-auto overflow-y-hidden pb-1 [scrollbar-gutter:stable_both-edges]">
            <div class="inline-grid [grid-auto-flow:column] [grid-auto-columns:max-content] [column-gap:6px] [contain:layout_paint]">
              <?=$beadHTML?>
            </div>
          </div>
        </div>
      </aside>

      <!-- MOBILE STACK -->
      <section class="md:hidden space-y-3">
        <!-- Percent bar (mobile) -->
        <div class="rounded-2xl p-3 bg-white/5 border border-white/10">
          <div class="flex items-center justify-between">
            <div class="text-[11px] uppercase tracking-[0.2em] text-white/70">Bet %</div>
            <div class="text-[11px] text-white/60">Total: ₱<?=number_format($pctTotal)?></div>
          </div>
          <div class="relative h-2.5 rounded-full bg-black/40 border border-white/10 overflow-hidden mt-1.5">
            <div class="absolute left-0 top-0 h-full bg-red-600/80" style="width:<?=$pctR?>%"></div>
            <div class="absolute right-0 top-0 h-full bg-blue-600/80" style="width:<?=$pctB?>%"></div>
          </div>
          <div class="mt-1.5 flex items-center justify-between text-[10px] text-white/70">
            <div>Red <?=$pctR?>%</div><div>Blue <?=$pctB?>%</div>
          </div>
        </div>

        <!-- MOBILE CARDS with strong color -->
        <div class="grid grid-cols-2 gap-2">
          <!-- MERON -->
          <div class="relative overflow-hidden rounded-2xl p-3 border border-red-400/30 ring-1 ring-red-400/20 shadow-[0_12px_24px_rgba(185,28,28,.45),0_6px_14px_rgba(0,0,0,.45)]">
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[linear-gradient(180deg,#ef4444_0%,#b91c1c_55%,#7f1d1d_100%)]"></div>
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[radial-gradient(120%_140%_at_100%_-10%,rgba(255,255,255,.10),transparent_60%)]"></div>
            <div class="absolute inset-0 pointer-events-none rounded-2xl mix-blend-screen bg-[radial-gradient(100%_60%_at_-10%_-10%,rgba(255,255,255,.35),transparent_60%)]"></div>

            <div class="grid place-items-center w-8 h-8 rounded-[10px] border border-white/20 bg-white/10 text-lg font-black shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">R</div>
            <div class="mt-1 text-xs font-semibold opacity-90 leading-tight"><?=$player1?></div>
            <div class="text-2xl mt-0.5 font-black"><?=number_format($meronAmount)?></div>
            <div class="mt-1">
              <span class="inline-block text-[10px] px-1 py-0.5 rounded-lg border border-white/20 bg-gradient-to-b from-white/20 to-white/0 font-bold">PAYOUT = <?=$meronOdds?></span>
            </div>

            <?php if($roleId===2): ?>
              <div class="grid grid-cols-4 gap-1 mt-2">
                <?php foreach([100,200,500,1000] as $chip): ?>
                  <form method="post">
                    <input type="hidden" name="action" value="chip">
                    <input type="hidden" name="value" value="<?=$chip?>">
                    <button class="w-full rounded-md border border-amber-300/40 bg-white/10 px-2 py-1 text-xs font-black hover:bg-white/15 shadow-[0_10px_20px_rgba(0,0,0,.45),inset_0_1px_2px_rgba(255,255,255,.25)]">♦<?=$chip?></button>
                  </form>
                <?php endforeach; ?>
              </div>

              <form method="post" class="mt-2 space-y-2">
                <input type="number" name="bet_amount" value="<?=htmlspecialchars($lastAmount)?>" placeholder="Enter amount"
                       class="p-2 text-sm text-white bg-black/30 w-full rounded border border-white/15 focus:outline-none shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">
                <button name="action" value="place_meron"
                        class="w-full px-3 py-2 text-xs font-black rounded-[12px] border border-white/20 bg-white/10 hover:bg-red-600/25">
                  BET
                </button>
              </form>
            <?php endif; ?>
          </div>

          <!-- WALA -->
          <div class="relative overflow-hidden rounded-2xl p-3 border border-blue-400/30 ring-1 ring-blue-400/20 shadow-[0_12px_24px_rgba(29,78,216,.45),0_6px_14px_rgba(0,0,0,.45)]">
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[linear-gradient(180deg,#3b82f6_0%,#1d4ed8_55%,#1e3a8a_100%)]"></div>
            <div class="absolute inset-0 -z-10 rounded-2xl bg-[radial-gradient(120%_140%_at_100%_-10%,rgba(255,255,255,.10),transparent_60%)]"></div>
            <div class="absolute inset-0 pointer-events-none rounded-2xl mix-blend-screen bg-[radial-gradient(100%_60%_at_-10%_-10%,rgba(255,255,255,.35),transparent_60%)]"></div>

            <div class="grid place-items-center w-8 h-8 rounded-[10px] border border-white/20 bg-white/10 text-lg font-black shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">B</div>
            <div class="mt-1 text-xs font-semibold opacity-90 leading-tight"><?=$player2?></div>
            <div class="text-2xl mt-0.5 font-black"><?=number_format($walaAmount)?></div>
            <div class="mt-1">
              <span class="inline-block text-[10px] px-1 py-0.5 rounded-lg border border-white/20 bg-gradient-to-b from-white/20 to-white/0 font-bold">PAYOUT = <?=$walaOdds?></span>
            </div>

            <?php if($roleId===2): ?>
              <div class="grid grid-cols-4 gap-1 mt-2">
                <?php foreach([100,200,500,1000] as $chip): ?>
                  <form method="post">
                    <input type="hidden" name="action" value="chip">
                    <input type="hidden" name="value" value="<?=$chip?>">
                    <button class="w-full rounded-md border border-amber-300/40 bg-white/10 px-2 py-1 text-xs font-black hover:bg-white/15 shadow-[0_10px_20px_rgba(0,0,0,.45),inset_0_1px_2px_rgba(255,255,255,.25)]">♦<?=$chip?></button>
                  </form>
                <?php endforeach; ?>
              </div>

              <form method="post" class="mt-2 space-y-2">
                <input type="number" name="bet_amount" value="<?=htmlspecialchars($lastAmount)?>" placeholder="Enter amount"
                       class="p-2 text-sm text-white bg-black/30 w-full rounded border border-white/15 focus:outline-none shadow-[inset_0_1px_2px_rgba(0,0,0,.35)]">
                <button name="action" value="place_wala"
                        class="w-full px-3 py-2 text-xs font-black rounded-[12px] border border-white/20 bg-white/10 hover:bg-blue-600/25">
                  BET
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>

        <!-- LOGRO / MINI ROAD / BALANCE -->
        <div class="rounded-2xl p-3 bg-white/5 border border-white/10">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-[0.2em] text-white/70">Road</div>
            <div class="text-[11px] text-white/70">Bal: ₱<?=number_format($balance)?></div>
          </div>
          <div class="relative overflow-x-auto overflow-y-hidden pb-1 [scrollbar-gutter:stable_both-edges]">
            <div class="inline-grid [grid-auto-flow:column] [grid-auto-columns:max-content] [column-gap:6px] [contain:layout_paint]">
              <?=$beadHTML?>
            </div>
          </div>
        </div>
      </section>

    </div>
  </main>
</body>
</html>
