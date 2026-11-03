<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsightTranslation extends Model
{
    protected $fillable = [
        'insight_id', 'locale', 'slug', 'title', 'excerpt', 'content',
        'meta_title', 'meta_description', 'source_hash', 'translated_at',
    ];

    protected function casts(): array
    {
        return ['translated_at' => 'datetime'];
    }

    public function insight(): BelongsTo
    {
        return $this->belongsTo(Insight::class);
    }
}
