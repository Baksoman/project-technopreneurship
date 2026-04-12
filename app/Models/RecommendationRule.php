<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationRule extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'use_case',
        'category_slug',
        'budget_percentage',
        'priority',
        'scoring_weights',
    ];

    protected $casts = [
        'scoring_weights' => 'array',
        'budget_percentage' => 'float',
        'priority' => 'integer',
    ];
}
