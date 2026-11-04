<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ContactController extends Controller
{
    private const SERVICE_INTERESTS = [
        'performance-marketing',
        'cpa-marketing',
        'cpa-insurance',
        'reward-network',
        'reward-advertiser',
        'reward-publisher',
        'seo',
        'wordpress',
        'rankfree',
        'boostingshop',
        'leadbay',
        'call2sale',
        'marketing-support',
        'other',
    ];

    private const UTM_KEYS = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    private const UTM_SESSION_KEY = 'contact.utm';

    public function show(Request $request): View
    {
        $utm = $this->utmFromQuery($request);

        if ($utm !== []) {
            $storedUtm = $request->session()->get(self::UTM_SESSION_KEY, []);
            $storedUtm = is_array($storedUtm) ? $storedUtm : [];

            $request->session()->put(self::UTM_SESSION_KEY, array_replace($storedUtm, $utm));
        }

        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_interest' => ['required', Rule::in(self::SERVICE_INTERESTS)],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $this->verifyTurnstile($request);

        $storedUtm = $request->session()->get(self::UTM_SESSION_KEY, []);
        $storedUtm = is_array($storedUtm) ? $storedUtm : [];
        $utm = array_replace($storedUtm, $this->utmFromQuery($request));

        $lead = new Lead;
        $lead->name = $validated['name'];
        $lead->company = $validated['company'] ?? null;
        $lead->email = $validated['email'];
        $lead->phone = $validated['phone'] ?? null;
        $lead->service_interest = $validated['service_interest'];
        $lead->message = $validated['message'];
        $lead->utm = $utm === [] ? null : $utm;
        $lead->status = 'new';
        $lead->save();

        $request->session()->forget(self::UTM_SESSION_KEY);

        return redirect()
            ->route('contact')
            ->with('status', 'inquiry-received');
    }

    /**
     * 클라우드플레어 Turnstile 서버 확인. 키가 둘 다 있을 때만 확인한다(없으면 예전처럼 통과).
     * 클라우드플레어가 응답하지 않을 때도 막는다(봇 막기가 목적).
     */
    private function verifyTurnstile(Request $request): void
    {
        $siteKey = config('services.turnstile.site_key');
        $secret = config('services.turnstile.secret_key');
        if (! $siteKey || ! $secret) {
            return;
        }

        $token = (string) $request->input('cf-turnstile-response', '');
        $ok = false;
        if ($token !== '' && strlen($token) <= 2048) {
            try {
                $ok = (bool) Http::asForm()->timeout(8)
                    ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                        'secret' => $secret,
                        'response' => $token,
                        'remoteip' => $request->ip(),
                    ])->json('success', false);
            } catch (\Throwable) {
                $ok = false;
            }
        }

        if (! $ok) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => '자동 입력 방지 확인을 마친 뒤 다시 보내 주세요.',
            ]);
        }
    }

    /**
     * @return array<string, string>
     */
    private function utmFromQuery(Request $request): array
    {
        $utm = [];

        foreach (self::UTM_KEYS as $key) {
            $value = $request->query($key);

            if (! is_string($value) || trim($value) === '') {
                continue;
            }

            $utm[$key] = mb_substr(trim($value), 0, 255);
        }

        return $utm;
    }
}
