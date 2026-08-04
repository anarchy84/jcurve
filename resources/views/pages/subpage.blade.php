@extends('layouts.app')

@section('title', $page['title'].' | 제이커브인터렉티브')

@section('content')
    <main class="subpage">
        <article class="subpage__content">
            @if (! empty($parent))
                <nav aria-label="상위 서비스" class="subpage__breadcrumb">
                    @if ($parent['param'] !== null)
                        <a href="{{ route($parent['route'], $parent['param']) }}">{{ $parent['label'] }}</a>
                    @else
                        <a href="{{ route($parent['route']) }}">{{ $parent['label'] }}</a>
                    @endif
                </nav>
            @endif

            <h1>{{ $page['title'] }}</h1>
            <p class="subpage__lead">{{ $page['lead'] }}</p>

            @foreach ($page['body'] as $block)
                @if (is_array($block))
                    <section>
                        <h2>{{ $block['h2'] }}</h2>
                        <ul>
                            @foreach ($block['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </section>
                @else
                    <p>{{ $block }}</p>
                @endif
            @endforeach

            <a href="{{ route('contact') }}">상담 문의하기</a>
        </article>
    </main>
@endsection
