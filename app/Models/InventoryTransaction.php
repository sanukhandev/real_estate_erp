<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'inventory_item_id',
        'transaction_type',
        'quantity',
        'transaction_date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function inventoryItem() : BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
