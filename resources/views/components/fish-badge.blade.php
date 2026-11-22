{{-- A fish class's badge in its rarity colour: "LEGENDARY Anglerfish", or the caught species if given. --}}
@props(['fishClass', 'species' => null])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset '.$fishClass->badgeClasses()]) }}>
    <x-creature :name="$species['creature'] ?? $fishClass->creature()" class="h-3.5 w-auto shrink-0" />
    <span class="text-[10px] font-semibold tracking-wider uppercase opacity-80">{{ $fishClass->rarity() }}</span>
    {{ $species['name'] ?? $fishClass->label() }}
</span>
