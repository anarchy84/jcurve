@extends('layouts.app')

@section('title', $board->name.' | 제이커브인터랙티브')

@section('content')
    <main class="board">
        <header class="board__header">
            <h1>{{ $board->name }}</h1>
            @if ($board->description)
                <p>{{ $board->description }}</p>
            @endif
            @auth
                <a href="{{ route('community.post.create', $board) }}">글쓰기</a>
            @endauth
        </header>

        @if ($notices->isNotEmpty())
            <section class="board__notices" aria-labelledby="board-notices-title">
                <h2 id="board-notices-title">공지</h2>
                <table>
                    <thead>
                        <tr>
                            <th scope="col">제목</th>
                            <th scope="col">작성자</th>
                            <th scope="col">날짜</th>
                            <th scope="col">조회</th>
                            <th scope="col">좋아요</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $post)
                            <tr>
                                <td><a href="{{ route('community.post', ['board' => $board, 'postSlug' => $post->id.'-'.$post->slug]) }}">{{ $post->title }}</a></td>
                                <td>{{ $post->user?->nickname ?: ($post->user?->name ?? '탈퇴한 회원') }}</td>
                                <td><time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('Y.m.d') }}</time></td>
                                <td>{{ $post->view_count }}</td>
                                <td>{{ $post->like_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif

        <section class="board__posts" aria-labelledby="board-posts-title">
            <h2 id="board-posts-title">게시글</h2>
            <table>
                <thead>
                    <tr>
                        <th scope="col">제목</th>
                        <th scope="col">작성자</th>
                        <th scope="col">날짜</th>
                        <th scope="col">조회</th>
                        <th scope="col">좋아요</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td><a href="{{ route('community.post', ['board' => $board, 'postSlug' => $post->id.'-'.$post->slug]) }}">{{ $post->title }}</a></td>
                            <td>{{ $post->user?->nickname ?: ($post->user?->name ?? '탈퇴한 회원') }}</td>
                            <td><time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('Y.m.d') }}</time></td>
                            <td>{{ $post->view_count }}</td>
                            <td>{{ $post->like_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">등록된 게시글이 없습니다.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="listing__pagination">{{ $posts->links('partials.pagination') }}</div>
        </section>

        <nav aria-label="커뮤니티 탐색">
            <a href="{{ route('community.index') }}">게시판 목록</a>
        </nav>
    </main>
@endsection
