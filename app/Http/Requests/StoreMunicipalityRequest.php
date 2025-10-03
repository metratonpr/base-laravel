<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreMunicipalityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ibge_code' => Str::padLeft(preg_replace('/\D/', '', (string) $this->input('ibge_code', '')), 7, '0'),
            'siafi_code' => Str::padLeft(preg_replace('/\D/', '', (string) $this->input('siafi_code', '')), 5, '0') ?: null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $municipalityId = $this->route('municipality')?->id;

        return [
            'state_id' => ['required', 'exists:states,id'],
            'name' => ['required', 'string', 'max:255'],
            'ibge_code' => ['required', 'string', 'size:7', Rule::unique('municipalities', 'ibge_code')->ignore($municipalityId)],
            'siafi_code' => ['nullable', 'string', 'max:5'],
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
            'max' => 'O campo :attribute deve ter no m?ximo :max caracteres.',
            'size' => 'O campo :attribute deve ter exatamente :size caracteres.',
            'exists' => 'O valor informado em :attribute n?o foi encontrado.',
            'unique' => 'O valor informado para :attribute j? est? em uso.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'state_id' => 'estado',
            'name' => 'munic?pio',
            'ibge_code' => 'c?digo IBGE',
            'siafi_code' => 'c?digo SIAFI',
        ];
    }
}

