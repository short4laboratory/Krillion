@php
    $meters = $dive->depthInMeters();
    $zone = $dive->depthZone();
    $fishClass = $dive->fishClass();
    $species = $dive->species();
@endphp

<x-layout
    :title="$dive->player_name.' reached '.number_format($meters).' m — Krillion'"
    :meters="$meters"
    :descend-from-meters="$descendFromMeters"
    :zone="$zone"
>
    <main class="mx-auto flex max-w-5xl flex-col gap-10 px-4 py-8 pb-40 sm:px-6 sm:py-12 sm:pb-44">
        <header>
            <x-krill-logo />
        </header>

        <div class="grid gap-10 md:grid-cols-[1fr_12rem]">
            <div class="flex flex-col gap-8">
                <section class="flex flex-col gap-4">
                    <p class="text-sm font-medium tracking-[0.2em] text-white/60 uppercase">{{ $dive->player_name }} reached</p>
                    <h1 class="text-6xl font-semibold tracking-tight sm:text-7xl"><x-depth-counter :meters="$meters" :from-meters="$descendFromMeters" />&nbsp;m</h1>
                    <div class="flex flex-col gap-1">
                        <p class="text-xl font-semibold">{{ $zone->label() }}</p>
                        <p class="text-white/75">{{ $zone->description() }}</p>
                    </div>

                    <div class="flex flex-col gap-4 rounded-2xl bg-slate-950/50 p-5 ring-1 ring-white/10 backdrop-blur-sm sm:flex-row sm:items-center">
                        <x-creature :name="$species['creature']" :label="$species['name']" class="catch-glow h-24 w-36 shrink-0 self-center" style="color: {{ $fishClass->rarityColor() }}" />
                        <div class="flex flex-1 flex-col gap-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm text-white/75">You are a</p>
                                <x-fish-badge :fish-class="$fishClass" :species="$species" class="text-sm" />
                            </div>
                            <p class="text-sm text-white/75">{{ $fishClass->description() }}</p>
                        </div>
                        <p class="text-sm text-white/60 tabular-nums sm:text-right">
                            <span class="block text-2xl font-semibold text-white">{{ $dive->total_score }}</span> of {{ \App\Models\Dive::maxScore() }} pts
                        </p>
                    </div>
                </section>

                <section class="flex flex-col gap-3" aria-labelledby="answers-heading">
                    <h2 id="answers-heading" class="text-lg font-semibold">Your descent</h2>
                    <ol class="flex flex-col divide-y divide-white/10 rounded-2xl bg-slate-950/40 ring-1 ring-white/10 backdrop-blur-sm">
                        @foreach ($dive->answers as $answer)
                            <li class="flex items-center gap-4 px-4 py-4">
                                @if ($caught = $answer->species())
                                    <x-creature :name="$caught['creature']" :label="$caught['name']" class="catch-glow hidden h-10 w-14 shrink-0 sm:block" style="color: {{ $answer->fish_class->rarityColor() }}" />
                                @else
                                    <span class="hidden h-10 w-14 shrink-0 sm:block" aria-hidden="true"></span>
                                @endif
                                <div class="flex min-w-0 flex-1 flex-col gap-1.5">
                                <p class="text-xs text-white/55">{{ $answer->question->prompt }}</p>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5">
                                    @if ($answer->timed_out)
                                        <p class="font-semibold text-rose-200">Time's up. The fish got away</p>
                                    @else
                                        <p class="font-semibold">
                                            “{{ $answer->answer }}”
                                            @if ($countedAs = $answer->countedAs())
                                                <span class="font-normal text-cyan-200">→ {{ $countedAs }}</span>
                                            @endif
                                        </p>
                                        <x-fish-badge :fish-class="$answer->fish_class" :species="$caught" />
                                    @endif
                                    <p class="ml-auto font-semibold text-krill tabular-nums">+{{ $answer->points }}</p>
                                </div>
                                <p class="text-xs text-white/55">
                                    {{ $answer->evidenceLabel() }}
                                    @if (! empty($mostCommonAnswers[$answer->question_id]))
                                        The school said: {{ implode(', ', $mostCommonAnswers[$answer->question_id]) }}.
                                    @endif
                                </p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </section>

                <section class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <form method="POST" action="{{ route('dives.store') }}">
                        @csrf
                        <input type="hidden" name="player_name" value="{{ $isOwner ? $dive->player_name : '' }}">
                        <button type="submit" class="w-full rounded-xl bg-krill px-6 py-3 font-semibold text-slate-950 shadow-lg shadow-krill/30 transition hover:brightness-110 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none sm:w-auto">
                            {{ $isOwner ? 'Dive again' : 'Take the plunge yourself' }}
                        </button>
                    </form>
                    <a href="{{ route('home') }}" class="rounded-xl px-6 py-3 text-center font-medium text-white/85 ring-1 ring-white/25 transition hover:bg-white/10">
                        Back to the surface
                    </a>
                    @if ($isOwner)
                        <p class="text-xs text-white/55 sm:ml-auto">Share this page's link to challenge a friend.</p>
                    @endif
                </section>
            </div>

            <x-depth-gauge :meters="$meters" :from-meters="$descendFromMeters" :zones="$zones" :last-catch="$dive->answers->last()" class="h-80 md:h-[30rem]" />
        </div>
    </main>
</x-layout>
