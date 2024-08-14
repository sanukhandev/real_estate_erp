<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentPageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_page_id',
        'language',
        'title',
        'content',
    ];

    public function contentPage(): BelongsTo
    {
        return $this->belongsTo(ContentPage::class);
    }
}
