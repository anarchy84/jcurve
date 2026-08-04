@extends('layouts.app')

@section('title', $work->title.' | 제이커브인터랙티브')

@section('content')
    <main class="work-detail">
        <article class="work-detail__content">
            <h1>{{ $work->title }}</h1>

            @if ($work->client || $work->industry)
                <dl class="work-detail__meta">
                    @if ($work->client)
                        <dt>클라이언트</dt>
                        <dd>{{ $work->client }}</dd>
                    @endif
                    @if ($work->industry)
                        <dt>산업</dt>
                        <dd>{{ $work->industry }}</dd>
                    @endif
                </dl>
            @endif

            @if ($work->summary)
                <p>{{ $work->summary }}</p>
            @endif

            @if ($work->metrics)
                <section aria-labelledby="work-metrics-title">
                    <h2 id="work-metrics-title">주요 성과</h2>
                    <dl>
                        @foreach ($work->metrics as $metric => $value)
                            <dt>{{ $metric }}</dt>
                            <dd>{{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                        @endforeach
                    </dl>
                </section>
            @endif

            <section aria-labelledby="work-content-title">
                <h2 id="work-content-title">프로젝트 내용</h2>
                <div>{{ $work->content }}</div>
            </section>
        </article>

        <nav aria-label="포트폴리오 탐색">
            <a href="{{ route('work.index') }}">목록으로</a>
        </nav>
    </main>
@endsection
