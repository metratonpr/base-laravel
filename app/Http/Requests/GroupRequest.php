<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => Str::slug((string) $this->input('name')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $groupId = $this->route('group')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups', 'name')->ignore($groupId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('groups', 'slug')->ignore($groupId),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
