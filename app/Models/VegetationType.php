<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VegetationType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function vegetationTypes(): BelongsToMany
    {
        return $this->belongsToMany(VegetationType::class, 'entity_vegetation')
        ->withTimestamps();
    }
}