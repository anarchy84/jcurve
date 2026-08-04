@extends('layouts.app')

@section('title', $category->name.' 인사이트 | 제이커브인터랙티브')

@section('content')
    <main class="insight-list">
        <section class="insight-list__content">
            <h1>{{ $category->name }} 인사이트</h1>

            @forelse ($insights as $insight)
                <article class="insight-card">
                    <h2><a href="{{ route('insights.show', $insight) }}">{{ $insight->title }}</a></h2>
                    @if ($insight->published_at)
                        <time datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                    @endif
                    <p>{{ $insight->excerpt }}</p>
                </article>
            @empty
                <p>이 카테고리에 등록된 인사이트가 없습니다.</p>
            @endforelse

            {{ $insights->links() }}
        </section>

        <nav aria-label="인사이트 탐색">
            <a href="{{ route('insights.index') }}">전체 인사이트</a>
        </nav>
    </main>
@endsection
