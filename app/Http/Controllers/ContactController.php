<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
