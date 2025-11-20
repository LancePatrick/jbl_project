
      /* ===== Code39 BARCODE (SVG) ===== */
      (function () {
        const CODE39 = {
          '0': 'nnnwwnwnn',
          '1': 'wnnwnnnnw',
          '2': 'nnwwnnnnw',
          '3': 'wnwwnnnnn',
          '4': 'nnnwwnnnw',
          '5': 'wnnwwnnnn',
          '6': 'nnwwwnnnn',
          '7': 'nnnwnnwnw',
          '8': 'wnnwnnwnn',
          '9': 'nnwwnnwnn',
          A: 'wnnnnwnnw',
          B: 'nnwnnwnnw',
          C: 'wnwnnwnnn',
          D: 'nnnnwwnnw',
          E: 'wnnnwwnnn',
          F: 'nnwnwwnnn',
          G: 'nnnnnwwnw',
          H: 'wnnnnwwnn',
          I: 'nnwnnwwnn',
          J: 'nnnnwwwnn',
          K: 'wnnnnnnww',
          L: 'nnwnnnnww',
          M: 'wnwnnnnwn',
          N: 'nnnnwnnww',
          O: 'wnnnwnnwn',
          P: 'nnwnwnnwn',
          Q: 'nnnnnnwww',
          R: 'wnnnnnwwn',
          S: 'nnwnnnwwn',
          T: 'nnnnwnwwn',
          U: 'wwnnnnnnw',
          V: 'nwwnnnnnw',
          W: 'wwwnnnnnn',
          X: 'nwnnwnnnw',
          Y: 'wwnnwnnnn',
          Z: 'nwwnwnnnn',
          '-': 'nwnnnnwnw',
          '.': 'wwnnnnwnn',
          ' ': 'nwwnnnwnn',
          $: 'nwnwnwnnn',
          '/': 'nwnwnnnwn',
          '+': 'nwnnnwnwn',
          '%': 'nnnwnwnwn',
          '*': 'nwnnwnwnn',
        };
        function patternFor(ch) {
          return CODE39[ch] || CODE39['-'];
        }
        function encode(text) {
          text =
            '*' +
            text
              .toUpperCase()
              .replace(/[^0-9A-Z\-\.\ \$\/\+\%]/g, '-') +
            '*';
          return Array.from(text)
            .map(patternFor)
            .join('n');
        }
        window.makeCode39SVG = function (data, opts = {}) {
          const h = opts.height || 60;
          const m = opts.module || 2;
          const wide = 3 * m;
          const patt = encode(data);
          let total = 0;
          for (const c of patt) {
            total += c === 'n' ? m : wide;
          }
          let x = 0,
            svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${total}" height="${
              h + 22
            }">`;
          let drawBar = true;
          for (const c of patt) {
            const w = c === 'n' ? m : wide;
            if (drawBar) {
              svg += `<rect x="${x}" y="0" width="${w}" height="${h}" fill="#000"/>`;
            }
            x += w;
            drawBar = !drawBar;
          }
          svg += `<text x="${
            total / 2
          }" y="${
            h + 16
          }" font-family="monospace" font-size="14" text-anchor="middle">${data}</text>`;
          svg += `</svg>`;
          return svg;
        };
      })();

      /* ===== State & helpers ===== */
      const players = [
        'Efren Reyes',
        'Earl Strickland',
        "Ronnie O'Sullivan",
        'Shane Van Boening',
        'Francisco Bustamante',
        'Alex Pagulayan',
        'Jeanette Lee',
        'Karen Corr',
        'Allison Fisher',
        'Johnny Archer',
        'Mika Immonen',
        'Niels Feijen',
        'Darren Appleton',
        'Ko Pin-Yi',
        'Wu Jiaqing',
      ];
      const BIGROAD_MAX_ROWS = 6,
        BEAD_MAX_ROWS = 6;

      let results = [];
      let meronAmount, walaAmount, meronOdds, walaOdds;
      let currentBalance = 500000;
      const betHistory = [];
      let pendingBet = null;

      function getRandomPlayer(ex) {
        let n;
        do {
          n = players[Math.floor(Math.random() * players.length)];
        } while (n === ex);
        return n;
      }
      function setRandomMatch() {
        const red = getRandomPlayer();
        const blue = getRandomPlayer(red);
        const id = Math.floor(Math.random() * 900) + 100;
        const p1 = document.getElementById('player1-name');
        if (p1) p1.textContent = red;
        const p2 = document.getElementById('player2-name');
        if (p2) p2.textContent = blue;
        const mn = document.getElementById('match-no');
        if (mn) mn.textContent = id;
        const p1m = document.getElementById('player1-name-mob');
        if (p1m) p1m.textContent = red;
        const p2m = document.getElementById('player2-name-mob');
        if (p2m) p2m.textContent = blue;
      }
      function setDateTime() {
        const now = new Date();
        const d =
          'EVENT - ' +
          now.toLocaleDateString('en-US', {
            month: '2-digit',
            day: '2-digit',
            year: 'numeric',
          });
        const t =
          now.toLocaleTimeString('en-US', {
            weekday: 'short',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
          }) + ' ';
        const ed = document.getElementById('event-date');
        if (ed) ed.textContent = d;
        const et = document.getElementById('event-time');
        if (et) et.textContent = t;
      }
      setInterval(setDateTime, 1000);

      function attachTilt(el) {
        const damp = 6;
        el.addEventListener('mousemove', (e) => {
          const r = el.getBoundingClientRect();
          const x = (e.clientX - r.left) / r.width;
          const y = (e.clientY - r.top) / r.height;
          const rx = (y - 0.5) * damp,
            ry = (0.5 - x) * damp;
          el.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
        });
        el.addEventListener('mouseleave', () => {
          el.style.transform =
            'rotateX(0) rotateY(0) translateY(0)';
        });
      }

      const isEmpty = (g, c, r) => !(g[c] && g[c][r]);
      const ensureCol = (g, c) => {
        if (!g[c]) g[c] = [];
      };
      function streakRuns(seq) {
        const out = [];
        for (const t of seq) {
          if (!out.length || out[out.length - 1].t !== t)
            out.push({ t, n: 1 });
          else out[out.length - 1].n++;
        }
        return out;
      }
      function buildBigRoadStrictL(seq, maxRows = BEAD_MAX_ROWS) {
        const runs = streakRuns(seq);
        const grid = [];
        let labelNo = 1;
        let prevRunStartCol = -1;
        for (const run of runs) {
          const t = run.t;
          let col, row;
          if (prevRunStartCol < 0) {
            col = 0;
            row = 0;
          } else {
            col = prevRunStartCol + 1;
            row = 0;
            while (!isEmpty(grid, col, row)) {
              col++;
              ensureCol(grid, col);
            }
          }
          const thisRunStartCol = col;
          let placed = 0;
          while (
            placed < run.n &&
            row < maxRows &&
            isEmpty(grid, col, row)
          ) {
            ensureCol(grid, col);
            grid[col][row] = { t, label: labelNo++ };
            placed++;
            row++;
          }
          const lockRow = Math.max(0, row - 1);
          let remain = run.n - placed;
          let c = col + 1;
          while (remain > 0) {
            ensureCol(grid, c);
            if (isEmpty(grid, c, lockRow)) {
              grid[c][lockRow] = { t, label: labelNo++ };
              remain--;
            }
            c++;
          }
          prevRunStartCol = thisRunStartCol;
        }
        return grid;
      }
      function computeColumnsSequential(seq, maxRows) {
        const cols = [];
        let col = [];
        let labelNo = 1;
        for (const t of seq) {
          col.push({ t, label: labelNo++ });
          if (col.length === maxRows) {
            cols.push(col);
            col = [];
          }
        }
        if (col.length) cols.push(col);
        return cols;
      }
      function renderLogroContinuous(
        seq,
        stripId,
        maxRows = BIGROAD_MAX_ROWS
      ) {
        const grid = buildBigRoadStrictL(seq, maxRows);
        const strip = document.getElementById(stripId);
        if (!strip) return;
        strip.innerHTML = '';
        grid.forEach((col) => {
          const colDiv = document.createElement('div');
          colDiv.className = 'logro-col';
          colDiv.style.gridTemplateRows = `repeat(${maxRows}, var(--logro-bubble))`;
          for (let r = 0; r < maxRows; r++) {
            const cell = col && col[r];
            if (cell) {
              const b = document.createElement('div');
              b.className = `ring-bubble ${
                cell.t === 'R' ? 'ring-red' : 'ring-blue'
              }`;
              const depth = Math.min(r, maxRows - 1);
              b.style.setProperty(
                '--z',
                `calc(var(--logro-step) * ${depth})`
              );
              b.style.transform = `translateZ(var(--z))`;
              colDiv.appendChild(b);
            } else {
              const gap = document.createElement('div');
              gap.className = 'ring-gap';
              colDiv.appendChild(gap);
            }
          }
          strip.appendChild(colDiv);
        });
        strip.scrollLeft = strip.scrollWidth;
      }
      function renderRoadStrictL(
        seq,
        stripId,
        maxRows = BEAD_MAX_ROWS
      ) {
        const cols = computeColumnsSequential(seq, maxRows);
        const strip = document.getElementById(stripId);
        if (!strip) return;
        strip.innerHTML = '';
        cols.forEach((col) => {
          const colDiv = document.createElement('div');
          colDiv.className = 'bead-col';
          colDiv.style.gridTemplateRows = `repeat(${maxRows}, var(--bead-bubble))`;
          for (let r = 0; r < maxRows; r++) {
            const cell = col[r];
            const dot = document.createElement('div');
            if (cell) {
              dot.className =
                'bead-solid ' +
                (cell.t === 'R' ? 'red' : 'blue');
              dot.textContent = cell.label;
            } else {
              dot.className = 'bead';
              dot.style.opacity = '0.12';
              dot.style.border =
                '1px dashed rgba(255,255,255,.15)';
            }
            colDiv.appendChild(dot);
          }
          strip.appendChild(colDiv);
        });
        strip.scrollLeft = strip.scrollWidth;
      }
      function renderAllRoads(seq) {
        renderLogroContinuous(
          seq,
          'logro-strip-center',
          BIGROAD_MAX_ROWS
        );
        renderRoadStrictL(
          seq,
          'bead-strip-center',
          BEAD_MAX_ROWS
        );
        renderLogroContinuous(
          seq,
          'logro-strip-mob',
          BIGROAD_MAX_ROWS
        );
      }

      function computeOdds() {
        meronOdds = (
          Math.random() * (2.0 - 1.5) +
          1.5
        ).toFixed(2);
        walaOdds = (
          parseFloat(meronOdds) + 0.2
        ).toFixed(2);
      }
      function renderOddsEverywhere() {
        const m = document.getElementById('meron-odds');
        if (m)
          m.textContent = 'PAYOUT = ' + meronOdds;
        const w = document.getElementById('wala-odds');
        if (w)
          w.textContent = 'PAYOUT = ' + walaOdds;
        const mm = document.getElementById(
          'meron-odds-mob'
        );
        if (mm)
          mm.textContent = 'PAYOUT = ' + meronOdds;
        const ww = document.getElementById(
          'wala-odds-mob'
        );
        if (ww)
          ww.textContent = 'PAYOUT = ' + walaOdds;
      }
      function renderBalance() {
        const mid = document.getElementById('mid-balance');
        const head =
          document.getElementById('header-balance');
        if (mid)
          mid.textContent =
            Number(currentBalance).toLocaleString();
        if (head)
          head.textContent =
            Number(currentBalance).toLocaleString();
      }
      function adjustBalance(delta) {
        const next = currentBalance + delta;
        if (next < 0) return false;
        currentBalance = next;
        renderBalance();
        return true;
      }
      function updatePercentBar() {
        const red = meronAmount || 0,
          blue = walaAmount || 0;
        const total = red + blue;
        let redPct = 50,
          bluePct = 50;
        if (total > 0) {
          redPct = Math.round((red / total) * 100);
          bluePct = 100 - redPct;
        }
        const rEl = document.getElementById('pct-red');
        const bEl = document.getElementById('pct-blue');
        const rl = document.getElementById(
          'pct-red-label'
        );
        const bl = document.getElementById(
          'pct-blue-label'
        );
        const tl = document.getElementById(
          'pct-total-label'
        );
        if (rEl) rEl.style.width = redPct + '%';
        if (bEl) bEl.style.width = bluePct + '%';
        if (rl) rl.textContent = `Red ${redPct}%`;
        if (bl) bl.textContent = `Blue ${bluePct}%`;
        if (tl)
          tl.textContent =
            'Total: ₱' +
            Number(total).toLocaleString('en-PH');
      }

      function sideBadgeHTML(side) {
        const cls =
          side === 'MERON'
            ? 'side-badge side-meron'
            : 'side-badge side-wala';
        return `<span class="side-3d"><span class="${cls}">${side}</span></span>`;
      }
      function badgeClassByStatus(s) {
        if (s === 'WIN') return 'badge-3d badge-win';
        if (s === 'LOSE') return 'badge-3d badge-lose';
        return 'badge-3d badge-pending';
      }
      function addToHistory(entry) {
        betHistory.unshift(entry);
        renderHeaderHistory();
        const dot =
          document.getElementById('header-history-dot') ||
          document.getElementById('history-dot');
        if (dot)
          dot.classList.toggle(
            'hidden',
            betHistory.length === 0
          );
        renderBetHistoryPage();
      }
      function renderHeaderHistory() {
        const list = document.getElementById(
          'header-history-list'
        );
        const empty = document.getElementById(
          'header-history-empty'
        );
        if (!list || !empty) return;
        if (betHistory.length === 0) {
          empty.classList.remove('hidden');
          list.classList.add('hidden');
          list.innerHTML = '';
          return;
        }
        empty.classList.add('hidden');
        list.classList.remove('hidden');
        const top = betHistory.slice(0, 8);
        list.innerHTML = top
          .map((item) => {
            const sideChip = sideBadgeHTML(
              item.side
            );
            const badge = `<span class="result-3d"><span class="${badgeClassByStatus(
              item.status
            )}">${item.status}</span></span>`;
            return `
          <div class="py-2 px-2 text-xs">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">${sideChip}</div>
              <div class="flex items-center gap-2">${badge}<div class="text-white/50">${item.time}</div></div>
            </div>
            <div class="text-white/80 mt-1">${item.player} • Match #${
              item.matchId
            }</div>
            <div class="mt-0.5">
              <span class="font-semibold">${Number(
                item.amount
              ).toLocaleString()}</span>
              @ <span class="font-semibold">${
                item.odds
              }</span>
              = <span class="text-yellow-300 font-bold">${Number(
                item.payout
              ).toLocaleString()}</span>
            </div>
            <div class="text-white/50 mt-0.5">Bal: ${Number(
              item.balanceBefore
            ).toLocaleString()} → <span class="text-white/80 font-semibold">${Number(
              item.balanceAfter
            ).toLocaleString()}</span></div>
          </div>`;
          })
          .join('');
      }
      function resolveLatestBet(winSide) {
        const idx = betHistory.findIndex(
          (b) => b.status === 'PENDING'
        );
        if (idx === -1) return;
        const bet = betHistory[idx];
        if (bet.side === winSide) {
          bet.status = 'WIN';
          adjustBalance(parseFloat(bet.payout));
          bet.balanceAfter = currentBalance;
        } else {
          bet.status = 'LOSE';
          bet.balanceAfter = currentBalance;
        }
        renderHeaderHistory();
        renderBetHistoryPage();
      }

      function buildTicketId(matchId, side, amount) {
        const ts = Date.now()
          .toString(36)
          .toUpperCase();
        return `BK-${matchId}-${side[0]}-${amount}-${ts}`;
      }
      function printTicket(ticket) {
        const holder = document.getElementById(
          'print-ticket-content'
        );
        const wrap =
          document.getElementById('print-ticket');
        const barSVG = makeCode39SVG(ticket.barcode, {
          height: 70,
          module: 2,
        });
        const html = `
        <div class="text-center">
          <div class="text-[12px] text-gray-600 tracking-widest">BK2025 • Bet Ticket</div>
          <div class="mt-1 text-xl font-bold">MATCH #${
            ticket.matchId
          }</div>
          <div class="mt-1 text-[13px]">Ticket: <span class="font-semibold">${
            ticket.ticketId
          }</span></div>
          <div class="mt-3 grid grid-cols-2 gap-3 text-left">
            <div class="border border-gray-200 rounded-lg p-3">
              <div class="text-[12px] text-gray-500">Side</div>
              <div class="text-lg font-semibold">${
                ticket.side
              }</div>
              <div class="mt-1 text-[12px] text-gray-500">Player</div>
              <div class="font-medium">${
                ticket.player
              }</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-3">
              <div class="text-[12px] text-gray-500">Amount</div>
              <div class="text-lg font-semibold">₱${Number(
                ticket.amount
              ).toLocaleString('en-PH')}</div>
              <div class="mt-1 text-[12px] text-gray-500">Odds</div>
              <div class="font-medium">${
                ticket.odds
              }</div>
              <div class="mt-1 text-[12px] text-gray-500">Potential Payout</div>
              <div class="font-semibold text-emerald-700">₱${Number(
                ticket.payout
              ).toLocaleString('en-PH')}</div>
            </div>
          </div>
          <div class="mt-4 flex items-center justify-center">${barSVG}</div>
          <div class="mt-2 text-[12px] text-gray-600">Printed: ${new Date().toLocaleString(
            'en-PH',
            { hour12: true }
          )}</div>
        </div>`;
        if (holder && wrap) {
          holder.innerHTML = html;
          wrap.classList.remove('hidden');
          window.print();
          setTimeout(
            () => wrap.classList.add('hidden'),
            300
          );
        }
      }

      /* ====== CUSTOMER DETAILS HELPER ====== */
      function updateCustomerDetails({
        amount,
        payout,
        time,
        who,
      }) {
        const betEl =
          document.getElementById('cust-name');
        if (betEl)
          betEl.value = `₱${Number(
            amount || 0
          ).toLocaleString('en-PH')}`;
        const payEl =
          document.getElementById('cust-user');
        if (payEl)
          payEl.value = `₱${Number(
            payout || 0
          ).toLocaleString('en-PH')}`;
        const timeEl =
          document.getElementById('cust-email');
        if (timeEl) timeEl.value = time || '';
        const whoEl =
          document.getElementById('cust-phone');
        if (whoEl) whoEl.value = who || '';
      }

      /* Confirm helpers */
      function openConfirmModal(details) {
        pendingBet = details;
        document.getElementById('c-side').textContent =
          details.side;
        document.getElementById(
          'c-player'
        ).textContent = details.player;
        document.getElementById('c-match').textContent =
          details.matchId;
        document.getElementById(
          'c-amount'
        ).textContent = `₱${Number(
          details.amount
        ).toLocaleString('en-PH')}`;
        document.getElementById('c-odds').textContent =
          details.odds;
        document.getElementById(
          'c-payout'
        ).textContent = `₱${Number(
          details.payout
        ).toLocaleString('en-PH')}`;
        document.getElementById(
          'c-balance'
        ).textContent = `₱${Number(
          details.balanceAfter
        ).toLocaleString('en-PH')}`;
        document.getElementById(
          'confirm-overlay'
        ).style.display = 'flex';
      }
      function closeConfirmModal() {
        pendingBet = null;
        document.getElementById(
          'confirm-overlay'
        ).style.display = 'none';
      }

      function placeBet(betType) {
        const input =
          document.getElementById('bet-amount');
        let betAmount = parseFloat(input?.value);
        if (isNaN(betAmount) || betAmount <= 0) {
          alert(
            'Please enter a valid bet amount greater than 0.'
          );
          return;
        }
        let odds, chosenPlayer;
        if (betType === 'MERON') {
          odds = meronOdds;
          chosenPlayer =
            document.getElementById(
              'player1-name'
            ).textContent;
        } else {
          odds = walaOdds;
          chosenPlayer =
            document.getElementById(
              'player2-name'
            ).textContent;
        }
        const matchId =
          document.getElementById('match-no')
            .textContent || '—';
        const balanceAfter =
          currentBalance - betAmount;
        if (balanceAfter < 0) {
          alert('Insufficient balance.');
          return;
        }
        const potential = (
          betAmount * parseFloat(odds)
        ).toFixed(2);
        openConfirmModal({
          side: betType,
          player:
            chosenPlayer ||
            (betType === 'MERON' ? 'Red' : 'Blue'),
          matchId,
          amount: betAmount,
          odds,
          payout: potential,
          balanceAfter,
        });
      }
      function executeBet(details) {
        const {
          side: betType,
          player: chosenPlayer,
          matchId,
          amount: betAmount,
          odds,
        } = details;
        const balanceBefore = currentBalance;
        if (!adjustBalance(-betAmount)) {
          alert('Insufficient balance.');
          return;
        }
        if (betType === 'MERON') {
          meronAmount += betAmount;
          const el =
            document.getElementById('meron-amount');
          if (el)
            el.textContent =
              meronAmount.toLocaleString();
        } else {
          walaAmount += betAmount;
          const el =
            document.getElementById('wala-amount');
          if (el)
            el.textContent =
              walaAmount.toLocaleString();
        }
        updatePercentBar();
        const totalWinnings =
          parseFloat(betAmount) * parseFloat(odds);
        if (betType === 'MERON') {
          const r =
            document.getElementById('meron-result');
          if (r)
            r.textContent = `${chosenPlayer} • Winnings: ${totalWinnings.toFixed(
              2
            )}`;
          const c =
            document.getElementById('wala-result');
          if (c) c.textContent = '';
        } else {
          const r =
            document.getElementById('wala-result');
          if (r)
            r.textContent = `${chosenPlayer} • Winnings: ${totalWinnings.toFixed(
              2
            )}`;
          const c =
            document.getElementById('meron-result');
          if (c) c.textContent = '';
        }
        const time = new Date().toLocaleString(
          'en-PH',
          { hour12: true }
        );

        /* Update Customer Details after successful bet */
        updateCustomerDetails({
          amount: betAmount,
          payout: totalWinnings,
          time,
          who: `${betType} — ${chosenPlayer}`,
        });

        const entry = {
          side: betType,
          player: chosenPlayer,
          matchId,
          amount: betAmount,
          odds,
          payout: totalWinnings.toFixed(2),
          time,
          balanceBefore,
          balanceAfter: currentBalance,
          status: 'PENDING',
        };
        addToHistory(entry);
        const ticketId = buildTicketId(
          matchId,
          betType,
          betAmount
        );
        const barcodeData = `BK|${ticketId}|${betType}|${betAmount}|${odds}|${entry.payout}`;
        printTicket({
          ticketId,
          barcode: barcodeData,
          matchId,
          side: betType,
          player: entry.player,
          amount: betAmount,
          odds,
          payout: entry.payout,
        });
        alert(
          `You placed a bet of ${betAmount} on ${chosenPlayer}.
Possible payout: ${totalWinnings.toFixed(
            2
          )}.
New Balance: ${currentBalance.toLocaleString()}.`
        );
      }

      function pushResult(side) {
        results.push(side === 'MERON' ? 'R' : 'B');
        renderAllRoads(results);
        resolveLatestBet(side);
      }
      function undoResult() {
        results.pop();
        renderAllRoads(results);
      }
      function clearResults() {
        results = [];
        renderAllRoads(results);
      }

      /* Pagination */
      let historyPage = 1;
      const pageSize = 10;
      function renderBetHistoryPage() {
        const listEl =
          document.getElementById('history-list');
        const emptyEl =
          document.getElementById('history-empty');
        const pageEl =
          document.getElementById('history-page');
        const pagesEl =
          document.getElementById('history-pages');
        const prevBtn =
          document.getElementById('history-prev');
        const nextBtn =
          document.getElementById('history-next');

        const total = betHistory.length;
        const totalPages = Math.max(
          1,
          Math.ceil(total / pageSize)
        );
        if (historyPage > totalPages)
          historyPage = totalPages;
        if (historyPage < 1) historyPage = 1;

        if (pagesEl)
          pagesEl.textContent = String(totalPages);
        if (pageEl)
          pageEl.textContent = String(historyPage);
        if (prevBtn)
          prevBtn.disabled = historyPage <= 1;
        if (nextBtn)
          nextBtn.disabled =
            historyPage >= totalPages;

        if (total === 0) {
          if (listEl) listEl.innerHTML = '';
          if (emptyEl)
            emptyEl.classList.remove('hidden');
          return;
        } else {
          if (emptyEl)
            emptyEl.classList.add('hidden');
        }

        const start = (historyPage - 1) * pageSize;
        const pageItems = betHistory.slice(
          start,
          start + pageSize
        );

        if (listEl) {
          listEl.innerHTML = pageItems
            .map((item) => {
              const sideChipClass =
                item.side === 'MERON'
                  ? 'inline-flex h-6 min-w-[24px] items-center justify-center rounded-full border border-red-500/70 bg-red-900 text-rose-100 text-[12px] font-semibold'
                  : 'inline-flex h-6 min-w-[24px] items-center justify-center rounded-full border border-sky-400/70 bg-blue-900 text-sky-100 text-[12px] font-semibold';
              const statusBase =
                'text-[13px] font-semibold';
              const statusClass =
                item.status === 'WIN'
                  ? `${statusBase} text-emerald-400`
                  : item.status === 'LOSE'
                  ? `${statusBase} text-rose-400`
                  : `${statusBase} text-amber-400`;

              return `
          <div class="py-3 border-b border-white/10 last:border-b-0">
            <div class="flex items-center justify-between text-[13px]">
              <div class="flex items-center gap-2">
                <span class="${sideChipClass}">${item.side[0]}</span>
                <span class="text-slate-200 font-medium">${item.player}</span>
              </div>
              <span class="text-slate-400 text-[11px]">${item.time}</span>
            </div>
            <div class="mt-1 grid grid-cols-3 gap-2 text-[12.5px] text-slate-300">
              <div>Match <strong class="text-white">#${item.matchId}</strong></div>
              <div>Amt <strong class="text-white">₱${Number(
                item.amount
              ).toLocaleString('en-PH')}</strong></div>
              <div class="text-right">Odds <strong class="text-white">${
                item.odds
              }</strong></div>
            </div>
            <div class="mt-1 flex items-center justify-between text-[13px]">
              <div class="${statusClass}">${item.status}</div>
              <div class="text-amber-300 text-[13px]">Payout <span class="font-bold">₱${Number(
                item.payout
              ).toLocaleString('en-PH')}</span></div>
            </div>
          </div>`;
            })
            .join('');
        }
      }

      /* Scan/Enter handlers */
      (function () {
        const form =
          document.getElementById('scan-form');
        const input =
          document.getElementById('scan-input');
        const status =
          document.getElementById('scan-status');
        const reset =
          document.getElementById('scan-reset');

        if (form) {
          form.addEventListener('submit', (e) => {
            e.preventDefault();
            const code = (input?.value || '').trim();
            if (!code) {
              status.textContent =
                'Please enter a card code.';
              return;
            }
            status.textContent =
              'Card accepted: ' + code;
          });
        }
        reset?.addEventListener('click', () => {
          input.value = '';
          [
            'cust-name',
            'cust-user',
            'cust-email',
            'cust-phone',
          ].forEach((id) => {
            const el =
              document.getElementById(id);
            if (el) el.value = '';
          });
          status.textContent = '';
        });
      })();

      /* Init */
      window.onload = () => {
        setDateTime();
        setRandomMatch();
        let meronAmountInit =
          Math.floor(Math.random() * (50000 - 10000 + 1)) +
          10000;
        let walaAmountInit =
          Math.floor(Math.random() * (50000 - 10000 + 1)) +
          10000;
        meronAmount = meronAmountInit;
        walaAmount = walaAmountInit;

        computeOdds();
        renderOddsEverywhere();
        const ma =
          document.getElementById('meron-amount');
        if (ma)
          ma.textContent =
            meronAmount.toLocaleString();
        const wa =
          document.getElementById('wala-amount');
        if (wa)
          wa.textContent =
            walaAmount.toLocaleString();
        const mam =
          document.getElementById(
            'meron-amount-mob'
          );
        if (mam)
          mam.textContent =
            meronAmount.toLocaleString();
        const wam =
          document.getElementById(
            'wala-amount-mob'
          );
        if (wam)
          wam.textContent =
            walaAmount.toLocaleString();

        updatePercentBar();
        document
          .querySelectorAll('.tilt')
          .forEach(attachTilt);

        // Admin controls (if present in DOM)
        const wm =
          document.getElementById(
            'btn-win-meron'
          );
        const ww =
          document.getElementById(
            'btn-win-wala'
          );
        const uu =
          document.getElementById('btn-undo');
        const cc =
          document.getElementById('btn-clear');
        if (wm)
          wm.addEventListener('click', () =>
            pushResult('MERON')
          );
        if (ww)
          ww.addEventListener('click', () =>
            pushResult('WALA')
          );
        if (uu)
          uu.addEventListener('click', undoResult);
        if (cc)
          cc.addEventListener('click', clearResults);

        renderAllRoads(results);
        renderBalance();

        document
          .querySelectorAll('.bet-chip')
          .forEach((btn) => {
            btn.addEventListener('click', () => {
              const raw = parseInt(
                btn.dataset.val || '0',
                10
              );
              const amt =
                document.getElementById(
                  'bet-amount'
                );
              if (amt) amt.value = raw;
              btn.animate(
                [
                  { transform: 'translateY(-3px)' },
                  { transform: 'translateY(0)' },
                ],
                { duration: 120 }
              );
            });
          });

        const bm =
          document.getElementById('bet-meron');
        const bw =
          document.getElementById('bet-wala');
        if (bm)
          bm.addEventListener('click', () =>
            placeBet('MERON')
          );
        if (bw)
          bw.addEventListener('click', () =>
            placeBet('WALA')
          );

        const videoWrap =
          document.getElementById('video-wrap');
        const toggleBtn =
          document.getElementById('toggle-video');
        const toggleLbl =
          document.getElementById(
            'toggle-video-label'
          );
        try {
          const saved =
            localStorage.getItem(
              'bk_video_hidden'
            );
          if (saved === '1') {
            videoWrap.classList.add('hidden');
            if (toggleLbl)
              toggleLbl.textContent =
                'Show Video';
          }
        } catch (e) {}
        if (toggleBtn && videoWrap) {
          toggleBtn.addEventListener('click', () => {
            const hidden =
              videoWrap.classList.toggle(
                'hidden'
              );
            if (toggleLbl)
              toggleLbl.textContent = hidden
                ? 'Show Video'
                : 'Hide Video';
            try {
              localStorage.setItem(
                'bk_video_hidden',
                hidden ? '1' : '0'
              );
            } catch (e) {}
          });
        }

        const prevBtn =
          document.getElementById(
            'history-prev'
          );
        const nextBtn =
          document.getElementById(
            'history-next'
          );
        prevBtn?.addEventListener('click', () => {
          historyPage = Math.max(
            1,
            historyPage - 1
          );
          renderBetHistoryPage();
        });
        nextBtn?.addEventListener('click', () => {
          const totalPages = Math.max(
            1,
            Math.ceil(
              betHistory.length / pageSize
            )
          );
          historyPage = Math.min(
            totalPages,
            historyPage + 1
          );
          renderBetHistoryPage();
        });

        document
          .getElementById('confirm-cancel')
          .addEventListener(
            'click',
            closeConfirmModal
          );
        document
          .getElementById('confirm-overlay')
          .addEventListener('click', (e) => {
            if (e.target.id === 'confirm-overlay')
              closeConfirmModal();
          });
        document
          .getElementById('confirm-ok')
          .addEventListener('click', () => {
            if (pendingBet) {
              executeBet(pendingBet);
            }
            closeConfirmModal();
          });

        renderBetHistoryPage();
      };
 