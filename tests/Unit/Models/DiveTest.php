<?php

use App\Models\Dive;

test('a score converts to depth along the trench curve', function (int $score, int $meters) {
    expect(Dive::depthForScore($score))->toBe($meters);
})->with([
    'no points stays at the surface' => [0, 0],
    'a weak start stays in the sunlight' => [35, 167],
    'the sunlight ends at 6% of the maximum' => [42, 200],
    'a decent start reaches the scattering layer' => [150, 768],
    'half marks reach the hydrothermal vents' => [350, 3423],
    'a perfect dive reaches Challenger Deep' => [700, 10935],
]);
