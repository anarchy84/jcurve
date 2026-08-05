@extends('layouts.app')

@section('title', '프로젝트 문의 — 목표와 병목부터 함께 정리합니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="퍼포먼스·CPA·리워드 네트워크·SEO·웹사이트·자체 솔루션 상담. 현재 상황과 목표를 알려주시면 필요한 확인 항목과 실행 방향을 검토해 연락드립니다.">
    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {"@type":"Question","name":"서비스를 정확히 몰라도 문의할 수 있나요?","acceptedAnswer":{"@type":"Answer","text":"가능합니다. 현재 목표와 가장 답답한 지점을 적어주시면 광고, 측정, 콘텐츠, 사이트 중 먼저 확인할 영역부터 정리합니다."}},
        {"@type":"Question","name":"상담 전에 어떤 자료가 필요한가요?","acceptedAnswer":{"@type":"Answer","text":"운영 중인 채널과 사이트 주소, 월 예산 범위, 중요한 전환, 최근 성과 자료가 있으면 좋습니다. 자료가 없어도 현재 상황부터 함께 정리할 수 있습니다."}},
        {"@type":"Question","name":"문의만 하면 바로 계약되나요?","acceptedAnswer":{"@type":"Answer","text":"아닙니다. 문의 내용을 확인하고 필요한 정보를 추가로 묻고, 수행 가능 범위와 다음 단계를 맞춘 뒤 별도로 계약 여부를 결정합니다."}},
        {"@type":"Question","name":"민감한 계정 정보나 고객 데이터를 보내도 되나요?","acceptedAnswer":{"@type":"Answer","text":"첫 문의에는 비밀번호, API 키, 고객 개인정보를 보내지 마세요. 검토에 필요한 경우에도 접근 방식과 제공 범위를 먼저 합의합니다."}}
      ]
    }
    </script>
    @endverbatim
@endsection

@section('content')
    @php
        $selectedInterest = old('service_interest', request()->query('service_interest', ''));
        $selectedInterest = is_string($selectedInterest) ? $selectedInterest : '';
        $prefilledMessage = old('message', request()->query('message', ''));
        $prefilledMessage = is_string($prefilledMessage) ? mb_substr($prefilledMessage, 0, 2000) : '';
    @endphp

    <main class="landing contact">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Project Inquiry</span>
                <h1>무엇을 맡길지보다,<br>무엇이 막혔는지 알려주세요</h1>
                <p class="landing__lead">서비스명을 정확히 고르지 못해도 괜찮습니다. 목표와 현재 상황을 읽고 필요한 확인 항목, 가능한 범위, 다음 단계를 구체적으로 정리해 연락드리겠습니다.</p>
                <div class="cta-row"><a class="btn-primary" href="#contact-form">문의 내용 작성하기</a></div>
            </div>
        </section>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">A Better Brief</span>
                <h2 class="landing__head">이 네 가지만 있으면 대화가 빨라집니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>지금 해결할 목표</strong><span>매출, 유효 상담, 설치 후 행동, 검색 노출, 사이트 전환처럼 가장 중요한 결과 하나.</span></div>
                    <div class="landing__point landing__point--light"><strong>현재 운영 상태</strong><span>사용 중인 광고 채널, 사이트·앱 주소, 내부 담당자와 현재 가장 답답한 지점.</span></div>
                    <div class="landing__point landing__point--light"><strong>예산과 일정의 범위</strong><span>확정 금액이 아니어도 됩니다. 검토 가능한 범위와 원하는 시작 시점을 알려주세요.</span></div>
                    <div class="landing__point landing__point--light"><strong>참고할 데이터</strong><span>최근 리포트, 전환 정의, 기존 제안서가 있다면 진단 정확도가 높아집니다. 없어도 문의 가능합니다.</span></div>
                </div>
            </div>
        </section>

        <section class="contact__form" id="contact-form">
            <span class="landing__eyebrow">Tell Us About The Project</span>
            <h2>프로젝트 문의</h2>
            <p>아는 범위까지만 적어주세요. 확인이 필요한 내용은 연락드릴 때 다시 묻겠습니다.</p>

            @if (session('status'))
                <p class="landing__note" role="status" aria-live="polite">문의가 접수됐습니다. 내용을 확인한 뒤 남겨주신 연락처로 답변드리겠습니다.</p>
            @endif

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                @honeypot

                <div class="form-field">
                    <label for="name">이름</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required>
                    @error('name')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="company">회사명</label>
                    <input id="company" name="company" type="text" value="{{ old('company') }}" autocomplete="organization">
                    @error('company')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="email">이메일</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                    @error('email')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="phone">전화번호</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel">
                    @error('phone')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="service_interest">관심 서비스</label>
                    <select id="service_interest" name="service_interest" required>
                        <option value="">선택</option>
                        <optgroup label="마케팅 서비스">
                            <option value="performance-marketing" @selected($selectedInterest === 'performance-marketing')>퍼포먼스 마케팅</option>
                            <option value="cpa-marketing" @selected($selectedInterest === 'cpa-marketing')>CPA 마케팅</option>
                            <option value="cpa-insurance" @selected($selectedInterest === 'cpa-insurance')>보험 CPA · 퍼미션 DB</option>
                            <option value="reward-advertiser" @selected(in_array($selectedInterest, ['reward-network', 'reward-advertiser'], true))>리워드 광고 집행</option>
                            <option value="reward-publisher" @selected($selectedInterest === 'reward-publisher')>리워드 앱 매체 제휴</option>
                            <option value="seo" @selected($selectedInterest === 'seo')>SEO · AEO · GEO</option>
                            <option value="wordpress" @selected($selectedInterest === 'wordpress')>워드프레스 제작·운영</option>
                            <option value="marketing-support" @selected($selectedInterest === 'marketing-support')>중소기업 마케팅 지원사업</option>
                        </optgroup>
                        <optgroup label="자체 솔루션">
                            <option value="rankfree" @selected($selectedInterest === 'rankfree')>랭크프리</option>
                            <option value="boostingshop" @selected($selectedInterest === 'boostingshop')>부스팅샵</option>
                            <option value="leadbay" @selected($selectedInterest === 'leadbay')>리드베이</option>
                            <option value="call2sale" @selected($selectedInterest === 'call2sale')>콜투세일</option>
                        </optgroup>
                        <option value="other" @selected($selectedInterest === 'other')>아직 모르겠음 · 기타</option>
                    </select>
                    @error('service_interest')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="message">문의 내용</label>
                    <textarea id="message" name="message" rows="10" maxlength="2000" placeholder="목표, 현재 상황, 예산 범위, 희망 일정, 확인하고 싶은 내용을 적어주세요." required>{{ $prefilledMessage }}</textarea>
                    @error('message')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">문의 보내기</button>
                <p class="landing__note">보내주신 정보는 문의 검토와 회신을 위해 사용합니다. 자세한 내용은 <a href="{{ route('privacy') }}">개인정보처리방침</a>에서 확인할 수 있습니다.</p>
            </form>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">What Happens Next</span>
                <h2 class="landing__head">문의 뒤에는 이렇게 진행됩니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>내용 확인</strong><p>목표, 서비스 적합성, 필요한 확인 자료와 법무·기술상 선행 조건을 검토합니다.</p></div>
                    <div class="steps__item"><strong>추가 질문과 진단</strong><p>바로 제안하기보다 현재 데이터와 병목을 이해하는 데 필요한 질문부터 드립니다.</p></div>
                    <div class="steps__item"><strong>범위와 다음 단계 합의</strong><p>수행 가능한 일, 별도 준비가 필요한 일, 진행 순서와 협의 항목을 구분합니다.</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">문의 전에 궁금한 것들</h2>
                <div class="faq">
                    <details class="faq__item"><summary>서비스를 정확히 몰라도 문의할 수 있나요?</summary><p>가능합니다. 현재 목표와 가장 답답한 지점을 적어주시면 광고, 측정, 콘텐츠, 사이트 중 먼저 확인할 영역부터 정리합니다.</p></details>
                    <details class="faq__item"><summary>상담 전에 어떤 자료가 필요한가요?</summary><p>운영 중인 채널과 사이트 주소, 월 예산 범위, 중요한 전환, 최근 성과 자료가 있으면 좋습니다. 자료가 없어도 현재 상황부터 함께 정리할 수 있습니다.</p></details>
                    <details class="faq__item"><summary>문의만 하면 바로 계약되나요?</summary><p>아닙니다. 문의 내용을 확인하고 필요한 정보를 추가로 묻고, 수행 가능 범위와 다음 단계를 맞춘 뒤 별도로 계약 여부를 결정합니다.</p></details>
                    <details class="faq__item"><summary>민감한 계정 정보나 고객 데이터를 보내도 되나요?</summary><p>첫 문의에는 비밀번호, API 키, 고객 개인정보를 보내지 마세요. 검토에 필요한 경우에도 접근 방식과 제공 범위를 먼저 합의합니다.</p></details>
                </div>
            </div>
        </section>
    </main>
@endsection
