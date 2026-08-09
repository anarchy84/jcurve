<?php

namespace App\Http\Controllers;

use App\Services\Seo\Backlinks\BacklinkProvider;
use App\Services\Seo\OnPageAuditor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoCheckController extends Controller
{
    public function index(Request $request, OnPageAuditor $auditor, BacklinkProvider $backlinks): View
    {
        [$url, $result, $backlinkData] = $this->run($request, $auditor, $backlinks);

        return view('seo.check', [
            'inputUrl' => $url,
            'result' => $result,
            'backlinks' => $backlinkData,
        ]);
    }

    /**
     * 리포트 PDF 다운로드 — 화면과 동일 분석을 실행해 인쇄 최적화 뷰를 dompdf로 렌더.
     */
    public function pdf(Request $request, OnPageAuditor $auditor, BacklinkProvider $backlinks)
    {
        [$url, $result, $backlinkData] = $this->run($request, $auditor, $backlinks);

        abort_if($url === '' || ! is_array($result) || empty($result['ok']), 404);

        $pdf = Pdf::loadView('seo.report-pdf', [
            'result' => $result,
            'backlinks' => $backlinkData,
            'generatedAt' => now(),
        ])->setPaper('a4');

        $host = preg_replace('/[^a-z0-9.\-]/i', '_', parse_url($result['url'], PHP_URL_HOST) ?? 'report');

        return $pdf->download("seo-report-{$host}.pdf");
    }

    /**
     * URL 감사 + 백링크 조회 공통 로직.
     *
     * @return array{0:string,1:array|null,2:array|null}
     */
    private function run(Request $request, OnPageAuditor $auditor, BacklinkProvider $backlinks): array
    {
        $url = trim((string) $request->query('url', ''));
        $result = null;
        $backlinkData = null;

        if ($url !== '') {
            if (mb_strlen($url) > 2000) {
                $result = ['ok' => false, 'error' => 'URL이 너무 깁니다.'];
            } else {
                $result = $auditor->audit($url);
                // 감사 성공 시에만 백링크 조회(최종 URL의 호스트 기준)
                if (! empty($result['ok']) && ! empty($result['url'])) {
                    $backlinkData = $backlinks->fetch($result['url']);
                }
            }
        }

        return [$url, $result, $backlinkData];
    }
}
