@extends('layouts.app')

@section('title', '글쓰기 | '.$board->name)

@section('content')
    <main class="post-form">
        <section class="post-form__content">
            <h1>{{ $board->name }} 글쓰기</h1>

            <form method="POST" action="{{ route('community.post.store', $board) }}">
                @csrf

                <div class="form-field">
                    <label for="title">제목</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required>
                    @error('title')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="content">내용</label>
                    <textarea id="content" name="content" rows="16" required>{{ old('content') }}</textarea>
                    @error('content')
                        <p role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">등록</button>
            </form>
        </section>
    </main>
@endsection
