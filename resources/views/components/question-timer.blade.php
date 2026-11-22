{{--
    The countdown ring beside the answer box, styled as the diver's air supply.
    resources/js/timer.js drains the ring, ticks the number and submits the answer when it hits zero.
    It turns amber at 10 seconds and red at 5.
--}}
@props([
    'secondsRemaining',
    'secondsTotal' => \App\Models\Dive::SECONDS_PER_QUESTION,
])

@php
    $radius = 21;
    $circumference = round(2 * M_PI * $radius, 3);
    $fractionLeft = $secondsTotal > 0 ? $secondsRemaining / $secondsTotal : 0;
    $urgency = match (true) {
        $secondsRemaining <= 5 => 'critical',
        $secondsRemaining <= 10 => 'warning',
        default => 'calm',
    };
@endphp

<div
    data-question-timer
    data-seconds-remaining="{{ $secondsRemaining }}"
    data-seconds-total="{{ $secondsTotal }}"
    data-urgency="{{ $urgency }}"
    role="timer"
    aria-label="{{ $secondsRemaining }} seconds left"
    {{ $attributes->merge(['class' => 'timer relative grid size-13 shrink-0 place-items-center text-cyan-200 data-[urgency=critical]:text-rose-300 data-[urgency=warning]:text-amber-200']) }}
>
    <svg viewBox="0 0 48 48" class="absolute inset-0 size-full -rotate-90" aria-hidden="true">
        <circle cx="24" cy="24" r="{{ $radius }}" fill="rgb(2 6 23 / 0.45)" stroke="rgb(255 255 255 / 0.15)" stroke-width="4" />
        <circle
            data-timer-ring=""
            cx="24"
            cy="24"
            r="{{ $radius }}"
            fill="none"
            stroke="currentColor"
            stroke-width="4"
            stroke-linecap="round"
            stroke-dasharray="{{ $circumference }}"
            stroke-dashoffset="{{ round($circumference * (1 - $fractionLeft), 3) }}"
            class="timer-ring"
        />
    </svg>
    <span data-timer-seconds class="timer-seconds relative text-lg leading-none font-semibold tabular-nums" aria-hidden="true">{{ $secondsRemaining }}</span>
    <span data-timer-bubble class="timer-bubble pointer-events-none absolute -top-1 left-1/2 size-1.5 rounded-full bg-current opacity-0" aria-hidden="true"></span>
    <span data-timer-announcer class="sr-only" aria-live="assertive"></span>
</div>
