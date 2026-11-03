<?php

/*
| 영어 문의 (Claude, 2026-11-03). 원문 = resources/views/contact.blade.php.
| 언어 안내는 제코 11/3 결정 「번역기로 대응」 — 어느 언어로 써도 되고, 답은 번역을 거쳐 보낸다. 「같은 언어로 답한다」는 약속은 하지 않는다.
*/

return [
    'title' => 'Contact us | J-Curve Interactive',
    'description' => 'Talk to us about performance ads, CPA, reward ads, SEO, websites or our own products. Tell us where you are and what you want to achieve, and we will come back with what to check and how to proceed.',

    'hero' => [
        'eyebrow' => 'Project Inquiry',
        'h1' => ['Tell us what is stuck,', 'not just what to hand over'],
        'lead' => 'You do not need to pick the right service name. We will read your goals and current situation, then come back with what to check, what is possible and the next steps.',
        'cta' => 'Write your inquiry',
    ],

    'brief' => [
        'eyebrow' => 'A Better Brief',
        'h2' => 'These four things make the conversation faster',
        'points' => [
            ['The goal to solve now', 'The one result that matters most — revenue, qualified consultations, post-install actions, search visibility or site conversions.'],
            ['Where things stand today', 'The ad channels you use, your site or app URL, who runs it internally and where you feel most stuck.'],
            ['Budget and timing range', 'It does not have to be a fixed amount. Tell us the range you can consider and when you would like to start.'],
            ['Data to reference', 'Recent reports, conversion definitions or past proposals make the diagnosis more accurate. You can still contact us without them.'],
        ],
    ],

    'form' => [
        'eyebrow' => 'Tell Us About The Project',
        'h2' => 'Project inquiry',
        'intro' => 'Write as much as you know. We will ask about anything we need to confirm when we get back to you.',
        'language' => 'You can write in English, Japanese or any language you are comfortable with. Our team works in Korean, so replies are prepared with the help of translation.',
        'received' => 'Your inquiry has been received. We will review it and reply to the contact details you left.',
        'name' => 'Name',
        'company' => 'Company',
        'email' => 'Email',
        'phone' => 'Phone (with country code)',
        'interest' => 'Service of interest',
        'select' => 'Select',
        'group_services' => 'Marketing services',
        'group_products' => 'Our products',
        // value => 문구. value 는 한국어 폼과 같은 값(서버 허용 목록)
        'options_services' => [
            'performance-marketing' => 'Performance marketing',
            'cpa-marketing' => 'CPA marketing',
            'cpa-insurance' => 'Insurance CPA · consent-based leads',
            'reward-advertiser' => 'Running reward ads',
            'reward-publisher' => 'Reward app publisher partnership',
            'seo' => 'SEO · AEO · GEO',
            'wordpress' => 'WordPress build & management',
            'marketing-support' => 'Korean SME marketing support programs',
        ],
        'options_products' => [
            'rankfree' => 'RankFree',
            'boostingshop' => 'BoostingShop',
            'leadbay' => 'LeadBay',
            'call2sale' => 'Call2Sale',
        ],
        'other' => 'Not sure yet · Other',
        'message' => 'Message',
        'placeholder' => 'Your goal, current situation, budget range, preferred timing and anything you want us to check.',
        'submit' => 'Send inquiry',
        'privacy_before' => 'We use the information you send to review and reply to your inquiry. See our',
        'privacy_link' => 'privacy policy',
        'privacy_after' => 'for details.',
    ],

    'next' => [
        'eyebrow' => 'What Happens Next',
        'h2' => 'What happens after you contact us',
        'steps' => [
            ['We review it', 'We check your goals, service fit, the materials we need and any legal or technical prerequisites.'],
            ['Follow-up questions and diagnosis', 'Rather than proposing right away, we first ask what we need to understand your current data and bottlenecks.'],
            ['Agree on scope and next steps', 'We separate what we can do, what needs separate preparation, the order of work and the points to discuss.'],
        ],
    ],

    'faq' => [
        'eyebrow' => 'FAQ',
        'h2' => 'Questions before you contact us',
        'items' => [
            ['Can I contact you without knowing exactly which service I need?', 'Yes. Tell us your current goal and where you feel most stuck, and we will start by sorting out which area to check first — ads, measurement, content or your site.'],
            ['What should I prepare before the consultation?', 'It helps to have the channels you run, your site URL, your monthly budget range, the conversions that matter and recent performance data. Without them, we can still start from your current situation.'],
            ['Does contacting you mean we sign a contract?', 'No. We review your inquiry, ask for any additional information, align on what we can do and the next steps, and only then decide on a contract separately.'],
            ['Can I send sensitive account information or customer data?', 'Please do not send passwords, API keys or customers’ personal data in your first inquiry. Even when we need access for a review, we agree on how access is given and what is shared first.'],
            ['Which language should I write in?', 'Any language you are comfortable with. Our team works in Korean, so replies are prepared with the help of translation.'],
        ],
    ],
];
