{{-- resources/views/livewire/logrohan-board.blade.php --}}
@volt
<div class="p-4 max-w-screen-xl mx-auto">
  @auth
    @if(auth()->user()->role_id == 1)
      <div class="flex gap-2 mb-4">
        <button id="btn-win-meron" class="bet-input bg-black/30 p-2">Red Score</button>
        <button id="btn-win-wala" class="bet-input bg-black/30 p-2">Blue Score</button>
        <button id="btn-undo" class="bet-input bg-black/30 p-2">Undo</button>
        <button id="btn-clear" class="bet-input bg-black/30 p-2">Clear</button>
      </div>
    @endif
  @endauth

  {{-- Road Display Section --}}
  <div class="flex flex-col gap-6">
    <div id="logro-strip-center" class="logro-strip-3d"></div>
    <div id="bead-strip-center" class="bead-strip"></div>
    <div id="logro-strip-mob" class="logro-strip-3d"></div>
  </div>

  {{-- Bet History Display --}}
  <div class="mt-8">
    <div id="bet-history" class="space-y-2"></div>
    <div id="pagination" class="flex justify-center items-center gap-2 mt-4"></div>
  </div>
</div>

<script>
  let results = [];
  const BIGROAD_MAX_ROWS = 6;
  const BEAD_MAX_ROWS = 6;

  const wm = document.getElementById('btn-win-meron');
  const ww = document.getElementById('btn-win-wala');
  const uu = document.getElementById('btn-undo');
  const cc = document.getElementById('btn-clear');

  if (wm) wm.addEventListener('click', () => pushResult('MERON'));
  if (ww) ww.addEventListener('click', () => pushResult('WALA'));
  if (uu) uu.addEventListener('click', undoResult);
  if (cc) cc.addEventListener('click', clearResults);

  function renderAllRoads(seq) {
    renderLogroContinuous(seq, 'logro-strip-center', BIGROAD_MAX_ROWS);
    renderRoadStrictL(seq, 'bead-strip-center', BEAD_MAX_ROWS);
    renderLogroContinuous(seq, 'logro-strip-mob', BIGROAD_MAX_ROWS);
  }

  function pushResult(side) {
    results.push(side === 'MERON' ? 'R' : 'B');
    renderAllRoads(results);
    resolveLatestBet(side);
    console.log(results);
  }

  function undoResult() {
    results.pop();
    renderAllRoads(results);
  }

  function clearResults() {
    results = [];
    renderAllRoads(results);
  }

  function renderLogroContinuous(seq, elementId, maxRows) {
    const container = document.getElementById(elementId);
    if (!container) return;
    container.innerHTML = '';
    let col = document.createElement('div');
    col.className = 'flex flex-col';
    container.appendChild(col);

    seq.forEach((res, index) => {
      const cell = document.createElement('div');
      cell.className = `w-5 h-5 rounded-full mb-1 ${res === 'R' ? 'bg-red-500' : 'bg-blue-500'}`;
      col.appendChild(cell);

      if ((index + 1) % maxRows === 0) {
        col = document.createElement('div');
        col.className = 'flex flex-col ml-1';
        container.appendChild(col);
      }
    });
  }

  function renderRoadStrictL(seq, elementId, maxRows) {
    const container = document.getElementById(elementId);
    if (!container) return;
    container.innerHTML = '';

    let col = document.createElement('div');
    col.className = 'flex flex-col';
    container.appendChild(col);

    seq.forEach((res, index) => {
      const cell = document.createElement('div');
      cell.className = `w-4 h-4 rounded-full mb-1 ${res === 'R' ? 'bg-red-400' : 'bg-blue-400'}`;
      col.appendChild(cell);

      if ((index + 1) % maxRows === 0) {
        col = document.createElement('div');
        col.className = 'flex flex-col ml-1';
        container.appendChild(col);
      }
    });
  }

  function resolveLatestBet(side) {
    // optional: handle bet logic
  }

  // Pagination & History
  const betHistory = [];
  const pageSize = 10;
  const paginationContainer = document.getElementById('pagination');

  function renderPagination() {
    paginationContainer.innerHTML = '';
    const total = betHistory.length;
  }
</script>
@endvolt
