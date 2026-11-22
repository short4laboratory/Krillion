{{--
    How an answer scored: the fish it caught (one of its class's species), its rarity, its points,
    what it counted as, and a rarity bar that fills with the score, so a rarer answer means a fuller bar.
--}}
@props(['answer', 'mostCommon' => null])

@php
    $species = $answer->species();
    $fishClass = $answer->fish_class;
@endphp

<section aria-live="polite" {{ $attributes->merge(['class' => 'flex items-center gap-4 rounded-2xl bg-slate-950/50 p-5 ring-1 ring-white/10 backdrop-blur-sm']) }}>
    @if ($species)
        <x-creature
            :name="$species['creature']"
            :label="$species['name']"
            class="catch-glow hidden h-14 w-20 shrink-0 sm:block"
            style="color: {{ $fishClass->rarityColor() }}"
        />
    @endif

    <div class="flex min-w-0 flex-1 flex-col gap-2">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
            @if ($answer->timed_out)
                <p class="text-lg font-semibold text-rose-200">Time's up!</p>
            @else
                <p class="text-lg font-semibold">“{{ $answer->answer }}”</p>
                <x-fish-badge :fish-class="$fishClass" :species="$species" />
            @endif
            <p class="ml-auto text-2xl font-semibold text-krill tabular-nums">+{{ $answer->points }}</p>
        </div>

        @if ($countedAs = $answer->countedAs())
            <p class="text-xs text-cyan-200">Counted as {{ $countedAs }}.</p>
        @endif

        <p class="text-sm text-white/75">
            {{ $answer->timed_out ? 'The fish got away. Be quicker on the next one.' : $fishClass->description() }}
        </p>

        @unless ($answer->timed_out)
            <div class="flex w-full items-center gap-3">
                <span class="w-20 shrink-0 text-[11px] font-semibold tracking-wide uppercase" style="color: {{ $fishClass->rarityColor() }}">
                    {{ $fishClass->rarity() }}
                </span>
                <div class="h-2 flex-1 overflow-hidden rounded-full bg-white/10" role="meter" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $answer->points }}" aria-label="Rarity: {{ $fishClass->rarity() }}">
                    <div class="rarity-fill h-full rounded-full {{ $fishClass->rarityBarClasses() }}" style="width: {{ max(4, $answer->points) }}%"></div>
                </div>
            </div>
        @endunless

        <p class="text-xs text-white/55">
            {{ $answer->evidenceLabel() }}
            @if ($mostCommon)
                The school's favourite answer: {{ $mostCommon }}.
            @endif
        </p>
    </div>
</section>
