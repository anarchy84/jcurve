@extends('layouts.app')

@section('title', '마케팅 커뮤니티 | 제이커브인터랙티브')

@section('content')
    <main class="community-index">
        <section class="community-index__boards">
            <h1>마케팅 커뮤니티</h1>

            <ul class="board-list">
                @forelse ($boards as $board)
                    <li class="board-list__item">
                        <article>
                            <h2><a href="{{ route('community.board', $board) }}">{{ $board->name }}</a></h2>
                            @if ($board->description)
                                <p>{{ $board->description }}</p>
                            @endif
                        </article>
                    </li>
                @empty
                    <li>개설된 게시판이 없습니다.</li>
                @endforelse
            </ul>
        </section>
    </main>
@endsection
