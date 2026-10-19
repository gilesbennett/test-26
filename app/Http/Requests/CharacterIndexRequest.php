<?php

namespace App\Http\Requests;

use App\Models\CharacterGender;
use App\Models\CharacterStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharacterIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'name' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::enum(CharacterStatus::class)],
            'gender' => ['nullable', Rule::enum(CharacterGender::class)],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Get the validated filters with empty values removed.
     *
     * @return array<string, string>
     */
    public function filters(): array
    {
        return array_filter(
            $this->safe()->only(['name', 'status', 'gender']),
            fn(mixed $value): bool => $value !== null && $value !== '',
        );
    }

    public function page(): int
    {
        return (int)($this->validated()['page'] ?? 1);
    }
}
