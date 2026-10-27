{{--
    제휴 띠: 리워드 네트워크 4곳 + 네트워크로 연결된 매체 앱(제휴 26 + 자체 12, 사이사이 섞음)
    - 대웅 확인(2026-10-27): 버즈빌·애드팝콘·NBT·OK캐쉬백은 제휴 네트워크, 매체 아이콘 26개 전부 노출 가능, 자체 앱은 중간중간 섞기
    - NBT·OK캐쉬백은 공식 로고 파일을 받기 전까지 글자 표기
    - 이름을 확인하지 못한 매체 아이콘은 alt를 비워 둔다(장식 처리). 이름을 받으면 채운다.
    사용: @include('partials.jc.partner-band', ['plain' => true|false])
--}}
@php
    $jcPartner = fn (string $n, string $alt) => ['src' => asset("images/partners/logo-{$n}.png"), 'alt' => $alt, 'own' => false];
    $jcOwn = fn (string $file, string $name) => ['src' => asset("images/apps/{$file}.png"), 'alt' => "{$name} (제이커브 자체 앱)", 'own' => true];
    $jcWall = [
        $jcPartner('01', 'OK캐쉬백'), $jcPartner('18', '카카오페이'), $jcOwn('eggfarm', '꼬꼬농장'),
        $jcPartner('24', '신한 SOL Pay'), $jcPartner('26', 'PAYCO'), $jcOwn('saimcash', '사임캐시'),
        $jcPartner('02', '시럽'), $jcPartner('04', '티머니'), $jcOwn('carrotcash', '당근캐시'),
        $jcPartner('09', '에이블리'), $jcPartner('06', '번개장터'), $jcOwn('pigcash', '꿀꿀캐시'),
        $jcPartner('19', 'KB Pay'), $jcPartner('23', 'WON멤버스'), $jcOwn('moneytree', '머니트리'),
        $jcPartner('11', ''), $jcPartner('20', ''), $jcOwn('stamptech', '꾹테크'),
        $jcPartner('05', ''),
        $jcPartner('25', '신한 SOL뱅크'), $jcPartner('21', ''), $jcOwn('cashpang', '캐시팡팡'),
        $jcPartner('14', ''), $jcPartner('03', ''), $jcOwn('youngtech', '영테크'),
        $jcPartner('07', ''), $jcPartner('08', ''), $jcOwn('moneycapsule', '용돈캡슐'),
        $jcPartner('10', ''), $jcPartner('12', ''), $jcOwn('potatofarm', '감자밭'),
        $jcPartner('13', ''), $jcPartner('15', ''), $jcOwn('eggmoney', '에그머니'),
        $jcPartner('16', ''), $jcPartner('17', ''), $jcOwn('jelly', '젤리요정키우기'),
        $jcPartner('22', ''),
    ];
    $jcPlain = $plain ?? false;
    $jcHeading = $heading ?? 'h2';
@endphp
<section class="jc-partners {{ $jcPlain ? 'jc-partners--plain' : '' }}" aria-label="제휴 네트워크와 매체">
    <div class="{{ $jcPlain ? '' : 'jc-wrap' }} jc-partners__inner">
        <div class="jc-networks">
            <{{ $jcHeading }} class="jc-networks__title">제휴 리워드 네트워크</{{ $jcHeading }}>
            <ul class="jc-networks__logos">
                <li><img src="{{ asset('images/networks/buzzvil.svg') }}" alt="버즈빌" width="113" height="34" style="height:34px"></li>
                <li><img src="{{ asset('images/networks/adpopcorn.png') }}" alt="애드팝콘" width="152" height="22" style="height:22px"></li>
                <li class="jc-networks__word jc-networks__word--latin">NBT</li>
                <li class="jc-networks__word">OK캐쉬백</li>
            </ul>
        </div>
        <div>
            <div class="jc-media__head">
                <{{ $jcHeading }} class="jc-media__title">네트워크로 연결된 매체</{{ $jcHeading }}>
                <span class="jc-media__legend"><span class="jc-dot" aria-hidden="true"></span>제이커브 자체 앱</span>
            </div>
            <ul class="jc-wall" aria-label="제휴 매체 앱 26개와 제이커브 자체 앱 12개">
                @foreach ($jcWall as $app)
                    <li>
                        <img src="{{ $app['src'] }}" alt="{{ $app['alt'] }}" width="56" height="56" loading="lazy">
                        @if ($app['own'])<span class="jc-wall__own" aria-hidden="true"></span>@endif
                    </li>
                @endforeach
            </ul>
            <p class="jc-media__note">로고와 앱 아이콘은 각 사의 상표입니다. 실제 연동 매체와 지원 범위는 캠페인 조건에 따라 확정합니다. 2026년 10월 기준.</p>
        </div>
    </div>
</section>
