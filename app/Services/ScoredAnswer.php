<?php

namespace App\Services;

use App\Enums\FishClass;

final readonly class ScoredAnswer
{
    /**
     * @param  string  $key  The answer-key entry's normalized key, used to tally the crowd.
     * @param  int|null  $pageviews  Wikipedia page views over the last 60 days; null if not fetched yet.
     * @param  int  $priorDivers  Players who gave this answer before.
     */
    public function __construct(
        public string $key,
        public int $points,
        public FishClass $fishClass,
        public ?int $pageviews,
        public int $priorDivers,
    ) {}
}
