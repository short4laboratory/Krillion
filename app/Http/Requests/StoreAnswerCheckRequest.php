<?php

namespace App\Http\Requests;

use App\Models\Dive;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * A check of a typed answer before it is submitted. Nothing is recorded and the clock keeps running.
 */
class StoreAnswerCheckRequest extends FormRequest
{
    /**
     * Only the diver whose dive it is, while it is in progress.
     */
    public function authorize(): bool
    {
        /** @var Dive $dive */
        $dive = $this->route('dive');

        return $dive->isOwnedBySession() && ! $dive->isComplete();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answer' => ['required', 'string', 'max:60'],
        ];
    }

    public function answer(): string
    {
        return $this->string('answer')->squish()->toString();
    }
}
