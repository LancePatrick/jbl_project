<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events | BK2025</title>

    <!-- Tailwind v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          crossorigin="anonymous" />

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }

        .neon {
            position: relative;
            display: inline-block;
            border-radius: .75rem;
            filter: drop-shadow(0 0 6px var(--glow, #22c55e))
                    drop-shadow(0 0 16px var(--glow, #22c55e));
        }
        .neon::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 2px solid var(--glow);
            box-shadow:
                inset 0 0 10px var(--glow, #22c55e),
                0 0 10px var(--glow, #22c55e);
            animation: neonPulse 1.8s ease-in-out infinite;
            pointer-events: none;
        }
        .neon-blue  { --glow: #0090ff; }
        .neon-amber { --glow: #f59e0b; }

        .no-scrollbar::-webkit-scrollbar { display: none }
        .no-scrollbar { scrollbar-width: none }

        @keyframes neonPulse {
            0%, 100% { opacity: .85; filter: brightness(1) }
            50%       { opacity: 1;  filter: brightness(1.2) }
        }

        .no-drag {
            -webkit-user-drag: none;
            user-drag: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }

        .no-drag-btn { touch-action: manipulation; }
    </style>

    <script>
        function app() {
            const today = new Date();

            return {
                /* active sport for filter + neon cards */
                sport: 'billiards', // 'billiards' | 'motor' | 'horse'

                /* month navigation for calendar */
                monthOffset: 0, // 0 = current month, +1 next month, etc.

                /* links papunta sa laro */
                playLinks: {
                    billiards: "{{ route('billiard') }}",
                    motor: "{{ route('drag.race') }}",
                    horse: "{{ route('horse') }}",
                },

                events: [
                    // BILLIARDS
                    {
                        id: 1,
                        date: '2025-11-22',
                        time: '14:00',
                        sport: 'billiards',
                        name: 'World Billiards Final',
                        tag: 'Major Final',
                        venue: 'Manila Arena',
                        status: 'Open for Bets'
                    },
                    {
                        id: 2,
                        date: '2025-11-24',
                        time: '19:30',
                        sport: 'billiards',
                        name: 'Legends 9-Ball Showdown',
                        tag: 'Exhibition',
                        venue: 'Quezon City Sports Club',
                        status: 'Coming Soon'
                    },
                    {
                        id: 3,
                        date: '2025-12-03',
                        time: '16:00',
                        sport: 'billiards',
                        name: 'Philippine Open Qualifiers',
                        tag: 'Qualifier',
                        venue: 'Cebu City',
                        status: 'Open for Bets'
                    },

                    // DRAG RACE / MOTOR
                    {
                        id: 4,
                        date: '2025-11-20',
                        time: '21:00',
                        sport: 'motor',
                        name: 'Midnight Drag Clash',
                        tag: 'Street',
                        venue: 'Cebu SRP',
                        status: 'Live Tonight'
                    },
                    {
                        id: 5,
                        date: '2025-11-27',
                        time: '18:30',
                        sport: 'motor',
                        name: 'Grand Prix – Heat 1',
                        tag: 'Championship',
                        venue: 'Clark International Speedway',
                        status: 'Open for Bets'
                    },
                    {
                        id: 6,
                        date: '2025-12-08',
                        time: '20:00',
                        sport: 'motor',
                        name: 'City Lights Sprint',
                        tag: 'Night Race',
                        venue: 'Subic Track',
                        status: 'Coming Soon'
                    },

                    // HORSE RACING
                    {
                        id: 7,
                        date: '2025-11-23',
                        time: '15:00',
                        sport: 'horse',
                        name: 'San Lazaro Cup',
                        tag: 'Grade 1',
                        venue: 'San Lazaro Leisure Park',
                        status: 'Open for Bets'
                    },
                    {
                        id: 8,
                        date: '2025-11-30',
                        time: '17:30',
                        sport: 'horse',
                        name: 'Metro Derby Trial',
                        tag: 'Derby Trial',
                        venue: 'MetroTurf',
                        status: 'Coming Soon'
                    },
                    {
                        id: 9,
                        date: '2025-12-12',
                        time: '16:15',
                        sport: 'horse',
                        name: 'Holiday Sprint Stakes',
                        tag: 'Festival',
                        venue: 'Santa Ana Park',
                        status: 'Planned'
                    }
                ],

                /* --- COMPUTED HELPERS --- */
                get currentMonthDate() {
                    const d = new Date(today);
                    d.setMonth(d.getMonth() + this.monthOffset);
                    d.setDate(1);
                    return d;
                },
                get monthLabel() {
                    return this.currentMonthDate.toLocaleDateString('en-PH', {
                        month: 'long',
                        year: 'numeric'
                    });
                },
                get calendarDays() {
                    const base = this.currentMonthDate;
                    const year = base.getFullYear();
                    const month = base.getMonth(); // 0-11
                    const firstDay = new Date(year, month, 1).getDay(); // 0=Sun
                    const daysInMonth = new Date(year, month + 1, 0).getDate();

                    const cells = [];

                    // empty cells before day 1
                    for (let i = 0; i < firstDay; i++) {
                        cells.push(null);
                    }

                    for (let day = 1; day <= daysInMonth; day++) {
                        const dateStr = [
                            year,
                            String(month + 1).padStart(2, '0'),
                            String(day).padStart(2, '0')
                        ].join('-');

                        const hasEvents = this.events.some(e =>
                            e.sport === this.sport && e.date === dateStr
                        );

                        const isToday =
                            year === today.getFullYear() &&
                            month === today.getMonth() &&
                            day === today.getDate();

                        cells.push({
                            day,
                            dateStr,
                            hasEvents,
                            isToday
                        });
                    }

                    return cells;
                },

                get filteredEvents() {
                    const base = this.currentMonthDate;
                    const year = base.getFullYear();
                    const month = base.getMonth();

                    return this.events
                        .filter(e => {
                            const d = new Date(e.date);
                            return (
                                e.sport === this.sport &&
                                d.getFullYear() === year &&
                                d.getMonth() === month
                            );
                        })
                        .sort((a, b) => new Date(a.date) - new Date(b.date));
                },

                /* play button helpers */
                get playHref() {
                    return this.playLinks[this.sport] ?? '#';
                },
                get playLabel() {
                    return 'Play ' + this.sportLabel(this.sport);
                },

                /* --- UI HELPERS --- */
                changeMonth(delta) {
                    this.monthOffset += delta;
                },
                sportLabel(code) {
                    if (code === 'billiards') return 'Billiards';
                    if (code === 'motor') return 'Drag Race';
                    if (code === 'horse') return 'Horse Racing';
                    return code;
                },
                sportPillClass(code) {
                    if (code === 'billiards') {
                        return 'bg-emerald-500/15 border-emerald-400/70 text-emerald-200';
                    }
                    if (code === 'motor') {
                        return 'bg-indigo-500/15 border-indigo-400/70 text-indigo-200';
                    }
                    if (code === 'horse') {
                        return 'bg-amber-500/15 border-amber-400/70 text-amber-200';
                    }
                    return 'bg-slate-600/20 border-slate-400/60 text-slate-200';
                },
                statusPillClass(status) {
                    if (status.includes('Live')) {
                        return 'bg-rose-500/20 border-rose-400/70 text-rose-200';
                    }
                    if (status.includes('Open')) {
                        return 'bg-emerald-500/20 border-emerald-400/70 text-emerald-200';
                    }
                    if (status.includes('Soon')) {
                        return 'bg-sky-500/20 border-sky-400/70 text-sky-200';
                    }
                    return 'bg-slate-600/30 border-slate-400/70 text-slate-200';
                },
                formatDate(dateStr) {
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('en-PH', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                },
                formatTime(timeStr) {
                    if (!timeStr) return '';
                    const [h, m] = timeStr.split(':').map(Number);
                    const d = new Date();
                    d.setHours(h);
                    d.setMinutes(m || 0);
                    return d.toLocaleTimeString('en-PH', {
                        hour: 'numeric',
                        minute: '2-digit'
                    });
                }
            };
        }
    </script>
</head>

<body
    class="overflow-x-hidden bg-[linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),url('{{ asset('images/loginPicture2.png') }}')] bg-cover bg-center bg-no-repeat [min-height:100dvh]"
    x-data="app()">

    @php
        $user = Auth::user();
    @endphp

    <!-- NAV -->
    <nav
        class="inset-x-0 z-50 border-b border-amber-400/20 bg-black/60 backdrop-blur-xl shadow-[0_8px_30px_rgba(251,191,36,.08)]">
        <div class="mx-auto max-w-7xl flex items-center justify-between px-4 py-3">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                <span
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-black font-extrabold text-lg shadow-[0_0_25px_rgba(251,191,36,.35)] ring-1 ring-amber-400/30">
                    B
                </span>
                <span class="tracking-wide text-slate-100 group-hover:text-amber-300 transition">
                    BK2025
                </span>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold hover:text-amber-300 transition">
                    <i class="fa-solid fa-house text-amber-300 mr-1"></i>
                    <span class="text-white">Home</span>
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition border border-white/10 text-sm font-medium">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-400 text-black text-xs font-extrabold ring-1 ring-amber-300/40">
                            {{ strtoupper(substr($user?->username ?? $user?->name ?? 'U', 0, 1)) }}
                        </span>
                        <span class="text-white">{{ $user?->name ?? 'Player' }}</span>
                        <i class="fa-solid fa-chevron-down text-white text-[10px]"></i>
                    </button>

                    <div x-show="open" x-transition x-cloak
                        class="absolute right-0 mt-2 w-56 rounded-xl border border-white/10 bg-black/85 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,.5)] overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-white/10">
                            <p class="text-sm font-semibold text-amber-300">
                                {{ $user?->name ?? 'Player' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $user?->email ?? 'player@example.com' }}
                            </p>
                        </div>
                        <a href="{{ url('/profile') }}"
                           class="block px-4 py-2 text-sm text-slate-200 hover:bg-white/5">
                            <i class="fa-regular fa-user mr-2 text-amber-300"></i>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-rose-300 hover:bg-white/5">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>
                                Sign out
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
            <main class="flex-1 pb-16">
                <!-- SPORT CARDS (filters) -->
                <div class="flex justify-center space-x-4 my-3 lg:mt-4 lg:-ml-18 lg:scale-80">
                    <!-- Billiards -->
                    <div class="rounded-xl" :class="sport === 'billiards' ? 'neon neon-blue' : ''">
                        <button
                            class="no-drag-btn relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-50 2xl:w-105"
                            @click="sport='billiards'" :aria-pressed="sport === 'billiards'">
                            <img src="{{ asset('images/billi.gif') }}" alt="Billiards"
                                 class="no-drag block w-full h-full object-contain -translate-y-2 2xl:-translate-y-5"
                                 draggable="false" ondragstart="return false;">
                        </button>
                    </div>

                    <!-- Motor -->
                    <div class="rounded-xl" :class="sport === 'motor' ? 'neon neon-blue' : ''">
                        <button
                            class="no-drag-btn relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-50 2xl:w-105"
                            @click="sport='motor'" :aria-pressed="sport === 'motor'">
                            <img src="{{ asset('images/racegif.gif') }}" alt="Drag Race"
                                 class="no-drag block w-full h-full object-contain -translate-y-2 2xl:-translate-y-5"
                                 draggable="false" ondragstart="return false;">
                        </button>
                    </div>

                    <!-- Horse -->
                    <div class="rounded-xl" :class="sport === 'horse' ? 'neon neon-amber' : ''">
                        <button
                            class="no-drag-btn relative grid place-items-center rounded-xl overflow-hidden h-12 w-26 bg-slate-400 transition leading-none 2xl:h-50 2xl:w-105"
                            @click="sport='horse'" :aria-pressed="sport === 'horse'">
                            <img src="{{ asset('images/hogif.gif') }}" alt="Horse Racing"
                                 class="no-drag block w-full h-full object-contain -translate-y-2 2xl:-translate-y-8"
                                 draggable="false" ondragstart="return false;">
                        </button>
                    </div>
                </div>

                <!-- HEADER: title + play button + new event -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between px-4 xl:px-16 mt-1 mb-3 gap-3">
                    <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-4">
                        <div>
                            <p class="text-[11px] text-amber-300 uppercase tracking-[0.22em] mb-1">
                                Events Overview
                            </p>
                            <h1 class="font-bold text-lg text-white sm:text-2xl lg:text-3xl">
                                <span x-text="sportLabel(sport)"></span> Events Calendar
                            </h1>
                        </div>

                        <!-- PLAY BUTTON – may href per sport, design gaya ng New Event -->
                        <a :href="playHref"
                           class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-4 py-1.5 text-[11px] sm:text-xs font-semibold text-slate-950 shadow-[0_8px_22px_rgba(251,191,36,.35)] hover:brightness-110 active:brightness-95 transition">
                            <i class="fa-solid fa-play text-xs"></i>
                            <span class="tracking-[0.18em]" x-text="playLabel.toUpperCase()"></span>
                        </a>
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            class="hidden sm:inline-flex items-center gap-2 rounded-full border border-slate-600/60 bg-slate-900/70 px-3 py-1.5 text-[11px] sm:text-xs text-slate-200 hover:bg-slate-800/70 transition">
                            <i class="fa-regular fa-calendar-check text-emerald-300"></i>
                            This Month:
                            <span class="font-semibold" x-text="monthLabel"></span>
                        </button>
                        <button
                            class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-4 py-1.5 text-[11px] sm:text-xs font-semibold text-slate-950 shadow-[0_8px_22px_rgba(251,191,36,.35)] hover:brightness-105 active:brightness-95 transition">
                            <i class="fa-solid fa-plus text-xs"></i>
                            New Event
                        </button>
                    </div>
                </div>

                <!-- MAIN GRID: CALENDAR + LIST -->
                <div class="px-4 xl:px-10 xl:mb-20">
                    <div class="grid gap-4 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1.5fr)]">
                        <!-- CALENDAR CARD -->
                        <section
                            class="rounded-2xl border border-slate-900/60 bg-[linear-gradient(180deg,rgba(15,23,42,.95),rgba(15,23,42,.85))] backdrop-blur-md shadow-[0_18px_45px_rgba(0,0,0,.55)] overflow-hidden">
                            <header
                                class="flex items-center justify-between px-4 py-3 border-b border-slate-700/60 bg-slate-950/70">
                                <div>
                                    <p class="text-[11px] text-slate-400">
                                        Calendar View
                                    </p>
                                    <p class="text-sm sm:text-base font-semibold text-slate-100"
                                       x-text="monthLabel"></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="changeMonth(-1)"
                                        class="w-7 h-7 flex items-center justify-center rounded-full border border-slate-600/70 bg-slate-900/80 text-slate-200 text-xs hover:bg-slate-800/80">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </button>
                                    <button @click="monthOffset = 0"
                                        class="hidden sm:inline-flex items-center rounded-full border border-emerald-400/60 bg-emerald-500/10 px-2.5 py-1 text-[11px] text-emerald-200 hover:bg-emerald-500/20">
                                        Today
                                    </button>
                                    <button @click="changeMonth(1)"
                                        class="w-7 h-7 flex items-center justify-center rounded-full border border-slate-600/70 bg-slate-900/80 text-slate-200 text-xs hover:bg-slate-800/80">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </header>

                            <div class="px-3 sm:px-4 pb-4 pt-2">
                                <!-- Weekday header -->
                                <div class="grid grid-cols-7 text-[10px] sm:text-[11px] font-semibold text-slate-400 mb-1">
                                    <span class="text-center">Sun</span>
                                    <span class="text-center">Mon</span>
                                    <span class="text-center">Tue</span>
                                    <span class="text-center">Wed</span>
                                    <span class="text-center">Thu</span>
                                    <span class="text-center">Fri</span>
                                    <span class="text-center">Sat</span>
                                </div>

                                <!-- Calendar grid -->
                                <div class="grid grid-cols-7 gap-1.5 text-[11px] sm:text-xs">
                                    <template x-for="(cell, idx) in calendarDays" :key="idx">
                                        <div class="aspect-square">
                                            <template x-if="cell === null">
                                                <div class="h-full rounded-xl bg-slate-900/40 border border-slate-800/50"></div>
                                            </template>

                                            <template x-if="cell !== null">
                                                <button
                                                    class="h-full w-full rounded-xl border flex flex-col items-center justify-center gap-1
                                                           transition text-[11px] sm:text-xs"
                                                    :class="[
                                                        cell.hasEvents
                                                            ? 'border-emerald-400/70 bg-emerald-500/10 shadow-[0_0_16px_rgba(16,185,129,.35)]'
                                                            : 'border-slate-700/70 bg-slate-900/70 hover:bg-slate-800/70',
                                                        cell.isToday ? 'ring-1 ring-amber-400/80' : ''
                                                    ]">
                                                    <span class="font-semibold text-slate-100" x-text="cell.day"></span>
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full"
                                                        :class="cell.hasEvents ? 'bg-emerald-400' : 'bg-slate-700'">
                                                    </span>
                                                </button>
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Legend -->
                                <div class="mt-3 flex items-center justify-between text-[10px] text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-block w-3 h-3 rounded-full bg-emerald-400"></span>
                                            <span>Has events</span>
                                        </div>
                                        <div class="hidden sm:flex items-center gap-1.5">
                                            <span class="inline-block w-3 h-3 rounded-full border border-amber-400"></span>
                                            <span>Today</span>
                                        </div>
                                    </div>
                                    <div class="hidden sm:flex items-center gap-2 text-[10px] text-slate-400">
                                        <span class="font-semibold text-slate-200" x-text="filteredEvents.length"></span>
                                        <span>event(s) this month</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- UPCOMING EVENTS LIST -->
                        <section
                            class="rounded-2xl border border-slate-900/60 bg-[linear-gradient(180deg,rgba(15,23,42,.98),rgba(15,23,42,.9))] backdrop-blur-md shadow-[0_18px_45px_rgba(0,0,0,.65)] overflow-hidden">
                            <header
                                class="flex items-center justify-between px-4 py-3 border-b border-slate-700/60 bg-slate-950/80">
                                <div>
                                    <p class="text-[11px] text-slate-400">
                                        Event Timeline
                                    </p>
                                    <p class="text-sm sm:text-base font-semibold text-slate-100">
                                        Upcoming <span x-text="sportLabel(sport)"></span> Events
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 text-[10px] sm:text-[11px] text-slate-300/80">
                                    <span class="hidden sm:inline">Total:</span>
                                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-600/70 bg-slate-900/80 px-2 py-0.5">
                                        <i class="fa-regular fa-calendar text-emerald-300 text-[11px]"></i>
                                        <span x-text="filteredEvents.length + ' event(s)'"></span>
                                    </span>
                                </div>
                            </header>

                            <div class="max-h-[420px] overflow-y-auto [scrollbar-width:thin] [scrollbar-color:#10b98133_transparent] pr-2">
                                <template x-if="filteredEvents.length === 0">
                                    <div class="px-4 py-6 text-center text-sm text-slate-300">
                                        No scheduled events for this month.
                                    </div>
                                </template>

                                <ul class="divide-y divide-slate-800/60">
                                    <template x-for="event in filteredEvents" :key="event.id">
                                        <li class="px-4 py-3 sm:py-3.5 hover:bg-slate-900/60 transition">
                                            <div class="grid grid-cols-[auto,1fr,auto] gap-3 items-center">
                                                <!-- Date -->
                                                <div class="flex flex-col items-start sm:items-center w-[80px]">
                                                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.15em]"
                                                       x-text="formatDate(event.date).split(' ')[0]"></p>
                                                    <p class="text-sm sm:text-base font-semibold text-slate-100 leading-tight"
                                                       x-text="formatDate(event.date).split(' ').slice(1).join(' ')"></p>
                                                    <p class="text-[11px] text-emerald-300 mt-0.5"
                                                       x-text="formatTime(event.time)"></p>
                                                </div>

                                                <!-- Main info -->
                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                                        <span class="text-slate-100 font-semibold text-sm sm:text-base truncate"
                                                              x-text="event.name"></span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-[2px] rounded-full border text-[10px] font-semibold"
                                                            :class="sportPillClass(event.sport)">
                                                            <i class="fa-solid fa-table-tennis-paddle-ball mr-1 text-[9px]"
                                                               x-show="event.sport === 'billiards'"></i>
                                                            <i class="fa-solid fa-car-side mr-1 text-[9px]"
                                                               x-show="event.sport === 'motor'"></i>
                                                            <i class="fa-solid fa-horse-head mr-1 text-[9px]"
                                                               x-show="event.sport === 'horse'"></i>
                                                            <span x-text="sportLabel(event.sport)"></span>
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-[2px] rounded-full border text-[10px] text-amber-200 border-amber-400/70 bg-amber-500/15"
                                                            x-text="event.tag">
                                                        </span>
                                                    </div>
                                                    <p class="text-[11px] sm:text-xs text-slate-300 flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-[11px] text-slate-400"></i>
                                                        <span x-text="event.venue"></span>
                                                    </p>
                                                </div>

                                                <!-- Status + CTA -->
                                                <div class="flex flex-col items-end gap-1">
                                                    <span
                                                        class="inline-flex items-center gap-1 rounded-full border px-2 py-[3px] text-[10px] font-semibold"
                                                        :class="statusPillClass(event.status)">
                                                        <i class="fa-solid fa-circle text-[8px]"></i>
                                                        <span x-text="event.status"></span>
                                                    </span>
                                                    <button
                                                        class="mt-1 inline-flex items-center gap-1 rounded-full bg-gradient-to-b from-yellow-300 to-yellow-600 text-slate-900 border border-yellow-500/70 px-3 py-1 text-[11px] font-semibold shadow-[0_2px_10px_rgba(234,179,8,.25),0_0_0_1px_rgba(234,179,8,.35)_inset,0_-2px_0_rgba(0,0,0,.25)_inset] hover:brightness-105 active:brightness-95">
                                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                                        View Event
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
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
        AOS.init({ once: true });
    </script>
</body>

</html>
