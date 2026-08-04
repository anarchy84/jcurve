@extends('layouts.app')

@section('title', '포트폴리오 | 제이커브인터랙티브')

@section('content')
    <main class="work-list">
        <section class="work-list__content">
            <h1>포트폴리오</h1>

            @forelse ($works as $work)
                <article class="work-card">
                    <h2><a href="{{ route('work.show', $work) }}">{{ $work->title }}</a></h2>
                    @if ($work->client)
                        <p>클라이언트: {{ $work->client }}</p>
                    @endif
                    @if ($work->industry)
                        <p>산업: {{ $work->industry }}</p>
                    @endif
                    <p>{{ $work->summary }}</p>
                </article>
            @empty
                <p>등록된 포트폴리오가 없습니다.</p>
            @endforelse

            {{ $works->links() }}
        </section>
    </main>
@endsection
