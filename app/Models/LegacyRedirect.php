<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LegacyRedirect extends Model
{
    protected $fillable = [
        'from_path',
        'to_path',
        'status_code',
        'hit_count',
    ];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'hit_count' => 'integer',
        ];
    }

    /**
     * 요청 경로를 저장 키 형식으로 정규화한다.
     * 소문자 + rawurldecode + 양끝 슬래시 제거.
     */
    public static function normalizePath(string $path): string
    {
        return mb_strtolower(trim(rawurldecode($path), '/'));
    }

    /**
     * 쿼리 파라미터를 정렬해 "path?k=v&k=v" 키로 조립한다.
     * (그누보드 board.php?bo_table=column&wr_id=N 형태 매칭용)
     *
     * @param  array<string, string>  $params
     */
    public static function buildQueryKey(string $path, array $params): string
    {
        ksort($params);
        $pairs = [];
        foreach ($params as $key => $value) {
            $pairs[] = mb_strtolower($key).'='.mb_strtolower((string) $value);
        }

        return self::normalizePath($path).'?'.implode('&', $pairs);
    }

    /**
     * 404 요청을 legacy_redirects와 대조해 매칭 레코드를 찾는다.
     * ① 그누보드 board.php?bo_table=column&wr_id=N 쿼리 매칭 우선
     * ② 실패 시 경로 단독 매칭
     */
    public static function resolveFor(Request $request): ?self
    {
        $path = $request->path();

        if (str_contains($path, 'board.php') && $request->query('bo_table') !== null) {
            $queryKey = self::buildQueryKey($path, [
                'bo_table' => (string) $request->query('bo_table'),
                'wr_id' => (string) $request->query('wr_id', ''),
            ]);

            $match = self::query()->where('from_path', $queryKey)->first();
            if ($match !== null) {
                return $match;
            }
        }

        return self::query()
            ->where('from_path', self::normalizePath($path))
            ->first();
    }
}
