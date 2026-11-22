<?php

namespace App\Enums;

/**
 * The layers and landmarks a diver passes on the way down the Mariana Trench. The five classic ocean
 * zones are joined by three famous stops: the deep scattering layer (a living cloud of krill and
 * lanternfish inside the twilight zone), the hydrothermal vents, and Challenger Deep itself.
 */
enum DepthZone: string
{
    case Sunlight = 'sunlight';
    case Twilight = 'twilight';
    case ScatteringLayer = 'scattering_layer';
    case Midnight = 'midnight';
    case Vents = 'vents';
    case Abyssal = 'abyssal';
    case Hadal = 'hadal';
    case ChallengerDeep = 'challenger_deep';

    /**
     * Depth of Challenger Deep, the bottom of the Mariana Trench, in metres.
     */
    public const int CHALLENGER_DEEP_METERS = 10935;

    public static function fromDepth(int $meters): self
    {
        foreach (array_reverse(self::cases()) as $zone) {
            if ($meters >= $zone->topMeters()) {
                return $zone;
            }
        }

        return self::Sunlight;
    }

    public function label(): string
    {
        return match ($this) {
            self::Sunlight => 'Sunlight Zone',
            self::Twilight => 'Twilight Zone',
            self::ScatteringLayer => 'Deep Scattering Layer',
            self::Midnight => 'Midnight Zone',
            self::Vents => 'Hydrothermal Vents',
            self::Abyssal => 'Abyssal Zone',
            self::Hadal => 'Hadal Zone',
            self::ChallengerDeep => 'Challenger Deep',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Sunlight => 'Warm, bright, and crowded. You never left the surface.',
            self::Twilight => 'The light fades to blue. The crowd is thinning out.',
            self::ScatteringLayer => 'A living cloud of krill and lanternfish so dense it shows up on sonar.',
            self::Midnight => 'No sunlight reaches here. Only the glowing and the strange.',
            self::Vents => 'Black smokers belch 400°C water, and tube worms thrive without any sunlight.',
            self::Abyssal => 'Near-freezing, crushing dark. Very few answers survive this deep.',
            self::Hadal => 'The trench itself. You are among the deepest minds in the sea.',
            self::ChallengerDeep => 'The deepest point in any ocean. Hardly anyone has ever been this far down.',
        };
    }

    /**
     * The depth, in metres, where this zone begins.
     */
    public function topMeters(): int
    {
        return match ($this) {
            self::Sunlight => 0,
            self::Twilight => 200,
            self::ScatteringLayer => 500,
            self::Midnight => 1000,
            self::Vents => 2500,
            self::Abyssal => 4000,
            self::Hadal => 6000,
            self::ChallengerDeep => 10000,
        };
    }
}
