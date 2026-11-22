<?php

namespace App\Enums;

/**
 * How unusual an answer is, expressed as the kind of fish that gave it, with a video-game style
 * rarity tier: Common (silver), Uncommon (green), Rare (red), Epic (purple), Legendary (gold)
 * and Mythic (prismatic). Each class has a few species, so the same class can turn up as
 * different fish (a Reef Dweller might be a clownfish, a blue tang or a butterflyfish).
 */
enum FishClass: string
{
    case Schooler = 'schooler';
    case ReefDweller = 'reef_dweller';
    case Drifter = 'drifter';
    case Lanternfish = 'lanternfish';
    case Anglerfish = 'anglerfish';
    case Snailfish = 'snailfish';

    /**
     * Classify a 0–100 point answer score.
     */
    public static function fromPoints(int $points): self
    {
        return match (true) {
            $points >= 100 => self::Snailfish,
            $points >= 80 => self::Anglerfish,
            $points >= 60 => self::Lanternfish,
            $points >= 40 => self::Drifter,
            $points >= 20 => self::ReefDweller,
            default => self::Schooler,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Schooler => 'Schooler',
            self::ReefDweller => 'Reef Dweller',
            self::Drifter => 'Drifter',
            self::Lanternfish => 'Lanternfish',
            self::Anglerfish => 'Anglerfish',
            self::Snailfish => 'Snailfish',
        };
    }

    public function rarity(): string
    {
        return match ($this) {
            self::Schooler => 'Common',
            self::ReefDweller => 'Uncommon',
            self::Drifter => 'Rare',
            self::Lanternfish => 'Epic',
            self::Anglerfish => 'Legendary',
            self::Snailfish => 'Mythic',
        };
    }

    /**
     * The rarity colour, used for the bobber and anything drawn in SVG.
     */
    public function rarityColor(): string
    {
        return match ($this) {
            self::Schooler => '#e2e8f0',
            self::ReefDweller => '#4ade80',
            self::Drifter => '#f87171',
            self::Lanternfish => '#c084fc',
            self::Anglerfish => '#fbbf24',
            self::Snailfish => '#f0abfc',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Schooler => 'One of millions in the school. Everyone said that.',
            self::ReefDweller => 'Popular on the reef, with a little colour of your own.',
            self::Drifter => 'Drifting off the shelf, away from the crowd.',
            self::Lanternfish => 'A faint glow in the twilight. Few divers come this far.',
            self::Anglerfish => 'A lone light in the midnight dark. A rare answer.',
            self::Snailfish => 'A creature of the deepest trench. Hardly anyone alive would think of this.',
        };
    }

    /**
     * The species this class can appear as: [creature drawing, name].
     *
     * @return list<array{creature: string, name: string}>
     */
    public function species(): array
    {
        $species = match ($this) {
            self::Schooler => ['sardine' => 'Sardine', 'anchovy' => 'Anchovy', 'mackerel' => 'Mackerel'],
            self::ReefDweller => ['reef-fish' => 'Clownfish', 'blue-tang' => 'Blue tang', 'butterflyfish' => 'Butterflyfish'],
            self::Drifter => ['sunfish' => 'Ocean sunfish', 'pufferfish' => 'Pufferfish', 'seahorse' => 'Seahorse'],
            self::Lanternfish => ['lanternfish' => 'Lanternfish', 'hatchetfish' => 'Hatchetfish'],
            self::Anglerfish => ['anglerfish' => 'Anglerfish', 'viperfish' => 'Viperfish', 'gulper-eel' => 'Gulper eel'],
            self::Snailfish => ['snailfish' => 'Snailfish', 'barreleye' => 'Barreleye'],
        };

        return array_map(
            fn (string $creature, string $name): array => ['creature' => $creature, 'name' => $name],
            array_keys($species),
            $species,
        );
    }

    /**
     * One of this class's species, chosen by a seed (such as an answer's id) so it stays the same on every visit.
     *
     * @return array{creature: string, name: string}
     */
    public function speciesFor(int $seed): array
    {
        $species = $this->species();

        return $species[abs($seed) % count($species)];
    }

    /**
     * The class's signature creature, for legends and badges.
     */
    public function creature(): string
    {
        return $this->species()[0]['creature'];
    }

    /**
     * The inclusive point range this class covers, for display.
     */
    public function pointRange(): string
    {
        return match ($this) {
            self::Schooler => '10',
            self::ReefDweller => '20–30',
            self::Drifter => '40–50',
            self::Lanternfish => '60–70',
            self::Anglerfish => '80–90',
            self::Snailfish => '100',
        };
    }

    /**
     * Tailwind classes for this class's badge, in its rarity colour.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Schooler => 'bg-slate-200/15 text-slate-100 ring-slate-200/40',
            self::ReefDweller => 'bg-green-400/15 text-green-200 ring-green-300/50',
            self::Drifter => 'bg-red-400/15 text-red-200 ring-red-300/50',
            self::Lanternfish => 'bg-purple-400/15 text-purple-200 ring-purple-300/50',
            self::Anglerfish => 'bg-amber-300/15 text-amber-200 ring-amber-300/60',
            self::Snailfish => 'rarity-mythic bg-fuchsia-300/15 text-fuchsia-100 ring-fuchsia-200/60',
        };
    }

    /**
     * Tailwind classes for the filled part of the rarity bar.
     */
    public function rarityBarClasses(): string
    {
        return match ($this) {
            self::Schooler => 'bg-linear-to-r from-slate-400 to-slate-100',
            self::ReefDweller => 'bg-linear-to-r from-green-600 to-green-300',
            self::Drifter => 'bg-linear-to-r from-red-600 to-red-300',
            self::Lanternfish => 'bg-linear-to-r from-purple-600 to-purple-300',
            self::Anglerfish => 'bg-linear-to-r from-amber-500 to-yellow-200',
            self::Snailfish => 'rarity-mythic bg-linear-to-r from-cyan-300 via-fuchsia-300 to-amber-200',
        };
    }
}
