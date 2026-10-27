{{--
    카카오톡 상담 떠 있는 버튼 — 모든 화면 오른쪽 아래 (대웅 지시 10/27 "카카오톡도 달아야 해")
    - 채널 주소는 config('services.kakao.channel_url') (env KAKAO_CHANNEL_URL) — GPT/Codex가 설정 추가 예정.
      주소가 없으면 프로젝트 문의로 보낸다(모양·자리만 먼저, 구현 마무리는 인계 문서 참고).
    - 주문 화면(self-marketing.order)은 왼쪽에 '카카오 문의' 버튼이 따로 있어 여기선 숨긴다.
--}}
@php($jcKakaoUrl = config('services.kakao.channel_url'))
@unless (request()->routeIs('self-marketing.order'))
    <a class="jc-kakao-float" href="{{ $jcKakaoUrl ?: route('contact') }}" @if ($jcKakaoUrl) target="_blank" rel="noopener" @endif aria-label="카카오톡 상담" data-jc-kakao>
        <x-jc.icon name="kakao" /><span>카카오톡 상담</span>
    </a>
@endunless
