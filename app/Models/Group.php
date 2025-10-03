<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Automatically create a slug when needed.
     */
    protected static function booted(): void
    {
        static::saving(function (Group $group): void {
            if (empty($group->slug) && ! empty($group->name)) {
                $group->slug = Str::slug($group->name);
            }
        });
    }
}
