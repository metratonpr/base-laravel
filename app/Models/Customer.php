<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'municipality_id',
        'nome',
        'razao_social',
        'document_type',
        'document',
        'ie',
        'is_ie_isento',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'phone',
        'email',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'is_ie_isento' => 'boolean',
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class)->with('state');
    }
}
