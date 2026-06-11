<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prediction extends Model
{
    protected $fillable = [
        'user_id',
        'match_id',
        'home_score',
        'away_score',
        'points',
        'result_type',
        'evaluated_at',
    ];

    protected function casts(): array
    {
        return [
            'points'       => 'float',
            'evaluated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class, 'match_id');
    }
}
