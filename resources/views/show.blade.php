<x-player-layout :user="auth()->user()">
    @php
        $statusColors = [
            0 => 'bg-amber-500',
            1 => 'bg-blue-600',
            2 => 'bg-emerald-600',
            3 => 'bg-rose-600'
        ];

        $participants = collect($lobby->participants ?? [])->map(function($name, $key){
            $idx = (int) preg_replace('/\D/', '', (string) $key);
            return [
                'key'   => $key,
                'index' => $idx,
                'name'  => $name
            ];
        })->values();

        $current = $currentGame ?? null;
    @endphp

    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;600;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            .font-display{font-family:'Baloo 2',cursive}
            .font-sans{font-family:'Rubik',sans-serif}
            .embed-responsive iframe,
            .embed-responsive video,
            .embed-responsive object,
            .embed-responsive embed{
                width:100%;
                height:100%;
                display:block
            }
        </style>
    @endpush

    <div class="mb-6">
        <a href="{{ route('player.dashboard') }}" class="text-sm text-slate-300 hover:text-white">&larr; Back to Lobbies</a>
    </div>

    <div id="player-lobby"
        data-lobby-id="{{ (int)$lobby->id }}"
        data-game-id="{{ (int)($current?->id ?? 0) }}"
        data-status="{{ (int)($current?->status ?? 0) }}"
        data-winner="{{ $current?->winner ? (int)$current->winner : '' }}"
        data-wallet="{{ number_format((float)(auth()->user()->wallet?->amount ?? 0), 2, '.', '') }}"
        class="grid grid-cols-1 lg:grid-cols-2 gap-6 font-sans">

        {{-- LEFT: STREAM / STATUS --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 backdrop-blur-xl shadow-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-700/60">
                <h3 class="font-display text-base text-slate-100 tracking-tight">
                    {{ $lobby->video_title ?? ($lobby->title ?? 'LIVE EVENT') }}
                </h3>
                <p class="text-xs text-slate-400">
                    @switch($lobby->game_type)
                        @case(1) Marble Race @break
                        @case(2) Billiards @break
                        @case(3) Drag Race @break
                        @default Game
                    @endswitch
                </p>
            </div>

            <div class="p-2">
                <div class="overflow-hidden rounded-xl bg-slate-950/40">
                    @if($lobby->video_html)
                        <div class="embed-responsive w-full h-56 sm:h-64 md:h-72 lg:h-[420px] xl:h-[460px]">
                            {!! $lobby->video_html !!}
                        </div>
                    @else
                        <div class="flex items-center justify-center w-full h-56 sm:h-64 md:h-72 lg:h-[420px] xl:h-[460px] bg-slate-900/80">
                            <span class="text-slate-500">No video available</span>
                        </div>
                    @endif
                </div>

                <div class="mt-3 px-3 pb-3">
                    <div class="flex justify-between items-center text-xs text-slate-400 mb-2">
                        <span>
                            @if($current)
                                Game
                                <span id="label-game-number">
                                    {{ (int)($current?->game_number ?? 0) ?: 1 }}
                                </span>

                                <span
                                    id="badge-status"
                                    class="ml-2 inline-flex items-center rounded-full px-2 py-[2px] text-[10px] text-white {{ $statusColors[$current->status] ?? 'bg-slate-500' }}">
                                    {{ ['Pending','Ongoing','Finished','Cancelled'][$current->status] ?? 'Unknown' }}
                                </span>
                            @else
                                No Current Game
                            @endif
                        </span>

                        <span id="live-time" class="font-mono"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: BET PANEL --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 backdrop-blur-xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-slate-700/60 flex justify-between items-center">
                <h3 class="font-display text-base text-slate-100">BET PANEL</h3>

                <div class="flex items-center gap-2 text-sm font-medium text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l5.878 3.09-1.122-6.545L19 6.91l-6.561-.955L10 0 7.561 5.955 1 6.91l4.244 4.635L4.122 18.09z"/>
                    </svg>

                    <span id="label-wallet">
                        {{ number_format((float)(auth()->user()->wallet?->amount ?? 0), 2, '.', '') }}
                    </span>

                    <span id="label-potential"
                        class="hidden ml-2 text-xs bg-emerald-600/20 text-emerald-300 px-2 py-[2px] rounded">
                        Potential: ₱ <span id="value-potential">0.00</span>
                    </span>
                </div>
            </div>

            <div class="p-4 space-y-4">
                {{-- PARTICIPANTS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                        $colors = [
                            'bg-red-600/90','bg-blue-600/90','bg-violet-600/90','bg-emerald-600/90','bg-orange-600/90',
                            'bg-cyan-600/90','bg-pink-600/90','bg-amber-600/90','bg-lime-600/90','bg-sky-600/90'
                        ];
                    @endphp

                    @forelse($participants as $i => $p)
                        @php $color = $colors[$i % count($colors)]; @endphp

                        <div class="participant-card rounded-xl {{ $color }} p-3 text-center text-white"
                            data-pkey="{{ $p['key'] }}"
                            data-index="{{ $p['index'] }}"
                            data-name="{{ $p['name'] }}">

                            <div class="text-xs opacity-90">{{ $p['name'] }}</div>

                            <div class="text-2xl font-display font-bold">
                                ₱ <span class="total-amount" data-pkey="{{ $p['key'] }}">—</span>
                            </div>

                            <div class="text-[11px] mt-1 opacity-90">
                                <span class="ratio" data-pkey="{{ $p['key'] }}">× —</span>
                            </div>

                            <div class="text-[10px] opacity-80 mt-1">
                                <span class="your-pick hidden inline-flex items-center gap-1">
                                    <i class="fa-solid fa-ticket"></i> Your pick
                                </span>
                            </div>

                            <div class="mt-2">
                                <button
                                    type="button"
                                    class="btn-bet w-full rounded-lg bg-white/10 hover:bg-white/20 text-sm font-medium py-1.5 disabled:opacity-50 disabled:cursor-not-allowed">
                                    BET
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-slate-400">No participants configured.</div>
                    @endforelse
                </div>

                {{-- AMOUNT --}}
                <div class="pt-2">
                    <div class="text-xs text-slate-400 mb-1">BET AMOUNT</div>

                    <div class="flex items-center gap-2">
                        <div class="flex-1 rounded-lg bg-slate-800/80 px-3 py-2 text-sm text-slate-200 flex justify-between items-center">
                            <input
                                id="amount-input"
                                type="text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                value="{{ old('amount', 100) }}"
                                class="bg-transparent w-24 focus:outline-none focus:ring-0 text-slate-100 placeholder:text-slate-400 text-right"
                                placeholder="Amount" />

                            <span class="text-amber-400 font-semibold">
                                💎
                                <span id="wallet-inline">
                                    {{ number_format((float)(auth()->user()->wallet?->amount ?? 0), 2, '.', '') }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <button type="button" class="preset-amount rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm py-2" data-val="100">₱100</button>
                        <button type="button" class="preset-amount rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm py-2" data-val="200">₱200</button>
                        <button type="button" class="preset-amount rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm py-2" data-val="500">₱500</button>
                        <button type="button" class="preset-amount rounded-lg bg-orange-600 hover:bg-orange-500 text-white font-semibold text-sm py-2" data-val="1000">₱1000</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-player-layout>
