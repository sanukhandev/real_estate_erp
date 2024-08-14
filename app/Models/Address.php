<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
