{{--
    Every sea creature in Krillion, defined once as an SVG <symbol> and drawn with <x-creature name="…" />.
    All creatures face right; flip them with a negative scale to swim left.
--}}
<svg xmlns="http://www.w3.org/2000/svg" class="absolute size-0 overflow-hidden" aria-hidden="true" focusable="false">
    <defs>
        <filter id="creature-glow" x="-200%" y="-200%" width="500%" height="500%">
            <feGaussianBlur stdDeviation="1.6" result="blur" />
            <feMerge>
                <feMergeNode in="blur" />
                <feMergeNode in="blur" />
                <feMergeNode in="SourceGraphic" />
            </feMerge>
        </filter>

        <linearGradient id="sardine-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#3d6fa8" />
            <stop offset="0.45" stop-color="#9fc0dc" />
            <stop offset="1" stop-color="#eef4f8" />
        </linearGradient>
        <linearGradient id="sunfish-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#7b8ea3" />
            <stop offset="1" stop-color="#d5dee8" />
        </linearGradient>
        <linearGradient id="lanternfish-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#1e293b" />
            <stop offset="1" stop-color="#52627a" />
        </linearGradient>
        <linearGradient id="angler-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#4f3a56" />
            <stop offset="1" stop-color="#1f1424" />
        </linearGradient>
        <linearGradient id="snailfish-body" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="#fbcfe8" stop-opacity="0.5" />
            <stop offset="0.6" stop-color="#fce7f3" />
            <stop offset="1" stop-color="#f9a8d4" />
        </linearGradient>
        <linearGradient id="shark-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#3f4f63" />
            <stop offset="0.55" stop-color="#64748b" />
            <stop offset="1" stop-color="#d4dce6" />
        </linearGradient>
        <linearGradient id="squid-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#c8677d" />
            <stop offset="1" stop-color="#86293f" />
        </linearGradient>
        <linearGradient id="anchovy-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#4b6f6a" />
            <stop offset="1" stop-color="#e2ecee" />
        </linearGradient>
        <linearGradient id="mackerel-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#1d6f7a" />
            <stop offset="0.5" stop-color="#7fb3bd" />
            <stop offset="1" stop-color="#eef3f5" />
        </linearGradient>
        <linearGradient id="puffer-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#d4a24c" />
            <stop offset="1" stop-color="#fef9c3" />
        </linearGradient>
        <linearGradient id="hatchet-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#e2e8f0" />
            <stop offset="0.5" stop-color="#94a3b8" />
            <stop offset="1" stop-color="#475569" />
        </linearGradient>
        <linearGradient id="viper-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#1e293b" />
            <stop offset="1" stop-color="#3b4a63" />
        </linearGradient>
        <clipPath id="reef-fish-clip">
            <path d="M10 20 C14 6 42 4 58 17 C60 19 60 21 58 23 C42 36 14 34 10 20 Z" />
        </clipPath>
    </defs>

    {{-- Schooler: a sardine --}}
    <symbol id="creature-sardine" viewBox="0 0 60 24">
        <path d="M11 12 L1 4 Q4.5 12 1 20 Z" fill="#5b86b8" />
        <path d="M30 6.5 L36 2 L38.5 7 Z" fill="#5b86b8" />
        <path d="M9 12 C17 4 42 3 58 11 C43 20 17 20 9 12 Z" fill="url(#sardine-body)" />
        <path d="M14 12.6 C26 11.2 40 11.2 52 12.2" stroke="#ffffff" stroke-opacity="0.55" stroke-width="0.8" fill="none" />
        <path d="M47.5 7 Q45.5 11.5 47.5 16" stroke="#1e3a5f" stroke-opacity="0.45" stroke-width="0.8" fill="none" />
        <circle cx="52" cy="10" r="1.8" fill="#0f172a" />
        <circle cx="52.5" cy="9.5" r="0.6" fill="#ffffff" />
    </symbol>

    <symbol id="creature-fish-school" viewBox="0 0 200 90">
        <use href="#creature-sardine" x="120" y="6" width="60" height="24" />
        <use href="#creature-sardine" x="78" y="20" width="54" height="22" />
        <use href="#creature-sardine" x="138" y="38" width="60" height="24" />
        <use href="#creature-sardine" x="38" y="8" width="48" height="19" />
        <use href="#creature-sardine" x="94" y="50" width="50" height="20" />
        <use href="#creature-sardine" x="18" y="42" width="52" height="21" />
        <use href="#creature-sardine" x="58" y="66" width="46" height="18" />
        <use href="#creature-sardine" x="148" y="68" width="42" height="17" />
    </symbol>

    {{-- Reef Dweller: a striped reef fish --}}
    <symbol id="creature-reef-fish" viewBox="0 0 64 40">
        <path d="M12 20 L1 9 Q5 20 1 31 Z" fill="#f97316" />
        <path d="M26 9 Q34 0 45 7 Z" fill="#ea580c" />
        <path d="M30 31 Q36 39 42 32 Z" fill="#ea580c" />
        <path d="M10 20 C14 6 42 4 58 17 C60 19 60 21 58 23 C42 36 14 34 10 20 Z" fill="#fb923c" />
        <g clip-path="url(#reef-fish-clip)" stroke="#1c1917" stroke-width="1">
            <rect x="44" y="-2" width="5" height="44" fill="#ffffff" />
            <rect x="28" y="-2" width="6" height="44" fill="#ffffff" />
            <rect x="13" y="-2" width="3" height="44" fill="#ffffff" />
        </g>
        <path d="M38 22 Q45 27 40 30 Z" fill="#ea580c" />
        <circle cx="52" cy="17" r="2.4" fill="#1c1917" />
        <circle cx="52.7" cy="16.3" r="0.8" fill="#ffffff" />
    </symbol>

    {{-- Drifter: an ocean sunfish, which drifts with the currents --}}
    <symbol id="creature-sunfish" viewBox="0 0 80 90">
        <path d="M36 25 Q40 2 51 3 Q48 14 49 25 Z" fill="#7b8ea3" />
        <path d="M36 65 Q40 88 51 87 Q48 76 49 65 Z" fill="#8fa1b5" />
        <path d="M17 29 Q9 33 14 38 Q7 42 14 46 Q7 50 14 54 Q9 58 17 61 Z" fill="#8fa1b5" />
        <ellipse cx="42" cy="45" rx="28" ry="24" fill="url(#sunfish-body)" />
        <g fill="#ffffff" fill-opacity="0.25">
            <circle cx="30" cy="40" r="2.5" />
            <circle cx="38" cy="54" r="2" />
            <circle cx="47" cy="34" r="1.8" />
            <circle cx="28" cy="52" r="1.6" />
        </g>
        <path d="M54 48 Q61 52 55 57 Z" fill="#7b8ea3" />
        <circle cx="60" cy="40" r="2.6" fill="#1e293b" />
        <circle cx="60.8" cy="39.2" r="0.8" fill="#ffffff" />
        <circle cx="69" cy="46" r="1.6" fill="#334155" />
    </symbol>

    {{-- Lanternfish: a small deep-sea fish lined with glowing photophores --}}
    <symbol id="creature-lanternfish" viewBox="0 0 64 28">
        <path d="M11 14 L1 6 Q4 14 1 22 Z" fill="#334155" />
        <path d="M30 7 L35 3 L37.5 8 Z" fill="#334155" />
        <path d="M9 14 C17 5 44 4 60 12 C46 23 17 23 9 14 Z" fill="url(#lanternfish-body)" />
        <circle cx="52" cy="11.5" r="3.4" fill="#e2e8f0" />
        <circle cx="52.6" cy="11.5" r="2" fill="#0f172a" />
        <g fill="#67e8f9" filter="url(#creature-glow)">
            <circle cx="16" cy="16.6" r="0.9" />
            <circle cx="21" cy="17.6" r="0.9" />
            <circle cx="26" cy="18.1" r="0.9" />
            <circle cx="31" cy="18.3" r="0.9" />
            <circle cx="36" cy="18.1" r="0.9" />
            <circle cx="41" cy="17.6" r="0.9" />
            <circle cx="46" cy="16.6" r="0.9" />
            <circle cx="56.5" cy="15" r="1.2" />
            <animate attributeName="opacity" values="1;0.45;1" dur="3s" repeatCount="indefinite" />
        </g>
    </symbol>

    {{-- Anglerfish: a fanged hunter with a glowing lure --}}
    <symbol id="creature-anglerfish" viewBox="0 0 96 72">
        <path d="M18 38 L3 26 Q8 38 3 52 Z" fill="#3b2a3f" />
        <path d="M38 17 L42 9 L45 16 L49 8 L52 16 Z" fill="#3b2a3f" />
        <path d="M16 38 C16 18 44 12 64 20 C78 26 86 36 84 44 C78 58 46 64 28 56 C21 52 16 46 16 38 Z" fill="url(#angler-body)" />
        <g fill="#ffffff" fill-opacity="0.08">
            <circle cx="34" cy="30" r="3" />
            <circle cx="44" cy="44" r="2.4" />
            <circle cx="28" cy="46" r="2" />
        </g>
        <path d="M63 38 Q80 31 88 42 Q79 55 62 48 Q66 43 63 38 Z" fill="#12090f" />
        <path d="M66.5 37.6 L68.6 42.2 L70.8 36.4 L72.9 41.6 L75 35.6 L77.1 41 L79.2 35.9 L81.2 40.5 L83.4 37" fill="none" stroke="#f1f5f9" stroke-width="1.2" stroke-linejoin="miter" />
        <path d="M65.5 47 L68 43.2 L70.6 48.4 L73.2 43.8 L75.8 48.8 L78.4 44.6 L81 47.6" fill="none" stroke="#f1f5f9" stroke-width="1.2" stroke-linejoin="miter" />
        <path d="M44 44 Q51 54 40 56 Z" fill="#2d1f31" />
        <circle cx="62" cy="28" r="2.6" fill="#d9f99d" fill-opacity="0.85" />
        <circle cx="62.5" cy="28" r="1.2" fill="#000000" />
        <path d="M58 19 Q69 -1 84 8" stroke="#6b5571" stroke-width="1.6" fill="none" stroke-linecap="round" />
        <circle cx="84" cy="10.5" r="3.6" fill="#fde68a" filter="url(#creature-glow)">
            <animate attributeName="r" values="3.1;4.4;3.1" dur="2.4s" repeatCount="indefinite" />
        </circle>
    </symbol>

    {{-- Snailfish: the pale, ghostly fish of the hadal trenches --}}
    <symbol id="creature-snailfish" viewBox="0 0 76 36">
        <path d="M8 17.5 C20 12 34 9 46 8" stroke="#fbcfe8" stroke-width="3" stroke-opacity="0.5" fill="none" stroke-linecap="round" />
        <path d="M8 18.5 C20 24 34 27 46 28" stroke="#fbcfe8" stroke-width="3" stroke-opacity="0.5" fill="none" stroke-linecap="round" />
        <path d="M70 17 C70 7 56 4 47 8 C34 12 17 14 3 17.5 C17 21 34 23 47 27 C56 31 70 27 70 17 Z" fill="url(#snailfish-body)" fill-opacity="0.92" />
        <ellipse cx="52" cy="19" rx="7" ry="4" fill="#f472b6" fill-opacity="0.25" />
        <path d="M54 22 Q58 32 50 32 Z" fill="#fbcfe8" fill-opacity="0.75" />
        <circle cx="62" cy="14" r="1.8" fill="#1e1b4b" />
    </symbol>

    <symbol id="creature-shark" viewBox="0 0 200 80">
        <path d="M26 40 L4 6 Q14 30 18 40 Q12 52 6 72 Z" fill="#475569" />
        <path d="M104 26 L120 2 Q124 14 132 25 Z" fill="#475569" />
        <path d="M52 34 L58 26 L62 33 Z" fill="#475569" />
        <path d="M14 40 C40 30 118 22 168 29 C184 32 194 37 198 42 C190 48 172 52 150 53 C110 55 50 51 14 40 Z" fill="url(#shark-body)" />
        <path d="M136 50 L118 74 Q134 66 150 52 Z" fill="#475569" />
        <path d="M158 36 Q156 42 158 47 M163 35 Q161 41 163 46 M168 35 Q166 41 168 46" stroke="#334155" stroke-width="1.2" fill="none" />
        <path d="M176 46 Q186 47 194 44" stroke="#334155" stroke-width="1.2" fill="none" />
        <circle cx="182" cy="37" r="2" fill="#0f172a" />
    </symbol>

    {{-- Jellyfish: tinted with currentColor so each one can glow differently --}}
    <symbol id="creature-jellyfish" viewBox="0 0 60 96">
        <g stroke="currentColor" stroke-opacity="0.6" stroke-width="1.4" fill="none" stroke-linecap="round">
            <path d="M14 34 C10 48 18 58 12 72 C8 82 14 88 12 94">
                <animate attributeName="d" dur="4s" repeatCount="indefinite" values="M14 34 C10 48 18 58 12 72 C8 82 14 88 12 94;M14 34 C18 48 10 58 16 72 C20 82 12 88 15 94;M14 34 C10 48 18 58 12 72 C8 82 14 88 12 94" />
            </path>
            <path d="M22 35 C26 50 18 60 23 76 C26 86 20 90 22 96">
                <animate attributeName="d" dur="5s" repeatCount="indefinite" values="M22 35 C26 50 18 60 23 76 C26 86 20 90 22 96;M22 35 C18 50 26 60 20 76 C17 86 24 90 21 96;M22 35 C26 50 18 60 23 76 C26 86 20 90 22 96" />
            </path>
            <path d="M38 35 C34 50 42 60 37 76 C34 86 40 90 38 96">
                <animate attributeName="d" dur="4.5s" repeatCount="indefinite" values="M38 35 C34 50 42 60 37 76 C34 86 40 90 38 96;M38 35 C42 50 34 60 40 76 C43 86 36 90 39 96;M38 35 C34 50 42 60 37 76 C34 86 40 90 38 96" />
            </path>
            <path d="M46 34 C50 48 42 58 48 72 C52 82 46 88 48 94">
                <animate attributeName="d" dur="3.6s" repeatCount="indefinite" values="M46 34 C50 48 42 58 48 72 C52 82 46 88 48 94;M46 34 C42 48 50 58 44 72 C40 82 48 88 45 94;M46 34 C50 48 42 58 48 72 C52 82 46 88 48 94" />
            </path>
            <path d="M27 35 C24 46 32 54 28 64" stroke-width="3.2" stroke-opacity="0.45" />
            <path d="M33 35 C36 46 28 54 32 64" stroke-width="3.2" stroke-opacity="0.45" />
        </g>
        <g filter="url(#creature-glow)">
            <path d="M6 32 C6 10 54 10 54 32 C48 36 42 33 36 36 C30 33 24 37 18 34 C14 36 10 34 6 32 Z" fill="currentColor" fill-opacity="0.55" />
            <path d="M14 24 C18 16 30 14 38 18" stroke="#ffffff" stroke-opacity="0.5" stroke-width="1.5" fill="none" stroke-linecap="round" />
        </g>
    </symbol>

    <symbol id="creature-giant-squid" viewBox="0 0 320 120">
        <g transform="translate(150 60)">
            <g stroke="#9b3b4a" fill="none" stroke-linecap="round">
                <animateTransform attributeName="transform" type="skewY" values="0;4;0;-4;0" dur="6s" repeatCount="indefinite" />
                <path d="M0 0 C-60 -10 -100 10 -146 -6" stroke-width="2.2" />
                <path d="M0 2 C-60 14 -110 26 -148 18" stroke-width="2.2" />
                <ellipse cx="-146" cy="-6" rx="7" ry="3.5" fill="#9b3b4a" stroke="none" />
                <ellipse cx="-148" cy="18" rx="7" ry="3.5" fill="#9b3b4a" stroke="none" />
                <path d="M0 -8 C-30 -24 -60 -26 -96 -32" stroke-width="4" />
                <path d="M0 -6 C-40 -14 -70 -4 -110 -12" stroke-width="5" />
                <path d="M0 -2 C-40 -4 -80 6 -120 0" stroke-width="5" />
                <path d="M0 2 C-40 8 -76 16 -116 14" stroke-width="5" />
                <path d="M0 6 C-36 18 -66 24 -100 30" stroke-width="5" />
                <path d="M0 8 C-30 28 -50 36 -86 42" stroke-width="4" />
            </g>
        </g>
        <path d="M276 50 L316 30 L304 60 Z" fill="#a8455a" />
        <path d="M276 66 L316 88 L304 58 Z" fill="#a8455a" />
        <path d="M174 46 C210 34 270 36 300 58 C270 82 210 84 174 74 Z" fill="url(#squid-body)" />
        <g fill="#7f1d34" fill-opacity="0.45">
            <circle cx="214" cy="52" r="3" />
            <circle cx="236" cy="66" r="2.4" />
            <circle cx="256" cy="54" r="2" />
            <circle cx="198" cy="66" r="2.2" />
        </g>
        <path d="M140 48 C150 42 172 44 178 50 L178 70 C172 76 150 78 140 72 Z" fill="#b4556a" />
        <circle cx="160" cy="58" r="7" fill="#f1f5f9" />
        <circle cx="161" cy="58" r="4.5" fill="#0f172a" />
        <circle cx="162.5" cy="56.5" r="1.3" fill="#ffffff" />
    </symbol>

    {{-- A strip of shallow reef: rock, staghorn and brain coral, a sea fan, tube coral, kelp and an anemone --}}
    <symbol id="creature-coral-reef" viewBox="0 0 400 140">
        <g stroke="#f472b6" stroke-width="3" stroke-linecap="round" fill="none">
            <path d="M20 108 L12 90 M20 108 L16 86 M20 108 L22 85 M20 108 L28 88 M20 108 L32 94" />
        </g>
        <g fill="none" stroke-linecap="round">
            <path d="M350 112 C342 90 358 76 348 58 C342 46 352 36 348 22" stroke="#22c55e" stroke-width="5">
                <animateTransform attributeName="transform" type="rotate" values="-4 350 112;4 350 112;-4 350 112" dur="5s" repeatCount="indefinite" />
            </path>
            <path d="M372 112 C366 96 378 86 370 70 C366 62 372 54 370 46" stroke="#16a34a" stroke-width="4">
                <animateTransform attributeName="transform" type="rotate" values="3 372 112;-5 372 112;3 372 112" dur="6s" repeatCount="indefinite" />
            </path>
        </g>
        <g stroke="#fb923c" stroke-width="6" stroke-linecap="round" fill="none">
            <path d="M60 108 L60 64 M60 88 L44 66 M60 78 L76 54 M44 66 L38 50 M76 54 L84 40 M60 64 L56 46" />
        </g>
        <path d="M208 106 C176 70 192 30 214 26 C238 28 252 66 226 106 Z" fill="#a855f7" fill-opacity="0.85" />
        <path d="M216 104 L214 40 M216 90 L196 60 M216 80 L234 50 M214 60 L204 40 M216 70 L240 70" stroke="#7e22ce" stroke-width="1.5" fill="none" />
        <g fill="#facc15">
            <rect x="282" y="74" width="10" height="36" rx="5" />
            <rect x="296" y="62" width="10" height="48" rx="5" />
            <rect x="310" y="80" width="9" height="30" rx="4.5" />
        </g>
        <g fill="#a16207">
            <ellipse cx="287" cy="77" rx="3" ry="1.6" />
            <ellipse cx="301" cy="65" rx="3" ry="1.6" />
            <ellipse cx="314.5" cy="83" rx="2.6" ry="1.4" />
        </g>
        <ellipse cx="130" cy="106" rx="28" ry="18" fill="#f0abfc" />
        <path d="M108 102 Q116 94 124 102 T140 102 T156 102 M112 110 Q120 102 128 110 T144 110" stroke="#c026d3" stroke-opacity="0.5" stroke-width="2" fill="none" />
        <path d="M0 140 L0 112 Q30 100 60 108 Q90 96 130 110 Q170 96 210 104 Q250 92 290 106 Q330 96 360 108 Q380 102 400 108 L400 140 Z" fill="#3f2a4d" />
        <path d="M250 99 L252.5 104 L258 104.5 L254 108 L255.5 113 L250 110.5 L244.5 113 L246 108 L242 104.5 L247.5 104 Z" fill="#f87171" />
    </symbol>

    {{-- Alternative species for each fish class --}}

    {{-- Common: an anchovy, slim and silver with a bright side stripe --}}
    <symbol id="creature-anchovy" viewBox="0 0 60 20">
        <path d="M10 10 L1 4 Q4 10 1 16 Z" fill="#6b8f8a" />
        <path d="M8 10 C16 4 44 4 58 9 C44 15 16 16 8 10 Z" fill="url(#anchovy-body)" />
        <path d="M12 10.4 L52 9.6" stroke="#f8fafc" stroke-width="1.4" stroke-opacity="0.9" />
        <path d="M32 6 L36 3 L38 6.5 Z" fill="#6b8f8a" />
        <circle cx="52" cy="8.6" r="1.6" fill="#0f172a" />
        <circle cx="52.4" cy="8.2" r="0.5" fill="#ffffff" />
    </symbol>

    {{-- Common: a mackerel, with wavy dark bands along its back --}}
    <symbol id="creature-mackerel" viewBox="0 0 70 26">
        <path d="M12 13 L1 4 L5 13 L1 22 Z" fill="#1e5a6e" />
        <path d="M30 6 L35 1 L38 6 Z" fill="#1e5a6e" />
        <path d="M10 13 C20 4 50 3 68 12 C52 21 20 22 10 13 Z" fill="url(#mackerel-body)" />
        <path d="M18 8 q2 3 0 5 M24 7 q2 3 0 5 M30 6.5 q2 3 0 5 M36 6.5 q2 3 0 5 M42 7 q2 3 0 5 M48 8 q2 3 0 4" stroke="#0b2f3a" stroke-width="1.3" fill="none" stroke-linecap="round" />
        <circle cx="61" cy="11" r="1.8" fill="#0f172a" />
        <circle cx="61.5" cy="10.5" r="0.6" fill="#ffffff" />
    </symbol>

    {{-- Uncommon: a blue tang, royal blue with a black palette mark and yellow tail --}}
    <symbol id="creature-blue-tang" viewBox="0 0 64 44">
        <path d="M12 22 L2 12 Q6 22 2 32 Z" fill="#facc15" />
        <path d="M10 22 C14 8 40 4 56 16 C60 19 60 25 56 28 C40 40 14 36 10 22 Z" fill="#2563eb" />
        <path d="M18 18 C26 12 40 10 50 16 C42 16 34 18 30 24 C34 26 40 26 44 30 C34 32 22 28 18 18 Z" fill="#0b1020" />
        <path d="M14 14 C24 6 42 4 52 12" stroke="#1e3a8a" stroke-width="3" fill="none" stroke-linecap="round" />
        <path d="M40 24 q7 2 4 7 Z" fill="#fde047" />
        <circle cx="51" cy="18" r="2.4" fill="#0b1020" />
        <circle cx="51.7" cy="17.3" r="0.8" fill="#ffffff" />
    </symbol>

    {{-- Uncommon: a butterflyfish, a yellow disc with an eye band and a false eye-spot --}}
    <symbol id="creature-butterflyfish" viewBox="0 0 56 50">
        <path d="M14 14 C20 2 34 2 42 12 Z" fill="#facc15" />
        <path d="M14 36 C22 48 34 46 40 38 Z" fill="#fde047" />
        <path d="M8 25 L1 18 L1 32 Z" fill="#fef08a" />
        <ellipse cx="26" cy="25" rx="20" ry="16" fill="#fde047" />
        <path d="M14 16 L22 36 M20 12 L30 38 M28 11 L36 36" stroke="#f59e0b" stroke-width="1.5" stroke-opacity="0.6" />
        <path d="M38 12 Q42 25 38 38" stroke="#111827" stroke-width="4" fill="none" />
        <circle cx="16" cy="20" r="3" fill="#111827" />
        <circle cx="16" cy="20" r="4.5" fill="none" stroke="#ffffff" stroke-width="1" />
        <path d="M45 24 L54 25 L45 27 Z" fill="#fbbf24" />
        <circle cx="40.5" cy="22" r="1.4" fill="#ffffff" />
    </symbol>

    {{-- Rare: a pufferfish, puffed up and spiky --}}
    <symbol id="creature-pufferfish" viewBox="0 0 60 52">
        <path d="M10 27 L2 20 L2 34 Z" fill="#d97706" />
        <g fill="#b45309">
            @foreach (range(0, 345, 15) as $angle)
                @php
                    $radians = deg2rad($angle);
                    [$cos, $sin] = [cos($radians), sin($radians)];
                    $spike = sprintf('M%.1f %.1f L%.1f %.1f L%.1f %.1f Z',
                        30 + 19 * cos($radians - 0.08), 27 + 19 * sin($radians - 0.08),
                        30 + 24 * $cos, 27 + 24 * $sin,
                        30 + 19 * cos($radians + 0.08), 27 + 19 * sin($radians + 0.08));
                @endphp
                <path d="{{ $spike }}" />
            @endforeach
        </g>
        <circle cx="30" cy="27" r="20" fill="url(#puffer-body)" />
        <g fill="#92400e" fill-opacity="0.5">
            <circle cx="22" cy="16" r="1.6" />
            <circle cx="30" cy="12" r="1.4" />
            <circle cx="18" cy="24" r="1.3" />
            <circle cx="26" cy="20" r="1.2" />
            <circle cx="34" cy="17" r="1.2" />
        </g>
        <path d="M30 32 q7 6 1 9 Z" fill="#f59e0b" />
        <circle cx="40" cy="21" r="4.5" fill="#ffffff" />
        <circle cx="41" cy="21" r="2.6" fill="#0f172a" />
        <ellipse cx="50" cy="29" rx="2" ry="1.4" fill="#92400e" />
    </symbol>

    {{-- Rare: a seahorse, upright with a curled tail --}}
    <symbol id="creature-seahorse" viewBox="0 0 44 76">
        <path d="M24 6 C30 4 34 8 33 13 L42 15 L42 18 L32 19 C30 22 31 26 28 30 C34 34 34 44 28 50 C24 54 20 58 20 64 C20 70 26 72 28 68 C30 65 26 63 24 65" stroke="#f59e0b" stroke-width="7" fill="none" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M27 34 C31 38 31 44 27 48" stroke="#fde68a" stroke-width="1.5" stroke-dasharray="1.5 2" fill="none" />
        <path d="M22 34 q-9 4 -4 11 Z" fill="#fcd34d" />
        <path d="M22 5 l-2 -4 M26 4 l0 -4" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" />
        <circle cx="29" cy="11" r="1.6" fill="#0f172a" />
    </symbol>

    {{-- Epic: a hatchetfish, deep and silver with upturned eyes and a glowing belly --}}
    <symbol id="creature-hatchetfish" viewBox="0 0 50 44">
        <path d="M8 14 L1 10 L2 18 Z" fill="#94a3b8" />
        <path d="M8 14 L40 10 C46 10 48 14 46 18 C42 30 30 40 18 40 C12 34 8 24 8 14 Z" fill="url(#hatchet-body)" />
        <g fill="#67e8f9" filter="url(#creature-glow)">
            @foreach ([[14, 30], [18, 34], [23, 36.5], [28, 36], [33, 33], [38, 28], [42, 22]] as [$x, $y])
                <circle cx="{{ $x }}" cy="{{ $y }}" r="0.9" />
            @endforeach
            <animate attributeName="opacity" values="1;0.4;1" dur="3.2s" repeatCount="indefinite" />
        </g>
        <circle cx="38" cy="14" r="4.5" fill="#e2e8f0" />
        <circle cx="38" cy="12.8" r="3" fill="#0f172a" />
        <path d="M46 16 l3 -3" stroke="#334155" stroke-width="1" />
    </symbol>

    {{-- Legendary: a viperfish, with fangs too big for its mouth and a glowing lure --}}
    <symbol id="creature-viperfish" viewBox="0 0 84 36">
        <path d="M6 18 L0 12 L0 24 Z" fill="#1e293b" />
        <path d="M4 18 C20 8 56 6 72 12 C78 14 80 18 78 22 C60 28 24 28 4 18 Z" fill="url(#viper-body)" />
        <path d="M48 9 Q52 -2 60 2" stroke="#475569" stroke-width="1" fill="none" />
        <circle cx="60" cy="2.5" r="1.6" fill="#a5f3fc" filter="url(#creature-glow)">
            <animate attributeName="opacity" values="1;0.4;1" dur="2.2s" repeatCount="indefinite" />
        </circle>
        <path d="M70 16 L82 15 L78 20 Z" fill="#0b1120" />
        <path d="M74 13 L75 22 M78 14 L79 21 M71 21 L72 12" stroke="#f8fafc" stroke-width="1" stroke-linecap="round" />
        <circle cx="67" cy="13" r="2.2" fill="#e2e8f0" />
        <circle cx="67.4" cy="13" r="1.2" fill="#000000" />
        <g fill="#67e8f9" filter="url(#creature-glow)">
            @foreach ([14, 22, 30, 38, 46, 54, 62] as $x)
                <circle cx="{{ $x }}" cy="{{ 22.5 - abs($x - 38) / 12 }}" r="0.8" />
            @endforeach
        </g>
    </symbol>

    {{-- Legendary: a gulper eel, mostly mouth, with a whip tail tipped in light --}}
    <symbol id="creature-gulper-eel" viewBox="0 0 110 44">
        <path d="M72 24 C56 30 40 20 26 26 C16 30 8 28 2 22" stroke="#1f2937" stroke-width="3" fill="none" stroke-linecap="round" />
        <path d="M70 22 C80 4 104 4 108 14 C104 26 92 34 74 28 Z" fill="#111827" />
        <path d="M78 16 C88 10 100 12 104 16 C96 20 86 22 78 20 Z" fill="#000000" />
        <circle cx="96" cy="10" r="1.3" fill="#94a3b8" />
        <circle cx="2.5" cy="22" r="2" fill="#f472b6" filter="url(#creature-glow)">
            <animate attributeName="opacity" values="1;0.3;1" dur="1.8s" repeatCount="indefinite" />
        </circle>
    </symbol>

    {{-- Mythic: a barreleye, whose see-through head shows its glowing green tube eyes --}}
    <symbol id="creature-barreleye" viewBox="0 0 72 42">
        <path d="M10 24 L1 17 L2 31 Z" fill="#475569" />
        <path d="M8 24 C14 14 34 12 50 16 C58 18 62 24 58 30 C40 36 18 34 8 24 Z" fill="#334155" />
        <path d="M34 28 q4 12 -6 12 Z" fill="#94a3b8" fill-opacity="0.5" />
        <path d="M38 16 C40 2 64 2 66 16 Z" fill="#a5f3fc" fill-opacity="0.18" stroke="#cffafe" stroke-opacity="0.6" stroke-width="1" />
        <g filter="url(#creature-glow)">
            <rect x="47" y="6" width="5" height="10" rx="2.5" fill="#4ade80" />
            <rect x="54" y="6" width="5" height="10" rx="2.5" fill="#22c55e" fill-opacity="0.85" />
        </g>
        <path d="M60 22 l6 -1" stroke="#1e293b" stroke-width="1.5" stroke-linecap="round" />
        <circle cx="60" cy="19" r="1.2" fill="#0f172a" />
    </symbol>

    {{-- Krill: the namesake. A translucent pink shrimp with glowing photophores. --}}
    <symbol id="creature-krill" viewBox="0 0 40 20">
        <path d="M5 12 L0 8 L1.5 12 L0 16 Z" fill="#fb7185" fill-opacity="0.8" />
        <path d="M4 12 C10 4 26 4 36 9 C30 14 16 16 4 12 Z" fill="#fda4af" fill-opacity="0.85" />
        <path d="M10 10 L12 7 M15 9.5 L17 6 M20 9 L22 5.8 M25 8.8 L27 6" stroke="#be123c" stroke-opacity="0.35" stroke-width="0.8" />
        <path d="M12 14 l-1 4 M16 14.5 l-0.5 4 M20 14.3 l0 4 M24 13.6 l0.5 3.6 M28 12.6 l1 3.2" stroke="#fda4af" stroke-width="0.7" />
        <path d="M35 8 Q38 4 40 1 M35 9 Q39 8 40 6" stroke="#fda4af" stroke-width="0.6" fill="none" />
        <circle cx="33" cy="8.2" r="1.3" fill="#111827" />
        <g fill="#67e8f9" filter="url(#creature-glow)">
            <circle cx="14" cy="13.3" r="0.6" />
            <circle cx="21" cy="13.2" r="0.6" />
            <circle cx="28" cy="12" r="0.6" />
            <animate attributeName="opacity" values="1;0.3;1" dur="2.6s" repeatCount="indefinite" />
        </g>
    </symbol>

    <symbol id="creature-krill-swarm" viewBox="0 0 220 110">
        @foreach ([[10, 20, 30], [40, 8, 26], [62, 34, 34], [92, 14, 24], [120, 40, 30], [150, 18, 28], [176, 46, 24], [30, 56, 28], [70, 72, 22], [104, 64, 30], [140, 80, 26], [186, 76, 22], [8, 86, 20], [56, 92, 18], [160, 4, 20], [196, 30, 18]] as [$x, $y, $width])
            <use href="#creature-krill" x="{{ $x }}" y="{{ $y }}" width="{{ $width }}" height="{{ $width / 2 }}" />
        @endforeach
    </symbol>

    {{-- Black smoker: a mineral chimney with glowing cracks, venting dark plumes --}}
    <symbol id="creature-black-smoker" viewBox="0 0 80 200">
        @foreach ([0, 1.3, 2.6] as $delay)
            <circle cx="40" cy="40" r="8" fill="#1e293b">
                <animate attributeName="cy" values="40;-10" dur="4s" begin="{{ $delay }}s" repeatCount="indefinite" />
                <animate attributeName="r" values="7;22" dur="4s" begin="{{ $delay }}s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.9;0" dur="4s" begin="{{ $delay }}s" repeatCount="indefinite" />
            </circle>
        @endforeach
        <path d="M8 200 L16 150 L12 120 L22 92 L20 66 L30 44 L50 44 L58 70 L56 96 L66 124 L62 152 L72 200 Z" fill="#1c1917" />
        <path d="M26 190 L30 160 L26 130 M48 186 L46 150 L52 118 L48 92 M36 120 L40 96 L36 70" stroke="#f97316" stroke-width="1.6" fill="none" filter="url(#creature-glow)">
            <animate attributeName="stroke-opacity" values="0.9;0.4;0.9" dur="3s" repeatCount="indefinite" />
        </path>
        <ellipse cx="40" cy="45" rx="10" ry="3" fill="#fb923c" fill-opacity="0.5" filter="url(#creature-glow)" />
    </symbol>

    {{-- Dumbo octopus: a little bell with ear-like fins that flap as it hovers --}}
    <symbol id="creature-dumbo-octopus" viewBox="0 0 70 60">
        <g fill="#f9a8d4" fill-opacity="0.85">
            <path d="M18 18 C6 8 2 16 6 24 C10 26 16 24 20 22 Z">
                <animateTransform attributeName="transform" type="rotate" values="0 20 20;-14 20 20;0 20 20" dur="1.6s" repeatCount="indefinite" />
            </path>
            <path d="M52 18 C64 8 68 16 64 24 C60 26 54 24 50 22 Z">
                <animateTransform attributeName="transform" type="rotate" values="0 50 20;14 50 20;0 50 20" dur="1.6s" repeatCount="indefinite" />
            </path>
        </g>
        <path d="M14 34 C14 12 56 12 56 34 C56 40 62 48 60 56 C54 50 50 56 46 50 C42 56 38 52 35 56 C32 52 28 56 24 50 C20 56 16 50 10 56 C8 48 14 40 14 34 Z" fill="#f472b6" fill-opacity="0.9" />
        <circle cx="28" cy="28" r="3" fill="#1e1b4b" />
        <circle cx="42" cy="28" r="3" fill="#1e1b4b" />
        <circle cx="28.8" cy="27.2" r="1" fill="#ffffff" />
        <circle cx="42.8" cy="27.2" r="1" fill="#ffffff" />
    </symbol>

    {{-- Xenophyophore: a giant single-celled lump that carpets the deepest sediments --}}
    <symbol id="creature-xenophyophore" viewBox="0 0 60 40">
        <path d="M4 40 C2 28 8 22 14 24 C14 14 24 10 30 16 C34 6 46 8 46 18 C54 16 60 26 56 40 Z" fill="#d6d3d1" fill-opacity="0.55" />
        <g fill="#78716c" fill-opacity="0.5">
            <circle cx="16" cy="32" r="2" />
            <circle cx="26" cy="24" r="1.6" />
            <circle cx="38" cy="20" r="1.8" />
            <circle cx="44" cy="31" r="2.2" />
            <circle cx="31" cy="34" r="1.4" />
        </g>
    </symbol>

    {{-- Flora (and the plant-like animals that replace it in the dark): tinted with currentColor where noted --}}

    {{-- Giant kelp: a tall swaying stalk with alternating blades and gas bladders --}}
    <symbol id="creature-kelp" viewBox="0 0 60 320">
        <g>
            <animateTransform attributeName="transform" type="rotate" values="-3 30 320;3 30 320;-3 30 320" dur="7s" repeatCount="indefinite" />
            <path d="M30 320 C24 260 38 210 30 160 C22 110 36 60 30 6" stroke="#4d7c0f" stroke-width="3.5" fill="none" stroke-linecap="round" />
            <g fill-opacity="0.9">
                <path d="M29 286 C14 280 6 262 4 246 C16 254 26 266 29 286 Z" fill="#65a30d" />
                <path d="M31 250 C46 244 54 226 56 210 C44 218 34 230 31 250 Z" fill="#84cc16" />
                <path d="M30 214 C15 208 7 190 5 174 C17 182 27 194 30 214 Z" fill="#65a30d" />
                <path d="M30 176 C45 170 53 152 55 136 C43 144 33 156 30 176 Z" fill="#84cc16" />
                <path d="M28 138 C13 132 5 114 3 98 C15 106 25 118 28 138 Z" fill="#65a30d" />
                <path d="M32 100 C47 94 55 76 57 60 C45 68 35 80 32 100 Z" fill="#84cc16" />
                <path d="M30 62 C16 56 9 40 8 26 C19 33 27 44 30 62 Z" fill="#65a30d" />
            </g>
            <g fill="#bef264">
                <circle cx="29" cy="286" r="2.5" />
                <circle cx="31" cy="250" r="2.5" />
                <circle cx="30" cy="214" r="2.5" />
                <circle cx="30" cy="176" r="2.5" />
                <circle cx="28" cy="138" r="2.5" />
                <circle cx="32" cy="100" r="2.5" />
                <circle cx="30" cy="62" r="2.5" />
            </g>
        </g>
    </symbol>

    <symbol id="creature-seagrass" viewBox="0 0 90 80">
        <g fill="none" stroke-linecap="round" stroke-width="3">
            <animateTransform attributeName="transform" type="rotate" values="-3 45 80;3 45 80;-3 45 80" dur="5s" repeatCount="indefinite" />
            <path d="M10 80 Q6 50 14 12" stroke="#22c55e" />
            <path d="M20 80 Q24 46 18 4" stroke="#16a34a" />
            <path d="M30 80 Q26 54 34 20" stroke="#4ade80" />
            <path d="M40 80 Q44 40 38 2" stroke="#16a34a" />
            <path d="M50 80 Q46 50 54 14" stroke="#22c55e" />
            <path d="M60 80 Q64 48 58 8" stroke="#4ade80" />
            <path d="M70 80 Q66 56 74 24" stroke="#16a34a" />
            <path d="M80 80 Q84 52 78 18" stroke="#22c55e" />
        </g>
    </symbol>

    {{-- Barrel sponge, tinted with currentColor --}}
    <symbol id="creature-barrel-sponge" viewBox="0 0 60 70">
        <path d="M8 70 L12 18 Q30 8 48 18 L52 70 Z" fill="currentColor" />
        <ellipse cx="30" cy="18" rx="18" ry="5" fill="#000000" fill-opacity="0.35" />
        <path d="M20 66 L21 22 M30 68 L30 20 M40 66 L39 22" stroke="#000000" stroke-opacity="0.18" stroke-width="2" />
        <path d="M14 60 L16 24" stroke="#ffffff" stroke-opacity="0.2" stroke-width="2" />
    </symbol>

    {{-- Sea pen: a glowing, feather-shaped colony, tinted with currentColor --}}
    <symbol id="creature-sea-pen" viewBox="0 0 30 100">
        <path d="M15 100 L15 8" stroke="currentColor" stroke-width="2" />
        <g fill="currentColor" filter="url(#creature-glow)">
            <animate attributeName="opacity" values="0.95;0.45;0.95" dur="4s" repeatCount="indefinite" />
            @foreach ([82, 70, 58, 46, 34, 22] as $y)
                <path d="M15 {{ $y }} q-12 -4 -13 -12 q8 2 13 12 Z" />
                <path d="M15 {{ $y }} q12 -4 13 -12 q-8 2 -13 12 Z" />
            @endforeach
        </g>
    </symbol>

    {{-- Sea lily (crinoid): feathery arms on a long stalk, tinted with currentColor --}}
    <symbol id="creature-crinoid" viewBox="0 0 80 120">
        <g>
            <animateTransform attributeName="transform" type="rotate" values="-2 40 120;2 40 120;-2 40 120" dur="9s" repeatCount="indefinite" />
            <path d="M40 120 C38 96 42 74 40 52" stroke="currentColor" stroke-width="2.5" fill="none" />
            <circle cx="40" cy="50" r="4" fill="currentColor" />
            <g fill="none" stroke="currentColor" stroke-linecap="round">
                @foreach (['M40 48 C26 36 14 30 6 10', 'M40 48 C30 30 24 18 22 2', 'M40 48 C38 30 38 16 40 0', 'M40 48 C50 30 56 18 58 2', 'M40 48 C54 36 66 30 74 10', 'M40 50 C30 46 18 48 10 40', 'M40 50 C50 46 62 48 70 40'] as $arm)
                    <path d="{{ $arm }}" stroke-width="4.5" stroke-dasharray="1 2.5" stroke-opacity="0.55" />
                    <path d="{{ $arm }}" stroke-width="1.4" />
                @endforeach
            </g>
        </g>
    </symbol>

    {{-- Glass sponge (Venus' flower basket): a lattice vase, tinted with currentColor --}}
    <symbol id="creature-glass-sponge" viewBox="0 0 50 110">
        <path d="M18 110 C14 80 8 50 12 24 C14 12 20 6 25 4 C30 6 36 12 38 24 C42 50 36 80 32 110 Z" fill="currentColor" fill-opacity="0.12" stroke="currentColor" stroke-opacity="0.75" stroke-width="1.2" />
        <g fill="none" stroke="currentColor" stroke-opacity="0.45" stroke-width="0.9">
            @foreach ([[20, 12], [32, 13], [44, 14], [56, 13.5], [68, 12], [80, 10.5], [92, 9], [104, 7.5]] as [$y, $rx])
                <ellipse cx="25" cy="{{ $y }}" rx="{{ $rx }}" ry="2" />
            @endforeach
            <path d="M25 4 L25 110 M18 14 C14 50 16 90 20 110 M32 14 C36 50 34 90 30 110" />
        </g>
        <path d="M17 8 L14 2 M21 5 L20 0 M29 5 L30 0 M33 8 L36 2" stroke="currentColor" stroke-opacity="0.6" stroke-width="1" />
    </symbol>

    {{-- Giant tube worms with red plumes, as found around deep-sea vents --}}
    <symbol id="creature-tube-worms" viewBox="0 0 90 90">
        @foreach ([[14, 30], [28, 14], [42, 26], [56, 8], [70, 34]] as [$x, $top])
            <rect x="{{ $x }}" y="{{ $top }}" width="8" height="{{ 90 - $top }}" rx="4" fill="#e2e8f0" />
            <path d="M{{ $x }} {{ $top + 14 }} h8 M{{ $x }} {{ $top + 28 }} h8 M{{ $x }} {{ $top + 42 }} h8" stroke="#94a3b8" stroke-width="1" />
            <ellipse cx="{{ $x + 4 }}" cy="{{ $top - 3 }}" rx="7" ry="6" fill="#ef4444">
                <animate attributeName="ry" values="6;7.5;6" dur="{{ 3 + $loop->index * 0.4 }}s" repeatCount="indefinite" />
            </ellipse>
            <ellipse cx="{{ $x + 4 }}" cy="{{ $top - 2 }}" rx="3.5" ry="3" fill="#b91c1c" />
        @endforeach
    </symbol>

    {{-- The trench floor: jagged rock, a sea cucumber and faintly glowing amphipods --}}
    <symbol id="creature-trench-floor" viewBox="0 0 400 100">
        <path d="M0 100 L0 70 L30 58 L52 66 L80 44 L104 60 L140 52 L168 68 L200 48 L236 62 L262 50 L300 66 L330 46 L360 60 L400 52 L400 100 Z" fill="#070d18" />
        <path d="M0 70 L30 58 L52 66 L80 44 L104 60 L140 52 L168 68 L200 48 L236 62 L262 50 L300 66 L330 46 L360 60 L400 52" stroke="#1e293b" stroke-width="1.5" fill="none" />
        <ellipse cx="150" cy="62" rx="14" ry="4.5" fill="#7c2d4a" fill-opacity="0.7" />
        <g fill="#e0f2fe" filter="url(#creature-glow)">
            <path d="M60 60 q3 -3 6 0" stroke="#e0f2fe" stroke-width="1" fill="none" />
            <path d="M246 56 q3 -3 6 0" stroke="#e0f2fe" stroke-width="1" fill="none" />
            <path d="M318 52 q3 -3 6 0" stroke="#e0f2fe" stroke-width="1" fill="none" />
            <animate attributeName="opacity" values="0.9;0.3;0.9" dur="4s" repeatCount="indefinite" />
        </g>
    </symbol>
</svg>
