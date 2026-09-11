<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VegetationType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'entity_vegetation')
            ->withTimestamps();
    }

    public function fires(): HasMany{
        return $this->hasMany(Fire::class);
    }
}