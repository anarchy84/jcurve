<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Insight extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'meta_title',
        'meta_description',
        'published_at',
        'legacy_wr_id',
        'source_url',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotIn('slug', config('seo.hidden_insights', []));
    }

    public function isHidden(): bool
    {
        return in_array($this->slug, config('seo.hidden_insights', []), true);
    }

    protected function content(): Attribute
    {
        return Attribute::get(fn ($value) => $this->displayText($value));
    }

    protected function excerpt(): Attribute
    {
        return Attribute::get(fn ($value) => $this->displayText($value));
    }

    private function displayText(?string $value): ?string
    {
        if ($value === null || ! in_array($this->slug, ['스마트스토어-검색광고가-꼭-필요할까', '스마트스토어-내게-맞는-키워드-발굴하는-법'], true)) {
            return $value;
        }

        return str_replace([
            '안녕하십니까. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다.',
            '안녕하세요. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다.',
        ], '', $value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(InsightTranslation::class);
    }

    public function translation(?string $locale = null): HasOne
    {
        return $this->hasOne(InsightTranslation::class)->where('locale', $locale ?? intl_locale());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(InsightCategory::class, 'category_id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
