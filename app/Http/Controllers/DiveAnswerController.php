<?php

namespace App\Http\Controllers;

use App\Enums\FishClass;
use App\Http\Requests\StoreDiveAnswerRequest;
use App\Models\Dive;
use App\Models\DiveAnswer;
use App\Services\AnswerScorer;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DiveAnswerController extends Controller
{
    /**
     * Record an answer to the current question, or a miss if the clock ran out first.
     */
    public function store(StoreDiveAnswerRequest $request, Dive $dive, AnswerScorer $scorer): RedirectResponse
    {
        $accepted = $request->acceptedAnswer();
        $typed = $request->answer();

        try {
            $diveAnswer = DB::transaction(function () use ($accepted, $typed, $dive, $scorer): DiveAnswer {
                $position = $dive->answers()->count();
                $question = $dive->currentQuestion();

                if ($accepted === null) {
                    $diveAnswer = $dive->answers()->create([
                        'question_id' => $question->id,
                        'position' => $position,
                        'points' => 0,
                        'fish_class' => FishClass::Schooler,
                        'timed_out' => true,
                    ]);
                } else {
                    $scored = $scorer->score($question, $accepted);

                    $diveAnswer = $dive->answers()->create([
                        'question_id' => $question->id,
                        'accepted_answer_id' => $accepted->id,
                        'position' => $position,
                        'answer' => $typed,
                        'answer_key' => $scored->key,
                        'points' => $scored->points,
                        'pageviews' => $scored->pageviews,
                        'prior_divers' => $scored->priorDivers,
                        'fish_class' => $scored->fishClass,
                    ]);

                    $dive->total_score += $scored->points;
                }

                $dive->question_started_at = null;

                if ($position + 1 >= Dive::QUESTIONS_PER_DIVE) {
                    $dive->completed_at = now();
                }

                $dive->save();

                return $diveAnswer;
            });
        } catch (UniqueConstraintViolationException) {
            // A double-submitted form already answered this question; just carry on.
            return redirect()->route('dives.show', $dive);
        }

        return redirect()
            ->route('dives.show', $dive)
            ->with('revealed_answer_id', $diveAnswer->id);
    }
}
