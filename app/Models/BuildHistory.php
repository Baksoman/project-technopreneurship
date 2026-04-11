<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildHistory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'build_id',
        'action',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }
}
