<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TenantSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'setting_key',
        'setting_value',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function attributes(): MorphMany
    {
        return $this->morphMany(AttributeValue::class, 'attributable');
    }
}
