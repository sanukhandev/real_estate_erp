<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'language',
        'description',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
