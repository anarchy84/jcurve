<?php

/*
| 영어 회사소개 (Claude, 2026-11-03). 원문 = resources/views/pages/company.blade.php. 사실·숫자·순서 그대로, 용어는 docs/intl/GLOSSARY.md.
*/

return [
    'title' => 'About us | J-Curve Interactive, digital marketing agency in Seoul since 2009',
    'description' => 'Founded in 2009, J-Curve Interactive connects ad buying, CPA, reward ads, search, web builds and its own software in one team. Our story and how we work.',

    'hero' => [
        'eyebrow' => 'About J-Curve',
        'h1' => ['Since 2009,', 'we have let execution and data do the talking'],
        'lead' => 'We never stopped at running ads for clients. Acquisition, conversion, search, lead operations, web systems — we have solved the bottlenecks ourselves.',
        'cta_primary' => 'Project inquiry',
        'cta_secondary' => 'How we work',
    ],

    'local_nav' => [
        'aria' => 'About us sections',
        'items' => ['story' => 'Our story', 'how-we-work' => 'How we work', 'capabilities' => 'Capabilities', 'products' => 'Our products', 'faq' => 'FAQ'],
    ],

    'story' => [
        'eyebrow' => 'Our Story',
        'h2' => 'Markets changed their names. Clients kept asking the same question.',
        'paragraphs' => [
            'J-Curve started in 2009. Media and technology kept changing, but advertisers always wanted to know one thing: “What did this budget actually produce?”',
            'So we started looking past impressions and clicks — whether a consultation request was valid, whether an installing user reached the core feature, whether search visitors turned into inquiries, and whether the operations team could turn those results into the next action.',
            'When the tool we needed did not exist, we built it. That accumulated execution became today’s performance, CPA, reward, SEO and web services, and four products of our own.',
        ],
        'callout' => 'As the name J-Curve suggests, we build structures where small improvements add up until the growth curve bends upward.',
    ],

    'stats' => [
        'aria' => 'Company-wide cumulative figures',
        // [숫자, 라벨] — 회사 전체 누적(2026년 기준) 라벨을 유지한다(서비스별 실적으로 오인 금지)
        'items' => [
            ['KRW 37.3B+', 'As of 2026 · cumulative ad spend managed, company-wide'],
            ['1.28M+', 'As of 2026 · cumulative leads collected, company-wide'],
            ['15,700+', 'As of 2026 · cumulative campaigns run, company-wide'],
            ['2009', 'Year of incorporation'],
        ],
    ],

    'how' => [
        'eyebrow' => 'How We Work',
        'h2' => 'Before results, we agree on what counts as a result',
        'points' => [
            ['Translate goals into numbers', 'We turn “make it work” into checkable criteria — revenue, qualified leads, sign-ups, key actions.'],
            ['No scaling without measurement', 'We check the foundation first, so you can see where conversions happen and what changes them.'],
            ['Validate small, adjust fast', 'We do not change everything at once. We split hypotheses, run them, and decide to keep, stop or scale.'],
            ['Uncomfortable numbers get shared too', 'We do not report only the good results. What is blocked and what we will change next sit in the same table.'],
        ],
    ],

    'loop' => [
        'eyebrow' => 'One Operating Loop',
        'h2' => 'Strategy, creative, media and development look at the same problem',
        'steps' => [
            ['Diagnose', 'We find the biggest bottleneck across your business model, customer journey, existing channels and data setup.'],
            ['Design', 'We connect goals, conversions, messaging, media, pages and follow-up operations into one execution plan.'],
            ['Execute', 'We run ads, content and creative, search optimization and the web work needed — within the agreed scope.'],
            ['Learn', 'We record what worked and why things failed, and feed it back into the next budget, creative and product priorities.'],
        ],
    ],

    'capabilities' => [
        'eyebrow' => 'Capabilities',
        'h2' => 'From bringing customers in to running what happens after conversion',
        // [제목, 설명, 링크 문구, 라우트, 인자]
        'cards' => [
            ['Data-driven ad operations', 'Connects media, creative and landing pages to the business KPIs we agree on.', 'Performance marketing →', 'services.show', ['slug' => 'performance-marketing']],
            ['Performance actions & leads', 'Runs on qualified actions and review and settlement criteria agreed in advance.', 'CPA marketing →', 'services.show', ['slug' => 'cpa-marketing']],
            ['Reward ecosystem', 'Connects advertiser actions with app monetization through shared operating criteria.', 'Reward ad network →', 'services.show', ['slug' => 'reward-network']],
            ['Search & AI visibility', 'Builds technology, content and trust signals into searchable digital assets.', 'SEO · AEO · GEO →', 'services.show', ['slug' => 'seo']],
            ['Marketing websites', 'Websites built for discovery, understanding, conversion and operations.', 'WordPress →', 'services.show', ['slug' => 'wordpress']],
        ],
    ],

    'products' => [
        'eyebrow' => 'Owned Products',
        'h2' => 'When the tool did not exist, we built it in the field',
        'paragraphs' => [
            'We built RankFree because we wanted to see ranking data ourselves, and ran BoostingShop to meet demand for self-serve marketing. Problems that kept recurring in insurance sales and lead call centers became LeadBay and Call2Sale.',
            'Running an agency and building products together means ideas do not end in a report. A recurring problem becomes a process, and where needed, a real tool.',
        ],
        'more' => 'Product overview →',
        'cards' => [
            ['RankFree', 'Our own tool for checking search rankings and market data.', 'solutions.rankfree'],
            ['BoostingShop', 'A self-serve service where you pick the marketing units you need.', 'solutions.boostingshop'],
            ['LeadBay', 'A CRM connecting lead purchasing, consultations and contracts for insurance sales teams.', 'solutions.leadbay'],
            ['Call2Sale', 'A CRM managing lead production, delivery and settlement for insurance lead call centers.', 'solutions.call2sale'],
        ],
    ],

    'ways' => [
        'eyebrow' => 'Ways To Work Together',
        'h2' => 'We work at the depth you need',
        'points' => [
            ['Diagnosis and design', 'We audit your current setup and set priorities, KPIs and an execution roadmap.'],
            ['Execution in specific areas', 'We take on only the parts you need — an ad channel, CPA, rewards, SEO or a website.'],
            ['Integrated operations', 'We run acquisition, conversion, content and page improvements on one rhythm.'],
            ['Adopting our products', 'Recurring operational problems are reviewed against the products J-Curve has built.'],
        ],
    ],

    'faq' => [
        'eyebrow' => 'FAQ',
        'h2' => 'Before working with J-Curve',
        'items' => [
            ['Are you an ad agency or a software company?', 'Both. We run ads, CPA, reward, SEO and web projects, and we develop and run our own products to solve problems that keep recurring in the field.'],
            ['How does a project start?', 'We first check your goals, conversion criteria, current data and execution conditions. We move to execution only when the scope and prerequisites line up.'],
            ['Can we hand over just part of the work?', 'Yes. Beyond full operation, we can scope only what you need — an account audit, a specific channel, SEO, a website or your measurement setup.'],
            ['Do you guarantee results in advance?', 'We do not guarantee market response or platform results in advance. Instead, we first agree on what to measure, the scope of tests, and the conditions to keep, stop or scale.'],
        ],
    ],

    'cta' => [
        'h2' => ['Describe the problem.', 'We will turn it into a structure you can execute.'],
        'text' => 'We will work out together whether to start with ads, search, leads, rewards or the web.',
        'button' => 'Start a project inquiry',
    ],
];
