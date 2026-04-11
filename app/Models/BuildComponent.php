<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildComponent extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'build_id',
        'component_id',
        'quantity',
        'price_at_time',
        'marketplace',
    ];

    protected $casts = [
        'price_at_time' => 'decimal:2',
    ];

    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
