{{--
    The page shell. `meters` is how deep the diver is; when `descendFromMeters` is given the page
    starts at that depth and resources/js/descent.js sinks it to `meters`: the water darkens, bubbles
    rush past, the depth counter climbs, the depth meter's line reels out and, on crossing into a new
    zone, a banner announces it.
--}}
@props([
    'title' => 'Krillion',
    'meters' => 0,
    'descendFromMeters' => null,
    'zone' => null,
    'surface' => false,
])

@php
    $bottom = \App\Enums\DepthZone::CHALLENGER_DEEP_METERS;
    $isDescending = $descendFromMeters !== null && $descendFromMeters < $meters;
    $toDepth = round(min(1, max(0, $meters / $bottom)), 3);
    $fromDepth = $isDescending ? round(min(1, max(0, $descendFromMeters / $bottom)), 3) : $toDepth;
    $enteredZone = $isDescending && $zone && \App\Enums\DepthZone::fromDepth($descendFromMeters) !== $zone ? $zone : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0b1026">

        <title>{{ $title }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{ $head ?? '' }}
    </head>
    <body
        class="sea relative overflow-x-hidden font-sans text-white antialiased"
        style="--depth: {{ $fromDepth }}"
        @if ($isDescending) data-descend-to="{{ $toDepth }}" @endif
    >
        <x-creature-sprites />

        @unless ($surface)
            <x-ocean-life />
        @endunless

        @if ($zone)
            <x-ocean-creatures :zone="$zone" :class="$isDescending ? 'arrive-in' : ''" />
        @endif

        @if ($isDescending)
            <x-descent-streaks />
        @endif

        @if ($enteredZone)
            {{-- A quiet notice on the reel side of the screen rather than across the question. --}}
            <div class="zone-banner pointer-events-none fixed top-20 right-3 z-20 max-w-[13rem] sm:right-6" role="status">
                <div class="rounded-xl bg-slate-950/70 px-4 py-2.5 text-right ring-1 ring-white/15 backdrop-blur-md">
                    <p class="text-[10px] font-semibold tracking-[0.25em] text-white/55 uppercase">Entering the</p>
                    <p class="font-display text-base leading-tight font-semibold">{{ $enteredZone->label() }}</p>
                    <p class="text-xs text-white/60 tabular-nums">{{ number_format($enteredZone->topMeters()) }} m and below</p>
                </div>
            </div>
        @endif

        <div class="relative z-10">
            {{ $slot }}
        </div>
    </body>
</html>
