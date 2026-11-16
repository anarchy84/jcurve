<?php

namespace App\Http\Controllers;

use App\Models\ResourceFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResourceFileController extends Controller
{
    public function index(Request $request): View
    {
        // '로그인하고 받기'로 로그인·가입한 뒤 파일 응답이 아니라 이 목록으로 돌아오게 한다.
        if (! $request->user()) {
            redirect()->setIntendedUrl(route('resources.index'));
        }

        return view('resources.index', [
            'files' => ResourceFile::published()->orderByDesc('id')->paginate(30),
        ]);
    }

    public function download(Request $request, ResourceFile $resourceFile): StreamedResponse
    {
        $disk = Storage::disk('local');

        abort_unless($resourceFile->is_published && $disk->exists($resourceFile->path), 404);

        // HEAD(용량만 확인하는 요청)는 받은 수에 넣지 않는다.
        if (! $request->isMethod('HEAD')) {
            ResourceFile::whereKey($resourceFile->getKey())->toBase()->increment('download_count');
        }

        return $disk->download(
            $resourceFile->path,
            ResourceFile::cleanOriginalName($resourceFile->original_name),
            ['X-Robots-Tag' => 'noindex, nofollow'],
        );
    }
}
