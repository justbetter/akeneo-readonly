<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'categories' => 'array',
        'groups' => 'array'
    ];

    protected $fillable = [
        'identifier',
        'type',
        'enabled',
        'family',
        'categories',
        'groups',
        'parent'
    ];

    public static function boot()
    {
        static::deleting(function(self $instance) {
            $instance->attributes()->delete();
        });

        parent::boot();
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }
}
