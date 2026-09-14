<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FireFolio extends Model
{
    protected $fillable = [
        'year',
        'entity_id',
        'consecutive_number',
        'full_key'
    ];

    public function entity(): BelongsTo{
        return $this->belongsTo(Entity::class);
    }

    
}
