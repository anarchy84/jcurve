<?php

namespace App\Services\Seo\Traffic;

/**
 * 트래픽 추정 데이터 제공자. 지금은 MockTrafficProvider(샘플),
 * 유료 API(Ahrefs/Semrush/SimilarWeb) 또는 GSC 연동 시 어댑터만 교체.
 */
interface TrafficProvider
{
    /**
     * @return array{
     *   sample:bool,
     *   domain:string,
     *   monthly_visits:int,
     *   traffic_value_krw:int,
     *   trend:array<int,array{month:string,visits:int}>,
     *   channels:array<int,array{name:string,pct:int}>,
     *   countries:array<int,array{name:string,pct:int}>
     * }
     */
    public function fetch(string $domain): array;
}
