{{--
    The countdown ring beside the final catch, styled like the question timer. resources/js/auto-advance.js
    drains it and moves on to the results when it reaches zero.
--}}
@props(['seconds', 'href'])

@php
    $radius = 21;
    $circumference = round(2 * M_PI * $radius, 3);
@endphp

<div
    data-auto-advance
    data-seconds="{{ $seconds }}"
    data-href="{{ $href }}"
    role="timer"
    aria-label="Results in {{ $seconds }} seconds"
    {{ $attributes->merge(['class' => 'timer relative grid size-13 shrink-0 place-items-center text-krill']) }}
>
    <svg viewBox="0 0 48 48" class="absolute inset-0 size-full -rotate-90" aria-hidden="true">
        <circle cx="24" cy="24" r="{{ $radius }}" fill="rgb(2 6 23 / 0.45)" stroke="rgb(255 255 255 / 0.15)" stroke-width="4" />
        <circle
            data-auto-advance-ring=""
            cx="24"
            cy="24"
            r="{{ $radius }}"
            fill="none"
            stroke="currentColor"
            stroke-width="4"
            stroke-linecap="round"
            stroke-dasharray="{{ $circumference }}"
            stroke-dashoffset="0"
            class="timer-ring"
        />
    </svg>
    <span data-auto-advance-count class="timer-seconds relative text-lg leading-none font-semibold tabular-nums" aria-hidden="true">{{ $seconds }}</span>
</div>
