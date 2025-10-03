<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    /** @use HasFactory<\Database\Factories\StateFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'abbreviation',
        'ibge_code',
    ];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}
