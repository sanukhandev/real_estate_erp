<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'contact_email',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function attributes(): MorphMany
    {
        return $this->morphMany(AttributeValue::class, 'attributable');
    }
}
