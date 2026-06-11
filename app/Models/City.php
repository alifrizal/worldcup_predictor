<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country', 'region', 'slug'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'location_id');
    }
}
