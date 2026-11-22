{{--
    The depth meter, drawn as a fishing rod's line: a reel at the top, the line running down a cross-section
    of the trench, and the bobber marking the diver's current depth. The bobber takes the rarity colour of the
    last catch (silver, green, red, purple, gold, or shimmering for Mythic), and is dull grey after a miss.

    Drawn on a square-root scale: the shallow zones are only a few hundred metres thick and would be
    unreadable slivers on a linear scale. With `fromMeters`, descent.js reels the line out from the previous
    depth while the reel spins.
--}}
@props(['meters', 'zones', 'fromMeters' => null, 'lastCatch' => null])

@php
    $bottom = \App\Enums\DepthZone::CHALLENGER_DEEP_METERS;
    $positionOf = fn (int $depth): float => round(sqrt(min(1, $depth / $bottom)) * 100, 2);
    $toPercent = $positionOf($meters);
    $isReeling = $fromMeters !== null && $fromMeters < $meters;
    $startPercent = $isReeling ? $positionOf($fromMeters) : $toPercent;
    $startMeters = $isReeling ? $fromMeters : $meters;

    $lure = $lastCatch?->fish_class;
    $missed = (bool) $lastCatch?->timed_out;
    $colour = match (true) {
        $missed => '#64748b',
        $lure !== null => $lure->rarityColor(),
        default => '#ef4444',
    };
@endphp

<figure {{ $attributes->merge(['class' => 'relative pt-6 pb-8']) }}>
    <div class="relative h-full">
        {{-- The water column behind the line --}}
        <div class="absolute inset-y-0 left-5 w-3 -translate-x-1/2 rounded-full bg-linear-to-b from-sky-400/40 via-blue-900/40 to-slate-950/60 ring-1 ring-white/10"></div>

        <div class="absolute inset-y-0 right-0 left-12">
            @foreach ($zones as $zone)
                <div class="absolute inset-x-0 border-t border-dashed border-white/15 pt-0.5" style="top: {{ $positionOf($zone->topMeters()) }}%">
                    <p class="truncate text-[10px] leading-tight font-medium tracking-wide text-white/60 uppercase">
                        {{ $zone->label() }} <span class="font-normal text-white/40 normal-case tabular-nums">{{ number_format($zone->topMeters()) }} m</span>
                    </p>
                </div>
            @endforeach

            <div class="absolute inset-x-0 top-full border-t border-white/30 pt-0.5">
                <p class="text-[10px] leading-tight text-white/40 tabular-nums">{{ number_format($bottom) }} m</p>
            </div>
        </div>

        {{-- The line, let out as far as the current depth --}}
        <div
            data-gauge-fill
            data-to-percent="{{ $toPercent }}"
            class="descent-move absolute top-0 left-5 w-px -translate-x-1/2 bg-linear-to-b from-white/80 to-white/50"
            style="height: {{ $startPercent }}%"
        ></div>

        {{-- The reel at the top of the line --}}
        <svg viewBox="0 0 60 60" class="absolute -top-7 left-5 size-10 -translate-x-1/2 drop-shadow-lg" aria-hidden="true">
            <g @class(['reel-spin' => $isReeling]) style="transform-origin: 30px 30px">
                <circle cx="30" cy="30" r="26" fill="#334155" stroke="#94a3b8" stroke-width="2" />
                <circle cx="30" cy="30" r="17" fill="#1e293b" stroke="#cbd5e1" stroke-width="1.2" stroke-dasharray="2 2.5" />
                <path d="M30 5 V55 M5 30 H55" stroke="#64748b" stroke-width="2" />
                <circle cx="30" cy="30" r="4.5" fill="#e2e8f0" />
                <rect x="44" y="7" width="6" height="13" rx="3" fill="#fbbf24" />
            </g>
        </svg>

        {{-- The bobber on the end of the line, with the depth reading beside it --}}
        <div
            data-gauge-marker
            data-to-percent="{{ $toPercent }}"
            class="descent-move absolute left-5 flex items-start gap-1"
            style="top: {{ $startPercent }}%"
        >
            <div
                @class(['lure-sway -ml-3.5', 'rarity-mythic' => ! $missed && $lure === \App\Enums\FishClass::Snailfish])
                style="color: {{ $colour }}"
                aria-hidden="true"
            >
                <svg viewBox="0 0 30 46" class="h-10 w-7" style="filter: drop-shadow(0 0 {{ $missed ? 0 : 8 }}px currentColor)">
                    <circle cx="15" cy="20" r="14" fill="currentColor" fill-opacity="{{ $missed ? 0 : 0.14 }}" />
                    <path d="M15 0 V10" stroke="#e2e8f0" stroke-width="1" />
                    <path d="M5 20 A10 10 0 0 1 25 20 Z" fill="currentColor" />
                    <path d="M5 20 A10 10 0 0 0 25 20 Z" fill="#f8fafc" />
                    <path d="M5 20 H25" stroke="#0f172a" stroke-opacity="0.35" stroke-width="1" />
                    <path d="M15 30 V40" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                </svg>
            </div>
            <span class="mt-3 rounded-md bg-slate-950/80 px-2 py-0.5 text-xs font-semibold whitespace-nowrap ring-1 ring-white/20">
                <x-depth-counter :meters="$meters" :from-meters="$startMeters" /> m
            </span>
        </div>
    </div>

    <figcaption class="sr-only">Current depth: {{ number_format($meters) }} metres of {{ number_format($bottom) }}.</figcaption>
</figure>
