<?php

namespace App\Services\Seo\Backlinks;

/**
 * 백링크 데이터 제공자 인터페이스.
 * 지금은 MockBacklinkProvider(샘플 데이터)로 바인딩되어 있고,
 * Ahrefs/DataForSEO 등 유료 API 키가 확보되면 같은 인터페이스로 어댑터만 교체한다.
 */
interface BacklinkProvider
{
    /**
     * 도메인의 백링크 프로필을 반환한다.
     *
     * @return array{
     *   sample:bool,               // true면 실데이터가 아닌 샘플(UI에 반드시 표기)
     *   domain:string,
     *   domain_rating:int,         // 0~100 (DR)
     *   referring_domains:int,
     *   total_backlinks:int,
     *   dofollow_ratio:float,      // 0~1
     *   top:array<int,array{domain:string,url:string,dr:int,anchor:string,type:string,first_seen:string}>
     * }
     */
    public function fetch(string $domain): array;
}
