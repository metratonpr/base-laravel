<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $cnpj = preg_replace('/\D/', '', (string) $this->input('cnpj', ''));
        $cep = preg_replace('/\D/', '', (string) $this->input('cep', ''));
        $phone = $this->input('phone') ? preg_replace('/\D/', '', (string) $this->input('phone')) : null;

        $this->merge([
            'cnpj' => $cnpj !== '' ? $cnpj : null,
            'cep' => $cep !== '' ? $cep : null,
            'phone' => $phone,
            'crt' => Str::of((string) $this->input('crt'))->trim()->value(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $companyId = $this->route('company')?->id;

        return [
            'municipality_id' => ['required', 'exists:municipalities,id'],
            'razao_social' => ['required', 'string', 'max:255'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'digits:14', Rule::unique('companies', 'cnpj')->ignore($companyId)],
            'ie' => ['required', 'string', 'max:14'],
            'im' => ['nullable', 'string', 'max:15'],
            'crt' => ['required', Rule::in(['1', '2', '3'])],
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
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'municipality_id' => 'munic?pio',
            'razao_social' => 'raz?o social',
            'nome_fantasia' => 'nome fantasia',
            'cnpj' => 'CNPJ',
            'ie' => 'inscri??o estadual',
            'im' => 'inscri??o municipal',
            'crt' => 'c?digo do regime tribut?rio',
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
