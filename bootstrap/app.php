<?php

use App\Http\Responses\RankfreeConnectionError;
use App\Models\LegacyRedirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            Route::middleware('web')->group(base_path('routes/seo.php'));
            Route::middleware('web')->group(base_path('routes/rankfree-connections.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontFlash(['api_key', 'credential_ciphertext', 'current_password']);
        $exceptions->report(function (Throwable $exception): ?bool {
            if (app()->bound('request') && RankfreeConnectionError::handles(request())) {
                Log::warning('rankfree_connection_request_failed', ['exception_type' => $exception::class]);

                return false;
            }

            return null;
        });
        $exceptions->render(function (Throwable $exception, Request $request): ?Response {
            return RankfreeConnectionError::handles($request) ? RankfreeConnectionError::render($exception) : null;
        });
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // 라우트 매칭 실패(404) 시에만 레거시 URL 리다이렉트 조회.
        // 정상 트래픽에는 오버헤드 0 (404에서만 DB 1회 조회).
        $exceptions->render(function (NotFoundHttpException $e, Request $request): ?Response {
            try {
                $redirect = LegacyRedirect::resolveFor($request);
            } catch (Throwable) {
                // DB 미가동(마이그레이션 전 등)이면 조용히 기본 404 유지.
                return null;
            }

            if ($redirect === null) {
                return null;
            }

            $redirect->increment('hit_count');

            return redirect($redirect->to_path, $redirect->status_code);
        });
    })->create();
