{{-- "Did you mean …?" above the answer box. Pressing Enter (or clicking the name) uses the suggestion. --}}
@props(['label'])

<div class="suggestion-pop flex flex-wrap items-center gap-x-2 gap-y-1 rounded-xl bg-amber-300/10 px-3 py-2 text-sm text-amber-50 ring-1 ring-amber-200/40">
    <span>Did you mean</span>
    <button type="button" data-accept-suggestion class="rounded-md bg-amber-200 px-2 py-0.5 font-semibold text-slate-950 transition hover:brightness-105 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">
        <span data-suggestion-label>{{ $label }}</span>
    </button>
    <span>?</span>
    <span class="text-xs text-amber-100/70 sm:ml-auto">Press Enter to use it, or keep typing.</span>
</div>
