<!doctype html>
{{-- 요청 전체가 서버 한도(post_max_size, 운영 25MB)를 넘을 때. 세션이 시작되기 전이라 레이아웃 없이 짧게 안내한다(errors/410 과 같은 형식). --}}
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>보내는 파일이 너무 커요 | 제이커브인터렉티브</title>
</head>
<body>
    <h1>보내는 파일이 너무 커요</h1>
    <p>PDF 자료는 20MB 이하만 올릴 수 있어요. 파일 크기를 줄여 다시 올려 주세요.</p>
    {{-- 이전 주소(Referer)는 바깥에서 오는 값이라 링크로 싣지 않는다. 브라우저 뒤로 가기로 안내한다. --}}
    <p>브라우저의 뒤로 가기로 돌아갈 수 있어요. · <a href="{{ route('home') }}">홈</a></p>
</body>
</html>
