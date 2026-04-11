<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'model',
        'slug',
        'description',
        'image',
        'base_price',
        'tdp',
        'performance_score',
        'specs',
        'compatibility_tags',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'specs' => 'array',
        'compatibility_tags' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ComponentCategory::class, 'category_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ComponentPrice::class);
    }

    public function performanceBenchmarks(): HasMany
    {
        return $this->hasMany(PerformanceBenchmark::class);
    }

    public function compatibilityRulesAsA(): HasMany
    {
        return $this->hasMany(CompatibilityRule::class, 'component_a_id');
    }

    public function compatibilityRulesAsB(): HasMany
    {
        return $this->hasMany(CompatibilityRule::class, 'component_b_id');
    }

    public function builds(): BelongsToMany
    {
        return $this->belongsToMany(Build::class, 'build_components')
            ->withPivot('quantity', 'price_at_time', 'marketplace')
            ->withTimestamps();
    }

    public function priceAlerts(): HasMany
    {
        return $this->hasMany(PriceAlert::class);
    }
}
