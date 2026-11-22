{{--
    The answer box, with the countdown to its left and a feedback line just above it.

    resources/js/answer-form.js checks each answer before submitting: a near miss shows
    "Did you mean …?" here, and pressing Enter again swaps in the suggestion and submits.
    With `cast`, leaving plays the casting animation from the boat first. When the countdown ends,
    timer.js sets timed_out and submits whatever is typed.

    Without JavaScript the server does the same check after submitting and shows the same feedback.
--}}
@props([
    'dive',
    'question',
    'secondsRemaining',
    'cast' => false,
])

@php
    $suggestion = $errors->first('suggestion') ?: null;
@endphp

<form
    method="POST"
    action="{{ route('dives.answers.store', $dive) }}"
    class="flex flex-col gap-3"
    data-answer-form
    data-check-url="{{ route('dives.answer-checks.store', $dive) }}"
    @if ($suggestion) data-suggestion="{{ $suggestion }}" @endif
    @if ($cast) data-cast @endif
>
    @csrf
    <input type="hidden" name="timed_out" value="0" data-timed-out>

    <div data-answer-feedback aria-live="polite" class="min-h-0">
        @if ($suggestion)
            <x-answer-suggestion :label="$suggestion" />
        @else
            @error('answer')
                <p class="text-sm text-rose-200">{{ $message }}</p>
            @enderror
        @endif
    </div>

    <label for="answer" class="sr-only">Your answer</label>
    <div class="flex flex-col gap-3 sm:flex-row">
        <div class="flex flex-1 items-center gap-3">
            <x-question-timer :seconds-remaining="$secondsRemaining" />
            <input
                id="answer"
                name="answer"
                type="text"
                required
                maxlength="60"
                autofocus
                autocomplete="off"
                spellcheck="false"
                value="{{ old('answer') }}"
                placeholder="{{ $question->placeholder }}"
                @error('answer') aria-invalid="true" @enderror
                class="w-full min-w-0 flex-1 rounded-xl bg-white/10 px-4 py-3 text-lg text-white ring-1 ring-white/25 transition placeholder:text-white/45 focus:ring-2 focus:ring-krill focus:outline-none"
            >
        </div>
        <button type="submit" class="rounded-xl bg-krill px-6 py-3 font-semibold text-slate-950 shadow-lg shadow-krill/30 transition hover:brightness-110 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none disabled:opacity-60 aria-busy:opacity-70">
            {{ $cast ? 'Cast' : 'Dive' }}
        </button>
    </div>
    {{ $slot }}
</form>

{{-- Template the script clones when the instant check suggests a correction. --}}
<template data-suggestion-template>
    <x-answer-suggestion label="" />
</template>
