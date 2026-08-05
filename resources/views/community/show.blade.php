@extends('layouts.app')

@section('title', $post->title.' | '.$board->name)

@section('content')
    <main class="detail">
        {{-- 히어로 [파치먼트] — 제목 · 메타 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <a class="landing__eyebrow" href="{{ route('community.board', $board) }}">{{ $board->name }}</a>
                <h1>{{ $post->title }}</h1>
                <div class="detail__meta">
                    <span>{{ $post->user?->nickname ?: ($post->user?->name ?? '탈퇴한 회원') }}</span>
                    @if ($post->published_at)
                        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('Y.m.d H:i') }}</time>
                    @endif
                    <span>조회 {{ $post->view_count }} · 좋아요 {{ $post->like_count }}</span>
                </div>
            </div>
        </section>

        {{-- 본문 [라이트] --}}
        <section class="detail__body">
            <div class="detail__inner">
                {{-- 사용자 작성 글 — XSS 방지 위해 이스케이프 유지, 줄바꿈만 보존 --}}
                <div class="prose prose--plain post-detail__body">{{ $post->content }}</div>

                <div class="post-detail__actions">
                    @auth
                        <form method="POST" action="{{ route('posts.like', $post) }}">
                            @csrf
                            <button class="btn-ghost" type="submit">♥ 좋아요 {{ $post->like_count }}</button>
                        </form>
                    @endauth

                    @can('update', $post)
                        <a class="btn-ghost" href="{{ route('community.post.edit', ['board' => $board, 'post' => $post]) }}">수정</a>
                    @endcan

                    @can('delete', $post)
                        <form method="POST" action="{{ route('community.post.destroy', ['board' => $board, 'post' => $post]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn-text-danger" type="submit">삭제</button>
                        </form>
                    @endcan
                </div>

                {{-- 댓글 (2단 중첩) — 기능 보존 --}}
                <section class="comments" aria-labelledby="comments-title">
                    <h2 id="comments-title">댓글</h2>

                    @auth
                        <form class="comment-form" method="POST" action="{{ route('comments.store', $post) }}">
                            @csrf
                            <div class="form-field">
                                <label for="comment-content">댓글 내용</label>
                                <textarea id="comment-content" name="content" rows="4" required>{{ old('content') }}</textarea>
                            </div>
                            @error('content')
                                <p class="input-error" role="alert">{{ $message }}</p>
                            @enderror
                            @error('parent_id')
                                <p class="input-error" role="alert">{{ $message }}</p>
                            @enderror
                            <button class="btn-primary" type="submit">댓글 등록</button>
                        </form>
                    @else
                        <p class="comments__login">댓글을 남기려면 <a href="{{ route('login') }}">로그인</a>이 필요합니다.</p>
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
                                            <button class="btn-text-danger" type="submit">댓글 삭제</button>
                                        </form>
                                    @endcan

                                    @auth
                                        <form class="comment-form comment-form--reply" method="POST" action="{{ route('comments.store', $post) }}">
                                            @csrf
                                            <input name="parent_id" type="hidden" value="{{ $comment->id }}">
                                            <div class="form-field">
                                                <label for="reply-content-{{ $comment->id }}">답글 내용</label>
                                                <textarea id="reply-content-{{ $comment->id }}" name="content" rows="3" required>{{ old('parent_id') == $comment->id ? old('content') : '' }}</textarea>
                                            </div>
                                            @error('content')
                                                @if (old('parent_id') == $comment->id)
                                                    <p class="input-error" role="alert">{{ $message }}</p>
                                                @endif
                                            @enderror
                                            <button class="btn-ghost" type="submit">답글 등록</button>
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
                                                                <button class="btn-text-danger" type="submit">답글 삭제</button>
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
                            <li class="comment comment--empty">등록된 댓글이 없습니다.</li>
                        @endforelse
                    </ol>
                </section>

                <div class="detail__foot">
                    <a class="detail__back" href="{{ route('community.board', $board) }}">← {{ $board->name }} 목록</a>
                </div>
            </div>
        </section>
    </main>
@endsection
