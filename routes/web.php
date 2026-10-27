<?php

use App\Http\Controllers\Community\BoardController;
use App\Http\Controllers\Community\CommentController;
use App\Http\Controllers\Community\LikeController;
use App\Http\Controllers\Community\PostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/', [PageController::class, 'home'])->name('home');

// 무료 SEO 인스턴트 진단 (온페이지 감사) — 남용 방지 rate limit
Route::get('/seo-check', [\App\Http\Controllers\SeoCheckController::class, 'index'])
    ->middleware('throttle:30,1')->name('seo.check');
// 리포트 PDF 다운로드 (dompdf) — PDF 렌더가 무거우니 더 타이트한 rate limit
Route::get('/seo-check/report.pdf', [\App\Http\Controllers\SeoCheckController::class, 'pdf'])
    ->middleware('throttle:10,1')->name('seo.check.pdf');

Route::get('/services', [PageController::class, 'services'])->name('services.index');
// 구체적 경로를 {slug} 와일드카드보다 먼저 등록한다.
Route::get('/services/marketing-support', [PageController::class, 'marketingSupport'])->name('services.marketing-support');
Route::get('/services/seo/aeo', [PageController::class, 'seoAeo'])->name('services.seo.aeo');
Route::get('/services/seo/geo', [PageController::class, 'seoGeo'])->name('services.seo.geo');
Route::get('/services/seo/{sub}', [PageController::class, 'seoSub'])->name('services.seo.sub');
Route::get('/services/cpa-marketing/{sub}', [PageController::class, 'cpaSub'])->name('services.cpa.sub');
Route::get('/services/performance-marketing/{sub}', [PageController::class, 'performanceSub'])->name('services.performance.sub');
Route::get('/services/{slug}', [PageController::class, 'service'])->name('services.show');
// 솔루션 허브 + 4종 (03_솔루션.md). 구체 경로를 {sub} 와일드카드보다 먼저 등록한다.
Route::get('/solutions', [PageController::class, 'solutions'])->name('solutions.index');
Route::get('/solutions/rankfree', [PageController::class, 'rankfree'])->name('solutions.rankfree');
Route::get('/solutions/leadbay', [PageController::class, 'leadbay'])->name('solutions.leadbay');
Route::get('/solutions/call2sale', [PageController::class, 'call2sale'])->name('solutions.call2sale');
Route::get('/solutions/boostingshop', [PageController::class, 'boostingshop'])->name('solutions.boostingshop');
Route::get('/solutions/boostingshop/{sub}', [PageController::class, 'boostingshopSub'])->name('solutions.boostingshop.sub');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/company', [PageController::class, 'company'])->name('company');
// 아나키 별도 페이지 폐지 → /company#anarchy 앵커로 301 통일 (04_회사소개.md)
Route::redirect('/company/anarchy', '/company#anarchy', 301);

Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{work:slug}', [WorkController::class, 'show'])->name('work.show');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/category/{slug}', [InsightController::class, 'category'])->name('insights.category');
Route::get('/insights/{insight:slug}', [InsightController::class, 'show'])->name('insights.show');

Route::get('/community', [BoardController::class, 'index'])->name('community.index');
Route::get('/community/{board:slug}', [BoardController::class, 'show'])->name('community.board');
Route::get('/community/{board:slug}/{postSlug}', [PostController::class, 'show'])
    ->where('postSlug', '[0-9]+-.+')
    ->name('community.post');

Route::middleware('auth')->scopeBindings()->group(function () {
    Route::get('/community/{board:slug}/create', [PostController::class, 'create'])->name('community.post.create');
    Route::post('/community/{board:slug}/store', [PostController::class, 'store'])->name('community.post.store');
    Route::get('/community/{board:slug}/{post}/edit', [PostController::class, 'edit'])->name('community.post.edit');
    Route::put('/community/{board:slug}/{post}/update', [PostController::class, 'update'])->name('community.post.update');
    Route::delete('/community/{board:slug}/{post}/destroy', [PostController::class, 'destroy'])->name('community.post.destroy');

    Route::post('/community/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/community/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
});

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware([ProtectAgainstSpam::class, 'throttle:5,1'])
    ->name('contact.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/pages.php';
