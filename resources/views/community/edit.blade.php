@extends('layouts.app')

@section('title', '글 수정 | '.$board->name)

@section('content')
    <main class="post-form">
        <section class="post-form__content">
            <h1>글 수정</h1>

            <form method="POST" action="{{ route('community.post.update', ['board' => $board, 'post' => $post]) }}">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="title">제목</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="content">내용</label>
                    <textarea id="content" name="content" rows="16" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">수정</button>
            </form>
        </section>
    </main>
@endsection
