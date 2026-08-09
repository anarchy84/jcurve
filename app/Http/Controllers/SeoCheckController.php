<?php

namespace App\Http\Controllers;

use App\Services\Seo\OnPageAuditor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoCheckController extends Controller
{
    public function index(Request $request, OnPageAuditor $auditor): View
    {
        $url = trim((string) $request->query('url', ''));
        $result = null;

        if ($url !== '') {
            // 길이 방어 (과도한 입력 차단)
            if (mb_strlen($url) > 2000) {
                $result = ['ok' => false, 'error' => 'URL이 너무 깁니다.'];
            } else {
                $result = $auditor->audit($url);
            }
        }

        return view('seo.check', [
            'inputUrl' => $url,
            'result' => $result,
        ]);
    }
}
