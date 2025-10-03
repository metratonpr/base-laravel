<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'municipality_id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'ie',
        'im',
        'crt',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'phone',
        'email',
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class)->with('state');
    }
}
