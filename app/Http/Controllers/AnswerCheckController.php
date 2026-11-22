<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerCheckRequest;
use App\Models\Dive;
use App\Services\AnswerChecker;
use Illuminate\Http\JsonResponse;

/**
 * The spell-check the answer box runs before submitting, so a typo gets "Did you mean …?"
 * and a wrong answer gets its message without leaving the page.
 */
class AnswerCheckController extends Controller
{
    public function store(StoreAnswerCheckRequest $request, Dive $dive, AnswerChecker $checker): JsonResponse
    {
        return response()->json($checker->check($dive->currentQuestion(), $request->answer())->toArray());
    }
}
