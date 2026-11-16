<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PDF 자료실 파일. 실제 파일은 local 디스크(storage/app/private)의 무작위 이름(path)에 있고,
 * 사용자가 올린 원래 이름은 original_name 에만 둔다.
 */
class ResourceFile extends Model
{
    protected $fillable = [
        'title',
        'description',
        'original_name',
        'path',
        'mime',
        'size',
        'is_published',
        'uploaded_by',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    /**
     * Content-Disposition 에 그대로 넣을 수 있는 이름으로 정리한다.
     * 경로 구분자(/ \)와 제어문자를 지우고, 끝을 .pdf 로 맞추고, 255자를 넘지 않게 자른다. 비면 '자료.pdf'.
     */
    public static function cleanOriginalName(string $name): string
    {
        $name = trim((string) preg_replace('/[\/\\\\\p{Cc}\p{Cf}]/u', '', mb_scrub($name, 'UTF-8')));
        $name = mb_substr($name, 0, 255);

        $hasPdf = (bool) preg_match('/\.pdf$/i', $name);
        $base = rtrim($hasPdf ? mb_substr($name, 0, -4) : $name);
        $extension = $hasPdf ? mb_substr($name, -4) : '.pdf';

        if ($base === '') {
            return '자료.pdf';
        }

        return mb_substr($base, 0, 255 - mb_strlen($extension)).$extension;
    }

    /**
     * 화면 표시용 용량 (예: 820KB, 3.4MB).
     */
    public function humanSize(): string
    {
        $bytes = (int) $this->size;

        if ($bytes >= 1024 * 1024) {
            return rtrim(rtrim(number_format($bytes / 1024 / 1024, 1), '0'), '.').'MB';
        }

        if ($bytes >= 1024) {
            return max(1, (int) round($bytes / 1024)).'KB';
        }

        return $bytes.'B';
    }

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'download_count' => 'integer',
            'is_published' => 'boolean',
        ];
    }
}
