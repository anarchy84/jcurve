{{--
    이관 글 제목 표시용 정리 (임시). 원문 데이터 정리는 Codex 구역(QUEUE Q-013)이고,
    정리가 끝나면 이 컴포넌트는 그대로 둬도 결과가 같다(꼬리·BOM이 없으면 원문 그대로 출력).
--}}
@props(['text' => ''])
{{ \Illuminate\Support\Str::of((string) $text)->replace("\u{FEFF}", '')->before(' - SEO 전문 컨설팅 기업')->trim() }}
