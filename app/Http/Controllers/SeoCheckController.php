<?php

namespace App\Http\Controllers;

use App\Services\Seo\Backlinks\BacklinkProvider;
use App\Services\Seo\Keywords\KeywordProvider;
use App\Services\Seo\OnPageAuditor;
use App\Services\Seo\Traffic\TrafficProvider;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoCheckController extends Controller
{
    public function index(Request $request): View
    {
        return view('seo.check', $this->run($request));
    }

    /**
     * 리포트 PDF 다운로드 — 화면과 동일 분석을 실행해 인쇄 최적화 뷰를 dompdf로 렌더.
     */
    public function pdf(Request $request)
    {
        $data = $this->run($request);
        $result = $data['result'];

        abort_if($data['inputUrl'] === '' || ! is_array($result) || empty($result['ok']), 404);

        $pdf = Pdf::loadView('seo.report-pdf', [
            'result' => $result,
            'backlinks' => $data['backlinks'],
            'keywords' => $data['keywords'],
            'traffic' => $data['traffic'],
            'generatedAt' => now(),
        ])->setPaper('a4');

        $host = preg_replace('/[^a-z0-9.\-]/i', '_', parse_url($result['url'], PHP_URL_HOST) ?? 'report');
        $filename = "seo-report-{$host}.pdf";

        // ?inline=1 이면 브라우저에서 바로 미리보기(다운로드 대신)
        return $request->boolean('inline')
            ? $pdf->stream($filename)
            : $pdf->download($filename);
    }

    /**
     * URL 감사 + 백링크·키워드·트래픽 조회 공통 로직.
     *
     * @return array{inputUrl:string, result:array|null, backlinks:array|null, keywords:array|null, traffic:array|null}
     */
    private function run(Request $request): array
    {
        $url = trim((string) $request->query('url', ''));
        $result = $backlinks = $keywords = $traffic = null;

        if ($url !== '') {
            if (mb_strlen($url) > 2000) {
                $result = ['ok' => false, 'error' => 'URL이 너무 깁니다.'];
            } else {
                $result = app(OnPageAuditor::class)->audit($url);
                // 감사 성공 시에만 도메인 지표 조회(최종 URL의 호스트 기준)
                if (! empty($result['ok']) && ! empty($result['url'])) {
                    $backlinks = app(BacklinkProvider::class)->fetch($result['url']);
                    $keywords = app(KeywordProvider::class)->fetch($result['url']);
                    $traffic = app(TrafficProvider::class)->fetch($result['url']);
                }
            }
        }

        return [
            'inputUrl' => $url,
            'result' => $result,
            'backlinks' => $backlinks,
            'keywords' => $keywords,
            'traffic' => $traffic,
        ];
    }
}
