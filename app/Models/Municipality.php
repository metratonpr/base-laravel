<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    /** @use HasFactory<\Database\Factories\MunicipalityFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'state_id',
        'name',
        'ibge_code',
        'siafi_code',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
