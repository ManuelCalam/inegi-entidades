<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    protected $fillable = ['key', 'name', 'entity_id'];

    public function entity() : BelongsTo{
        return $this->belongsTo(Entity::class);
    }

    public function fires(): HasMany{
        return $this->hasMany(Fire::class);
    }
}
