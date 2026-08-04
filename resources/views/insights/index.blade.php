@extends('layouts.app')

@section('title', '인사이트 | 제이커브인터랙티브')

@section('content')
    <main class="insight-list">
        <section class="insight-list__content">
            <h1>인사이트</h1>

            @forelse ($insights as $insight)
                <article class="insight-card">
                    <h2><a href="{{ route('insights.show', $insight) }}">{{ $insight->title }}</a></h2>
                    @if ($insight->category)
                        <p><a href="{{ route('insights.category', ['slug' => $insight->category->slug]) }}">{{ $insight->category->name }}</a></p>
                    @endif
                    @if ($insight->published_at)
                        <time datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                    @endif
                    <p>{{ $insight->excerpt }}</p>
                </article>
            @empty
                <p>등록된 인사이트가 없습니다.</p>
            @endforelse

            {{ $insights->links() }}
        </section>
    </main>
@endsection
