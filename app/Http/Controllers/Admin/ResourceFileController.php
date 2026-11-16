<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class ResourceFileController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'files' => ResourceFile::with('uploader')->orderByDesc('id')->paginate(30),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // 앱 기본 언어가 en 이라 검사 문구를 여기서 한국어로 준다.
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ], [
            'title.required' => '제목을 입력해 주세요.',
            'title.string' => '제목을 글자로 입력해 주세요.',
            'title.max' => '제목은 200자 이하로 입력해 주세요.',
            'description.string' => '설명을 글자로 입력해 주세요.',
            'description.max' => '설명은 2,000자 이하로 입력해 주세요.',
            'file.required' => '올릴 PDF 파일을 골라 주세요.',
            'file.file' => '올릴 PDF 파일을 골라 주세요.',
            'file.uploaded' => '파일을 올리지 못했습니다. 20MB 이하 PDF인지 확인해 주세요.',
            'file.mimes' => 'PDF 파일만 올릴 수 있습니다.',
            'file.max' => '20MB(20,480KB) 이하 파일만 올릴 수 있습니다.',
        ]);

        $file = $request->file('file');

        // 저장 이름은 무작위 40자 + 내용 기준 확장자. 원래 이름은 DB 에만 둔다.
        $path = $file->store('resources', 'local');

        if ($path === false) {
            return back()->withInput()->withErrors(['file' => '파일을 저장하지 못했습니다. 다시 시도해 주세요.']);
        }

        try {
            ResourceFile::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'original_name' => ResourceFile::cleanOriginalName($file->getClientOriginalName()),
                'path' => $path,
                'mime' => $file->getMimeType() ?: 'application/pdf',
                'size' => $file->getSize(),
                'uploaded_by' => $request->user()->getKey(),
            ]);
        } catch (Throwable $e) {
            Storage::disk('local')->delete($path);

            throw $e;
        }

        return redirect()->route('admin.resources.index')->with('status', 'resource-uploaded');
    }

    public function destroy(ResourceFile $resourceFile): RedirectResponse
    {
        $resourceFile->delete();
        Storage::disk('local')->delete($resourceFile->path);

        return redirect()->route('admin.resources.index')->with('status', 'resource-deleted');
    }
}
