<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAmenity extends Model
{
    use HasFactory;

    protected $table = 'property_amenity';

    protected $fillable = [
        'property_id',
        'amenity_id',
        // Add any additional fields here if needed
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function amenity(): BelongsTo
    {
        return $this->belongsTo(Amenity::class);
    }
}
