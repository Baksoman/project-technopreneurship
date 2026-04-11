<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceBenchmark extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'component_id',
        'workload',
        'workload_type',
        'result_label',
        'result_value',
        'result_unit',
    ];

    protected $casts = [
        'result_value' => 'decimal:2',
    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
