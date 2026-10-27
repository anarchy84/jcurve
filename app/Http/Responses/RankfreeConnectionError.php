<?php

namespace App\Http\Responses;

use App\Services\Rankfree\ConnectionStoreException;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class RankfreeConnectionError
{
    public static function handles(Request $request): bool
    {
        return $request->is('api/account/rankfree-connection', 'api/account/rankfree-connection/*');
    }

    public static function render(Throwable $exception): JsonResponse
    {
        [$status, $code, $message] = match (true) {
            $exception instanceof AuthenticationException => [401, 'unauthenticated', '로그인이 필요합니다.'],
            $exception instanceof AuthorizationException => [403, 'forbidden', '이 작업은 허용되지 않습니다.'],
            $exception instanceof ValidationException => [422, 'validation_failed', '입력값을 확인해 주세요.'],
            $exception instanceof TokenMismatchException => [419, 'csrf_mismatch', '보안 토큰을 갱신한 후 다시 시도해 주세요.'],
            $exception instanceof ConnectionStoreException => [503, $exception->reason === 'connections_disabled' ? 'connections_disabled' : 'connection_storage_unavailable', '계정 연결을 처리할 수 없습니다.'],
            $exception instanceof RankfreeException => [422, 'connection_invalid', '계정 연결 정보를 확인해 주세요.'],
            $exception instanceof HttpExceptionInterface => self::httpError($exception->getStatusCode()),
            default => [500, 'internal_error', '계정 연결을 처리할 수 없습니다.'],
        };
        $error = ['code' => $code, 'message' => $message];
        if ($exception instanceof ValidationException) {
            $error['fields'] = [];
            foreach (array_keys($exception->errors()) as $field) {
                if (in_array($field, ['api_key', 'current_password', 'request'], true)) {
                    $error['fields'][$field] = [$field === 'current_password' ? '현재 비밀번호를 확인해 주세요.' : '입력값을 확인해 주세요.'];
                }
            }
        }
        $headers = ['Cache-Control' => 'no-store, private', 'X-Robots-Tag' => 'noindex, nofollow', 'X-Content-Type-Options' => 'nosniff'];
        if ($exception instanceof HttpExceptionInterface) {
            foreach ($exception->getHeaders() as $name => $value) {
                if (in_array(strtolower($name), ['retry-after', 'x-ratelimit-limit', 'x-ratelimit-remaining', 'x-ratelimit-reset'], true)
                    && is_scalar($value) && preg_match('/^\d+$/D', (string) $value)) {
                    $headers[$name] = (string) $value;
                }
            }
        }

        return response()->json(['error' => $error], $status, $headers);
    }

    private static function httpError(int $status): array
    {
        return match ($status) {
            400 => [400, 'invalid_json', 'JSON 요청 형식을 확인해 주세요.'],
            403 => [403, 'forbidden', '요청이 허용되지 않습니다.'],
            404 => [404, 'not_found', '요청한 경로가 없습니다.'],
            405 => [405, 'method_not_allowed', '허용되지 않는 요청 방식입니다.'],
            413 => [413, 'payload_too_large', '요청 크기가 너무 큽니다.'],
            415 => [415, 'json_required', 'JSON 형식으로 요청해 주세요.'],
            419 => [419, 'csrf_mismatch', '보안 토큰을 갱신한 후 다시 시도해 주세요.'],
            429 => [429, 'rate_limited', '잠시 후 다시 시도해 주세요.'],
            default => [$status >= 400 && $status <= 599 ? $status : 500, 'request_failed', '계정 연결을 처리할 수 없습니다.'],
        };
    }
}
