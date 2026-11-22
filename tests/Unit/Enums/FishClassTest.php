<?php

use App\Enums\FishClass;

test('each point score maps to the fish class covering its range', function (int $points, FishClass $expected) {
    expect(FishClass::fromPoints($points))->toBe($expected);
})->with([
    [0, FishClass::Schooler],
    [19, FishClass::Schooler],
    [20, FishClass::ReefDweller],
    [39, FishClass::ReefDweller],
    [40, FishClass::Drifter],
    [59, FishClass::Drifter],
    [60, FishClass::Lanternfish],
    [79, FishClass::Lanternfish],
    [80, FishClass::Anglerfish],
    [99, FishClass::Anglerfish],
    [100, FishClass::Snailfish],
]);

test('fish classes climb through video-game rarity tiers', function () {
    expect(array_map(fn (FishClass $class): string => $class->rarity(), FishClass::cases()))
        ->toBe(['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic']);
});

test('the rarer tiers use silver, green, red, purple, gold and a shimmering mythic', function () {
    expect(FishClass::Schooler->badgeClasses())->toContain('slate')
        ->and(FishClass::ReefDweller->badgeClasses())->toContain('green')
        ->and(FishClass::Drifter->badgeClasses())->toContain('red')
        ->and(FishClass::Lanternfish->badgeClasses())->toContain('purple')
        ->and(FishClass::Anglerfish->badgeClasses())->toContain('amber')
        ->and(FishClass::Snailfish->badgeClasses())->toContain('rarity-mythic');
});

test('each class can turn up as more than one species, chosen consistently by seed', function (FishClass $class) {
    $species = $class->species();
    $seen = collect(range(0, 20))->map(fn (int $seed): string => $class->speciesFor($seed)['name'])->unique();

    expect(count($species))->toBeGreaterThan(1)
        ->and($seen->count())->toBe(count($species))
        ->and($class->speciesFor(7))->toBe($class->speciesFor(7));
})->with(FishClass::cases());

test('a reef dweller can be a clownfish, a blue tang or a butterflyfish', function () {
    expect(array_column(FishClass::ReefDweller->species(), 'name'))->toBe(['Clownfish', 'Blue tang', 'Butterflyfish']);
});
