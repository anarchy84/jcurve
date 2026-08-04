@extends('layouts.app')

@section('title', '문의 | 제이커브인터랙티브')

@section('content')
    <main class="contact">
        <section class="contact__form">
            <h1>프로젝트 문의</h1>
            <p>목표와 현재 상황을 알려주시면 적합한 실행 방향을 검토해 연락드리겠습니다.</p>

            @if (session('status'))
                <p role="status">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                @honeypot

                <div class="form-field">
                    <label for="name">이름</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                    @error('name')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="company">회사명</label>
                    <input id="company" name="company" type="text" value="{{ old('company') }}">
                    @error('company')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="email">이메일</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="phone">전화번호</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}">
                    @error('phone')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="service_interest">관심 서비스</label>
                    <select id="service_interest" name="service_interest" required>
                        <option value="">선택</option>
                        <option value="performance-marketing" @selected(old('service_interest') === 'performance-marketing')>퍼포먼스 마케팅</option>
                        <option value="cpa-marketing" @selected(old('service_interest') === 'cpa-marketing')>CPA 마케팅</option>
                        <option value="reward-network" @selected(old('service_interest') === 'reward-network')>리워드 네트워크</option>
                        <option value="seo" @selected(old('service_interest') === 'seo')>SEO·AEO·GEO</option>
                        <option value="wordpress" @selected(old('service_interest') === 'wordpress')>워드프레스</option>
                    </select>
                    @error('service_interest')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="message">문의 내용</label>
                    <textarea id="message" name="message" rows="10" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">문의 보내기</button>
            </form>
        </section>
    </main>
@endsection
