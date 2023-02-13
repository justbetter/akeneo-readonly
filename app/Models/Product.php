<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $identifier
 * @property string $type
 * @property bool $enabled
 * @property ?string $family
 * @property ?array $categories
 * @property ?array $groups
 * @property ?string $parent
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'categories' => 'array',
        'groups' => 'array',
    ];

    protected $fillable = [
        'identifier',
        'type',
        'enabled',
        'family',
        'categories',
        'groups',
        'parent',
    ];

    public static function boot()
    {
        static::deleting(function (self $instance) {
            $instance->attributes()->delete();
        });

        parent::boot();
    }

    public function scopeSearch(Builder $query, string $term, array $searchables): Builder
    {
        $codes = collect($searchables)->pluck('code');

        return $query->whereHas('attributes', function(Builder $query) use ($term, $codes) {
            $query->whereIn('code', $codes)
                ->where(DB::raw('lower(value)'), 'LIKE', "%{$term}%")
                ->orWhere('identifier', 'LIKE', "%{$term}%");
        });
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    public function getAttributeGroups(): Collection
    {
        $attributeCodes = $this
            ->attributes()
            ->select(['code'])
            ->distinct()
            ->get();

        return AttributeConfig::query()
            ->whereIn('code', $attributeCodes)
            ->select(['code', 'data'])
            ->get()
            ->sortByDesc(fn (AttributeConfig $config) => $config->data['sort_order'])
            ->mapWithKeys(fn (AttributeConfig $config) => [$config->data['group'] => $config->data['group_labels']]);
    }

    public function getAttributesPerGroup(): array
    {
        $attributeCodes = $this
            ->attributes()
            ->select(['code'])
            ->distinct()
            ->get();

        return AttributeConfig::query()
            ->whereIn('code', $attributeCodes)
            ->select(['code', 'data'])
            ->where('visible', true)
            ->get()
            ->sortByDesc(fn (AttributeConfig $config) => $config->data['sort_order'])
            ->map(fn (AttributeConfig $config) => [
                'group' => $config->data['group'],
                'code' => $config->code,
                'labels' => $config->data['labels'],
            ])
            ->groupBy('group')
            ->toArray();
    }
}
