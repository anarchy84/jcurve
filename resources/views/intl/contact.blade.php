@extends('layouts.intl-app')

{{--
    영어·일본어 문의 (Claude 구역, 2026-11-03 INTL) — 한국어 문의(contact)와 같은 구조·같은 접수 처리.
    - 폼은 그 언어의 POST 주소(intl_route('contact.store'))로 보낸다. 언어는 주소로만 정해지고, 폼에 언어 값을 넣지 않는다.
    - 관심 서비스 value 는 한국어 폼과 같은 값(서버 허용 목록 ContactController::SERVICE_INTERESTS).
    - 언어 안내: 제코 11/3 「번역기로 대응」. 워드프레스 원문 구간은 한국어 SEO 보존용이라 넣지 않는다.
--}}

@php
    $t = fn (string $key) => __('pages/contact.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@section('title', __('pages/contact.title'))
@section('meta')
    <meta name="description" content="{{ __('pages/contact.description') }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'inLanguage' => config('intl.locales.'.intl_locale().'.html_lang'),
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]],
            ], __('pages/contact.faq.items')),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
    </script>
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
                <span class="landing__eyebrow">{{ $t('hero.eyebrow') }}</span>
                <h1>{!! $lines($t('hero.h1')) !!}</h1>
                <p class="landing__lead">{{ $t('hero.lead') }}</p>
                <div class="cta-row"><a class="btn-primary" href="#contact-form">{{ $t('hero.cta') }}</a></div>
            </div>
        </section>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('brief.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('brief.h2') }}</h2>
                <div class="landing__points">
                    @foreach ($t('brief.points') as [$title, $text])
                        <div class="landing__point landing__point--light"><strong>{{ $title }}</strong><span>{{ $text }}</span></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="contact__form" id="contact-form">
            <span class="landing__eyebrow">{{ $t('form.eyebrow') }}</span>
            <h2>{{ $t('form.h2') }}</h2>
            <p>{{ $t('form.intro') }}</p>
            <p class="landing__note">{{ $t('form.language') }}</p>

            @if (session('status'))
                <p class="landing__note" role="status" aria-live="polite">{{ $t('form.received') }}</p>
            @endif

            <form method="POST" action="{{ intl_route('contact.store') }}">
                @csrf
                @honeypot

                @foreach (['name' => ['text', 'name', true], 'company' => ['text', 'organization', false], 'email' => ['email', 'email', true], 'phone' => ['tel', 'tel', false]] as $field => [$type, $autocomplete, $required])
                    <div class="form-field">
                        <label for="{{ $field }}">{{ $t('form.'.$field) }}</label>
                        <input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field) }}" autocomplete="{{ $autocomplete }}" @if ($required) required @endif>
                        @error($field)
                            <p role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="form-field">
                    <label for="service_interest">{{ $t('form.interest') }}</label>
                    <select id="service_interest" name="service_interest" required>
                        <option value="">{{ $t('form.select') }}</option>
                        <optgroup label="{{ $t('form.group_services') }}">
                            @foreach ($t('form.options_services') as $value => $label)
                                <option value="{{ $value }}" @selected($selectedInterest === $value || ($value === 'reward-advertiser' && $selectedInterest === 'reward-network'))>{{ $label }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="{{ $t('form.group_products') }}">
                            @foreach ($t('form.options_products') as $value => $label)
                                <option value="{{ $value }}" @selected($selectedInterest === $value)>{{ $label }}</option>
                            @endforeach
                        </optgroup>
                        <option value="other" @selected($selectedInterest === 'other')>{{ $t('form.other') }}</option>
                    </select>
                    @error('service_interest')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="message">{{ $t('form.message') }}</label>
                    <textarea id="message" name="message" rows="10" maxlength="2000" placeholder="{{ $t('form.placeholder') }}" required>{{ $prefilledMessage }}</textarea>
                    @error('message')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">{{ $t('form.submit') }}</button>
                <p class="landing__note">{{ $t('form.privacy_before') }} <a href="{{ intl_route('privacy') }}">{{ $t('form.privacy_link') }}</a> {{ $t('form.privacy_after') }}</p>
            </form>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('next.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('next.h2') }}</h2>
                <div class="steps">
                    @foreach ($t('next.steps') as [$title, $text])
                        <div class="steps__item"><strong>{{ $title }}</strong><p>{{ $text }}</p></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('faq.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('faq.h2') }}</h2>
                <div class="faq">
                    @foreach ($t('faq.items') as [$question, $answer])
                        <details class="faq__item"><summary>{{ $question }}</summary><p>{{ $answer }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
