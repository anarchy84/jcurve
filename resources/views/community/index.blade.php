@extends('layouts.app')

@section('title', '마케팅 커뮤니티 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="마케팅 실무자들이 묻고 답하는 공간입니다. 제이커브인터렉티브 마케팅 커뮤니티.">
@endsection

@section('content')
    <main class="listing">
        {{-- 헤더 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Community</span>
                <h1>마케팅 커뮤니티</h1>
                <p class="landing__lead">실무자들이 묻고 답하는 공간입니다.</p>
                @guest
                    <div class="cta-row">
                        <a class="btn-primary" href="{{ route('login') }}">로그인</a>
                        <a class="btn-ghost" href="{{ route('register') }}">회원가입</a>
                    </div>
                @endguest
            </div>
        </section>

        {{-- 게시판 카드 [라이트] --}}
        <section class="listing__body">
            <ul class="board-list">
                @forelse ($boards as $board)
                    <li class="board-list__item">
                        <article>
                            <a href="{{ route('community.board', $board) }}">{{ $board->name }}</a>
                            @if ($board->description)
                                <p>{{ $board->description }}</p>
                            @endif
                            <span class="board-list__count">글 {{ $board->posts_count ?? 0 }}개</span>
                        </article>
                    </li>
                @empty
                    <li class="board-list__item">개설된 게시판이 없습니다.</li>
                @endforelse
            </ul>
        </section>
    </main>
@endsection
