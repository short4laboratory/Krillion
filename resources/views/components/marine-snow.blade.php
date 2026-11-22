{{-- Flecks of "marine snow" drifting down through the deep. --}}
@php
    $flakes = [
        [4, 2, 22, 0], [11, 1, 18, 6], [19, 2, 26, 12], [27, 1, 20, 3], [35, 2, 24, 9], [44, 1, 19, 15],
        [52, 2, 28, 1], [60, 1, 21, 11], [68, 2, 25, 5], [76, 1, 17, 14], [84, 2, 23, 8], [92, 1, 27, 2],
    ];
@endphp

@foreach ($flakes as [$left, $size, $duration, $delay])
    <span
        class="marine-snow"
        style="left: {{ $left }}%; width: {{ $size + 1 }}px; height: {{ $size + 1 }}px; animation-duration: {{ $duration }}s; animation-delay: -{{ $delay }}s;"
    ></span>
@endforeach
