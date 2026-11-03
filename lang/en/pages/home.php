<?php

/*
| 영어 홈 문구 (Claude, 2026-11-03). 대상 = 한국 시장에 들어오려는 외국 기업.
| 사실·숫자는 한국어 홈(resources/views/pages/home.blade.php) 그대로. 용어는 docs/intl/GLOSSARY.md.
| 한국어에만 맞는 문장(「지금 이 화면도 저희가 검색 상위에 올린 결과」 등)은 영어판에 사실이 아니므로 뺐다.
*/

return [
    'title' => 'Digital marketing agency in Korea | J-Curve Interactive',
    'description' => 'Performance ads, CPA, SEO and NAVER, Coupang and Kakao marketing for brands growing in Korea. KRW 37.3B+ cumulative ad spend managed as of 2026.',

    'hero' => [
        'badge' => 'Performance · CPA · SEO · Reward network',
        'h1' => 'Your revenue partner in Korea',
        'brand' => 'J-Curve Interactive',
        'lead' => 'Performance ads, search and AI-answer optimization, and our own data tools — a full-service digital marketing agency in Seoul that reports in numbers.',
        'cta_primary' => 'Talk to us',
        'cta_secondary' => 'See our services',
        'tabs_label' => 'Hero panels',
        'tab_numbers' => 'By the numbers',
        'tab_start' => 'Get started',
        'numbers_title' => 'Proof in numbers, not promises',
        'numbers_meta' => 'Cumulative, as of 2026',
        'start_title' => 'Start the way that fits you',
    ],

    // [숫자, 라벨, 카운트 지연ms] — 값은 한국어판 그대로
    'hero_proof' => [
        ['1.28M+', 'leads collected', 600],
        ['15,700+', 'campaigns run', 900],
        ['KRW 37.3B+', 'ad spend managed', 1200],
    ],

    'doors' => [
        ['megaphone', 'Hand it to us', 'Marketing services', 'We run performance, CPA, SEO and reward campaigns for you.', 'services.index'],
        ['self', 'Order it yourself', 'Self-serve marketing', 'NAVER Place and shopping ranking campaigns you can order directly.', 'self-marketing'],
        ['store', 'Use our platforms', 'Our platforms', 'RankFree · BoostingShop · ShopiTrend · LeadBay · Call2Sale', 'solutions.index'],
    ],

    'korea' => [
        'label' => 'WHY A LOCAL PARTNER',
        'h2' => 'Korea runs on its own platforms',
        'text' => 'Korean customers search on NAVER, shop on Coupang and NAVER Shopping, and talk on KakaoTalk. A global playbook alone does not reach them. We plan and run campaigns on these platforms and on Google, YouTube and Meta.',
        'items' => [
            ['seo', 'NAVER', "Korea's largest search portal — search results, blogs, maps (NAVER Place) and NAVER Shopping."],
            ['coupang', 'Coupang', "Korea's largest e-commerce marketplace, with its own search ranking."],
            ['gift', 'KakaoTalk', "Korea's dominant messenger — and Kakao Gift, the gifting store inside it."],
            ['performance', 'Google · YouTube · Meta', 'The global channels, run against the same Korean revenue KPIs.'],
        ],
    ],

    'biz' => [
        'h2' => 'Hand it to us, order it yourself, or use our platforms',
        'text' => 'J-Curve Interactive runs agency services, self-serve marketing and its own platforms under one roof. Start the way that fits you.',
        'kicker' => 'Hand it to us',
        'col_title' => 'Marketing services',
        'more' => 'Learn more',
        'consult' => 'Talk to us',
        'close' => 'Close details',
        'all' => 'All services',
        'self_kicker' => 'Order it yourself',
        'self_title' => 'Self-serve marketing',
        'self_text' => 'Pick and order NAVER Place and shopping ranking campaigns. Tell us your store or product and we will set it up with you.',
        'self_cta' => 'About self-serve marketing',
        'ops_kicker' => 'Use our platforms',
        'ops_title' => 'Our platforms',
        'ops_all' => 'All our platforms',
    ],

    // [아이콘, 이름, 한 줄, 그룹, 제목, 설명, 라우트 이름, 라우트 인자, 하위 링크 키]
    'services' => [
        ['performance', 'Performance marketing', 'Media buying on conversions', 'Advertising', 'Your ad spend, measured in revenue',
            'We run media against the business KPIs we agree on — revenue, qualified leads, sign-ups — not platform vanity metrics.',
            'services.show', ['slug' => 'performance-marketing'], 'performance'],
        ['cpa', 'CPA marketing', 'Pay per qualified action', 'Advertising', 'Performance ads billed per qualified action',
            'We run campaigns on qualified actions agreed in advance — installs, sign-ups, purchases, consultation requests — and design the tracking and settlement too.',
            'services.show', ['slug' => 'cpa-marketing'], 'cpa'],
        ['reward', 'Reward ad network', 'Advertiser actions × app monetization', 'Advertising', 'Connecting advertiser actions with app monetization',
            'From advertiser campaigns built around a target action to partnerships with apps that run offerwalls and reward placements — in one flow.',
            'services.show', ['slug' => 'reward-network'], 'reward'],
        ['seo', 'SEO · AEO · GEO', 'Visibility in search and AI answers', 'Search marketing', 'Built to be found in search and AI answers',
            'From Google and NAVER SEO to AEO and GEO. We fix crawling, indexing, content, entities, trust signals and the path to conversion together.',
            'services.show', ['slug' => 'seo'], 'seo'],
        ['place', 'Place & shopping', 'NAVER · Coupang · Kakao rankings', 'Search marketing', 'From discovery to visit and purchase',
            'On NAVER Place, NAVER Shopping, Coupang and Kakao Gift we align search intent, store and product information, and the conversion path.',
            'services.seo.sub', ['sub' => 'naver-place'], 'place'],
        ['backlink', 'Backlinks', 'Trust signals for search', 'Search marketing', 'Designing trust signals for search',
            'Managed step by step — from page diagnosis to source context, anchor text and link health checks.',
            'services.seo.sub', ['sub' => 'backlinks'], null],
        ['wordpress', 'WordPress build & management', 'Sites built for search', 'Build & support', 'Websites built for search and marketing',
            'We build and run sites with search, ads, content operations and conversion tracking in mind — not design alone.',
            'services.show', ['slug' => 'wordpress'], null],
        ['support', 'SME marketing support programs', 'From notice to evidence', 'Build & support', 'Execution support for Korean government SME marketing programs',
            'We check the notice, scope and evidence requirements, then support execution — ads, SEO, content, video, web — and the result documents. Selection and grant payment are not guaranteed.',
            'services.marketing-support', [], null],
    ],

    'subs' => [
        'performance' => [
            ['Google Ads', 'google-ads'],
            ['NAVER GFA', 'services.performance.sub', ['sub' => 'naver-gfa']],
            ['Facebook & Instagram', 'services.performance.sub', ['sub' => 'facebook']],
            ['YouTube', 'services.performance.sub', ['sub' => 'youtube']],
        ],
        'cpa' => [
            ['Real estate pre-sale', 'services.cpa.sub', ['sub' => 'real-estate']],
            ['Stock-investor leads', 'services.cpa.sub', ['sub' => 'stock']],
            ['Insurance leads', 'services.cpa.sub', ['sub' => 'insurance']],
            ['Crypto-investor leads', 'services.cpa.sub', ['sub' => 'coin']],
            ['Consent-based call leads', 'services.cpa.sub', ['sub' => 'permission-call']],
        ],
        'reward' => [
            ['Advertiser campaigns', 'services.show', ['slug' => 'reward-network'], '#advertisers'],
            ['App publisher partnerships', 'services.show', ['slug' => 'reward-network'], '#publishers'],
        ],
        'seo' => [
            ['SEO', 'services.show', ['slug' => 'seo']],
            ['AEO — Answer Engine Optimization', 'services.seo.aeo', []],
            ['GEO — Generative Engine Optimization', 'services.seo.geo', []],
        ],
        'place' => [
            ['NAVER Place', 'services.seo.sub', ['sub' => 'naver-place']],
            ['NAVER Shopping', 'services.seo.sub', ['sub' => 'naver-shopping']],
            ['Coupang', 'services.seo.sub', ['sub' => 'coupang']],
            ['Kakao Gift', 'services.seo.sub', ['sub' => 'kakao-gift']],
        ],
    ],

    'trust' => [
        'h2' => 'Brands we have run campaigns for',
        'brands' => ['Netflix', 'LG U+', 'Hyundai Marine & Fire Insurance', 'Yanolja', 'Hamsoa', 'Daemyung Resort', 'Lami Cosmetics', '1300K', 'Yoogane'],
        'proof' => 'As of 2026: KRW 37.3 billion in cumulative ad spend managed · 15,700 campaigns run',
    ],

    'stats' => [
        'label' => 'BY THE NUMBERS',
        'h2' => 'The numbers speak first',
        'text' => 'Proven with cumulative data, not gut feeling. As of 2026.',
        'items' => [
            ['KRW 37.3B+', 'Ad spend managed', 'Actual media spend'],
            ['1.28M+', 'Leads collected', 'Performance and lead campaigns combined'],
            ['15,700+', 'Campaigns run', 'Cumulative campaigns'],
        ],
    ],

    'layers' => [
        'h2' => 'From media to signed contracts — we run all five layers',
        'text' => 'A company that handles one layer cannot explain problems that start in another. J-Curve runs the apps, the network, visibility, conversion and sales ourselves.',
        // [번호, 이름, 하는 일, 우리 것, CTA, 라우트 이름(또는 #앵커), 아이콘]
        'items' => [
            ['1', 'Media', 'Apps people use every day', 'Our own reward apps, such as Kkokko Farm and Saim Cash', 'See our apps', '#apps', 'apps'],
            ['2', 'Network', "Connecting advertisers' missions to media", 'Reward ad network, offerwall', 'Reward ad network', 'reward', 'network'],
            ['3', 'Visibility', 'Being seen in search, AI and platforms', 'SEO·AEO·GEO, self-serve marketing, RankFree', 'Self-serve marketing', 'self-marketing', 'seo'],
            ['4', 'Conversion', 'Turning ad spend into inquiries and purchases', 'Performance marketing, CPA marketing', 'Advertising services', 'services.index', 'performance'],
            ['5', 'Sales', 'Turning incoming leads into contracts', 'LeadBay, Call2Sale', 'Our platforms', 'solutions.index', 'users'],
        ],
    ],

    'products' => [
        'label' => 'OUR PRODUCTS',
        'h2' => 'We build our own tools',
        'text' => 'We do not rent other people\'s tools. From marketing data to a sales CRM for insurance teams, we build and run the tools the work needs.',
        'more' => 'Learn more →',
        // [이름, 설명, 라우트, 아이콘]
        'items' => [
            ['RankFree', 'NAVER ranking and market analysis', 'solutions.rankfree', 'rankfree'],
            ['BoostingShop', 'Self-serve marketing you run yourself', 'solutions.boostingshop', 'boostingshop'],
            ['ShopiTrend', 'ShopiTrend marketing platform', 'solutions.shopitrend', 'shopitrend'],
            ['LeadBay', 'Sales CRM for insurance sales teams', 'solutions.leadbay', 'leadbay'],
            ['Call2Sale', 'Call-center CRM for insurance leads', 'solutions.call2sale', 'call2sale'],
        ],
    ],

    'apps' => [
        'h2' => 'Reward apps we run today',
        'text' => 'Apps we plan, build and run on the app stores ourselves. Advertisers\' missions run inside these apps.',
        'prev' => 'Previous app',
        'next' => 'Next app',
        'alt' => ':name app screen',
        // [파일, 이름, 설명]
        'items' => [
            ['eggfarm-1', 'Kkokko Farm', 'Raise chickens, earn mobile gift vouchers and cash'],
            ['carrotcash-1', 'Danggeun Cash', 'Grow carrots, earn mobile gift vouchers and cash'],
            ['pigcash-1', 'Kkulkkul Cash', 'Log your meals, earn mobile gift vouchers and cash'],
            ['cashpang-1', 'Cash Pangpang', 'Study English words, earn mobile gift vouchers and cash'],
            ['stamptech-1', 'Kkuk Tech', 'Study Korean daily, earn mobile gift vouchers and cash'],
            ['moneytree-1', 'Money Tree', 'Grow a tree, earn mobile gift vouchers and cash'],
        ],
    ],

    'split' => [
        'aria' => 'Advertisers and app publishers',
        'adv_label' => 'Advertisers & brands',
        'adv_h2' => 'Reward ads run per target action',
        'adv_text' => 'Go beyond installs: choose the depth of action you need — sign-up, mission completion, consultation request, purchase. Approval criteria are agreed in writing before launch and applied the same way during the campaign.',
        'adv_chips' => ['App install', 'Sign-up', 'Mission completion', 'Consultation request', 'Purchase'],
        'adv_cta' => 'Discuss a campaign',
        'pub_label' => 'App publishers',
        'pub_h2' => 'Offerwall monetization that fits your app',
        'pub_text' => 'We pick touchpoints that suit your service and design user experience and revenue together — from media review to integration and stable operation.',
        'pub_chips' => ['Offerwall setup', 'User experience', 'Revenue operations', 'Settlement criteria'],
        'pub_cta' => 'Publisher partnership',
    ],

    'insights' => [
        'label' => 'INSIGHTS',
        'h2' => 'Notes from the field',
        'text' => 'We only write up what we have tested in practice.',
        'all' => 'All insights →',
    ],

    'cta' => [
        'h2' => 'Planning to grow in Korea?',
        'text' => 'Tell us where your marketing stands today. We will start by pointing out what to improve.',
        'phone' => 'Phone',
        'email' => 'Email',
        'primary' => 'Talk to us',
        'secondary' => 'See our services',
    ],
];
