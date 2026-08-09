<?php

namespace App\Services\Seo;

use Illuminate\Support\Facades\Http;

/**
 * 온페이지 SEO 감사 — 공개 URL을 가져와 기본 SEO 요소를 점검한다.
 * 외부 유료 API 없이 100% 자체 구현(무료). 결과는 항목별 pass/warn/fail + 점수.
 */
class OnPageAuditor
{
    private const MAX_BYTES = 2_500_000; // 2.5MB 초과 본문은 잘라서 파싱

    public function __construct(private UrlGuard $guard) {}

    /**
     * @return array{ok:bool, error?:string, url?:string, score?:int, grade?:string,
     *   fetch?:array, checks?:array}
     */
    public function audit(string $input): array
    {
        // 리다이렉트를 자동 추종하지 않고, 매 홉마다 재검증 + 검증에 쓴 IP로 접속을 고정한다.
        // (DNS 리바인딩·오픈리다이렉트·중간 홉 SSRF 차단 — 검증 시점과 접속 시점의 IP를 일치시킴)
        $current = $input;
        $res = null;
        $finalUrl = null;

        for ($hop = 0; $hop <= 3; $hop++) {
            $v = $this->guard->validate($current);
            if (! $v['ok']) {
                return ['ok' => false, 'error' => $v['error']];
            }
            $port = str_starts_with($v['url'], 'https://') ? 443 : 80;

            try {
                $res = Http::withHeaders([
                        'User-Agent' => 'JcurveSEOBot/1.0 (+https://jcurve; on-page audit)',
                        'Accept' => 'text/html,application/xhtml+xml',
                    ])
                    ->timeout(10)
                    ->connectTimeout(5)
                    ->withOptions([
                        'allow_redirects' => false,  // 수동 처리
                        'stream' => true,            // 본문 통째 로딩 방지
                        'decode_content' => false,   // gzip 폭탄 자동해제 방지
                        'curl' => [
                            // 검증에 쓴 바로 그 IP로만 접속 고정 → 리바인딩 차단
                            CURLOPT_RESOLVE => ["{$v['host']}:{$port}:{$v['ip']}"],
                        ],
                    ])
                    ->get($v['url']);
            } catch (\Throwable $e) {
                return ['ok' => false, 'error' => '페이지를 가져오지 못했습니다. 주소를 확인해 주세요.'];
            }

            $status = $res->status();
            $finalUrl = $v['url'];

            // 3xx면 Location을 절대화해 다음 홉으로 (다음 루프에서 재검증·재고정)
            if ($status >= 300 && $status < 400) {
                $loc = $res->header('Location');
                if ($loc === null || $loc === '') break;
                $current = (string) \GuzzleHttp\Psr7\UriResolver::resolve(
                    new \GuzzleHttp\Psr7\Uri($v['url']),
                    new \GuzzleHttp\Psr7\Uri($loc)
                );
                $res = null; // 아직 최종 응답 아님
                continue;
            }
            break; // 최종 응답
        }

        if ($res === null) {
            return ['ok' => false, 'error' => '리다이렉트가 너무 많습니다.'];
        }
        $status = $res->status();
        $ctype = strtolower($res->header('Content-Type') ?? '');
        if ($status >= 400) {
            return ['ok' => false, 'error' => "페이지 응답 오류(HTTP {$status})."];
        }
        if ($ctype !== '' && ! str_contains($ctype, 'html')) {
            return ['ok' => false, 'error' => 'HTML 페이지가 아닙니다.'];
        }
        // Content-Length 사전 차단
        $len = (int) $res->header('Content-Length');
        if ($len > self::MAX_BYTES) {
            return ['ok' => false, 'error' => '페이지가 너무 큽니다.'];
        }
        // 스트림에서 상한까지만 읽어 메모리/압축폭탄 DoS 차단
        $body = '';
        $stream = $res->toPsrResponse()->getBody();
        while (! $stream->eof() && strlen($body) < self::MAX_BYTES) {
            $body .= $stream->read(8192);
        }
        $html = substr($body, 0, self::MAX_BYTES);
        $checks = $this->analyze($html, $finalUrl, $res);
        [$score, $grade] = $this->score($checks);

        return [
            'ok' => true,
            'url' => $finalUrl,
            'score' => $score,
            'grade' => $grade,
            'fetch' => [
                'status' => $status,
                'https' => str_starts_with($finalUrl, 'https://'),
                'bytes' => strlen($html),
            ],
            'checks' => $checks,
        ];
    }

    /** @return array<int,array{key:string,label:string,status:string,detail:string}> */
    private function analyze(string $html, string $url, $res): array
    {
        $prev = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);
        $xp = new \DOMXPath($dom);

        $c = [];
        // by-reference 캡처(arrow fn은 값 복사라 push가 반영되지 않음)
        $add = function ($key, $label, $status, $detail) use (&$c) {
            $c[] = compact('key', 'label', 'status', 'detail');
        };

        // title
        $title = trim($xp->evaluate('string(//head/title)'));
        $tlen = mb_strlen($title);
        if ($title === '') $add('title', '타이틀 태그', 'fail', '<title>이 없습니다. 검색결과 제목으로 필수입니다.');
        elseif ($tlen < 10 || $tlen > 60) $add('title', '타이틀 태그', 'warn', "길이 {$tlen}자 — 권장 10~60자. \"".mb_strimwidth($title, 0, 50, '…').'"');
        else $add('title', '타이틀 태그', 'pass', "\"".mb_strimwidth($title, 0, 60, '…').'"');

        // meta description
        $desc = trim($xp->evaluate('string(//meta[translate(@name,"DESCRIPTION","description")="description"]/@content)'));
        $dlen = mb_strlen($desc);
        if ($desc === '') $add('description', '메타 설명', 'fail', 'meta description이 없습니다. 클릭률에 직접 영향.');
        elseif ($dlen < 50 || $dlen > 160) $add('description', '메타 설명', 'warn', "길이 {$dlen}자 — 권장 50~160자.");
        else $add('description', '메타 설명', 'pass', "{$dlen}자, 적정 길이.");

        // h1
        $h1 = $xp->query('//h1');
        $h1n = $h1->length;
        if ($h1n === 0) $add('h1', 'H1 제목', 'fail', 'H1이 없습니다. 페이지 주제를 검색엔진에 알리는 핵심.');
        elseif ($h1n > 1) $add('h1', 'H1 제목', 'warn', "H1이 {$h1n}개 — 보통 1개 권장.");
        else $add('h1', 'H1 제목', 'pass', 'H1 1개, 적정.');

        // canonical
        $canon = trim($xp->evaluate('string(//link[@rel="canonical"]/@href)'));
        $add('canonical', 'Canonical', $canon !== '' ? 'pass' : 'warn',
            $canon !== '' ? '표준 URL 지정됨.' : 'canonical 링크가 없습니다. 중복 콘텐츠 위험.');

        // viewport (모바일)
        $vp = trim($xp->evaluate('string(//meta[@name="viewport"]/@content)'));
        $add('viewport', '모바일 뷰포트', $vp !== '' ? 'pass' : 'fail',
            $vp !== '' ? '반응형 뷰포트 설정됨.' : 'viewport 메타가 없습니다. 모바일 최적화 필수.');

        // lang
        $lang = trim($xp->evaluate('string(//html/@lang)'));
        $add('lang', '언어 속성', $lang !== '' ? 'pass' : 'warn',
            $lang !== '' ? "html lang=\"{$lang}\"." : 'html lang 속성이 없습니다.');

        // Open Graph
        $ogT = trim($xp->evaluate('string(//meta[@property="og:title"]/@content)'));
        $ogI = trim($xp->evaluate('string(//meta[@property="og:image"]/@content)'));
        if ($ogT !== '' && $ogI !== '') $add('og', '오픈그래프(SNS 공유)', 'pass', 'og:title/og:image 설정됨.');
        elseif ($ogT !== '' || $ogI !== '') $add('og', '오픈그래프(SNS 공유)', 'warn', 'og 태그 일부만 있습니다.');
        else $add('og', '오픈그래프(SNS 공유)', 'fail', 'og:title/og:image가 없습니다. 공유 시 미리보기 저하.');

        // robots noindex
        $robots = strtolower(trim($xp->evaluate('string(//meta[@name="robots"]/@content)')));
        if (str_contains($robots, 'noindex')) $add('robots', '색인 허용', 'fail', 'robots meta에 noindex — 검색 노출이 차단됩니다.');
        else $add('robots', '색인 허용', 'pass', '색인을 막는 설정 없음.');

        // 이미지 alt
        $imgs = $xp->query('//img');
        $total = $imgs->length; $missing = 0;
        foreach ($imgs as $img) {
            $alt = $img->getAttribute('alt');
            if (trim($alt) === '') $missing++;
        }
        if ($total === 0) $add('img-alt', '이미지 대체텍스트', 'warn', '이미지가 없습니다.');
        elseif ($missing === 0) $add('img-alt', '이미지 대체텍스트', 'pass', "{$total}개 이미지 모두 alt 있음.");
        else {
            $st = $missing / max($total, 1) > 0.3 ? 'fail' : 'warn';
            $add('img-alt', '이미지 대체텍스트', $st, "{$total}개 중 {$missing}개 alt 누락.");
        }

        // 구조화 데이터
        $ld = $xp->query('//script[@type="application/ld+json"]');
        $add('structured', '구조화 데이터', $ld->length > 0 ? 'pass' : 'warn',
            $ld->length > 0 ? "JSON-LD {$ld->length}개 감지." : 'JSON-LD 구조화 데이터가 없습니다. 리치결과 기회 손실.');

        // HTTPS
        $add('https', 'HTTPS 보안', str_starts_with($url, 'https://') ? 'pass' : 'fail',
            str_starts_with($url, 'https://') ? 'HTTPS 사용.' : 'HTTP — 보안/순위에 불리.');

        return $c;
    }

    /** @return array{0:int,1:string} */
    private function score(array $checks): array
    {
        $w = ['pass' => 1.0, 'warn' => 0.5, 'fail' => 0.0];
        $sum = 0; $n = count($checks);
        foreach ($checks as $ck) $sum += $w[$ck['status']] ?? 0;
        $score = $n ? (int) round($sum / $n * 100) : 0;
        $grade = $score >= 90 ? 'A' : ($score >= 75 ? 'B' : ($score >= 60 ? 'C' : ($score >= 40 ? 'D' : 'F')));
        return [$score, $grade];
    }
}
