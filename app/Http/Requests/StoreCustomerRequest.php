<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $documentType = Str::upper((string) $this->input('document_type', ''));
        $document = preg_replace('/\D/', '', (string) $this->input('document', ''));
        $cep = preg_replace('/\D/', '', (string) $this->input('cep', ''));
        $phone = $this->input('phone') ? preg_replace('/\D/', '', (string) $this->input('phone')) : null;
        $isIeIsento = filter_var($this->input('is_ie_isento', false), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;

        $payload = [
            'document_type' => $documentType,
            'document' => $document !== '' ? $document : null,
            'cep' => $cep !== '' ? $cep : null,
            'phone' => $phone,
            'is_ie_isento' => $isIeIsento,
        ];

        if ($isIeIsento) {
            $payload['ie'] = null;
        }

        $this->merge($payload);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $customerId = $this->route('customer')?->id;
        $requiresIe = $this->input('document_type') === 'CNPJ' && ! $this->boolean('is_ie_isento');

        $ieRules = ['string', 'max:14'];
        array_unshift($ieRules, $requiresIe ? 'required' : 'nullable');

        return [
            'municipality_id' => ['required', 'exists:municipalities,id'],
            'nome' => ['required', 'string', 'max:255'],
            'razao_social' => ['nullable', 'string', 'max:255'],
            'document_type' => ['required', Rule::in(['CPF', 'CNPJ'])],
            'document' => [
                'required',
                'string',
                Rule::unique('customers', 'document')->ignore($customerId),
                Rule::when($this->input('document_type') === 'CPF', ['digits:11'], ['digits:14']),
            ],
            'ie' => $ieRules,
            'is_ie_isento' => ['boolean'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:80'],
            'bairro' => ['required', 'string', 'max:120'],
            'cep' => ['required', 'string', 'digits:8'],
            'phone' => ['nullable', 'string', 'digits_between:10,11'],
            'email' => ['nullable', 'email', 'max:255'],
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
            'digits' => 'O campo :attribute deve conter exatamente :digits d?gitos.',
            'digits_between' => 'O campo :attribute deve conter entre :min e :max d?gitos.',
            'email' => 'Informe um :attribute v?lido.',
            'exists' => 'O valor informado em :attribute n?o foi encontrado.',
            'unique' => 'O valor informado para :attribute j? est? em uso.',
            'in' => 'O campo :attribute cont?m um valor inv?lido.',
            'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'municipality_id' => 'munic?pio',
            'nome' => 'nome',
            'razao_social' => 'raz?o social',
            'document_type' => 'tipo de documento',
            'document' => 'CPF/CNPJ',
            'ie' => 'inscri??o estadual',
            'is_ie_isento' => 'isento de inscri??o estadual',
            'logradouro' => 'logradouro',
            'numero' => 'n?mero',
            'complemento' => 'complemento',
            'bairro' => 'bairro',
            'cep' => 'CEP',
            'phone' => 'telefone',
            'email' => 'e-mail',
        ];
    }
}
