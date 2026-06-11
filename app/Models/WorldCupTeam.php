<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorldCupTeam extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'flag_emoji', 'flag_url', 'group', 'slug'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'supported_team_id');
    }
}
