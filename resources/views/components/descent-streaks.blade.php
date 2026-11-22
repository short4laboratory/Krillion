{{-- A burst of bubbles rushing upward while the diver sinks to their new depth; fades out on its own. --}}
@php
    $streaks = [
        [5, 3, 0.9, 0], [12, 2, 0.7, 0.3], [19, 4, 1.1, 0.1], [26, 2, 0.8, 0.5], [33, 3, 1.0, 0.2],
        [40, 2, 0.6, 0.6], [47, 5, 1.2, 0], [54, 2, 0.7, 0.4], [61, 3, 0.9, 0.15], [68, 2, 0.8, 0.55],
        [75, 4, 1.0, 0.25], [82, 2, 0.7, 0.45], [89, 3, 0.9, 0.05], [95, 2, 0.8, 0.35], [36, 6, 1.3, 0.7],
        [72, 5, 1.2, 0.8],
    ];
@endphp

<div aria-hidden="true" class="descent-streaks pointer-events-none fixed inset-0 z-0 overflow-hidden">
    @foreach ($streaks as [$left, $size, $duration, $delay])
        <span
            class="descent-streak"
            style="left: {{ $left }}%; width: {{ $size }}px; height: {{ $size * 9 }}px; animation-duration: {{ $duration }}s; animation-delay: {{ $delay }}s;"
        ></span>
    @endforeach
</div>
