<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'transaction_date',
        'description',
        'debit',
        'credit',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
