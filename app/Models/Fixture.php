<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fixture extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_time',
        'stage',
        'group',
        'venue',
        'home_score',
        'away_score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'match_time' => 'datetime',
            'home_score' => 'integer',
            'away_score' => 'integer',
        ];
    }

    // ── Relasi ────────────────────────────────────────────────
    public function homeTeam(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorldCupTeam::class, 'home_team_id');
    }

    public function awayTeam(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorldCupTeam::class, 'away_team_id');
    }

    public function predictions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Prediction::class, 'match_id');
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeLive(Builder $query): Builder
    {
        return $query->where('status', 'live');
    }

    public function scopeFinished(Builder $query): Builder
    {
        return $query->where('status', 'finished');
    }

    public function scopeByStage(Builder $query, string $stage): Builder
    {
        return $query->where('stage', $stage);
    }

    public function scopeByGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    // ── Helper ────────────────────────────────────────────────
    public function isLocked(): bool
    {
        return now()->greaterThanOrEqualTo($this->match_time);
    }

    public function getStagesLabelAttribute(): string
    {
        return match ($this->stage) {
            'group'          => 'Fase Grup',
            'round_of_32'    => 'Round of 32',
            'round_of_16'    => 'Round of 16',
            'quarter_final'  => 'Perempat Final',
            'semi_final'     => 'Semi Final',
            'third_place'    => 'Perebutan Juara 3',
            'final'          => 'Final',
            default          => $this->stage,
        };
    }

    public function getResultLabelAttribute(): ?string
    {
        if (is_null($this->home_score) || is_null($this->away_score)) {
            return null;
        }

        if ($this->home_score > $this->away_score) return 'home';
        if ($this->home_score < $this->away_score) return 'away';
        return 'draw';
    }
}
