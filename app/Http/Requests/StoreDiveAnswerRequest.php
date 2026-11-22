<?php

namespace App\Http\Requests;

use App\Models\AcceptedAnswer;
use App\Models\Dive;
use App\Services\AnswerCheck;
use App\Services\AnswerChecker;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * An answer to the dive's current question. It must be on the question's answer key.
 *
 * The page checks answers before submitting (see AnswerCheckController), so normally only accepted
 * answers arrive here; this is the safety net for when that check can't run. A near miss comes back
 * with a `suggestion` error carrying the suggested label.
 *
 * When the countdown runs out the page submits whatever was typed with `timed_out=1`. Those submissions
 * are never bounced back: a near miss is auto-corrected, and anything else becomes a miss. An answer
 * that arrives after the deadline (plus grace) is always a miss, whatever the browser says.
 */
class StoreDiveAnswerRequest extends FormRequest
{
    private ?AnswerCheck $check = null;

    /**
     * Only the browser that started a dive may answer for it, and only while it is in progress.
     */
    public function authorize(): bool
    {
        return $this->dive()->isOwnedBySession() && ! $this->dive()->isComplete();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answer' => [$this->ranOutOfTime() ? 'nullable' : 'required', 'string', 'max:60'],
        ];
    }

    /**
     * @return array<int, Closure(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->ranOutOfTime() || $validator->errors()->isNotEmpty()) {
                    return;
                }

                $check = $this->check();

                if ($check->status === AnswerCheck::ACCEPTED) {
                    return;
                }

                $validator->errors()->add('answer', $check->message);

                if ($check->status === AnswerCheck::SUGGESTION) {
                    $validator->errors()->add('suggestion', $check->acceptedAnswer->label);
                }
            },
        ];
    }

    public function ranOutOfTime(): bool
    {
        return $this->boolean('timed_out') || $this->dive()->isPastDeadline();
    }

    /**
     * The answer-key entry to score, or null when this is a miss: too late, nothing typed,
     * or (when the clock ran out mid-thought) nothing close enough to correct.
     */
    public function acceptedAnswer(): ?AcceptedAnswer
    {
        if ($this->dive()->isPastDeadline() || $this->answer() === '') {
            return null;
        }

        $check = $this->check();

        return match ($check->status) {
            AnswerCheck::ACCEPTED => $check->acceptedAnswer,
            AnswerCheck::SUGGESTION => $this->ranOutOfTime() ? $check->acceptedAnswer : null,
            default => null,
        };
    }

    public function answer(): string
    {
        return $this->string('answer')->squish()->toString();
    }

    private function check(): AnswerCheck
    {
        return $this->check ??= app(AnswerChecker::class)->check($this->dive()->currentQuestion(), $this->answer());
    }

    private function dive(): Dive
    {
        return $this->route('dive');
    }
}
