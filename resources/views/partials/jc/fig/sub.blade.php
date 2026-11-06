{{-- 서브페이지 그림: 페이지(eyebrow)마다 다른 그림 하나. 글은 그 페이지 sections 의 글을 그대로 꺼내 쓴다. --}}
@php
    $jfSecs = collect($page['sections'] ?? []);
    $jfCk = $jfSecs->firstWhere('type', 'checklist')['items'] ?? [];
    $jfSt = collect($jfSecs->firstWhere('type', 'steps')['items'] ?? [])->pluck('title')->filter()->values()->all();
    $jfEb = (string) ($page['eyebrow'] ?? '');
@endphp
@switch(true)

@case($jfEb === 'Link Building')
<section class="jf" aria-label="링크 관리 기록">
    <div class="jf__in">
        <p class="jf__cap"><b>링크 관리 기록</b> · {{ $jfCk[3] ?? '' }}</p>
        <div class="jf-scroll">
            <table class="jf-sheet">
                <thead><tr><th>게재 URL</th><th>연결 대상</th><th>앵커텍스트</th><th>확인 시점</th><th>상태</th></tr></thead>
                <tbody>
                    @foreach ([[120, 90, 60], [100, 110, 74], [130, 80, 52]] as $w)
                    <tr><td><span class="jf-sk" style="width:{{ $w[0] }}px"></span></td><td><span class="jf-sk" style="width:{{ $w[1] }}px"></span></td><td><span class="jf-sk" style="width:{{ $w[2] }}px"></span></td><td><span class="jf-sk" style="width:64px"></span></td><td><span class="jf-pick"><span>연결</span><span>변경</span><span>삭제</span></span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="jf__note">{{ $jfCk[1] ?? '' }}도 같은 표에서 봅니다.</p>
    </div>
</section>
@break

@case($jfEb === 'Local Search')
<section class="jf" aria-label="플레이스 화면">
    <div class="jf__in">
        <p class="jf__cap"><b>고객이 보는 플레이스 한 장</b> · 발견에서 방문까지</p>
        <div class="jf-duo jf-duo--phone">
            <div class="jf-phone" aria-hidden="true"><div class="jf-phone__top"></div>
                <div class="jf-m">
                    <div class="jf-m__thumb"><span class="jf-tag">대표 이미지</span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">상호</span><span class="jf-sk" style="width:60%"></span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">주소</span><span class="jf-sk" style="width:75%"></span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">전화</span><span class="jf-sk" style="width:45%"></span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">영업시간</span><span class="jf-sk" style="width:50%"></span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">리뷰</span><span class="jf-sk" style="width:35%"></span></div>
                    <div class="jf-m__btns"><span>전화</span><span>길찾기</span><span>예약</span></div>
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfCk as $t)<li>{{ $t }}</li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Commerce SEO')
<section class="jf" aria-label="쇼핑 검색 결과 한 줄">
    <div class="jf__in">
        <p class="jf__cap"><b>쇼핑 검색 결과 한 줄</b> · 상품이 검색돼도, 선택 이유가 보여야 합니다</p>
        <div class="jf-duo">
            <div class="jf-win" aria-hidden="true">
                <div class="jf-win__bar"><i></i><i></i><i></i><span>쇼핑 검색 결과</span></div>
                <div class="jf-wire">
                    @foreach ([1, 0, 0] as $on)
                    <div class="jf-wire__row" style="grid-template-columns:90px minmax(0,1fr)">
                        <div class="jf-wire__blk jf-wire__blk--tall" @if($on) style="border-color:var(--b)" @endif>@if($on)<span class="jf-pin">1</span>@endif</div>
                        <div style="display:grid;gap:8px;align-content:start">
                            <div>@if($on)<span class="jf-pin">2</span> @endif<span class="jf-sk" style="width:80%"></span></div>
                            <div>@if($on)<span class="jf-pin">3</span> @endif<span class="jf-sk" style="width:40%"></span></div>
                            <div>@if($on)<span class="jf-pin">4</span> @endif<span class="jf-sk" style="width:55%"></span></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfSt as $t)<li><b>{{ $t }}</b></li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Gift Commerce')
<section class="jf" aria-label="선물 상품 화면">
    <div class="jf__in">
        <p class="jf__cap"><b>선물을 고르는 사람의 화면</b> · 선물의 이유를 상품 정보로</p>
        <div class="jf-duo jf-duo--phone">
            <div class="jf-phone" aria-hidden="true"><div class="jf-phone__top"></div>
                <div class="jf-m">
                    <div class="jf-m__thumb"><span class="jf-tag">대표 이미지</span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">받는 사람</span><span class="jf-sk" style="width:55%"></span></div>
                    <div class="jf-m__row"><span class="jf-m__lbl">선물 상황</span><span class="jf-sk" style="width:65%"></span></div>
                    <div class="jf-m__btns"><span>옵션</span><span>포장</span><span>배송·교환</span></div>
                    <div class="jf-m__submit">선물하기</div>
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfCk as $t)<li>{{ $t }}</li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Marketplace SEO')
<section class="jf" aria-label="상품 화면의 비교 순서">
    <div class="jf__in">
        <p class="jf__cap"><b>고객의 비교 순서로 다시 놓은 상품 화면</b></p>
        <div class="jf-duo">
            <div class="jf-win" aria-hidden="true">
                <div class="jf-win__bar"><i></i><i></i><i></i><span>상품 상세</span></div>
                <div class="jf-wire">
                    <div class="jf-wire__hero">
                        <div class="jf-wire__blk jf-wire__blk--tall"><span class="jf-pin">2</span>대표 이미지</div>
                        <div style="display:grid;gap:10px;align-content:start">
                            <div class="jf-wire__blk"><span class="jf-pin">2</span>상품명</div>
                            <div class="jf-wire__blk"><span class="jf-pin">1</span>카테고리 · 옵션 · 필수 속성</div>
                            <div class="jf-wire__blk jf-wire__blk--btn"><span class="jf-pin">3</span>가격 · 배송 · 반품</div>
                        </div>
                    </div>
                    <div class="jf-wire__blk"><span class="jf-pin">4</span>상세페이지의 정보 순서</div>
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfCk as $t)<li>{{ $t }}</li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Real Estate CPA')
<section class="jf" aria-label="상담 신청 화면">
    <div class="jf__in">
        <p class="jf__cap"><b>상담 신청 화면 한 장</b> · 수집보다 먼저 기준과 흐름을 설계합니다</p>
        <div class="jf-duo jf-duo--phone">
            <div class="jf-phone" aria-hidden="true"><div class="jf-phone__top"></div>
                <div class="jf-m jf-m__form">
                    <div class="jf-m__thumb"><span class="jf-tag">사업지 · 공급 조건</span></div>
                    <div class="jf-m__field">필수 상담 신청 항목</div>
                    <div class="jf-m__field">목표 지역 · 고객 조건</div>
                    <div class="jf-m__agree"><span class="jf-box"></span><span>개인정보 수집·이용 및 상담 연락 동의</span></div>
                    <div class="jf-m__submit">상담 신청</div>
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfSt as $t)<li><b>{{ $t }}</b></li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Finance Lead CPA')
<section class="jf" aria-label="광고 문구 검토표">
    <div class="jf__in">
        <p class="jf__cap"><b>광고 문구 검토표</b> · 강한 약속보다 정확한 설명이 먼저입니다</p>
        <div class="jf-scroll">
            <table class="jf-sheet">
                <thead><tr><th>광고 문구</th><th>근거 자료</th><th>필수 위험 고지</th><th>검토</th></tr></thead>
                <tbody>
                    @foreach ([[160, 110, 120], [140, 90, 130], [170, 100, 110]] as $w)
                    <tr><td><span class="jf-sk" style="width:{{ $w[0] }}px"></span></td><td><span class="jf-sk" style="width:{{ $w[1] }}px"></span></td><td><span class="jf-sk" style="width:{{ $w[2] }}px"></span></td><td><span class="jf-box"></span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="jf__note">함께 보는 것 — {{ implode(' / ', array_filter([$jfCk[0] ?? null, $jfCk[2] ?? null, $jfCk[3] ?? null])) }}</p>
    </div>
</section>
@break

@case($jfEb === 'Insurance Permission DB')
<section class="jf" aria-label="전달 전 확인">
    <div class="jf__in">
        <p class="jf__cap"><b>차이는 ‘전달 전 확인’입니다</b> · 같은 신청도 거치는 단계가 다릅니다</p>
        <div class="jf-gate">
            <div class="jf-gate__r"><b>일반 랜딩 신청 DB</b><div class="jf-gate__flow"><span>신청 화면 기록</span><i>→</i><span>전달</span></div></div>
            <div class="jf-gate__r"><b>퍼미션 확인을 거친 DB</b><div class="jf-gate__flow">
                @foreach (array_slice($jfSt, 1, 4) as $i => $t)<span @class(['k' => in_array($i, [1, 2])])>{{ $t }}</span><i>→</i>@endforeach<span>미팅·상담 상태 관리</span>
            </div></div>
        </div>
        <p class="jf__note">퍼미션 확인이 미팅·계약을 보장하지는 않습니다.</p>
    </div>
</section>
@break

@case($jfEb === 'Digital Asset Lead CPA')
<section class="jf" aria-label="위험 고지 화면">
    <div class="jf__in">
        <p class="jf__cap"><b>위험 고지가 먼저 보이는 화면</b> · 위험 고지와 동의가 출발점입니다</p>
        <div class="jf-duo jf-duo--phone">
            <div class="jf-phone" aria-hidden="true"><div class="jf-phone__top"></div>
                <div class="jf-m jf-m__form">
                    <div class="jf-m__risk"><b>고객에게 고지할 핵심 위험</b>가격 변동성 등 <span class="jf-sk" style="width:70%"></span></div>
                    <div class="jf-m__field">서비스 제공 주체 · 실제 제공 기능</div>
                    <div class="jf-m__agree"><span class="jf-box"></span><span>개인정보 동의 · 상담 주체 확인</span></div>
                    <div class="jf-m__submit">상담 신청</div>
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfSt as $t)<li><b>{{ $t }}</b></li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Permission Marketing')
<section class="jf" aria-label="동의 기록">
    <div class="jf__in">
        <p class="jf__cap"><b>동의 기록 한 줄</b> · 동의는 문구가 아니라 전체 연락 흐름입니다</p>
        <div class="jf-scroll">
            <table class="jf-sheet">
                <thead><tr><th>동의 문구</th><th>버전</th><th>시점</th><th>유입 경로</th><th>연락 주체</th><th>철회·삭제 요청</th></tr></thead>
                <tbody>
                    @foreach ([0, 1, 2] as $r)
                    <tr><td><span class="jf-sk" style="width:{{ 120 - $r * 10 }}px"></span></td><td><span class="jf-sk" style="width:30px"></span></td><td><span class="jf-sk" style="width:70px"></span></td><td><span class="jf-sk" style="width:{{ 60 + $r * 8 }}px"></span></td><td><span class="jf-sk" style="width:56px"></span></td><td><span class="jf-box"></span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="jf__note">{{ $jfCk[2] ?? '' }}</p>
    </div>
</section>
@break

@case($jfEb === 'Naver GFA')
<section class="jf" aria-label="피드 안의 광고">
    <div class="jf__in">
        <p class="jf__cap"><b>피드 안의 광고 한 칸</b> · 노출이 아니라 전환을 설계합니다</p>
        <div class="jf-duo jf-duo--phone">
            <div class="jf-phone" aria-hidden="true"><div class="jf-phone__top"></div>
                <div class="jf-m jf-m__feed">
                    <span class="jf-sk"></span>
                    <div class="jf-m__ad is-on"><span class="jf-tag jf-tag--b">광고</span><div class="jf-m__thumb"><span class="jf-tag">오디언스별 소재</span></div><span class="jf-sk" style="width:80%"></span><div class="jf-m__submit">랜딩페이지</div></div>
                    <span class="jf-sk"></span><span class="jf-sk"></span>
                </div>
            </div>
            <ol class="jf-keys">@foreach ($jfSt as $t)<li><b>{{ $t }}</b></li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'Meta Advertising')
<section class="jf" aria-label="소재 가설 비교">
    <div class="jf__in">
        <p class="jf__cap"><b>소재 두 개, 가설 두 개</b> · 측정과 소재를 같은 주기로 움직입니다</p>
        <div class="jf-duo">
            <div class="jf-duo" aria-hidden="true" style="gap:14px">
                @foreach (['A', 'B'] as $v)
                <div class="jf-m__ad"><b>소재 {{ $v }}</b><div class="jf-m__thumb"></div><span class="jf-sk" style="width:85%"></span><span class="jf-sk" style="width:60%"></span><span class="jf-tag">가설 · 변경 이력</span></div>
                @endforeach
            </div>
            <ol class="jf-keys">@foreach ($jfCk as $t)<li>{{ $t }}</li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case($jfEb === 'YouTube Marketing')
<section class="jf" aria-label="영상 한 편의 구성">
    <div class="jf__in">
        <p class="jf__cap"><b>영상 한 편의 시간표</b> · 조회 이후의 행동까지 설계합니다</p>
        <div class="jf-duo">
            <div class="jf-vid" aria-hidden="true">
                <div class="jf-vid__screen"><span></span></div>
                <div class="jf-vid__track"><i></i><i></i><i></i></div>
                <div class="jf-vid__lbl"><div>훅<span>시청 유지</span></div><div>구성<span>영상별 역할</span></div><div>다음 행동<span>클릭 · 전환</span></div></div>
            </div>
            <ol class="jf-keys">@foreach ($jfSt as $t)<li><b>{{ $t }}</b></li>@endforeach</ol>
        </div>
    </div>
</section>
@break

@case(in_array($jfEb, ['SEO Basic', 'SEO Pro', 'SEO Elite'], true))
@php
    $jfTiers = collect(config('subpages.boostingshop.items', []))->only(['basic', 'pro', 'elite']);
@endphp
<section class="jf" aria-label="캠페인 단계 비교">
    <div class="jf__in">
        <p class="jf__cap"><b>베이직 · 프로 · 엘리트가 다루는 범위</b> · 지금 보고 있는 단계를 표시했습니다</p>
        <div class="jf-scroll">
            <table class="jf-sheet">
                <thead><tr><th></th>@foreach ($jfTiers as $t)<th>{{ $t['eyebrow'] }}</th>@endforeach</tr></thead>
                <tbody>
                    @for ($r = 0; $r < 4; $r++)
                    <tr>
                        <td>{{ $r + 1 }}</td>
                        @foreach ($jfTiers as $t)
                            @php $tc = collect($t['sections'] ?? [])->firstWhere('type', 'checklist')['items'] ?? []; @endphp
                            <td @if($t['eyebrow'] === $jfEb) style="background:var(--fog);color:var(--ink);font-weight:600" @endif>{{ $tc[$r] ?? '' }}</td>
                        @endforeach
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</section>
@break

@case(str_starts_with($jfEb, 'Instagram'))
<section class="jf" aria-label="인사이트 화면">
    <div class="jf__in">
        <p class="jf__cap"><b>숫자 하나 대신 보는 인사이트 화면</b></p>
        <div class="jf-doc">
            <div class="jf-doc__h">인사이트 <small>기간 <span class="jf-sk" style="width:60px"></span></small></div>
            <dl>
                @foreach ($jfCk as $i => $t)
                <div><dt>{{ $i + 1 }}</dt><dd style="display:flex;justify-content:space-between;gap:14px"><span>{{ $t }}</span><span class="jf-sk" style="width:{{ 40 + $i * 12 }}px;flex:none"></span></dd></div>
                @endforeach
            </dl>
        </div>
    </div>
</section>
@break

@endswitch
