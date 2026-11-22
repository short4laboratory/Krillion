<?php

namespace App\Http\Controllers;

use App\Enums\DepthZone;
use App\Enums\FishClass;
use App\Http\Requests\StoreDiveRequest;
use App\Models\Dive;
use App\Models\Question;
use App\Services\AnswerScorer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DiveController extends Controller
{
    /**
     * How long the final catch is shown before moving on to the results.
     */
    private const int FINAL_CATCH_SECONDS = 5;

    /**
     * The surface: start a new dive and see the deepest divers.
     */
    public function index(): View
    {
        $leaderboard = Dive::query()
            ->whereNotNull('completed_at')
            ->orderByDesc('total_score')
            ->orderBy('completed_at')
            ->limit(10)
            ->get();

        return view('dives.index', [
            'leaderboard' => $leaderboard,
            'fishClasses' => FishClass::cases(),
        ]);
    }

    public function store(StoreDiveRequest $request): RedirectResponse
    {
        $questionIds = Question::query()
            ->active()
            ->inRandomOrder()
            ->limit(Dive::QUESTIONS_PER_DIVE)
            ->pluck('id');

        abort_if(
            $questionIds->count() < Dive::QUESTIONS_PER_DIVE,
            503,
            'Not enough questions are loaded. Run `php artisan db:seed --class=QuestionSeeder`.'
        );

        $dive = Dive::create([
            'player_name' => $request->playerName(),
            'question_ids' => $questionIds->all(),
        ]);

        $request->session()->push(Dive::SESSION_KEY, $dive->id);

        return redirect()->route('dives.show', $dive);
    }

    /**
     * Show the next question while diving, or the results once the dive is over.
     * Finished dives are public so results can be shared; unfinished ones belong to their diver.
     *
     * Right after an answer, the page descends from the depth before that answer to the new one.
     */
    public function show(Dive $dive, AnswerScorer $scorer): View
    {
        abort_unless($dive->isComplete() || $dive->isOwnedBySession(), 403);

        $dive->load(['answers.question', 'answers.acceptedAnswer']);
        $questions = Question::query()->findMany($dive->question_ids)->keyBy('id');
        $revealedAnswer = $dive->answers->firstWhere('id', session('revealed_answer_id'));
        $descendFromMeters = $revealedAnswer
            ? Dive::depthForScore($dive->total_score - $revealedAnswer->points)
            : null;

        // Straight after the last answer, linger on what it caught before revealing the results.
        if ($dive->isComplete() && $revealedAnswer) {
            return view('dives.catch', [
                'dive' => $dive,
                'revealedAnswer' => $revealedAnswer,
                'revealedMostCommon' => $scorer->mostCommonAnswers(collect([$revealedAnswer->question]), 1)[$revealedAnswer->question_id][0] ?? null,
                'descendFromMeters' => $descendFromMeters,
                'seconds' => self::FINAL_CATCH_SECONDS,
            ]);
        }

        if ($dive->isComplete()) {
            return view('dives.results', [
                'dive' => $dive,
                'mostCommonAnswers' => $scorer->mostCommonAnswers($questions->values()),
                'zones' => DepthZone::cases(),
                'isOwner' => $dive->isOwnedBySession(),
                'descendFromMeters' => $descendFromMeters,
            ]);
        }

        $position = $dive->answers->count();
        $dive->startQuestionClock();

        return view($position === 0 ? 'dives.cast' : 'dives.play', [
            'dive' => $dive,
            'question' => $questions->get($dive->question_ids[$position]),
            'position' => $position,
            'secondsRemaining' => $dive->secondsRemaining(),
            'revealedAnswer' => $revealedAnswer,
            'revealedMostCommon' => $revealedAnswer
                ? ($scorer->mostCommonAnswers(collect([$revealedAnswer->question]), 1)[$revealedAnswer->question_id][0] ?? null)
                : null,
            'descendFromMeters' => $descendFromMeters,
            'zones' => DepthZone::cases(),
        ]);
    }
}
