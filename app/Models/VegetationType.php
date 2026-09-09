<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}