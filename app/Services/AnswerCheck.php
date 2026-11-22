<?php

namespace App\Services;

use App\Models\AcceptedAnswer;

/**
 * The verdict on a typed answer before it is submitted: on the answer key, a near miss, or wrong.
 */
final readonly class AnswerCheck
{
    public const string ACCEPTED = 'accepted';

    public const string SUGGESTION = 'suggestion';

    public const string REJECTED = 'rejected';

    /**
     * @param  AcceptedAnswer|null  $acceptedAnswer  The match (accepted) or the likely intended answer (suggestion).
     */
    public function __construct(
        public string $status,
        public ?AcceptedAnswer $acceptedAnswer,
        public string $message,
    ) {}

    /**
     * @return array{status: string, suggestion: string|null, message: string}
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'suggestion' => $this->status === self::SUGGESTION ? $this->acceptedAnswer?->label : null,
            'message' => $this->message,
        ];
    }
}
