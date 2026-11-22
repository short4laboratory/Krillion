{{-- Draws one creature from <x-creature-sprites />. Pass a label to make it a meaningful image. --}}
@props([
    'name',
    'label' => null,
])

@php
    $viewBoxes = [
        'sardine' => '0 0 60 24',
        'fish-school' => '0 0 200 90',
        'reef-fish' => '0 0 64 40',
        'sunfish' => '0 0 80 90',
        'lanternfish' => '0 0 64 28',
        'anglerfish' => '0 0 96 72',
        'snailfish' => '0 0 76 36',
        'shark' => '0 0 200 80',
        'jellyfish' => '0 0 60 96',
        'giant-squid' => '0 0 320 120',
        'coral-reef' => '0 0 400 140',
        'trench-floor' => '0 0 400 100',
        'anchovy' => '0 0 60 20',
        'mackerel' => '0 0 70 26',
        'blue-tang' => '0 0 64 44',
        'butterflyfish' => '0 0 56 50',
        'pufferfish' => '0 0 60 52',
        'seahorse' => '0 0 44 76',
        'hatchetfish' => '0 0 50 44',
        'viperfish' => '0 0 84 36',
        'gulper-eel' => '0 0 110 44',
        'barreleye' => '0 0 72 42',
        'krill' => '0 0 40 20',
        'krill-swarm' => '0 0 220 110',
        'black-smoker' => '0 0 80 200',
        'dumbo-octopus' => '0 0 70 60',
        'xenophyophore' => '0 0 60 40',
        'kelp' => '0 0 60 320',
        'seagrass' => '0 0 90 80',
        'barrel-sponge' => '0 0 60 70',
        'sea-pen' => '0 0 30 100',
        'crinoid' => '0 0 80 120',
        'glass-sponge' => '0 0 50 110',
        'tube-worms' => '0 0 90 90',
    ];
@endphp

<svg
    viewBox="{{ $viewBoxes[$name] }}"
    @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" @endif
    {{ $attributes->merge(['class' => 'overflow-visible']) }}
><use href="#creature-{{ $name }}" /></svg>
