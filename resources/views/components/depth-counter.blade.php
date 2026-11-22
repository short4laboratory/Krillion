{{-- A depth reading that counts up from `fromMeters` to `meters` while the page descends (see descent.js). --}}
@props(['meters', 'fromMeters' => null])

<span data-depth-counter data-from="{{ $fromMeters ?? $meters }}" data-to="{{ $meters }}" {{ $attributes->merge(['class' => 'tabular-nums']) }}>{{ number_format($fromMeters ?? $meters) }}</span>
