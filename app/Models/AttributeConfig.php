<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property array $data
 * @property bool $visible
 * @property bool $grid
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property int $sort
 * @property bool $title
 * @property bool $description
 */
class AttributeConfig extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
        'import_filter' => 'array',
    ];

    public function scopeGrid(Builder $builder): Builder
    {
        return $builder
            ->where('grid', '=', true)
            ->orderBy('sort');
    }

    public function scopeTitle(Builder $builder): Builder
    {
        return $builder->where('title', '=', true);
    }

    public function scopeDescription(Builder $builder): Builder
    {
        return $builder->where('description', '=', true);
    }
}
