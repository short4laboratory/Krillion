@php
    $meters = $dive->depthInMeters();
@endphp

<x-layout
    :title="'Question '.($position + 1).' — Krillion'"
    :meters="$meters"
    :descend-from-meters="$descendFromMeters"
    :zone="$dive->depthZone()"
>
    <main class="mx-auto flex max-w-5xl flex-col gap-10 px-4 py-8 pb-40 sm:px-6 sm:py-12 sm:pb-44">
        <header class="flex items-center justify-between gap-4">
            <x-krill-logo />
            <p class="text-right text-sm text-white/75">
                <span class="font-semibold text-white"><x-depth-counter :meters="$meters" :from-meters="$descendFromMeters" /> m</span>
                · {{ $dive->depthZone()->label() }}
            </p>
        </header>

        <div class="grid gap-10 md:grid-cols-[1fr_12rem]">
            <div data-dive-card class="sink-in flex flex-col gap-6">
                @if ($revealedAnswer)
                    <x-answer-reveal :answer="$revealedAnswer" :most-common="$revealedMostCommon" />
                @endif

                <section class="flex flex-col gap-6 rounded-3xl bg-slate-950/50 p-6 ring-1 ring-white/15 backdrop-blur-md sm:p-8">
                    <div class="flex flex-col gap-3">
                        <x-dive-progress :position="$position" />
                        <h1 class="text-3xl font-semibold tracking-tight text-balance sm:text-4xl">{{ $question->prompt }}</h1>
                    </div>

                    <x-answer-form :dive="$dive" :question="$question" :seconds-remaining="$secondsRemaining">
                        <p class="text-xs text-white/55">Answers must be correct. The fewer people who'd think of yours, the deeper you sink.</p>
                    </x-answer-form>
                </section>
            </div>

            <x-depth-gauge :meters="$meters" :from-meters="$descendFromMeters" :zones="$zones" :last-catch="$dive->answers->last()" class="h-80 md:h-[30rem]" />
        </div>
    </main>
</x-layout>
