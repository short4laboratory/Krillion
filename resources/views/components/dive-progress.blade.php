@props(['position'])

<div class="flex items-center gap-3">
    <p class="text-xs font-medium tracking-[0.2em] text-white/60 uppercase">Question {{ $position + 1 }} of {{ \App\Models\Dive::QUESTIONS_PER_DIVE }}</p>
    <div class="flex flex-1 gap-1" aria-hidden="true">
        @for ($step = 0; $step < \App\Models\Dive::QUESTIONS_PER_DIVE; $step++)
            <span @class([
                'h-1 flex-1 rounded-full',
                'bg-krill' => $step < $position,
                'bg-white/70' => $step === $position,
                'bg-white/15' => $step > $position,
            ])></span>
        @endfor
    </div>
</div>
