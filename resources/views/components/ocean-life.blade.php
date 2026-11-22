{{-- Decorative bubbles rising from below, and glowing specks that only appear in deep water. --}}
@php
    $bubbles = [
        [6, 10, 14, 0], [14, 6, 11, 4], [23, 14, 18, 2], [31, 8, 13, 7], [42, 5, 10, 1],
        [51, 12, 16, 5], [60, 7, 12, 9], [68, 16, 20, 3], [77, 6, 11, 6], [85, 10, 15, 8],
        [93, 8, 13, 2], [37, 4, 9, 11], [72, 4, 9, 13], [18, 5, 10, 15],
    ];

    $specks = [
        [12, 22, 3, 'text-cyan-300', 3], [28, 64, 2, 'text-krill', 4], [47, 38, 3, 'text-emerald-300', 5],
        [63, 78, 2, 'text-cyan-200', 3.5], [81, 30, 3, 'text-fuchsia-300', 4.5], [90, 58, 2, 'text-krill', 6],
        [8, 84, 2, 'text-emerald-200', 5.5], [55, 12, 2, 'text-cyan-300', 4], [36, 90, 3, 'text-krill', 3],
    ];
@endphp

<div aria-hidden="true" class="pointer-events-none fixed inset-0 overflow-hidden">
    @foreach ($bubbles as [$left, $size, $duration, $delay])
        <span
            class="bubble"
            style="left: {{ $left }}%; width: {{ $size }}px; height: {{ $size }}px; animation-duration: {{ $duration }}s; animation-delay: -{{ $delay }}s; --drift: {{ $loop->even ? '' : '-' }}{{ 1 + $loop->index % 3 }}rem;"
        ></span>
    @endforeach

    @foreach ($specks as [$left, $top, $size, $color, $duration])
        <span
            class="glow-speck {{ $color }}"
            style="left: {{ $left }}%; top: {{ $top }}%; width: {{ $size }}px; height: {{ $size }}px; animation-duration: {{ $duration }}s;"
        ></span>
    @endforeach
</div>
