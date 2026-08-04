<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Work extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'client',
        'industry',
        'summary',
        'content',
        'metrics',
        'cover_image',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'metrics' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
