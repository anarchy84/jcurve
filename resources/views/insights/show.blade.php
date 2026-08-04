@extends('layouts.app')

@section('title', ($insight->meta_title ?: $insight->title).' | 제이커브인터랙티브')

@section('content')
    <main class="insight-detail">
        <article class="insight-detail__content">
            <h1>{{ $insight->title }}</h1>

            <header class="insight-detail__meta">
                @if ($insight->category)
                    <a href="{{ route('insights.category', ['slug' => $insight->category->slug]) }}">{{ $insight->category->name }}</a>
                @endif
                @if ($insight->user)
                    <span>{{ $insight->user->nickname ?: $insight->user->name }}</span>
                @endif
                @if ($insight->published_at)
                    <time datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                @endif
            </header>

            @if ($insight->excerpt)
                <p>{{ $insight->excerpt }}</p>
            @endif

            <div class="insight-detail__body">{{ $insight->content }}</div>
        </article>

        <nav aria-label="인사이트 탐색">
            <a href="{{ route('insights.index') }}">목록으로</a>
        </nav>
    </main>
@endsection
