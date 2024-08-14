<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'version_number',
        'document_url',
        'created_at',
    ];

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }
}
