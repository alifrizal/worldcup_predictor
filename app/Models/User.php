<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'email', 'nickname', 'x_account', 'location_id', 'supported_team_id', 'password', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Otomatis lowercase saat set nickname & x_account
    public function setNicknameAttribute(string $value): void
    {
        $this->attributes['nickname'] = strtolower($value);
    }

    public function setXAccountAttribute(string $value): void
    {
        $this->attributes['x_account'] = strtolower($value);
    }

    // Relasi
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'location_id');
    }

    public function supportedTeam(): BelongsTo
    {
        return $this->belongsTo(WorldCupTeam::class, 'supported_team_id');
    }
}
