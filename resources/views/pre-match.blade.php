<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Today's Matches</title>

    <!-- Tailwind v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        crossorigin="anonymous" />

    <!-- AOS (kept) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Keep only essentials: x-cloak helper + NEON animation */
        [x-cloak] {
            display: none !important;
        }

        .neon {
            position: relative;
            display: inline-block;
            border-radius: .75rem;
            filter: drop-shadow(0 0 6px var(--glow, #22c55e)) drop-shadow(0 0 16px var(--glow, #22c55e));
        }

        .neon::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 2px solid var(--glow);
            box-shadow: inset 0 0 10px var(--glow, #22c55e), 0 0 10px var(--glow, #22c55e);
            animation: neonPulse 1.8s ease-in-out infinite;
            pointer-events: none;
        }

        .neon-slate {
            --glow: #22c55e;
        }

        .neon-blue {
            --glow: #0090ff;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none
        }

        .no-scrollbar {
            scrollbar-width: none
        }

        .neon-amber {
            --glow: #f59e0b;
        }

        @keyframes neonPulse {

            0%,
            100% {
                opacity: .85;
                filter: brightness(1)
            }

            50% {
                opacity: 1;
                filter: brightness(1.2)
            }
        }
    </style>

    <!-- (Optional) Backend can override the sample data by defining window.TABLE_DATA before Alpine runs -->
    <script>
        /* Example structure the backend can output:
                  window.TABLE_DATA = {
                    billiards: [{event:'',venue:'',participants:'',status:'Upcoming',odds:[1.8,2.0],href:'#'}, ...],
                    motor:     [...],
                    horse:     [...]
                  };
                */
    </script>

    <script>
        // Alpine component: adds client-side pagination
        function app() {
            return {
                sport: 'billiards',

                // PAGINATION STATE
                page: 1,
                pageSizeOptions: [5, 10, 15, 20],
                pageSize: 5,

                data: window.TABLE_DATA ?? {
                    billiards: [{
                            event: 'World Billiards Final',
                            venue: 'Manila',
                            participants: 'Strickland vs. Reyes',
                            status: 'Upcoming',
                            odds: [1.8, 2.0],
                            href: '#'
                        },
                        {
                            event: 'Philippine Open QF',
                            venue: 'Cebu',
                            participants: 'Orcullo vs. Ko',
                            status: 'Upcoming',
                            odds: [1.9, 1.9],
                            href: '#'
                        },
                        {
                            event: 'City Invitational',
                            venue: 'Davao',
                            participants: 'Filler vs. Ouschan',
                            status: 'Upcoming',
                            odds: [1.85, 2.05],
                            href: '#'
                        },
                        {
                            event: 'Legends Showdown',
                            venue: 'Quezon City',
                            participants: 'Bustamante vs. Parica',
                            status: 'Upcoming',
                            odds: [1.75, 2.20],
                            href: '#'
                        },
                        {
                            event: 'Doubles Masters',
                            venue: 'Baguio',
                            participants: 'Gomez/Moritz vs. Ko/Woodward',
                            status: 'Upcoming',
                            odds: [2.30, 1.65],
                            href: '#'
                        },
                        // add more to see pagination in action
                        {
                            event: 'Regional Classic',
                            venue: 'Cavite',
                            participants: 'Van Boening vs. Orcollo',
                            status: 'Upcoming',
                            odds: [1.80, 2.10],
                            href: '#'
                        },
                        {
                            event: 'Night Cup',
                            venue: 'Makati',
                            participants: 'Shaw vs. Chua',
                            status: 'Upcoming',
                            odds: [2.00, 1.90],
                            href: '#'
                        },
                    ],
                    motor: [{
                            event: 'Grand Prix – Heat 1',
                            venue: 'Clark International',
                            participants: 'Team Apex vs. Velocity',
                            status: 'Upcoming',
                            odds: [1.90, 1.95],
                            href: '#'
                        },
                        {
                            event: 'Street Circuit Sprint',
                            venue: 'Subic',
                            participants: 'Santos vs. Nakamura',
                            status: 'Upcoming',
                            odds: [2.10, 1.75],
                            href: '#'
                        },
                        {
                            event: 'Time Attack Series',
                            venue: 'Batangas Racing',
                            participants: 'Rivera vs. Kim',
                            status: 'Upcoming',
                            odds: [1.85, 2.05],
                            href: '#'
                        },
                        {
                            event: 'Drag Night Finals',
                            venue: 'Cebu SRP',
                            participants: 'Hayabusa vs. ZX-14R',
                            status: 'Upcoming',
                            odds: [1.70, 2.20],
                            href: '#'
                        },
                        {
                            event: 'Endurance 200',
                            venue: 'BRC',
                            participants: 'TorqueWorks vs. RapidX',
                            status: 'Upcoming',
                            odds: [2.30, 1.65],
                            href: '#'
                        },
                    ],
                    horse: [{
                            event: 'San Lazaro Cup',
                            venue: 'San Lazaro',
                            participants: 'Thunderstrike vs. Golden Dusk',
                            status: 'Upcoming',
                            odds: [2.40, 1.60],
                            href: '#'
                        },
                        {
                            event: 'Manila Derby Trial',
                            venue: 'MetroTurf',
                            participants: 'Blue Comet vs. Night Ember',
                            status: 'Upcoming',
                            odds: [1.95, 1.95],
                            href: '#'
                        },
                        {
                            event: 'Weekend Handicap',
                            venue: 'Santa Ana Park',
                            participants: 'Silver Arrow vs. Red Lantern',
                            status: 'Upcoming',
                            odds: [1.80, 2.05],
                            href: '#'
                        },
                        {
                            event: 'Night Sprint Series',
                            venue: 'MetroTurf',
                            participants: 'Jade Runner vs. Iron Fog',
                            status: 'Upcoming',
                            odds: [2.20, 1.70],
                            href: '#'
                        },
                        {
                            event: 'Metro Stakes',
                            venue: 'San Lazaro',
                            participants: 'Star Harbor vs. Quicksilver',
                            status: 'Upcoming',
                            odds: [1.65, 2.30],
                            href: '#'
                        },
                    ]
                },

                rows() {
                    return this.data[this.sport] ?? [];
                },

                // derived counts
                get totalItems() {
                    return this.rows().length;
                },
                get totalPages() {
                    return Math.max(1, Math.ceil(this.totalItems / this.pageSize));
                },

                // visible slice
                pagedRows() {
                    const start = (this.page - 1) * this.pageSize;
                    return this.rows().slice(start, start + this.pageSize);
                },

                // UI helpers
                fmtOdds(odds) {
                    return Array.isArray(odds) ? `${odds[0].toFixed(2)} / ${odds[1].toFixed(2)}` : String(odds);
                },
                showingFrom() {
                    return this.totalItems === 0 ? 0 : (this.page - 1) * this.pageSize + 1;
                },
                showingTo() {
                    return Math.min(this.page * this.pageSize, this.totalItems);
                },

                goto(p) {
                    this.page = Math.min(Math.max(1, p), this.totalPages);
                },
                prev() {
                    if (this.page > 1) this.page--;
                },
                next() {
                    if (this.page < this.totalPages) this.page++;
                },

                // page number list (compact for many pages)
                get pageList() {
                    const pages = [];
                    const total = this.totalPages;
                    const cur = this.page;
                    const push = (n) => {
                        if (!pages.includes(n) && n >= 1 && n <= total) pages.push(n);
                    };

                    // Always include first, last, current, and neighbors
                    push(1);
                    push(2);
                    push(cur - 2);
                    push(cur - 1);
                    push(cur);
                    push(cur + 1);
                    push(cur + 2);
                    push(total - 1);
                    push(total);

                    // Sort & unique
                    pages.sort((a, b) => a - b);

                    // Insert ellipses markers as 0
                    const out = [];
                    for (let i = 0; i < pages.length; i++) {
                        out.push(pages[i]);
                        if (i < pages.length - 1 && pages[i + 1] > pages[i] + 1) out.push(0);
                    }
                    return out;
                }
            }
        }
    </script>
</head>

<body
    class="overflow-x-hidden bg-[linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),url('images/loginPicture2.png')] bg-cover bg-center bg-no-repeat [min-height:100dvh]"
    x-data="app()" x-init="// reset page when sport changes or pageSize changes
    $watch('sport', () => { page = 1 });
    $watch('pageSize', () => { page = 1 });">
    <!-- NAV -->
    <nav
        class="inset-x-0 z-50 border-b border-amber-400/20 bg-black/60 backdrop-blur-xl shadow-[0_8px_30px_rgba(251,191,36,.08)]">
        <div class="mx-auto max-w-7xl flex items-center justify-between px-4 py-3">
            <a href="/" class="flex items-center gap-2 group">
                <span
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-black font-extrabold text-lg shadow-[0_0_25px_rgba(251,191,36,.35)] ring-1 ring-amber-400/30">B</span>
                <span class="tracking-wide text-slate-100 group-hover:text-amber-300 transition">BK2025</span>
            </a>

            <div class="flex items-center gap-4">
                <a href="/" class="text-sm font-semibold hover:text-amber-300 transition">
                    <i class="fa-solid fa-house text-amber-300 mr-1"></i> <span class="text-white">Home</span>
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition border border-white/10 text-sm font-medium">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-400 text-black text-xs font-extrabold ring-1 ring-amber-300/40">
                            {{ strtoupper(substr($user?->username ?? 'U', 0, 1)) }}
                        </span>
                        <span class="text-white">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-white text-[10px]"></i>
                    </button>

                    <div x-show="open" x-transition x-cloak
                        class="absolute right-0 mt-2 w-56 rounded-xl border border-white/10 bg-black/85 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,.5)] overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-white/10">
                            <p class="text-sm font-semibold text-amber-300">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ $user?->email ?? 'player@example.com' }}</p>
                        </div>
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-slate-200 hover:bg-white/5">
                            <i class="fa-regular fa-user mr-2 text-amber-300"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-rose-300 hover:bg-white/5">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- BG GRADIENT SHEET -->
    <div class="overflow-x-hidden bg-gradient-to-b from-slate-950/70 via-slate-800/70 to-slate-700/30 min-h-full">
        <div class="w-full 2xl:max-w-screen-2xl 2xl:mx-auto 2xl:flex 2xl:gap-4">
            <!-- MAIN -->
            <main class="flex-1">
                <!-- SPORT CARDS -->
                <div class="flex justify-center space-x-4 my-2 lg:mt-4 lg:-ml-18 lg:scale-80">
                    <!-- Billiards -->
                    <div class="rounded-xl" :class="sport === 'billiards' ? 'neon neon-slate' : ''">
                        <button
                            class="relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-50 2xl:w-105"
                            @click="sport='billiards'" :aria-pressed="sport === 'billiards'">
                            <img src="images/billiardscard.png" alt="Billiards"
                                class="block w-full h-full object-contain" />
                        </button>
                    </div>

                    <!-- Motor -->
                    <div class="rounded-xl" :class="sport === 'motor' ? 'neon neon-blue' : ''">
                        <button
                            class="relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-50 2xl:w-105"
                            @click="sport='motor'" :aria-pressed="sport === 'motor'">
                            <img src="images/motorcard.png" alt="Motor"
                                class="block w-full h-full object-contain -translate-y-2 2xl:-translate-y-5" />
                        </button>
                    </div>

                    <!-- Horse -->
                    <div class="rounded-xl" :class="sport === 'horse' ? 'neon neon-amber' : ''">
                        <button
                            class="relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-50 2xl:w-105"
                            @click="sport='horse'" :aria-pressed="sport === 'horse'">
                            <img src="images/horsecard.png" alt="Horse"
                                class="block w-full h-full object-contain -translate-y-2 2xl:-translate-y-8" />
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <h1 class="font-bold text-xs text-white lg:text-4xl ml-4  my-2 xl:ml-14">Available Games:</h1>
                    <h1 class="font-semibold text-xs ml-2 text-white lg:text-3xl" x-text="rows().length + ' Games'">
                    </h1>
                </div>

                <!-- TABLE CARD -->
                <div class="flex mx-4 xl:-ml-3 xl:py-2 xl:mb-20">
                    <div
                        class="w-full max-w-[1200px] rounded-lg overflow-hidden border border-slate-900/40 lg:scale-90
           bg-[linear-gradient(180deg,rgba(2,6,23,.75),rgba(15,23,42,.7))] backdrop-blur-md
           shadow-[inset_0_1px_0_rgba(255,255,255,.05),inset_0_-1px_0_rgba(0,0,0,.35),0_8px_28px_rgba(0,0,0,.45),0_0_0_1px_rgba(51,65,85,.8)]">

                        <!-- MOBILE SCROLL WRAPPER -->
                        <div class="relative overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0
             [scrollbar-width:thin] [scrollbar-color:#10b98166_transparent]"
                            style="-webkit-overflow-scrolling:touch">
                            <table
                                class="min-w-[840px] md:min-w-0 w-full md:table-fixed border-separate border-spacing-0 text-center">
                                <!-- Column widths (apply only from md up) -->
                                <colgroup class="hidden md:table-column-group">
                                    <col class="w-[22%]" />
                                    <col class="w-[11%]" />
                                    <col class="w-[23%]" />
                                    <col class="w-[12%]" />
                                    <col class="w-[12%]" />
                                    <col class="w-[160px] 2xl:w-[180px]" />
                                </colgroup>

                                <!-- HEAD -->
                                <thead class="text-white sticky top-0 z-10">
                                    <tr
                                        class="bg-gradient-to-b from-slate-900 to-slate-700 relative text-[9px] md:text-[11px] 2xl:text-[17px] font-semibold">
                                        <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20">
                                            Event</th>
                                        <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20">
                                            Venue</th>
                                        <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20">
                                            Participants</th>
                                        <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20">
                                            Status</th>
                                        <th class="px-2 py-1 font-bold tracking-[.02em] border-r border-slate-500/20">
                                            Odds</th>
                                        <th class="px-2 py-1 font-bold tracking-[.02em]">Actions</th>
                                    </tr>
                                </thead>

                                <!-- BODY (paged) -->
                                <tbody class="text-[10px] md:text-[12px] 2xl:text-[16px]">
                                    <template x-for="row in pagedRows()" :key="row.event + row.venue">
                                        <tr
                                            class="transition bg-slate-950/70 even:bg-slate-900/70 hover:bg-slate-800/60">
                                            <td class="px-2 py-3 text-white border-t border-slate-500/20 border-r">
                                                <span class="font-bold" x-text="row.event"></span>
                                            </td>
                                            <td class="px-2 py-3 text-white border-t border-slate-500/20 border-r"
                                                x-text="row.venue"></td>
                                            <td class="px-2 py-3 text-white border-t border-slate-500/20 border-r"
                                                x-text="row.participants"></td>

                                            <!-- Status chip (NO WRAP) -->
                                            <td
                                                class="px-2 py-3 text-white border-t border-slate-500/20 border-r whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full px-2 py-1 border text-[.92em] leading-none
                         text-white border-blue-500/60 whitespace-nowrap
                         bg-gradient-to-b from-[#0b2545] to-[#071a35]
                         shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                                                    <i
                                                        class="fa-solid fa-bolt shrink-0 opacity-80 text-[.95em] text-yellow-300"></i>
                                                    <span x-text="row.status" class="md:text-[1em]"></span>
                                                </span>
                                            </td>

                                            <!-- Odds chip (NO WRAP, TABULAR NUMS) -->
                                            <td
                                                class="px-2 py-3 text-white border-t border-slate-500/20 border-r whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full px-2 py-1 border text-[.92em] leading-none
                         text-white border-blue-500/60 whitespace-nowrap tabular-nums
                         bg-gradient-to-b from-[#0b2545] to-[#071a35]
                         shadow-[0_0_12px_rgba(59,130,246,.18),inset_0_1px_0_rgba(255,255,255,.06)]">
                                                    <i
                                                        class="fa-solid fa-coins shrink-0 opacity-80 text-[.95em] text-yellow-300"></i>
                                                    <span x-text="fmtOdds(row.odds)"></span>
                                                </span>
                                            </td>

                                            <!-- Action -->
                                            <td
                                                class="px-2 py-3 text-white border-t border-slate-500/20 whitespace-nowrap">
                                                <a :href="row.href || '#'"
                                                    class="inline-block rounded-full font-bold
                          bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900
                          border border-yellow-500/70 px-3 py-1 text-[.92em]
                          shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset]
                          hover:brightness-105 active:brightness-95 transition">
                                                    View Match
                                                </a>
                                            </td>
                                        </tr>
                                    </template>

                                    <!-- Empty state -->
                                    <tr x-show="totalItems === 0">
                                        <td colspan="6" class="px-3 py-6 text-slate-300">No matches found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION BAR: left stats, right controls -->
                        <div class="border-t border-slate-700/40 p-2 bg-slate-950/60">
                            <div class="flex items-center justify-between gap-2">

                                <!-- LEFT: rows per page + range (fixed, no scroll) -->
                                <div class="flex items-center gap-2 text-[11px] md:text-sm text-slate-200 shrink-0">
                                    <span class="shrink-0">Rows per page:</span>
                                    <select x-model.number="pageSize"
                                        class="h-7 rounded-md bg-slate-900/70 border border-slate-600/50 px-2 text-[11px] md:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/40 shrink-0">
                                        <template x-for="opt in pageSizeOptions" :key="opt">
                                            <option :value="opt" x-text="opt"></option>
                                        </template>
                                    </select>
                                    <span class="text-[11px] md:text-sm text-slate-300/80 shrink-0"
                                        x-text="`${showingFrom()}–${showingTo()} of ${totalItems}`"></span>
                                </div>

                                <!-- RIGHT: controls (single row; horizontally scrollable on tight screens) -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-end">
                                        <div
                                            class="inline-flex items-center gap-1 whitespace-nowrap overflow-x-auto no-scrollbar max-w-full">

                                            <!-- First -->
                                            <button @click="goto(1)" :disabled="page === 1"
                                                class="shrink-0 px-2 py-1 text-[11px] md:text-sm rounded-md border border-slate-600/50 bg-slate-900/70 text-slate-200 disabled:opacity-40 hover:bg-slate-800/60">
                                                <span aria-hidden="true">«</span><span
                                                    class="hidden md:inline ml-1">First</span>
                                            </button>

                                            <!-- Prev -->
                                            <button @click="prev()" :disabled="page === 1"
                                                class="shrink-0 px-2 py-1 text-[11px] md:text-sm rounded-md border border-slate-600/50 bg-slate-900/70 text-slate-200 disabled:opacity-40 hover:bg-slate-800/60">
                                                <span aria-hidden="true">‹</span><span
                                                    class="hidden md:inline ml-1">Prev</span>
                                            </button>

                                            <!-- Page numbers -->
                                            <template x-for="p in pageList" :key="p + '-' + sport">
                                                <div class="shrink-0">
                                                    <span x-show="p === 0" class="px-1 text-slate-400">…</span>
                                                    <button x-show="p !== 0" @click="goto(p)"
                                                        :aria-current="page === p ? 'page' : null"
                                                        class="px-2 py-1 text-[11px] md:text-sm rounded-md border transition shrink-0"
                                                        :class="page === p ?
                                                            'bg-amber-500/90 text-slate-900 border-amber-400' :
                                                            'bg-slate-900/70 text-slate-200 border-slate-600/50 hover:bg-slate-800/60'">
                                                        <span x-text="p"></span>
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Next -->
                                            <button @click="next()" :disabled="page === totalPages"
                                                class="shrink-0 px-2 py-1 text-[11px] md:text-sm rounded-md border border-slate-600/50 bg-slate-900/70 text-slate-200 disabled:opacity-40 hover:bg-slate-800/60">
                                                <span class="hidden md:inline mr-1">Next</span><span
                                                    aria-hidden="true">›</span>
                                            </button>

                                            <!-- Last -->
                                            <button @click="goto(totalPages)" :disabled="page === totalPages"
                                                class="shrink-0 px-2 py-1 text-[11px] md:text-sm rounded-md border border-slate-600/50 bg-slate-900/70 text-slate-200 disabled:opacity-40 hover:bg-slate-800/60">
                                                <span class="hidden md:inline mr-1">Last</span><span
                                                    aria-hidden="true">»</span>
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </main>

            <!-- BETS BLOCK / RIGHT SIDEBAR (visible on all screens; compact on phones) -->
            @auth
                <aside class="w-80 xl:scale-90 xl:-ml-30 2xl:w-[26rem] shrink-0 2xl:sticky 2xl:top-4 mx-auto mt-4 mb-14">
                    <div
                        class="rounded-2xl border border-slate-800/50 bg-gradient-to-b from-slate-950/90 to-slate-900/70 backdrop-blur-md shadow-2xl overflow-hidden">
                        <!-- Header -->
                        <div class="relative px-3 py-3 sm:px-4 sm:py-4">
                            <div class="absolute inset-0 pointer-events-none"
                                style=" background: radial-gradient( 60% 80% at 50% 0%, rgba(16, 185, 129, 0.15), transparent 60% ); ">
                            </div>
                            <div class="relative flex items-center justify-between gap-2">
                                <h2 class="text-slate-100 font-black tracking-wide text-sm sm:text-base"> Bets </h2>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    <button
                                        class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-100/90 border border-slate-500/30 hover:bg-slate-800/40 transition">Clear</button>
                                    <button
                                        class="px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold text-slate-950 bg-slate-400/90 hover:bg-slate-400 transition border border-slate-300/60">Export</button>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-2 sm:gap-3">
                                <div
                                    class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2">
                                    <i
                                        class="fa-solid fa-coins text-yellow-300 text-slate-300/90 text-sm sm:text-base"></i>
                                    <div>
                                        <p class="text-[10px] sm:text-xs text-slate-300/80"> Total Staked </p>
                                        <p class="font-bold text-slate-100 text-sm sm:text-base"> ₱ 12,500 </p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-2 rounded-xl bg-slate-900/60 border border-slate-700/50 px-2.5 py-2">
                                    <i class="fa-solid fa-gem text-teal-300/90 text-sm sm:text-base"></i>
                                    <div>
                                        <p class="text-[10px] text-slate-300/80"> Potential Payout </p>
                                        <p class="font-bold text-slate-100 text-sm sm:text-base"> ₱ 21,750 </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-3 sm:px-4">
                            <div
                                class="text-[10px] sm:text-[11px] text-slate-300/80 font-semibold grid grid-cols-12 border-t border-slate-800/60">
                                <div class="col-span-5 py-2">Match</div>
                                <div class="col-span-3 py-2 text-center">Bet</div>
                                <div class="col-span-2 py-2 text-center">Odds</div>
                                <div class="col-span-2 py-2 text-right pr-1.5">Result</div>
                            </div>
                        </div>
                        <div
                            class="max-h-64 sm:max-h-80 2xl:max-h-[520px] overflow-y-auto [scrollbar-width:thin] [scrollbar-color:#10b98133_transparent]">
                            <ul class="divide-y divide-slate-800/50">
                                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                                    <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                                        <div class="col-span-5">
                                            <p class="text-slate-100 font-semibold leading-tight"> #1232131 </p>
                                            <p class="text-[10px] sm:text-[11px] text-slate-300/70"> Strickland vs. Reyes
                                            </p>
                                        </div>
                                        <div class="col-span-3 flex justify-center">
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-slate-100">
                                                <i
                                                    class="fa-solid fa-coins text-yellow-300 text-slate-300 text-xs sm:text-sm"></i>
                                                ₱500
                                            </span>
                                        </div>
                                        <div class="col-span-2 text-center"> <span
                                                class="text-slate-200 font-semibold">1.90</span> </div>
                                        <div class="col-span-2 text-right">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-amber-200 bg-amber-600/20 border border-amber-400/30">
                                                <i class="fa-regular fa-clock text-[11px]"></i> Pending
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                                    <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                                        <div class="col-span-5">
                                            <p class="text-slate-100 font-semibold leading-tight"> #1232132 </p>
                                            <p class="text-[10px] sm:text-[11px] text-slate-300/70"> Orcullo vs. Ko </p>
                                        </div>
                                        <div class="col-span-3 flex justify-center">
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-800/30 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-cyan-100">
                                                <i class="fa-solid fa-gem text-xs sm:text-sm"></i> ₱1,000
                                            </span>
                                        </div>
                                        <div class="col-span-2 text-center"> <span
                                                class="text-slate-200 font-semibold">2.05</span> </div>
                                        <div class="col-span-2 text-right">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-slate-200 bg-slate-600/20 border border-slate-400/30">
                                                <i class="fa-solid fa-circle-check text-[11px]"></i> Win
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="px-3 sm:px-4 py-2.5 hover:bg-slate-900/40 transition">
                                    <div class="grid grid-cols-12 items-center gap-2 text-xs sm:text-sm">
                                        <div class="col-span-5">
                                            <p class="text-slate-100 font-semibold leading-tight"> #1232133 </p>
                                            <p class="text-[10px] sm:text-[11px] text-slate-300/70"> Filler vs. Ouschan
                                            </p>
                                        </div>
                                        <div class="col-span-3 flex justify-center">
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-slate-500/30 bg-slate-800/40 px-2 py-0.5 sm:px-2.5 sm:py-1 text-[11px] sm:text-[12px] font-semibold text-slate-100">
                                                <i
                                                    class="fa-solid fa-coins text-yellow-300 text-slate-300 text-xs sm:text-sm"></i>
                                                ₱750
                                            </span>
                                        </div>
                                        <div class="col-span-2 text-center"> <span
                                                class="text-slate-200 font-semibold">1.75</span> </div>
                                        <div class="col-span-2 text-right">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-bold text-rose-200 bg-rose-600/20 border border-rose-400/30">
                                                <i class="fa-solid fa-circle-xmark text-[11px]"></i> Lost
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="px-3 sm:px-5 py-2.5 sm:py-3 border-t border-slate-800/60 bg-slate-950/60">
                            <div class="flex items-center justify-between text-[11px] sm:text-[12px]">
                                <div class="text-slate-300/80">
                                    <span class="mr-2">Open Bets:</span> <span class="font-bold text-slate-100">3</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-slate-300/80"> Won: <span class="font-bold text-slate-100">2</span>
                                    </div>
                                    <div class="text-slate-300/80"> Lost: <span class="font-bold text-slate-100">1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            @endauth

        </div>
    </div>

    <footer class="fixed inset-x-0 bottom-0 z-40">
        <div class="border-t border-white/10 bg-black/60 backdrop-blur-xl">
            <div class="flex justify-center items-center py-2">
                <p class="text-[10px] md:text-[12px] text-amber-200/90 text-center">
                    ©2024-2025 BK2025 PLUS ALL RIGHT RESERVED
                </p>
            </div>
        </div>
    </footer>

    <script>
        AOS.init({
            once: true
        });
    </script>
</body>

</html>
