@extends('layouts.app')

@section('title', $post->title.' | '.$board->name)

@section('content')
    <main class="post-detail">
        <article class="post-detail__content">
            <header>
                <h1>{{ $post->title }}</h1>
                <p>작성자: {{ $post->user?->nickname ?: ($post->user?->name ?? '탈퇴한 회원') }}</p>
                @if ($post->published_at)
                    <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('Y.m.d H:i') }}</time>
                @endif
                <p>조회 {{ $post->view_count }} · 좋아요 {{ $post->like_count }}</p>
            </header>

            <div class="post-detail__body">{{ $post->content }}</div>

            @auth
                <form method="POST" action="{{ route('posts.like', $post) }}">
                    @csrf
                    <button type="submit">좋아요</button>
                </form>
            @endauth

            @can('update', $post)
                <a href="{{ route('community.post.edit', ['board' => $board, 'post' => $post]) }}">수정</a>
            @endcan

            @can('delete', $post)
                <form method="POST" action="{{ route('community.post.destroy', ['board' => $board, 'post' => $post]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">삭제</button>
                </form>
            @endcan
        </article>

        <section class="comments" aria-labelledby="comments-title">
            <h2 id="comments-title">댓글</h2>

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <label for="comment-content">댓글 내용</label>
                    <textarea id="comment-content" name="content" rows="4" required>{{ old('content') }}</textarea>
                    @error('content')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                    @error('parent_id')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                    <button type="submit">댓글 등록</button>
                </form>
            @endauth

            <ol class="comments__list">
                @forelse ($post->comments->whereNull('parent_id') as $comment)
                    <li class="comment">
                        <article>
                            <header>
                                <strong>{{ $comment->user?->nickname ?: ($comment->user?->name ?? '탈퇴한 회원') }}</strong>
                                <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->format('Y.m.d H:i') }}</time>
                            </header>
                            <p>{{ $comment->content }}</p>

                            @can('delete', $comment)
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">댓글 삭제</button>
                                </form>
                            @endcan

                            @auth
                                <form method="POST" action="{{ route('comments.store', $post) }}">
                                    @csrf
                                    <input name="parent_id" type="hidden" value="{{ $comment->id }}">
                                    <label for="reply-content-{{ $comment->id }}">답글 내용</label>
                                    <textarea id="reply-content-{{ $comment->id }}" name="content" rows="3" required>{{ old('parent_id') == $comment->id ? old('content') : '' }}</textarea>
                                    @error('content')
                                        @if (old('parent_id') == $comment->id)
                                            <p role="alert">{{ $message }}</p>
                                        @endif
                                    @enderror
                                    <button type="submit">답글 등록</button>
                                </form>
                            @endauth

                            @if ($comment->children->isNotEmpty())
                                <ol class="comment__replies">
                                    @foreach ($comment->children as $reply)
                                        <li>
                                            <article>
                                                <header>
                                                    <strong>{{ $reply->user?->nickname ?: ($reply->user?->name ?? '탈퇴한 회원') }}</strong>
                                                    <time datetime="{{ $reply->created_at->toIso8601String() }}">{{ $reply->created_at->format('Y.m.d H:i') }}</time>
                                                </header>
                                                <p>{{ $reply->content }}</p>
                                                @can('delete', $reply)
                                                    <form method="POST" action="{{ route('comments.destroy', $reply) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">답글 삭제</button>
                                                    </form>
                                                @endcan
                                            </article>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </article>
                    </li>
                @empty
                    <li>등록된 댓글이 없습니다.</li>
                @endforelse
            </ol>
        </section>

        <nav aria-label="게시글 탐색">
            <a href="{{ route('community.board', $board) }}">{{ $board->name }} 목록</a>
        </nav>
    </main>
@endsection
