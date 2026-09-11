<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    protected $fillable = [
        'name',
        'key',
        'regional_center',
    ];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }

    public function vegetationTypes(): BelongsToMany
    {
        return $this->belongsToMany(VegetationType::class, 'entity_vegetation');
    }

    public function neighbors(): BelongsToMany
    {
        return $this->belongsToMany(
            Entity::class,
            'entity_neighbor',    
            'entity_id',           
            'neighbor_entity_id'
        );
    }

    public function fires(): HasMany{
        return $this->hasMany(Fire::class);
    }
}