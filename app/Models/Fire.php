<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fire extends Model
{
    protected $fillable = [
        'reported_at',
        'entity_id',
        'municipality_id',
        'vegetation_type_id',
        'fire_folio_id',
        'fire_status',
        'start_date',
        'extinction_date',
        'duration_days',
        'control_percentage',
        'extinction_percentage',
    ];

    public function entity(): BelongsTo{
        return $this->belongsTo(Entity::class);
    }

    public function municipality(): BelongsTo{
        return $this->belongsTo(Municipality::class);
    }

    public function vegetationType(): BelongsTo{
        return $this->belongsTo(VegetationType::class);
    }

    public function fireFolio(): BelongsTo{
        return $this->belongsTo(FireFolio::class);
    }

}
