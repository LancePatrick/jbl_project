{{-- resources/views/billiard.blade.php --}}
<x-layouts.app :title="__('Billiard')">
@php
  // ----------------------------------------
  // A) SESSION BOOTSTRAP (pure PHP state)
  // ----------------------------------------
  if (session_status() === PHP_SESSION_NONE) { session_start(); }

  // Helpers
  function ph_rand_odds($min=1.50, $max=2.00, $step=0.01){
    $v = $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
    return number_format(round($v / $step) * $step, 2);
  }
  function ph_random_player($exclude = null){
    $list = [
      "Efren Reyes","Earl Strickland","Ronnie O'Sullivan","Shane Van Boening",
      "Francisco Bustamante","Alex Pagulayan","Jeanette Lee","Karen Corr",
      "Allison Fisher","Johnny Archer","Mika Immonen","Niels Feijen",
      "Darren Appleton","Ko Pin-Yi","Wu Jiaqing"
    ];
    do { $p = $list[array_rand($list)]; } while($exclude && $p === $exclude);
    return $p;
  }

  // Defaults
  if (!isset($_SESSION['balance']))      $_SESSION['balance']      = 500000;
  if (!isset($_SESSION['meron_amount'])) $_SESSION['meron_amount'] = rand(10000,50000);
  if (!isset($_SESSION['wala_amount']))  $_SESSION['wala_amount']  = rand(10000,50000);
  if (!isset($_SESSION['odds_meron']))   $_SESSION['odds_meron']   = ph_rand_odds(1.50, 2.00, 0.01);
  if (!isset($_SESSION['odds_wala']))    $_SESSION['odds_wala']    = number_format((float)$_SESSION['odds_meron'] + 0.20, 2);
  if (!isset($_SESSION['bet_amount']))   $_SESSION['bet_amount']   = 0;

  if (!isset($_SESSION['player_red']))   $_SESSION['player_red']   = ph_random_player();
  if (!isset($_SESSION['player_blue']))  $_SESSION['player_blue']  = ph_random_player($_SESSION['player_red']);

  if (!isset($_SESSION['match_no']))     $_SESSION['match_no']     = rand(100, 999);
  if (!isset($_SESSION['bet_history']))  $_SESSION['bet_history']  = []; // newest first
  if (!isset($_SESSION['results']))      $_SESSION['results']      = ['R','R','R','R','R','R','R','R','R','B','B','B','B','B','B','B','B','R','R','R','R','R','R','R'];

  // Role (1=admin/teller, 2=player)
  $roleId = auth()->user()->role_id ?? 2;

  // ----------------------------------------
  // B) POST HANDLER (no JS; everything via form posts)
  // ----------------------------------------
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $action = request()->input('action');

      if ($action === 'set_amount') {
          $val = (int) request()->input('val', 0);
          $_SESSION['bet_amount'] = max(0, $val);
      }

      if ($action === 'type_amount') {
          $val = (int) request()->input('amount', 0);
          $_SESSION['bet_amount'] = max(0, $val);
      }

      if ($action === 'place_bet' && $roleId == 2) {
          $side = request()->input('side'); // MERON or WALA
          $amt  = (int) ($_SESSION['bet_amount'] ?? 0);
          if ($amt > 0 && $_SESSION['balance'] >= $amt) {
              $_SESSION['balance'] -= $amt;
              if ($side === 'MERON') {
                  $_SESSION['meron_amount'] += $amt;
                  $odds = (float) $_SESSION['odds_meron'];
                  $chosen = $_SESSION['player_red'] ?? 'Red';
              } else {
                  $_SESSION['wala_amount']  += $amt;
                  $odds = (float) $_SESSION['odds_wala'];
                  $chosen = $_SESSION['player_blue'] ?? 'Blue';
              }
              $payout = $amt * $odds;
              $entry = [
                'side' => $side,
                'player' => $chosen,
                'matchId' => $_SESSION['match_no'],
                'amount' => $amt,
                'odds'   => number_format($odds,2),
                'payout' => number_format($payout,2,'.',''),
                'time'   => now()->timezone('Asia/Manila')->format('m/d/Y h:i:s A'),
                'balanceBefore' => number_format($_SESSION['balance'] + $amt, 0, '.', ''),
                'balanceAfter'  => number_format($_SESSION['balance'], 0, '.', ''),
                'status' => 'PENDING',
              ];
              array_unshift($_SESSION['bet_history'], $entry);
          }
      }

      if ($action === 'admin_add_result' && $roleId == 1) {
          $win = request()->input('win'); // MERON or WALA
          $_SESSION['results'][] = ($win === 'MERON') ? 'R' : 'B';

          // settle first pending bet (if any)
          foreach ($_SESSION['bet_history'] as &$bet) {
            if ($bet['status'] === 'PENDING') {
              if ($bet['side'] === $win) {
                $bet['status'] = 'WIN';
                $_SESSION['balance'] += (float)$bet['payout'];
                $bet['balanceAfter'] = number_format($_SESSION['balance'], 0, '.', '');
              } else {
                $bet['status'] = 'LOSE';
                $bet['balanceAfter'] = number_format($_SESSION['balance'], 0, '.', '');
              }
              break;
            }
          }
          unset($bet);
      }

      if ($action === 'undo_result' && $roleId == 1) {
          array_pop($_SESSION['results']);
      }

      if ($action === 'clear_results' && $roleId == 1) {
          $_SESSION['results'] = [];
      }

      if ($action === 'new_match') {
          // reroll players, odds, match ID
          $_SESSION['player_red']  = ph_random_player();
          $_SESSION['player_blue'] = ph_random_player($_SESSION['player_red']);
          $_SESSION['match_no']    = rand(100,999);
          $_SESSION['odds_meron']  = ph_rand_odds(1.50, 2.00, 0.01);
          $_SESSION['odds_wala']   = number_format((float)$_SESSION['odds_meron'] + 0.20, 2);
          // keep amounts; or reset if you prefer:
          // $_SESSION['meron_amount'] = rand(10000,50000);
          // $_SESSION['wala_amount']  = rand(10000,50000);
      }

      // Redirect (PRG) to avoid resubmission
      return redirect()->to(url()->current());
  }

  // ----------------------------------------
  // C) COMPUTED VIEW DATA
  // ----------------------------------------
  $redAmt  = (int) ($_SESSION['meron_amount'] ?? 0);
  $blueAmt = (int) ($_SESSION['wala_amount'] ?? 0);
  $total   = max(0, $redAmt + $blueAmt);
  $redPct  = $total ? round(($redAmt / $total) * 100) : 50;
  $bluePct = 100 - $redPct;

  $redName  = $_SESSION['player_red']  ?? 'Red';
  $blueName = $_SESSION['player_blue'] ?? 'Blue';
  $matchId  = $_SESSION['match_no']    ?? '—';

  $meronOdds = $_SESSION['odds_meron'];
  $walaOdds  = $_SESSION['odds_wala'];

  $betAmountInput = (int) ($_SESSION['bet_amount'] ?? 0);
  $balanceNow     = (int) ($_SESSION['balance'] ?? 0);
  $results        = $_SESSION['results'] ?? [];

  // ----------------------------------------
  // D) ROAD BUILDERS (PHP versions of your JS)
  // ----------------------------------------
  function streak_runs($seq){
    $out=[]; foreach($seq as $t){
      if(empty($out) || $out[count($out)-1]['t'] !== $t) $out[]=['t'=>$t,'n'=>1];
      else $out[count($out)-1]['n']++;
    } return $out;
  }
  function build_bigroad_strictL($seq, $maxRows=8){
    $runs = streak_runs($seq);
    $grid = []; // $grid[col][row] = ['t'=>'R/B','label'=>n]
    $labelNo = 1; $prevRunStartCol = -1;

    foreach ($runs as $run){
      $t = $run['t']; $col=0; $row=0;
      if ($prevRunStartCol < 0){ $col=0; $row=0; }
      else {
        $col = $prevRunStartCol + 1; $row = 0;
        while(isset($grid[$col][$row])){ $col++; if(!isset($grid[$col])) $grid[$col]=[]; }
      }
      $thisRunStartCol = $col;

      // place downward
      $placed = 0;
      while($placed < $run['n'] && $row < $maxRows && empty($grid[$col][$row])){
        if(!isset($grid[$col])) $grid[$col]=[];
        $grid[$col][$row] = ['t'=>$t, 'label'=>$labelNo++];
        $placed++; $row++;
      }
      $lockRow = max(0, $row-1);
      $remain = $run['n'] - $placed; $c = $col + 1;
      while($remain > 0){
        if(!isset($grid[$c])) $grid[$c]=[];
        if(empty($grid[$c][$lockRow])){ $grid[$c][$lockRow] = ['t'=>$t, 'label'=>$labelNo++]; $remain--; }
        $c++;
      }
      $prevRunStartCol = $thisRunStartCol;
    }
    return $grid;
  }
  function compute_columns_sequential($seq, $maxRows){
    $cols=[]; $col=[]; $labelNo=1;
    foreach($seq as $t){
      $col[]=['t'=>$t,'label'=>$labelNo++];
      if(count($col) === $maxRows){ $cols[]=$col; $col=[]; }
    }
    if(count($col)) $cols[]=$col;
    return $cols;
  }
@endphp

  {{-- Optional small auto-refresh for clock/match tick (remove if undesired) --}}
  <meta http-equiv="refresh" content="5"/>

  <body class="text-white font-sans bg-black">
  <div class="bg-animated"></div>

  {{-- ========================================================
       MAIN
  ========================================================= --}}
  <main class="max-w-screen-2xl 2xl:max-w-[2400px] mx-auto p-4">
    <div class="grid gap-6 md:grid-cols-[7fr_5fr]">

      {{-- LEFT: Video + Logrohan --}}
      <div class="relative z-10 p-4 rounded-lg shadow-lg mt-2">
        {{-- Date / Match --}}
        <div class="grid grid-cols-3 items-center mb-3 text-sm text-gray-300">
          <div class="text-left">
            EVENT - {{ now()->timezone('Asia/Manila')->format('m/d/Y') }}
          </div>
          <div class="text-center font-bold text-yellow-400 text-lg">
            MATCH# {{ $matchId }}
          </div>
          <div class="text-right">
            {{ now()->timezone('Asia/Manila')->format('D h:i:s A') }}
          </div>
        </div>

        {{-- Video with 3D border glow (CSS-only) --}}
        <div class="mb-3 relative w-full md:max-w-[85%] mx-auto">
          <div class="relative aspect-video">
            <div class="absolute inset-0 rounded-xl overflow-hidden z-10 pointer-events-none select-none">
              <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-yellow-500 to-blue-500 animate-[pulse_4s_infinite] mix-blend-overlay opacity-70"></div>
              <div class="absolute inset-0 rounded-xl border-4 border-transparent bg-gradient-to-tr from-red-500/60 via-yellow-500/60 to-blue-500/60 mix-blend-overlay opacity-50 blur-sm"></div>
              <div class="absolute inset-0 border-[6px] border-transparent rounded-xl box-content bg-gradient-to-tr from-red-500/20 via-yellow-500/20 to-blue-500/20 mix-blend-overlay animate-[glow-border_2s_ease-in-out_infinite_alternate]"></div>
            </div>
            <iframe
              class="absolute inset-0 w-full h-full rounded-lg relative z-20 border-4 border-transparent"
              src="https://www.youtube.com/embed/lefHUxQurhU?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
          </div>
        </div>

        {{-- LOGROHAN (desktop only) --}}
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2 md:max-w-[85%] mx-auto hidden md:block">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1">
                <span class="inline-block w-3 h-3 rounded-full border-2 border-white/20 bg-red-600"></span>
                <span class="opacity-70">Red</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="inline-block w-3 h-3 rounded-full border-2 border-white/20 bg-blue-600"></span>
                <span class="opacity-70">Blue</span>
              </div>
            </div>
          </div>

          @if($roleId == 1)
            <form method="POST" class="flex items-center gap-2 mb-2">
              @csrf
              <button name="action" value="admin_add_result" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-xs font-bold hover:bg-red-700">+ Red win</button>
              <input type="hidden" name="win" value="MERON"/>
            </form>
            <form method="POST" class="inline">
              @csrf
              <input type="hidden" name="win" value="WALA"/>
              <button name="action" value="admin_add_result" class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-xs font-bold hover:bg-blue-700">+ Blue win</button>
            </form>
            <form method="POST" class="inline">
              @csrf
              <button name="action" value="undo_result"  class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-xs hover:bg-gray-700">Undo</button>
            </form>
            <form method="POST" class="inline">
              @csrf
              <button name="action" value="clear_results" class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-xs hover:bg-gray-800">Clear</button>
            </form>
            <form method="POST" class="inline">
              @csrf
              <button name="action" value="new_match" class="ml-2 px-2 py-1 rounded bg-amber-600/70 border border-white/10 text-xs hover:bg-amber-600">New Match</button>
            </form>
          @endif

          {{-- Render Big Road (strict-L) --}}
          @php
            $maxRows = 8;
            $grid = build_bigroad_strictL($results, $maxRows);
          @endphp
          <div class="relative overflow-x-auto overflow-y-hidden pb-1 scrollbar-gutter-stable">
            <div class="inline-grid gap-x-[6px]" style="grid-auto-flow:column;grid-auto-columns:max-content;">
              @foreach($grid as $col)
                <div class="grid gap-y-[6px]" style="grid-auto-rows:26px;grid-template-rows:repeat({{ $maxRows }},26px)">
                  @for($r=0;$r<$maxRows;$r++)
                    @php $cell = $col[$r] ?? null; @endphp
                    @if($cell)
                      <div class="w-[26px] h-[26px] rounded-full border-[3px]
                                  shadow-[inset_0_2px_0_rgba(0,0,0,.35),inset_0_0_0_2px_rgba(255,255,255,.06),0_6px_16px_rgba(0,0,0,.45)]
                                  {{ $cell['t']==='R' ? 'text-red-500 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,.18),transparent_55%)]' : 'text-blue-500 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,.18),transparent_55%)]' }}">
                      </div>
                    @else
                      <div class="w-[26px] h-[26px] rounded-full opacity-20 border border-dashed border-white/20"></div>
                    @endif
                  @endfor
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      {{-- RIGHT: Bet cards + Amount + Mini Road --}}
      <aside class="hidden md:block">
        <div class="sticky mt-4 space-y-3">

          {{-- Bet Percentage (desktop) --}}
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
            <div class="text-[11px] uppercase tracking-widest text-white/70 mb-1">Bet Percentage</div>
            <div class="relative h-3 rounded-full bg-black/40 border border-white/10 overflow-hidden">
              <div class="absolute left-0 top-0 h-full bg-red-600/80"  style="width: {{ $redPct }}%"></div>
              <div class="absolute right-0 top-0 h-full bg-blue-600/80" style="width: {{ $bluePct }}%"></div>
            </div>
            <div class="mt-1 grid grid-cols-3 text-[11px] text-white/70">
              <div class="text-left">Red {{ $redPct }}%</div>
              <div class="text-center text-white/50">Total: ₱{{ number_format($total) }}</div>
              <div class="text-right">Blue {{ $bluePct }}%</div>
            </div>
          </div>

          {{-- Cards (3D look, CSS-only hover tilt) --}}
          <div class="grid grid-cols-2 gap-3">
            {{-- RED --}}
            <div class="text-center rounded-2xl p-3 border border-white/10 bg-gradient-to-b from-white/10 to-transparent shadow-[0_10px_24px_rgba(239,68,68,.15)] transition-transform will-change-transform hover:-translate-y-1 hover:rotate-x-2 hover:rotate-y-[-2deg] [transform-style:preserve-3d]">
              <div class="inline-grid place-items-center w-10 h-10 rounded-xl border border-white/20 bg-white/5 text-2xl">R</div>
              <div class="mt-2 text-sm font-semibold opacity-90">{{ $redName }}</div>
              <div class="text-4xl mt-1 [text-shadow:0_2px_0_rgba(0,0,0,.4),0_10px_30px_rgba(0,0,0,.35)]">
                {{ number_format($redAmt) }}
              </div>
              <div class="mt-2">
                <span class="inline-block px-2 py-1 rounded-lg border border-white/15 bg-white/10 text-xs">
                  PAYOUT = {{ $meronOdds }}
                </span>
              </div>

              @if($roleId == 2)
                <form method="POST" class="mt-2">
                  @csrf
                  <input type="hidden" name="action" value="place_bet"/>
                  <input type="hidden" name="side" value="MERON"/>
                  <button class="w-full px-3 py-2 text-sm rounded-lg border border-white/15 bg-white/5 hover:bg-red-600/30">BET</button>
                </form>
              @endif

              {{-- Latest result line (server-side: show last winnings preview if desired) --}}
              @php
                $last = collect($_SESSION['bet_history'] ?? [])->first();
                $show = $last && $last['side']==='MERON' ? "Winnings: ".$last['payout'] : "";
              @endphp
              <div class="mt-2 text-xs text-yellow-300">{{ $show }}</div>
            </div>

            {{-- BLUE --}}
            <div class="text-center rounded-2xl p-3 border border-white/10 bg-gradient-to-b from-white/10 to-transparent shadow-[0_10px_24px_rgba(59,130,246,.15)] transition-transform will-change-transform hover:-translate-y-1 hover:rotate-x-2 hover:rotate-y-[2deg] [transform-style:preserve-3d]">
              <div class="inline-grid place-items-center w-10 h-10 rounded-xl border border-white/20 bg-white/5 text-2xl">B</div>
              <div class="mt-2 text-sm font-semibold opacity-90">{{ $blueName }}</div>
              <div class="text-4xl mt-1 [text-shadow:0_2px_0_rgba(0,0,0,.4),0_10px_30px_rgba(0,0,0,.35)]">
                {{ number_format($blueAmt) }}
              </div>
              <div class="mt-2">
                <span class="inline-block px-2 py-1 rounded-lg border border-white/15 bg-white/10 text-xs">
                  PAYOUT = {{ $walaOdds }}
                </span>
              </div>

              @if($roleId == 2)
                <form method="POST" class="mt-2">
                  @csrf
                  <input type="hidden" name="action" value="place_bet"/>
                  <input type="hidden" name="side" value="WALA"/>
                  <button class="w-full px-3 py-2 text-sm rounded-lg border border-white/15 bg-white/5 hover:bg-blue-600/30">BET</button>
                </form>
              @endif

              @php
                $last = collect($_SESSION['bet_history'] ?? [])->first();
                $show = $last && $last['side']==='WALA' ? "Winnings: ".$last['payout'] : "";
              @endphp
              <div class="mt-2 text-xs text-yellow-300">{{ $show }}</div>
            </div>
          </div>

          {{-- Bet Amount + Chips + Mini Road --}}
          <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
            @if($roleId == 2)
              <div class="flex items-center justify-between mb-2">
                <div class="text-[12px] uppercase tracking-widest text-white/70">Bet Amount</div>
                <div class="text-[12px] text-white/60">min ₱100</div>
              </div>

              {{-- amount input posts on blur/enter via button --}}
              <form method="POST" class="flex flex-wrap items-center gap-2 mb-2">
                @csrf
                <input type="hidden" name="action" value="type_amount"/>
                <input type="number" name="amount" value="{{ $betAmountInput }}" min="0"
                       class="p-2 text-sm text-white bg-black/30 w-[160px] rounded"
                       placeholder="Enter amount" />
                <button type="submit" class="px-3 py-2 text-xs rounded border border-white/15 bg-white/5 hover:bg-white/10">
                  Apply
                </button>
                <div class="ml-auto text-yellow-300">
                  Balance: <span class="font-semibold">{{ number_format($balanceNow) }}</span>
                </div>
              </form>

              {{-- chips (server posts) --}}
              <div class="grid grid-cols-2 gap-1 mb-2">
                @foreach([100,'♦100',200,'♦200',500,'♦500',1000,'♦1000'] as $i=>$val)
                  @if($i%2===0)
                    @php $num = $val; $label = '♦'.number_format($val); @endphp
                    <form method="POST">
                      @csrf
                      <input type="hidden" name="action" value="set_amount"/>
                      <input type="hidden" name="val" value="{{ $num }}"/>
                      <button class="w-full px-3 py-2 text-sm rounded border border-white/15 bg-white/5 hover:bg-white/10">
                        {{ $label }}
                      </button>
                    </form>
                  @endif
                @endforeach
              </div>
            @endif

            {{-- Mini Road --}}
            <div class="mt-6">
              <div class="flex items-center justify-between">
                <div class="text-[11px] uppercase tracking-widest text-white/70">Road</div>
                <div class="flex items-center gap-2 text-[10px]">
                  <div class="flex items-center gap-1">
                    <span class="inline-block w-3 h-3 rounded-full border-2 border-red-600 bg-red-600"></span>
                    <span class="opacity-70">Red</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <span class="inline-block w-3 h-3 rounded-full border-2 border-blue-600 bg-blue-600"></span>
                    <span class="opacity-70">Blue</span>
                  </div>
                </div>
              </div>

              @php
                $maxRows = 8;
                $cols = compute_columns_sequential($results, $maxRows);
              @endphp
              <div class="relative overflow-x-auto overflow-y-hidden pb-1">
                <div class="inline-grid gap-x-[6px]" style="grid-auto-flow:column;grid-auto-columns:max-content;">
                  @foreach($cols as $col)
                    <div class="grid gap-y-[4px]" style="grid-template-rows:repeat({{ $maxRows }},26px)">
                      @for($r=0;$r<$maxRows;$r++)
                        @php $cell = $col[$r] ?? null; @endphp
                        @if($cell)
                          <div class="w-[26px] h-[26px] rounded-full border-2 text-[10px] font-semibold grid place-items-center
                                      {{ $cell['t']==='R' ? 'bg-red-600 border-red-600 text-white' : 'bg-blue-600 border-blue-600 text-white' }}">
                            {{ $cell['label'] }}
                          </div>
                        @else
                          <div class="w-[26px] h-[26px] rounded-full opacity-20 border border-dashed border-white/20"></div>
                        @endif
                      @endfor
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

        </div>
      </aside>

      {{-- ===================== MOBILE STACK ===================== --}}
      <div class="md:hidden space-y-3">
        {{-- Bet % --}}
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
          <div class="flex items-center justify-between">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Bet %</div>
            <div class="text-[11px] text-white/60">Total: ₱{{ number_format($total) }}</div>
          </div>
          <div class="relative h-2.5 rounded-full bg-black/40 border border-white/10 overflow-hidden mt-1.5">
            <div class="absolute left-0 top-0 h-full bg-red-600/80"  style="width: {{ $redPct }}%"></div>
            <div class="absolute right-0 top-0 h-full bg-blue-600/80" style="width: {{ $bluePct }}%"></div>
          </div>
          <div class="mt-1.5 flex items-center justify-between text-[10px] text-white/70">
            <div>Red {{ $redPct }}%</div>
            <div>Blue {{ $bluePct }}%</div>
          </div>
        </div>

        {{-- Mobile cards --}}
        <div class="grid grid-cols-2 gap-2">
          <div class="text-center rounded-2xl p-3 border border-white/10 bg-gradient-to-b from-white/10 to-transparent shadow-[0_10px_24px_rgba(239,68,68,.15)]">
            <div class="inline-grid place-items-center w-8 h-8 rounded-xl border border-white/20 bg-white/5 text-lg">R</div>
            <div class="mt-1 text-xs font-semibold opacity-90 leading-tight">{{ $redName }}</div>
            <div class="text-2xl mt-0.5 [text-shadow:0_2px_0_rgba(0,0,0,.4),0_10px_30px_rgba(0,0,0,.35)]">
              {{ number_format($redAmt) }}
            </div>
            <div class="mt-1">
              <span class="inline-block px-1 py-0.5 text-[10px] rounded-lg border border-white/15 bg-white/10">PAYOUT = {{ $meronOdds }}</span>
            </div>

            @if($roleId == 2)
              <form method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="action" value="place_bet"/>
                <input type="hidden" name="side" value="MERON"/>
                <button class="w-full px-3 py-2 text-xs rounded-lg border border-white/15 bg-white/5 hover:bg-red-600/30">BET</button>
              </form>
            @endif
          </div>

          <div class="text-center rounded-2xl p-3 border border-white/10 bg-gradient-to-b from-white/10 to-transparent shadow-[0_10px_24px_rgba(59,130,246,.15)]">
            <div class="inline-grid place-items-center w-8 h-8 rounded-xl border border-white/20 bg-white/5 text-lg">B</div>
            <div class="mt-1 text-xs font-semibold opacity-90 leading-tight">{{ $blueName }}</div>
            <div class="text-2xl mt-0.5 [text-shadow:0_2px_0_rgba(0,0,0,.4),0_10px_30px_rgba(0,0,0,.35)]">
              {{ number_format($blueAmt) }}
            </div>
            <div class="mt-1">
              <span class="inline-block px-1 py-0.5 text-[10px] rounded-lg border border-white/15 bg-white/10">PAYOUT = {{ $walaOdds }}</span>
            </div>

            @if($roleId == 2)
              <form method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="action" value="place_bet"/>
                <input type="hidden" name="side" value="WALA"/>
                <button class="w-full px-3 py-2 text-xs rounded-lg border border-white/15 bg-white/5 hover:bg-blue-600/30">BET</button>
              </form>
            @endif
          </div>
        </div>

        {{-- Bet amount + chips (mobile) --}}
        @if($roleId == 2)
        <div class="bg-gray-900/60 border border-white/10 rounded-xl p-2">
          <div class="flex items-center justify-between mb-2">
            <div class="text-[12px] uppercase tracking-widest text-white/70">Bet Amount</div>
            <div class="text-[12px] text-white/60">min ₱100</div>
          </div>
          <form method="POST" class="flex items-center gap-2 mb-2">
            @csrf
            <input type="hidden" name="action" value="type_amount"/>
            <input type="number" name="amount" value="{{ $betAmountInput }}" min="0"
                   class="p-2 text-sm text-white bg-black/30 w-full rounded" placeholder="Enter amount" />
            <button type="submit" class="px-3 py-2 text-xs rounded border border-white/15 bg-white/5 hover:bg-white/10">
              Apply
            </button>
            <div class="shrink-0 text-yellow-300">
              <span class="font-semibold">{{ number_format($balanceNow) }}</span>
            </div>
          </form>

          <div class="grid grid-cols-4 gap-1">
            @foreach([100,200,500,1000] as $num)
              <form method="POST">
                @csrf
                <input type="hidden" name="action" value="set_amount"/>
                <input type="hidden" name="val" value="{{ $num }}"/>
                <button class="w-full px-2 py-2 text-xs rounded border border-white/15 bg-white/5 hover:bg-white/10">
                  ♦{{ number_format($num) }}
                </button>
              </form>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Mobile Logrohan (admin-only controls optional) --}}
        <div class="bg-gray-900/50 border border-white/10 rounded-lg p-2">
          <div class="flex items-center justify-between mb-1">
            <div class="text-[11px] uppercase tracking-widest text-white/70">Logrohan</div>
            <div class="flex items-center gap-2 text-[10px]">
              <div class="flex items-center gap-1">
                <span class="inline-block w-2.5 h-2.5 rounded-full border-2 border-white/20 bg-red-600"></span>
                <span class="opacity-70">Red</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="inline-block w-2.5 h-2.5 rounded-full border-2 border-white/20 bg-blue-600"></span>
                <span class="opacity-70">Blue</span>
              </div>
            </div>
          </div>

          @if($roleId == 1)
          <div class="flex items-center gap-2 mb-2">
            <form method="POST" class="inline">@csrf
              <input type="hidden" name="win" value="MERON">
              <button name="action" value="admin_add_result" class="px-2 py-1 rounded bg-red-700/70 border border-white/10 text-[11px] font-bold hover:bg-red-700">+ Red win</button>
            </form>
            <form method="POST" class="inline">@csrf
              <input type="hidden" name="win" value="WALA">
              <button name="action" value="admin_add_result" class="px-2 py-1 rounded bg-blue-700/70 border border-white/10 text-[11px] font-bold hover:bg-blue-700">+ Blue win</button>
            </form>
            <form method="POST" class="inline">@csrf
              <button name="action" value="undo_result"  class="px-2 py-1 rounded bg-gray-700/70 border border-white/10 text-[11px] hover:bg-gray-700">Undo</button>
            </form>
            <form method="POST" class="inline">@csrf
              <button name="action" value="clear_results" class="px-2 py-1 rounded bg-gray-800/70 border border-white/10 text-[11px] hover:bg-gray-800">Clear</button>
            </form>
          </div>
          @endif

          {{-- Mobile Big Road --}}
          @php
            $maxRows = 8;
            $gridMob = build_bigroad_strictL($results, $maxRows);
          @endphp
          <div class="relative overflow-x-auto overflow-y-hidden pb-1">
            <div class="inline-grid gap-x-[6px]" style="grid-auto-flow:column;grid-auto-columns:max-content;">
              @foreach($gridMob as $col)
                <div class="grid gap-y-[6px]" style="grid-template-rows:repeat({{ $maxRows }},26px)">
                  @for($r=0;$r<$maxRows;$r++)
                    @php $cell = $col[$r] ?? null; @endphp
                    @if($cell)
                      <div class="w-[26px] h-[26px] rounded-full border-[3px]
                                  shadow-[inset_0_2px_0_rgba(0,0,0,.35),inset_0_0_0_2px_rgba(255,255,255,.06),0_6px_16px_rgba(0,0,0,.45)]
                                  {{ $cell['t']==='R' ? 'text-red-500 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,.18),transparent_55%)]' : 'text-blue-500 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,.18),transparent_55%)]' }}">
                      </div>
                    @else
                      <div class="w-[26px] h-[26px] rounded-full opacity-20 border border-dashed border-white/20"></div>
                    @endif
                  @endfor
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      {{-- =================== /MOBILE STACK =================== --}}

    </div>
  </main>
</body>
</x-layouts.app>
