{{--
    The sea life swimming behind the page, chosen by how deep the diver is:
    coral reefs in the sunlight, sharks and jellyfish in the twilight, glowing hunters at midnight,
    giant squid in the abyss, and pale snailfish on the trench floor.
--}}
@props(['zone'])

@use('App\Enums\DepthZone')

<div aria-hidden="true" {{ $attributes->merge(['class' => 'pointer-events-none fixed inset-0 overflow-hidden']) }}>
    @switch($zone)
        @case(DepthZone::Sunlight)
            <div class="swim absolute top-[16%]" style="--swim-duration: 38s; --swim-delay: -8s; --rest-x: 55vw">
                <x-creature name="fish-school" class="w-48 opacity-90 sm:w-64" />
            </div>
            <div class="swim swim-left absolute top-[52%]" style="--swim-duration: 26s; --swim-delay: -15s; --rest-x: 12vw">
                <x-creature name="reef-fish" class="w-14" />
            </div>
            <div class="swim absolute top-[64%]" style="--swim-duration: 31s; --swim-delay: -4s; --rest-x: 70vw">
                <x-creature name="reef-fish" class="w-10" />
            </div>
            <div class="swim swim-left absolute top-[44%]" style="--swim-duration: 28s; --swim-delay: -9s; --rest-x: 80vw">
                <x-creature name="blue-tang" class="w-12" />
            </div>
            <div class="swim absolute top-[28%]" style="--swim-duration: 35s; --swim-delay: -22s; --rest-x: 35vw">
                <x-creature name="butterflyfish" class="w-10" />
            </div>
            <div class="swim swim-left absolute top-[36%]" style="--swim-duration: 47s; --swim-delay: -30s; --rest-x: 30vw">
                <x-creature name="fish-school" class="w-32 opacity-60" />
            </div>
            <svg viewBox="0 0 1200 140" preserveAspectRatio="xMidYMax slice" class="absolute inset-x-0 bottom-0 h-28 w-full sm:h-36">
                <use href="#creature-coral-reef" x="0" width="400" height="140" />
                <use href="#creature-coral-reef" x="400" width="400" height="140" />
                <use href="#creature-coral-reef" x="800" width="400" height="140" />
            </svg>
            @break

        @case(DepthZone::Twilight)
            <div class="swim absolute top-[26%]" style="--swim-duration: 44s; --swim-delay: -10s; --rest-x: 50vw">
                <x-creature name="shark" class="w-64 opacity-80 sm:w-96" />
            </div>
            <div class="bob absolute top-[52%] left-[6%]" style="--bob-duration: 7s">
                <x-creature name="jellyfish" class="w-14 text-pink-300 opacity-80" />
            </div>
            <div class="bob absolute top-[14%] right-[8%]" style="--bob-duration: 9s">
                <x-creature name="jellyfish" class="w-10 text-violet-300 opacity-70" />
            </div>
            <div class="swim swim-left absolute top-[70%]" style="--swim-duration: 34s; --swim-delay: -20s; --rest-x: 60vw">
                <x-creature name="fish-school" class="w-40 opacity-45" />
            </div>
            <div class="swim absolute top-[82%]" style="--swim-duration: 29s; --swim-delay: -6s; --rest-x: 25vw">
                <x-creature name="sunfish" class="w-16 opacity-70" />
            </div>
            <div class="bob absolute top-[38%] left-[22%] hidden sm:block" style="--bob-duration: 6s">
                <x-creature name="seahorse" class="w-7 opacity-80" />
            </div>
            <div class="swim swim-left absolute top-[62%]" style="--swim-duration: 40s; --swim-delay: -14s; --rest-x: 75vw">
                <x-creature name="pufferfish" class="w-10 opacity-80" />
            </div>
            @break

        @case(DepthZone::ScatteringLayer)
            {{-- A living cloud: krill swarms and lanternfish crowd every direction. --}}
            <div class="swim absolute top-[12%]" style="--swim-duration: 40s; --swim-delay: -12s; --rest-x: 45vw">
                <x-creature name="krill-swarm" class="w-64 sm:w-96" />
            </div>
            <div class="swim swim-left absolute top-[38%]" style="--swim-duration: 52s; --swim-delay: -30s; --rest-x: 15vw">
                <x-creature name="krill-swarm" class="w-48 opacity-70 sm:w-72" />
            </div>
            <div class="swim absolute top-[60%]" style="--swim-duration: 34s; --swim-delay: -4s; --rest-x: 70vw">
                <x-creature name="krill-swarm" class="w-40 opacity-50 sm:w-56" />
            </div>
            @foreach ([[24, 26, -3, 'w-12'], [30, 26, -9, 'w-9'], [48, 30, -16, 'w-11'], [72, 22, -6, 'w-10'], [78, 27, -20, 'w-8']] as [$top, $duration, $delay, $width])
                <div class="swim {{ $loop->even ? 'swim-left' : '' }} absolute" style="top: {{ $top }}%; --swim-duration: {{ $duration }}s; --swim-delay: {{ $delay }}s; --rest-x: {{ 10 + $loop->index * 18 }}vw">
                    <x-creature name="lanternfish" class="{{ $width }}" />
                </div>
            @endforeach
            <div class="bob absolute top-[46%] right-[6%]" style="--bob-duration: 9s">
                <x-creature name="jellyfish" class="w-11 text-violet-300 opacity-80" />
            </div>
            <div class="swim swim-left absolute top-[84%]" style="--swim-duration: 30s; --swim-delay: -11s; --rest-x: 45vw">
                <x-creature name="hatchetfish" class="w-10" />
            </div>
            @break

        @case(DepthZone::Midnight)
            <div class="swim absolute top-[60%]" style="--swim-duration: 58s; --swim-delay: -18s; --rest-x: 60vw">
                <x-creature name="anglerfish" class="w-24 sm:w-32" />
            </div>
            <div class="swim swim-left absolute top-[22%]" style="--swim-duration: 24s; --swim-delay: -5s; --rest-x: 20vw">
                <x-creature name="lanternfish" class="w-14" />
            </div>
            <div class="swim swim-left absolute top-[26%]" style="--swim-duration: 24s; --swim-delay: -7s; --rest-x: 28vw">
                <x-creature name="lanternfish" class="w-10" />
            </div>
            <div class="swim absolute top-[44%]" style="--swim-duration: 30s; --swim-delay: -22s; --rest-x: 80vw">
                <x-creature name="lanternfish" class="w-12" />
            </div>
            <div class="bob absolute top-[10%] right-[10%]" style="--bob-duration: 8s">
                <x-creature name="jellyfish" class="w-12 text-cyan-300" />
            </div>
            <div class="bob absolute top-[74%] left-[8%]" style="--bob-duration: 10s">
                <x-creature name="jellyfish" class="w-9 text-fuchsia-300" />
            </div>
            <div class="swim absolute top-[12%]" style="--swim-duration: 70s; --swim-delay: -40s; --rest-x: 40vw">
                <x-creature name="shark" class="w-72 opacity-20" />
            </div>
            <div class="swim swim-left absolute top-[36%]" style="--swim-duration: 48s; --swim-delay: -26s; --rest-x: 55vw">
                <x-creature name="viperfish" class="w-20" />
            </div>
            @break

        @case(DepthZone::Vents)
            {{-- Black smokers venting on the seafloor, with krill grazing in the warm water. --}}
            <x-creature name="black-smoker" class="absolute bottom-6 left-[6%] h-[34vh] w-auto" />
            <x-creature name="black-smoker" class="absolute bottom-4 left-[20%] hidden h-[24vh] w-auto opacity-80 sm:block" />
            <x-creature name="black-smoker" class="absolute right-[10%] bottom-6 h-[40vh] w-auto" />
            <x-creature name="black-smoker" class="absolute right-[26%] bottom-4 hidden h-[20vh] w-auto opacity-70 sm:block" />
            <div class="swim absolute top-[58%]" style="--swim-duration: 30s; --swim-delay: -10s; --rest-x: 30vw">
                <x-creature name="krill-swarm" class="w-40 opacity-80" />
            </div>
            <div class="swim swim-left absolute top-[30%]" style="--swim-duration: 66s; --swim-delay: -20s; --rest-x: 60vw">
                <x-creature name="anglerfish" class="w-20 opacity-70" />
            </div>
            <x-marine-snow />
            @break

        @case(DepthZone::Abyssal)
            <div class="bob absolute top-[56%] left-[12%]" style="--bob-duration: 6s">
                <x-creature name="dumbo-octopus" class="w-16 sm:w-20" />
            </div>
            <div class="swim absolute top-[20%]" style="--swim-duration: 72s; --swim-delay: -33s; --rest-x: 60vw">
                <x-creature name="gulper-eel" class="w-32 opacity-80" />
            </div>
            <div class="swim swim-left absolute top-[30%]" style="--swim-duration: 85s; --swim-delay: -25s; --rest-x: 20vw">
                <x-creature name="giant-squid" class="w-[22rem] opacity-90 sm:w-[36rem]" />
            </div>
            <div class="bob absolute top-[70%] right-[12%]" style="--bob-duration: 11s">
                <x-creature name="jellyfish" class="w-10 text-cyan-200 opacity-70" />
            </div>
            <div class="swim absolute top-[78%]" style="--swim-duration: 64s; --swim-delay: -9s; --rest-x: 15vw">
                <x-creature name="anglerfish" class="w-20 opacity-80" />
            </div>
            <div class="swim absolute top-[12%]" style="--swim-duration: 28s; --swim-delay: -14s; --rest-x: 70vw">
                <x-creature name="lanternfish" class="w-10 opacity-80" />
            </div>
            <x-marine-snow />
            @break

        @case(DepthZone::Hadal)
            <div class="swim absolute top-[66%]" style="--swim-duration: 70s; --swim-delay: -12s; --rest-x: 30vw">
                <x-creature name="snailfish" class="w-24" />
            </div>
            <div class="swim swim-left absolute top-[74%]" style="--swim-duration: 82s; --swim-delay: -50s; --rest-x: 65vw">
                <x-creature name="snailfish" class="w-16 opacity-80" />
            </div>
            <div class="swim absolute top-[58%]" style="--swim-duration: 95s; --swim-delay: -70s; --rest-x: 80vw">
                <x-creature name="snailfish" class="w-12 opacity-60" />
            </div>
            <div class="swim swim-left absolute top-[40%]" style="--swim-duration: 88s; --swim-delay: -20s; --rest-x: 25vw">
                <x-creature name="barreleye" class="w-16 opacity-80" />
            </div>
            <div class="swim swim-left absolute top-[14%]" style="--swim-duration: 120s; --swim-delay: -30s; --rest-x: 40vw">
                <x-creature name="giant-squid" class="w-80 opacity-15" />
            </div>
            <svg viewBox="0 0 1200 100" preserveAspectRatio="xMidYMax slice" class="absolute inset-x-0 bottom-0 h-24 w-full sm:h-32">
                <use href="#creature-trench-floor" x="0" width="400" height="100" />
                <use href="#creature-trench-floor" x="400" width="400" height="100" />
                <use href="#creature-trench-floor" x="800" width="400" height="100" />
            </svg>
            <x-marine-snow />
            @break

        @case(DepthZone::ChallengerDeep)
            {{-- The bottom of the trench: sheer walls, near-total darkness, and very little life. --}}
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute inset-0 size-full">
                <path d="M0 0 L14 0 L10 18 L16 34 L9 52 L15 70 L8 86 L12 100 L0 100 Z" fill="#03060d" />
                <path d="M100 0 L86 0 L91 20 L84 38 L90 56 L83 74 L89 90 L86 100 L100 100 Z" fill="#03060d" />
            </svg>
            <div class="swim absolute top-[70%]" style="--swim-duration: 110s; --swim-delay: -40s; --rest-x: 40vw">
                <x-creature name="snailfish" class="w-16 opacity-50" />
            </div>
            <svg viewBox="0 0 1200 100" preserveAspectRatio="xMidYMax slice" class="absolute inset-x-0 bottom-0 h-20 w-full sm:h-28">
                <use href="#creature-trench-floor" x="0" width="400" height="100" />
                <use href="#creature-trench-floor" x="400" width="400" height="100" />
                <use href="#creature-trench-floor" x="800" width="400" height="100" />
            </svg>
            <x-marine-snow />
            @break
    @endswitch

    <x-ocean-flora :zone="$zone" />
</div>
