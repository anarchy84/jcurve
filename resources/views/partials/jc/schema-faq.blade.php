{{--
    FAQPage 구조화 데이터(JSON-LD) — SEO-KW-02 (2026-11-04)
    - 화면에 보이는 질문·답과 **같은 배열**을 넘긴다(화면과 다른 질문을 넣으면 검색엔진 정책 위반).
    - 사용: @include('partials.jc.schema-faq', ['items' => $faqs])
      항목 모양은 ['question' => …, 'answer' => …] · ['q' => …, 'a' => …] · [질문, 답] 셋 다 받는다.
    - 답에 링크 같은 HTML 이 있으면 글자만 남긴다. 결과는 head 의 @stack('jsonld') 로 나간다.
--}}
@php
    $jcFaqClean = fn ($s) => trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $s), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    $jcFaqAt = '@';
    $jcFaqItems = [];
    foreach (($items ?? []) as $jcFaqItem) {
        $jcFaqQ = $jcFaqClean($jcFaqItem['question'] ?? $jcFaqItem['q'] ?? $jcFaqItem[0] ?? '');
        $jcFaqA = $jcFaqClean($jcFaqItem['answer'] ?? $jcFaqItem['a'] ?? $jcFaqItem[1] ?? '');
        if ($jcFaqQ !== '' && $jcFaqA !== '') {
            $jcFaqItems[] = [$jcFaqAt.'type' => 'Question', 'name' => $jcFaqQ, 'acceptedAnswer' => [$jcFaqAt.'type' => 'Answer', 'text' => $jcFaqA]];
        }
    }
@endphp
@if (count($jcFaqItems) > 0)
    @push('jsonld')
<script type="application/ld+json">{!! json_encode([$jcFaqAt.'context' => 'https://schema.org', $jcFaqAt.'type' => 'FAQPage', 'mainEntity' => $jcFaqItems], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
    @endpush
@endif
