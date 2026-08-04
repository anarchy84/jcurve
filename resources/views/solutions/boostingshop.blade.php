@extends('layouts.app')

@section('title', '부스팅샵 | 제이커브인터랙티브')

@section('content')
    <main class="solution">
        <article class="solution__content">
            <h1>부스팅샵</h1>
            <p>필요한 마케팅 서비스를 직접 선택하고 실행할 수 있도록 구성한 셀프마케팅 솔루션입니다.</p>
            <section aria-labelledby="boostingshop-value-title">
                <h2 id="boostingshop-value-title">필요한 만큼 빠르게</h2>
                <p>목표와 예산에 맞는 상품을 선택해 실행하고 다음 성장 단계로 연결합니다.</p>
            </section>
            <a href="{{ route('contact') }}">부스팅샵 문의</a>
        </article>
    </main>
@endsection
