@extends('layouts.jc')

{{--
    PDF 자료실 (2026-11-11) — 목록은 누구나 보고, 받기는 로그인한 회원만.
    - 받는 주소는 resources.download(로그인 + 분당 30회). 저장 위치·파일 주소는 화면에 내지 않는다.
    - 비로그인 '로그인하고 받기'는 route('login'). 컨트롤러가 돌아올 곳을 이 목록으로 잡아 둬서
      로그인하거나 가입한 뒤 파일 응답이 아니라 여기로 돌아온다.
    - 검색 노출 안 함(noindex). 사이트맵·RSS·llms 에 넣지 않는다. 메인 메뉴 위치는 대웅 결정 대기.
    - 받는 값: $files = LengthAwarePaginator<ResourceFile>(공개 자료만, 최신순 30개)
--}}

@section('title', 'PDF 자료실 | 제이커브인터렉티브')
@section('robots', 'noindex, nofollow')
@section('meta')
    <meta name="description" content="제이커브인터렉티브 PDF 자료실. 회원으로 로그인하면 자료를 내려받을 수 있습니다.">
@endsection

@section('content')
    <section class="jc-support-hero" aria-labelledby="resources-title">
        <div class="jc-wrap">
            <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><span aria-current="page">PDF 자료실</span></nav>
            <h1 id="resources-title" class="jc-display jc-h1--page">PDF 자료실</h1>
            <p class="jc-lead">제이커브가 준비한 자료를 PDF로 내려받을 수 있습니다.</p>
            @guest
                <p class="jc-res__note">자료는 회원만 받을 수 있습니다. <a href="{{ route('login') }}">로그인</a>하거나 <a href="{{ route('register') }}">회원가입</a>하면 이 목록으로 돌아옵니다.</p>
            @endguest
            @if (auth()->user()?->role === 'admin')
                <div class="jc-support-links">
                    <a href="{{ route('admin.resources.index') }}"><x-jc.icon name="layers" />자료 올리기·관리</a>
                </div>
            @endif
        </div>
    </section>

    <section class="jc-section" aria-label="자료 목록">
        <div class="jc-wrap">
            @if ($files->count())
                <table class="jc-table jc-res">
                    <thead>
                        <tr>
                            <th scope="col">자료</th>
                            <th scope="col">용량</th>
                            <th scope="col">올린 날짜</th>
                            <th scope="col"><span class="jc-sr">받기</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>
                                    {{ $file->title }}
                                    @if ($file->description)
                                        <span class="jc-res__desc">{{ $file->description }}</span>
                                    @endif
                                </td>
                                <td><span class="jc-sr">용량 </span>PDF · {{ $file->humanSize() }}</td>
                                <td><span class="jc-sr">올린 날짜 </span><time datetime="{{ $file->created_at->toDateString() }}">{{ $file->created_at->format('Y.m.d') }}</time></td>
                                <td>
                                    @auth
                                        <a class="jc-btn jc-btn--primary jc-btn--sm" href="{{ route('resources.download', $file) }}" rel="nofollow">받기<span class="jc-sr"> — {{ $file->title }}</span></a>
                                    @else
                                        <a class="jc-btn jc-btn--line jc-btn--sm" href="{{ route('login') }}" rel="nofollow">로그인하고 받기<span class="jc-sr"> — {{ $file->title }}</span></a>
                                    @endauth
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
                <p class="jc-res__empty">아직 올라온 자료가 없습니다.</p>
            @endif
        </div>
    </section>
@endsection
