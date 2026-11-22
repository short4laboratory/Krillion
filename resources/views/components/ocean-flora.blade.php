{{--
    The plants (and plant-like animals) on the seafloor behind the page, chosen by zone:
    kelp forests and seagrass in the sunlight, sponges on twilight ledges, glowing sea pens and sea lilies
    at midnight, glass sponges on the abyssal plain, and tube worms on the trench floor.
--}}
@props(['zone'])

@use('App\Enums\DepthZone')

@php
    /**
     * Per zone: the seafloor colour and its flora as [creature, x, width, height, colour, opacity].
     * Coordinates are in a 1200 x 170 strip anchored to the bottom of the screen.
     */
    $floors = [
        DepthZone::Sunlight->value => [null, [
            ['seagrass', 120, 90, 80, null, 1], ['seagrass', 430, 70, 62, null, 0.9], ['seagrass', 700, 90, 80, null, 1],
            ['seagrass', 980, 80, 70, null, 0.9], ['barrel-sponge', 560, 34, 40, '#f97316', 1], ['barrel-sponge', 1100, 28, 33, '#c084fc', 1],
        ]],
        DepthZone::Twilight->value => ['#13243d', [
            ['barrel-sponge', 90, 50, 58, '#c2410c', 0.8], ['barrel-sponge', 150, 34, 40, '#9a3412', 0.7],
            ['glass-sponge', 380, 34, 75, '#bae6fd', 0.7], ['barrel-sponge', 610, 44, 51, '#7e22ce', 0.75],
            ['seagrass', 760, 70, 60, null, 0.35], ['glass-sponge', 900, 30, 66, '#bae6fd', 0.6], ['barrel-sponge', 1080, 52, 60, '#c2410c', 0.8],
        ]],
        DepthZone::ScatteringLayer->value => ['#0f1d33', [
            ['glass-sponge', 70, 36, 80, '#bae6fd', 0.6], ['barrel-sponge', 240, 40, 46, '#9a3412', 0.6],
            ['glass-sponge', 520, 28, 62, '#bae6fd', 0.5], ['barrel-sponge', 760, 46, 54, '#6b21a8', 0.65],
            ['sea-pen', 960, 20, 66, '#67e8f9', 0.7], ['glass-sponge', 1100, 32, 72, '#bae6fd', 0.55],
        ]],
        DepthZone::Midnight->value => ['#0a1424', [
            ['sea-pen', 70, 24, 80, '#67e8f9', 1], ['sea-pen', 110, 18, 60, '#f0abfc', 0.9], ['crinoid', 300, 70, 105, '#fbcfe8', 0.8],
            ['sea-pen', 520, 22, 74, '#a5f3fc', 1], ['glass-sponge', 690, 30, 66, '#bae6fd', 0.5], ['crinoid', 860, 60, 90, '#fde68a', 0.7],
            ['sea-pen', 1040, 26, 86, '#f0abfc', 1], ['sea-pen', 1090, 18, 62, '#67e8f9', 0.9],
        ]],
        DepthZone::Abyssal->value => ['#080f1c', [
            ['crinoid', 60, 76, 114, '#e2e8f0', 0.75], ['glass-sponge', 260, 40, 88, '#e0f2fe', 0.6], ['glass-sponge', 310, 28, 62, '#e0f2fe', 0.5],
            ['sea-pen', 520, 20, 66, '#67e8f9', 0.8], ['crinoid', 700, 64, 96, '#fecdd3', 0.7], ['glass-sponge', 930, 36, 80, '#e0f2fe', 0.6],
            ['crinoid', 1080, 70, 105, '#e2e8f0', 0.7],
        ]],
        DepthZone::Vents->value => ['#120d0c', [
            ['tube-worms', 40, 74, 74, null, 0.95], ['tube-worms', 300, 60, 60, null, 0.85], ['tube-worms', 480, 80, 80, null, 0.95],
            ['tube-worms', 780, 66, 66, null, 0.9], ['tube-worms', 1060, 76, 76, null, 0.95],
        ]],
        DepthZone::Hadal->value => [null, [
            ['xenophyophore', 140, 54, 36, null, 0.9], ['xenophyophore', 520, 40, 27, null, 0.8], ['glass-sponge', 760, 30, 66, '#e0f2fe', 0.45],
            ['xenophyophore', 960, 60, 40, null, 0.9],
        ]],
        DepthZone::ChallengerDeep->value => [null, [
            ['xenophyophore', 260, 46, 31, null, 0.7], ['xenophyophore', 640, 60, 40, null, 0.8], ['xenophyophore', 900, 36, 24, null, 0.6],
        ]],
    ];
    [$floorColour, $flora] = $floors[$zone->value];
@endphp

@if ($zone === DepthZone::Sunlight)
    {{-- A kelp forest along both edges, swaying in the light. --}}
    <x-creature name="kelp" class="absolute bottom-0 -left-4 h-[70vh] w-auto opacity-90" />
    <x-creature name="kelp" class="absolute bottom-0 left-[5%] hidden h-[52vh] w-auto opacity-75 sm:block" />
    <x-creature name="kelp" class="absolute bottom-0 -right-3 h-[64vh] w-auto opacity-90" />
    <x-creature name="kelp" class="absolute right-[7%] bottom-0 hidden h-[44vh] w-auto opacity-70 sm:block" />
@elseif ($zone === DepthZone::Twilight)
    {{-- The last faint kelp, fading out of the light. --}}
    <x-creature name="kelp" class="absolute bottom-0 -left-6 h-[56vh] w-auto opacity-25 brightness-50" />
    <x-creature name="kelp" class="absolute -right-5 bottom-0 h-[48vh] w-auto opacity-20 brightness-50" />
@endif

<svg viewBox="0 0 1200 170" preserveAspectRatio="xMidYMax slice" class="absolute inset-x-0 bottom-0 h-32 w-full sm:h-40" aria-hidden="true">
    @if ($floorColour)
        <path d="M0 170 L0 150 Q80 136 160 146 Q260 132 360 144 Q460 130 560 142 Q680 128 800 142 Q900 132 1000 144 Q1100 134 1200 142 L1200 170 Z" fill="{{ $floorColour }}" />
    @endif
    @foreach ($flora as [$name, $x, $width, $height, $colour, $opacity])
        <use
            href="#creature-{{ $name }}"
            x="{{ $x }}"
            y="{{ 150 - $height }}"
            width="{{ $width }}"
            height="{{ $height }}"
            opacity="{{ $opacity }}"
            @if ($colour) color="{{ $colour }}" @endif
        />
    @endforeach
</svg>
