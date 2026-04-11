<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompatibilityRule extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'component_a_id',
        'component_b_id',
        'status',
        'message',
        'suggestion',
    ];

    public function componentA(): BelongsTo
    {
        return $this->belongsTo(Component::class, 'component_a_id');
    }

    public function componentB(): BelongsTo
    {
        return $this->belongsTo(Component::class, 'component_b_id');
    }
}
