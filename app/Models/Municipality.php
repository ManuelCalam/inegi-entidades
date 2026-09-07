<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipality extends Model
{
    protected $fillable = ['key', 'name', 'entity_id'];

    public function entity() : BelongsTo{
        return $this->belongsTo(Entity::class);
    }
}
