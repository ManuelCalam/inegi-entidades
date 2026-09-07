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
        'bordering_entities',
    ];

    protected $casts = [
        'bordering_entities' => 'array',
    ];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }

    public function vegetationTypes(): BelongsToMany
    {
        return $this->belongsToMany(VegetationType::class, 'entity_vegetation');
    }
}