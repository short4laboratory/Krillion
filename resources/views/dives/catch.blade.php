{{--
    The final catch: after the seventh answer, show what it scored for a few seconds before the results,
    laid out like the question pages with a countdown ring beside the catch. resources/js/auto-advance.js
    moves on when it runs out; without JavaScript the meta refresh does it. Reloading the same URL shows
    the results, because the reveal is only flashed for one request.
--}}
@php
    $meters = $dive->depthInMeters();
    $resultsUrl = route('dives.show', $dive);
@endphp

<x-layout
    :title="'Final catch — Krillion'"
    :meters="$meters"
    :descend-from-meters="$descendFromMeters"
    :zone="$dive->depthZone()"
>
    <x-slot:head>
        <noscript><meta http-equiv="refresh" content="{{ $seconds }};url={{ $resultsUrl }}"></noscript>
    </x-slot:head>

    <main class="mx-auto flex max-w-5xl flex-col gap-10 px-4 py-8 pb-40 sm:px-6 sm:py-12 sm:pb-44">
        <header class="flex items-center justify-between gap-4">
            <x-krill-logo />
            <p class="text-right text-sm text-white/75">
                <span class="font-semibold text-white"><x-depth-counter :meters="$meters" :from-meters="$descendFromMeters" /> m</span>
                · {{ $dive->depthZone()->label() }}
            </p>
        </header>

        <div class="grid gap-10 md:grid-cols-[1fr_12rem]">
            <div class="sink-in flex flex-col gap-6">
                <div class="flex items-center gap-4">
                    <x-results-countdown :seconds="$seconds" :href="$resultsUrl" />
                    <x-answer-reveal :answer="$revealedAnswer" :most-common="$revealedMostCommon" class="min-w-0 flex-1" />
                </div>

                <section class="flex flex-col gap-4 rounded-3xl bg-slate-950/50 p-6 ring-1 ring-white/15 backdrop-blur-md sm:p-8">
                    <x-dive-progress :position="\App\Models\Dive::QUESTIONS_PER_DIVE - 1" />
                    <h1 class="text-3xl font-semibold tracking-tight text-balance sm:text-4xl">Your final catch</h1>
                    <p class="text-sm text-white/70">{{ $revealedAnswer->question->prompt }}</p>
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="text-sm text-white/60">Hauling in your results…</p>
                        <a href="{{ $resultsUrl }}" class="rounded-xl bg-krill px-5 py-2.5 font-semibold text-slate-950 shadow-lg shadow-krill/30 transition hover:brightness-110 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none sm:ml-auto">
                            See my results
                        </a>
                    </div>
                </section>
            </div>

            <x-depth-gauge :meters="$meters" :from-meters="$descendFromMeters" :zones="\App\Enums\DepthZone::cases()" :last-catch="$revealedAnswer" class="h-80 md:h-[30rem]" />
        </div>
    </main>
</x-layout>
