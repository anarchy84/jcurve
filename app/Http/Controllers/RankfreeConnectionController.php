<?php

namespace App\Http\Controllers;

use App\Services\Rankfree\ConnectionStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use JsonException;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RankfreeConnectionController extends Controller
{
    public function show(Request $request, ConnectionStore $store): JsonResponse
    {
        $this->noQuery($request);

        return response()->json(['data' => $store->statusFor($request->user())]);
    }

    public function update(Request $request, ConnectionStore $store): JsonResponse
    {
        $payload = $this->payload($request, ['api_key', 'current_password']);
        $values = Validator::make($payload, [
            'api_key' => ['bail', 'required', 'string', 'max:512', 'regex:/^rk_[A-Za-z0-9_-]+$/D'],
            'current_password' => ['bail', 'required', 'string', 'max:1024', 'current_password:web'],
        ])->stopOnFirstFailure()->validate();

        return response()->json(['data' => $store->registerFor($request->user(), $values['api_key'])]);
    }

    public function destroy(Request $request, ConnectionStore $store): Response
    {
        $payload = $this->payload($request, ['current_password']);
        Validator::make($payload, [
            'current_password' => ['bail', 'required', 'string', 'max:1024', 'current_password:web'],
        ])->stopOnFirstFailure()->validate();
        $store->disconnectFor($request->user());

        return response()->noContent();
    }

    private function noQuery(Request $request): void
    {
        if ($request->query->count() > 0) {
            throw ValidationException::withMessages(['request' => ['Query parameters are not supported.']]);
        }
    }

    private function payload(Request $request, array $allowed): array
    {
        $this->noQuery($request);
        if (! $request->isJson()) {
            throw new HttpException(415);
        }
        if (strlen($request->getContent()) > 8192) {
            throw new HttpException(413);
        }
        try {
            $body = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new HttpException(400);
        }
        if (! $body instanceof stdClass) {
            throw new HttpException(400);
        }
        $payload = get_object_vars($body);
        if (array_diff(array_keys($payload), $allowed) !== []) {
            throw ValidationException::withMessages(['request' => ['Unsupported input fields.']]);
        }

        return $payload;
    }
}
