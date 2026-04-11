<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Build extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'use_case',
        'experience_level',
        'budget',
        'total_price',
        'total_tdp',
        'performance_score',
        'has_bottleneck',
        'bottleneck_details',
        'status',
        'is_public',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'total_price' => 'decimal:2',
        'has_bottleneck' => 'boolean',
        'bottleneck_details' => 'array',
        'is_public' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Component::class, 'build_components')
            ->withPivot('quantity', 'price_at_time', 'marketplace')
            ->withTimestamps();
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(BuildRating::class);
    }

    public function ratingsByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'build_ratings')
            ->withPivot('rating', 'comment')
            ->withTimestamps();
    }

    public function histories(): HasMany
    {
        return $this->hasMany(BuildHistory::class);
    }
}
