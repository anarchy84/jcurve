<?php

namespace App\Services\Seo\Keywords;

/**
 * 오가닉 키워드 데이터 제공자. 지금은 MockKeywordProvider(샘플),
 * 유료 API(Ahrefs/Semrush 등) 키 확보 시 같은 인터페이스로 어댑터만 교체.
 */
interface KeywordProvider
{
    /**
     * @return array{
     *   sample:bool,
     *   domain:string,
     *   total_keywords:int,
     *   top3:int, top10:int,
     *   keywords:array<int,array{keyword:string,position:int,volume:int,share:float,url:string,intent:string,trend:string}>
     * }
     */
    public function fetch(string $domain): array;
}
