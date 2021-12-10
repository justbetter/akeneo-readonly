<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeConfig extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public function scopeGrid($builder)
    {
        return $builder->where('grid', true)
            ->orderBy('sort');
    }

    public function scopeTitle($builder)
    {
        return $builder->where('title', true);
    }

    public function scopeDescription($builder)
    {
        return $builder->where('description', true);
    }
}
