<x-player-layout :user="auth()->user()">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet">
        <style>
            .font-display { font-family: 'Orbitron', sans-serif; }
            .font-body { font-family: 'Rubik', sans-serif; }
        </style>
    @endpush

    <div class="font-body space-y-8">
        <div class="text-center">
            <h1 class="font-display text-2xl md:text-3xl text-emerald-400 tracking-wider uppercase drop-shadow-[0_0_10px_rgba(16,185,129,0.5)]">
                Lobbies
            </h1>
            <p class="text-slate-300 text-sm">Pick a lobby to enter and place your bets.</p>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-slate-200 mb-3">Top Lobbies</h2>

            @if(($topLobbies ?? collect())->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($topLobbies as $lobby)
                        <a href="{{ route('player.lobbies.show', $lobby) }}"
                            class="group relative block rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-950/80 border border-white/10 hover:border-emerald-500/50 overflow-hidden transition-all duration-300 hover:scale-[1.02] shadow-lg hover:shadow-emerald-600/20 backdrop-blur">
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.7),transparent_60%)]"></div>

                            <div class="p-5 space-y-2 relative z-10">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-display text-lg text-white tracking-wide">
                                        {{ $lobby->title ?? $lobby->name }}
                                    </h3>
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $lobby->is_active ? 'bg-green-500/20 text-green-300 border border-green-700/40' : 'bg-rose-500/20 text-rose-300 border border-rose-700/40' }}">
                                        {{ $lobby->is_active ? 'OPEN' : 'CLOSED' }}
                                    </span>
                                </div>

                                <p class="text-xs text-slate-300">
                                    @switch($lobby->game_type)
                                        @case(1) Marble Race @break
                                        @case(2) Billiards @break
                                        @case(3) Drag Race @break
                                        @default Game
                                    @endswitch
                                </p>
                            </div>

                            <div class="px-5 pb-4 relative z-10 text-sm text-slate-200">
                                <div class="flex justify-between">
                                    <span>ODDS</span>
                                    <span class="font-semibold text-emerald-400">1/{{ $lobby->participants_count ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Games</span>
                                    <span class="font-semibold text-emerald-400">{{ $lobby->games()->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Updated</span>
                                    <span class="text-slate-300">{{ $lobby->updated_at?->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="absolute bottom-0 inset-x-0 px-4 py-3 bg-slate-900/80 text-center text-xs font-semibold text-emerald-300 tracking-wider">
                                Enter Lobby →
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-white/10 bg-white/10 backdrop-blur p-6 text-center text-slate-200">
                    No featured lobbies yet.
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur overflow-hidden">
            <div class="px-4 py-3 border-b border-white/10 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-white">All Lobbies</h2>
            </div>

            <div class="">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-white/10 text-slate-200">
                            <th class="px-4 py-2 text-left font-semibold">Lobby</th>
                            <th class="px-4 py-2 text-left font-semibold">Type</th>
                            <th class="px-4 py-2 text-left font-semibold">Players</th>
                            <th class="px-4 py-2 text-left font-semibold">Games</th>
                            <th class="px-4 py-2 text-left font-semibold">Status</th>
                            <th class="px-4 py-2 text-left font-semibold">Updated</th>
                            <th class="px-4 py-2 text-right font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($lobbies as $lobby)
                            <tr class="text-slate-100">
                                <td class="px-4 py-2">
                                    <div class="font-medium">{{ $lobby->title ?? $lobby->name }}</div>
                                    <div class="text-xs text-slate-300">#{{ $lobby->id }}</div>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="text-slate-200">
                                        @switch($lobby->game_type)
                                            @case(1) Marble Race @break
                                            @case(2) Billiards @break
                                            @case(3) Drag Race @break
                                            @default Game
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $lobby->participants_count ?? 0 }}</td>
                                <td class="px-4 py-2">{{ $lobby->games()->count() }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $lobby->is_active ? 'bg-green-500/20 text-green-300 border border-green-700/40' : 'bg-rose-500/20 text-rose-300 border border-rose-700/40' }}">
                                        {{ $lobby->is_active ? 'OPEN' : 'CLOSED' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-slate-300">{{ $lobby->updated_at?->diffForHumans() }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('player.lobbies.show', $lobby) }}"
                                        class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 text-xs font-semibold">
                                        Enter <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-slate-200">
                                    No lobbies found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="px-4 py-3">
                    {{ $lobbies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-player-layout>
