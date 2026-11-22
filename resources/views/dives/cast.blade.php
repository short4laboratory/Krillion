{{-- The first question is asked on the boat; answering it casts the line and starts the descent. --}}
<x-layout title="Question 1 — Krillion" surface>
    <x-boat-scene>
        <main class="mx-auto flex w-full max-w-3xl flex-col gap-6 px-4 py-8 sm:px-6 sm:py-10">
            <header class="flex items-center justify-between gap-4">
                <x-krill-logo />
                <p class="text-right text-sm text-white/75">
                    <span class="font-semibold text-white">On deck</span> · 0 m
                </p>
            </header>

            <section class="flex flex-col gap-6 rounded-3xl bg-slate-950/45 p-6 ring-1 ring-white/15 backdrop-blur-md transition-opacity duration-500 sm:p-8 [.is-casting_&]:opacity-0 [.is-casting_&]:delay-[1100ms]">
                <div class="flex flex-col gap-3">
                    <x-dive-progress :position="0" />
                    <h1 class="text-3xl font-semibold tracking-tight text-balance sm:text-4xl">{{ $question->prompt }}</h1>
                </div>

                <x-answer-form :dive="$dive" :question="$question" :seconds-remaining="$secondsRemaining" cast>
                    <p class="text-xs text-white/60">Cast your first answer off the side of the boat. The rarer (but real) it is, the deeper your line sinks.</p>
                </x-answer-form>
            </section>
        </main>
    </x-boat-scene>
</x-layout>
