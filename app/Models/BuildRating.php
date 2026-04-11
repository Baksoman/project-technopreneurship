<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildRating extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'build_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
