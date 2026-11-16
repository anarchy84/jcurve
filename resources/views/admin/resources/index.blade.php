@extends('layouts.jc')

{{--
    PDF 자료실 관리 (2026-11-11) — 관리자(users.role = admin)만 들어온다(라우트 auth + admin).
    - 올리기: 20MB 이하 PDF. 서버가 내용으로 PDF 인지 다시 검사하고, 무작위 이름으로 비공개 폴더에 저장한다.
    - 지우기: DB 행과 저장 파일을 함께 지운다(확인 창을 거친다).
    - 검색 노출 안 함(noindex). 받는 값: $files = LengthAwarePaginator<ResourceFile>(전체, 최신순 30개, uploader 로드)
--}}

@section('title', 'PDF 자료실 관리 | 제이커브인터렉티브')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="jc-support-hero" aria-labelledby="admin-resources-title">
        <div class="jc-wrap">
            <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><a href="{{ route('resources.index') }}">PDF 자료실</a><span aria-hidden="true">/</span><span aria-current="page">관리</span></nav>
            <h1 id="admin-resources-title" class="jc-display jc-h1--page">자료실 관리</h1>
            <p class="jc-lead">PDF를 올리면 자료실 목록에 바로 보이고, 로그인한 회원만 내려받을 수 있습니다.</p>
            <div class="jc-support-links">
                <a href="{{ route('resources.index') }}"><x-jc.icon name="layers" />자료실 목록 보기</a>
            </div>
        </div>
    </section>

    <section class="jc-section" aria-labelledby="admin-resources-upload">
        <div class="jc-wrap">
            @if (session('status') === 'resource-uploaded')
                <p class="jc-res-msg" role="status">자료를 올렸습니다.</p>
            @elseif (session('status') === 'resource-deleted')
                <p class="jc-res-msg" role="status">자료를 지웠습니다.</p>
            @endif

            @if ($errors->any())
                <div class="jc-res-msg jc-res-msg--error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 id="admin-resources-upload" class="jc-display jc-h3 jc-res-head">자료 올리기</h2>
            <form class="jc-res-form" method="POST" action="{{ route('admin.resources.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="jc-field jc-field--light">
                    제목
                    <input class="jc-input jc-input--line" type="text" name="title" value="{{ old('title') }}" maxlength="200" required>
                    @error('title')<span class="jc-res-err">{{ $message }}</span>@enderror
                </label>
                <label class="jc-field jc-field--light">
                    설명 <span class="jc-small">(선택, 2,000자 이하)</span>
                    <textarea class="jc-input jc-input--line" name="description" maxlength="2000" rows="4">{{ old('description') }}</textarea>
                    @error('description')<span class="jc-res-err">{{ $message }}</span>@enderror
                </label>
                <label class="jc-field jc-field--light">
                    PDF 파일
                    <input class="jc-input jc-input--line" type="file" name="file" accept="application/pdf,.pdf" required>
                    <span class="jc-small">20MB 이하 PDF만 올릴 수 있습니다. 파일 이름은 받는 사람에게 그대로 보입니다.</span>
                    @error('file')<span class="jc-res-err">{{ $message }}</span>@enderror
                </label>
                <div class="jc-btns">
                    <button class="jc-btn jc-btn--primary jc-btn--md" type="submit">올리기</button>
                </div>
            </form>
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="admin-resources-list">
        <div class="jc-wrap">
            <h2 id="admin-resources-list" class="jc-display jc-h3 jc-res-head">올린 자료 <span class="jc-small">{{ number_format($files->total()) }}개</span></h2>
            @if ($files->count())
                <table class="jc-table jc-res">
                    <thead>
                        <tr>
                            <th scope="col">자료</th>
                            <th scope="col">용량</th>
                            <th scope="col">받은 수</th>
                            <th scope="col">올린 날짜</th>
                            <th scope="col"><span class="jc-sr">지우기</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>
                                    {{ $file->title }}@unless ($file->is_published) <span class="jc-small">(비공개)</span>@endunless
                                    <span class="jc-res__meta">{{ $file->original_name }}@if ($file->uploader) · {{ $file->uploader->name }}@endif</span>
                                </td>
                                <td><span class="jc-sr">용량 </span>{{ $file->humanSize() }}</td>
                                <td><span class="jc-sr">받은 수 </span>{{ number_format($file->download_count) }}회</td>
                                <td><span class="jc-sr">올린 날짜 </span><time datetime="{{ $file->created_at->toDateString() }}">{{ $file->created_at->format('Y.m.d H:i') }}</time></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.resources.destroy', $file) }}" onsubmit="return confirm(this.dataset.confirm)" data-confirm="‘{{ $file->title }}’ 자료를 지울까요? 저장된 파일도 함께 지워지고 되돌릴 수 없습니다.">
                                        @csrf
                                        @method('DELETE')
                                        <button class="jc-btn jc-btn--line jc-btn--sm" type="submit">지우기<span class="jc-sr"> — {{ $file->title }}</span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($files->hasPages())
                    <nav class="jc-res__pager" aria-label="페이지 이동">
                        @if ($files->onFirstPage())
                            <span></span>
                        @else
                            <a class="jc-btn jc-btn--line jc-btn--sm" href="{{ $files->previousPageUrl() }}" rel="prev">← 이전</a>
                        @endif
                        @if ($files->hasMorePages())
                            <a class="jc-btn jc-btn--line jc-btn--sm" href="{{ $files->nextPageUrl() }}" rel="next">다음 →</a>
                        @endif
                    </nav>
                @endif
            @else
                <p class="jc-res__empty">아직 올린 자료가 없습니다.</p>
            @endif
        </div>
    </section>
@endsection
