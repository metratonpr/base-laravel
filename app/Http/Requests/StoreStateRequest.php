<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'abbreviation' => Str::upper((string) $this->input('abbreviation', '')),
            'ibge_code' => Str::padLeft(preg_replace('/\D/', '', (string) $this->input('ibge_code', '')), 2, '0'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $stateId = $this->route('state')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'abbreviation' => ['required', 'string', 'size:2', Rule::unique('states', 'abbreviation')->ignore($stateId)],
            'ibge_code' => ['required', 'string', 'size:2', Rule::unique('states', 'ibge_code')->ignore($stateId)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute ? obrigat?rio.',
            'string' => 'O campo :attribute deve ser um texto.',
            'size' => 'O campo :attribute deve ter exatamente :size caracteres.',
            'max' => 'O campo :attribute deve ter no m?ximo :max caracteres.',
            'unique' => 'O valor informado para :attribute j? est? em uso.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'abbreviation' => 'sigla',
            'ibge_code' => 'c?digo IBGE',
        ];
    }
}

