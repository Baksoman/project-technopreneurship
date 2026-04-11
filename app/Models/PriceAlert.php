<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceAlert extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'component_id',
        'target_price',
        'marketplace',
        'is_triggered',
        'triggered_at',
        'is_active',
    ];

    protected $casts = [
        'target_price' => 'decimal:2',
        'is_triggered' => 'boolean',
        'triggered_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
