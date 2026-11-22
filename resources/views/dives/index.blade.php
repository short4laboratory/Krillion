<x-layout title="Krillion — How deep does your mind go?" surface>
    <x-boat-scene>
        <main class="mx-auto flex w-full max-w-5xl flex-col gap-10 px-4 py-8 sm:px-6 sm:py-12">
            <x-krill-logo />

            <section class="flex max-w-xl flex-col gap-5">
                <h1 class="text-4xl font-semibold tracking-tight text-balance sm:text-6xl">How deep does your mind go?</h1>
                <p class="text-lg text-pretty text-white/85">
                    Seven tricky questions, 25 seconds each. Give a correct answer nobody else would think of.
                    Cast your first answer off the boat, then sink with every obscure one,
                    down toward Challenger Deep, 10,935&nbsp;m below.
                </p>

                <form method="POST" action="{{ route('dives.store') }}" class="flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <label for="player_name" class="sr-only">Diver name</label>
                    <input
                        id="player_name"
                        name="player_name"
                        type="text"
                        maxlength="24"
                        value="{{ old('player_name') }}"
                        placeholder="Your name (optional)"
                        autocomplete="nickname"
                        class="w-full rounded-xl bg-slate-950/40 px-4 py-3 text-white ring-1 ring-white/25 backdrop-blur-sm placeholder:text-white/55 focus:ring-2 focus:ring-krill focus:outline-none sm:max-w-xs"
                    >
                    <button type="submit" class="rounded-xl bg-krill px-6 py-3 font-semibold text-slate-950 shadow-lg shadow-krill/30 transition hover:brightness-110 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">
                        Start fishing
                    </button>
                </form>
                @error('player_name')
                    <p class="text-sm text-rose-200">{{ $message }}</p>
                @enderror
            </section>
        </main>
    </x-boat-scene>

    <div class="mx-auto grid max-w-5xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2">
        <section class="flex flex-col gap-4" aria-labelledby="classes-heading">
            <div>
                <h2 id="classes-heading" class="text-xl font-semibold">What kind of fish are you?</h2>
                <p class="text-sm text-white/70">Every correct answer scores 10–100 points by how rarely people look it up on Wikipedia, and how few divers have said it.</p>
            </div>

            <ul class="flex flex-col divide-y divide-white/10 rounded-2xl bg-slate-950/30 ring-1 ring-white/10 backdrop-blur-sm">
                @foreach ($fishClasses as $fishClass)
                    <li class="flex items-center gap-4 px-4 py-3">
                        <x-creature :name="$fishClass->creature()" class="catch-glow h-10 w-16 shrink-0" style="color: {{ $fishClass->rarityColor() }}" />
                        <div class="flex min-w-0 flex-col gap-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-fish-badge :fish-class="$fishClass" />
                                <span class="text-xs text-white/50 tabular-nums">{{ $fishClass->pointRange() }} points</span>
                            </div>
                            <span class="text-sm text-white/80">{{ $fishClass->description() }}</span>
                            <span class="text-xs text-white/50">
                                Could be a {{ collect($fishClass->species())->pluck('name')->map(fn (string $name): string => strtolower($name))->join(', ', ' or ') }}.
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="flex flex-col gap-4" aria-labelledby="leaderboard-heading">
            <div>
                <h2 id="leaderboard-heading" class="text-xl font-semibold">Deepest divers</h2>
                <p class="text-sm text-white/70">The strangest minds to reach the bottom.</p>
            </div>

            @if ($leaderboard->isEmpty())
                <p class="rounded-2xl bg-slate-950/30 px-4 py-8 text-center text-sm text-white/70 ring-1 ring-white/10">
                    No one has finished a dive yet. The trench is waiting.
                </p>
            @else
                <ol class="flex flex-col divide-y divide-white/10 rounded-2xl bg-slate-950/30 ring-1 ring-white/10 backdrop-blur-sm">
                    @foreach ($leaderboard as $dive)
                        <li>
                            <a href="{{ route('dives.show', $dive) }}" class="flex items-center gap-4 px-4 py-3 transition hover:bg-white/5">
                                <span class="w-5 text-right text-sm text-white/50 tabular-nums">{{ $loop->iteration }}</span>
                                <span class="min-w-0 flex-1 truncate font-medium">{{ $dive->player_name }}</span>
                                <x-fish-badge :fish-class="$dive->fishClass()" class="hidden sm:inline-flex" />
                                <span class="text-right text-sm tabular-nums">
                                    <span class="block font-semibold">{{ number_format($dive->depthInMeters()) }} m</span>
                                    <span class="block text-xs text-white/50">{{ $dive->total_score }} pts</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>
    </div>
</x-layout>
