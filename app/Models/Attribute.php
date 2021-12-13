<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attribute extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'value' => 'array',
    ];

    protected $fillable = [
        'product_id',
        'code',
        'value',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function config(): BelongsTo
    {
        return $this->belongsTo(AttributeConfig::class, 'code', 'code');
    }
}
