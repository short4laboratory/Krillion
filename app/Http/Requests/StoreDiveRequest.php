<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiveRequest extends FormRequest
{
    /**
     * Anyone may start a dive; no account is required.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'player_name' => ['nullable', 'string', 'max:24'],
        ];
    }

    public function playerName(): string
    {
        return $this->string('player_name')->squish()->toString() ?: 'Anonymous Krill';
    }
}
