<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    protected $fillable = [
        'name', 
        'key',
        'regional_center',
        'bordering_entities',
        'vegetation_types',
    ];

    protected $casts = [
        'bordering_entities' => 'array',
        'vegetation_types' => 'array'
    ];

    public function municipalities(): HasMany{
        return $this->hasMany(Municipality::class);
    }
    
}
