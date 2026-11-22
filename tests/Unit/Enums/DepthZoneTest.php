<?php

use App\Enums\DepthZone;

test('each depth maps to the ocean zone it lies in', function (int $meters, DepthZone $expected) {
    expect(DepthZone::fromDepth($meters))->toBe($expected);
})->with([
    [0, DepthZone::Sunlight],
    [199, DepthZone::Sunlight],
    [200, DepthZone::Twilight],
    [499, DepthZone::Twilight],
    [500, DepthZone::ScatteringLayer],
    [999, DepthZone::ScatteringLayer],
    [1000, DepthZone::Midnight],
    [2499, DepthZone::Midnight],
    [2500, DepthZone::Vents],
    [3999, DepthZone::Vents],
    [4000, DepthZone::Abyssal],
    [5999, DepthZone::Abyssal],
    [6000, DepthZone::Hadal],
    [9999, DepthZone::Hadal],
    [10000, DepthZone::ChallengerDeep],
    [DepthZone::CHALLENGER_DEEP_METERS, DepthZone::ChallengerDeep],
]);

test('zones are listed from the surface down', function () {
    $tops = array_map(fn (DepthZone $zone): int => $zone->topMeters(), DepthZone::cases());

    expect($tops)->toBe([0, 200, 500, 1000, 2500, 4000, 6000, 10000]);
});
