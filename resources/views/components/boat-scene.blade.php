{{--
    The surface: a little fishing boat at dusk, drawn as a cut-away so you can see below the waterline.
    The rod, line, bobber and splash carry ids that resources/js/cast.js animates when the first answer is cast.
    Coordinates in that script must match the ones here (rod pivot 812,506; rod tip 690,378; bobber 668,562).
--}}
<section {{ $attributes->merge(['class' => 'relative isolate flex min-h-[100svh] flex-col overflow-hidden']) }} data-boat-scene>
    <svg class="absolute inset-0 -z-10 size-full" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMax slice" aria-hidden="true">
        <defs>
            <linearGradient id="scene-sky" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#0b1026" />
                <stop offset="0.45" stop-color="#2a2a6b" />
                <stop offset="0.8" stop-color="#9a3f6b" />
                <stop offset="1" stop-color="#f59e63" />
            </linearGradient>
            <radialGradient id="scene-sun" cx="0.5" cy="0.5" r="0.5">
                <stop offset="0" stop-color="#fff1c1" />
                <stop offset="0.55" stop-color="#fdba74" />
                <stop offset="1" stop-color="#fb923c" stop-opacity="0" />
            </radialGradient>
            <linearGradient id="scene-water" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#1f7fb3" />
                <stop offset="0.5" stop-color="#145a8a" />
                <stop offset="1" stop-color="#0e3f66" stop-opacity="0" />
            </linearGradient>
            <linearGradient id="scene-ray" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#ffffff" stop-opacity="0.22" />
                <stop offset="1" stop-color="#ffffff" stop-opacity="0" />
            </linearGradient>
        </defs>

        {{-- Sky, stars, sun and clouds --}}
        <rect width="1440" height="562" fill="url(#scene-sky)" />
        <g fill="#ffffff">
            @foreach ([[120, 60, 1.4], [260, 130, 1], [410, 40, 1.2], [560, 110, 0.9], [690, 50, 1.5], [840, 140, 1], [980, 70, 1.2], [1120, 30, 1], [1260, 120, 1.4], [1380, 60, 0.9], [200, 220, 0.8], [1010, 210, 0.8], [1330, 240, 1]] as [$x, $y, $r])
                <circle cx="{{ $x }}" cy="{{ $y }}" r="{{ $r }}" opacity="0.75">
                    <animate attributeName="opacity" values="0.8;0.25;0.8" dur="{{ 3 + $loop->index % 4 }}s" repeatCount="indefinite" />
                </circle>
            @endforeach
        </g>
        <circle cx="330" cy="545" r="150" fill="url(#scene-sun)" opacity="0.6" />
        <circle cx="330" cy="548" r="62" fill="#ffd8a1" />
        <g fill="#f8b4a0" opacity="0.35">
            <ellipse cx="520" cy="430" rx="120" ry="10" />
            <ellipse cx="600" cy="446" rx="80" ry="7" />
            <ellipse cx="1150" cy="380" rx="140" ry="11" />
            <ellipse cx="1060" cy="398" rx="70" ry="6" />
        </g>

        {{-- Water, cut away below the surface --}}
        <rect y="560" width="1440" height="340" fill="url(#scene-water)" />
        <g fill="#ffd8a1" opacity="0.45">
            <rect x="282" y="572" width="96" height="3" rx="1.5" />
            <rect x="298" y="584" width="64" height="3" rx="1.5" />
            <rect x="312" y="596" width="36" height="2" rx="1" />
        </g>
        <g fill="url(#scene-ray)">
            <polygon points="420,562 470,562 380,900 300,900" />
            <polygon points="620,562 650,562 640,900 580,900" />
            <polygon points="1040,562 1090,562 1180,900 1100,900" />
        </g>
        <use href="#creature-kelp" x="160" y="640" width="52" height="280" opacity="0.6" />
        <use href="#creature-kelp" x="210" y="700" width="40" height="220" opacity="0.45" />
        <use href="#creature-kelp" x="1230" y="660" width="50" height="260" opacity="0.55" />
        <use href="#creature-seagrass" x="460" y="842" width="80" height="70" opacity="0.6" />
        <use href="#creature-seagrass" x="980" y="852" width="70" height="60" opacity="0.5" />
        <use href="#creature-fish-school" x="1060" y="690" width="180" height="81" opacity="0.55" />
        <use href="#creature-reef-fish" x="380" y="770" width="40" height="25" opacity="0.6" />

        {{-- The boat, gently bobbing; the rod, line and bobber ride along with it --}}
        <g>
            <animateTransform attributeName="transform" type="translate" values="0 0;0 4;0 0" dur="4s" repeatCount="indefinite" />

            <path d="M770 536 L990 536 Q984 560 960 590 L808 590 Q784 566 770 536 Z" fill="#9a3412" />
            <path d="M774 547 L986 547" stroke="#fef3c7" stroke-width="4" />
            <rect x="894" y="478" width="76" height="10" rx="2" fill="#7c2d12" />
            <rect x="900" y="488" width="64" height="48" fill="#f5f5f4" />
            <rect x="914" y="498" width="18" height="14" rx="2" fill="#fde68a" />
            <rect x="938" y="498" width="16" height="14" rx="2" fill="#fde68a" opacity="0.7" />
            <path d="M950 478 L950 446" stroke="#e7e5e4" stroke-width="2" />
            <circle cx="950" cy="444" r="2.5" fill="#f87171">
                <animate attributeName="opacity" values="1;0.2;1" dur="1.6s" repeatCount="indefinite" />
            </circle>

            {{-- Fisher in a yellow raincoat --}}
            <rect x="824" y="512" width="16" height="24" fill="#1e3a8a" />
            <path d="M818 516 Q818 484 832 482 Q846 484 846 516 Z" fill="#facc15" />
            <circle cx="832" cy="470" r="11" fill="#f5c9a3" />
            <path d="M818 467 Q832 448 846 467 Z" fill="#facc15" />
            <ellipse cx="832" cy="467" rx="17" ry="3.5" fill="#eab308" />
            <circle cx="836" cy="470" r="1.4" fill="#1f2937" />

            <g id="cast-rod">
                <path d="M818 512 L690 378" stroke="#a16207" stroke-width="3.5" stroke-linecap="round" />
                <circle cx="810" cy="503" r="4" fill="#44403c" />
            </g>
            <path d="M828 494 L812 506" stroke="#eab308" stroke-width="6" stroke-linecap="round" />

            <path id="cast-line" d="M690 378 Q676 470 668 562" stroke="#e2e8f0" stroke-opacity="0.85" stroke-width="1.2" fill="none" />
            <g id="cast-lure" transform="translate(668 562)">
                <path d="M0 -6 L0 -12" stroke="#e2e8f0" stroke-width="1.2" />
                <path d="M-6 0 A6 6 0 0 1 6 0 Z" fill="#ef4444" />
                <path d="M-6 0 A6 6 0 0 0 6 0 Z" fill="#f8fafc" />
            </g>
            <ellipse id="cast-splash" cx="0" cy="0" rx="0" ry="0" fill="none" stroke="#ffffff" stroke-width="2" opacity="0" />
        </g>

        {{-- Waves along the surface, in front of the hull --}}
        <g>
            <path d="M-160 560 q20 -8 40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 t40 0 V578 H-160 Z" fill="#2b93c6" opacity="0.9">
                <animateTransform attributeName="transform" type="translate" values="0 0;80 0" dur="5s" repeatCount="indefinite" />
            </path>
            <path d="M-160 566 q30 -6 60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 t60 0 V582 H-160 Z" fill="#1f7fb3" opacity="0.8">
                <animateTransform attributeName="transform" type="translate" values="0 0;-120 0" dur="7s" repeatCount="indefinite" />
            </path>
        </g>
    </svg>

    <div data-cast-veil class="pointer-events-none absolute inset-0 bg-sea-floor opacity-0 transition-opacity duration-700"></div>

    <div class="relative z-10 flex flex-1 flex-col">
        {{ $slot }}
    </div>
</section>
