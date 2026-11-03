<?php

return [
    'title' => 'FAQ — Support | J-Curve Interactive',
    'description' => 'Find answers about performance, CPA and rewarded ads, SEO, AEO (Answer Engine Optimization), GEO (Generative Engine Optimization), self-serve marketing, BoostingShop, LeadBay, Call2Sale, web builds and support programs.',
    'heading' => 'Frequently asked questions',
    'breadcrumb_aria' => 'Current location',
    'home' => 'Home',
    'support' => 'Support',
    'lead' => 'We have collected the questions we receive most often about each service. If you cannot find the answer you need, send us an inquiry.',
    'search_label' => 'Search questions',
    'search_placeholder' => 'Search your question — for example: guarantees, accounts, refunds, reports',
    'questions' => 'questions',
    'results' => 'results',
    'inquiry' => 'Send an inquiry',
    'project_direct' => 'Project inquiry (1:1)',
    'project' => 'Project inquiry',
    'list_aria' => 'List of questions',
    'categories_aria' => 'Question categories',
    'all' => 'All',
    'related' => 'Related page',
    'empty_before' => 'We could not find any questions matching “',
    'empty_after' => '”.',
    'empty_text' => 'Try a different term, or send us an inquiry. We will check your question and reply.',
    'cta_heading' => 'Cannot find the answer you need?',
    'cta_text' => 'Send us your question. For a project consultation, a direct 1:1 inquiry is the fastest way to reach us.',
    'phone' => 'Phone',
    'email' => 'Email',
    'categories' => [
        'start' => [
            'label' => 'Getting started & consultations',
            'icon' => 'megaphone',
            'items' => [
                [
                    'q' => 'Which service should we start with?',
                    'a' => 'Choose your most urgent goal: quickly testing sales potential, securing valid actions, increasing app activity, building search assets or establishing your own web channel. If the goal is unclear, we first diagnose where your current data shows the largest drop-off.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'Marketing services',
                    ],
                ],
                [
                    'q' => 'Can you run several services together?',
                    'a' => 'Yes. Before adding more channels, we need to align conversion definitions and measurement criteria. With that foundation in place, we can apply what paid ads teach us to SEO, your website and reward campaigns.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'Marketing services',
                    ],
                ],
                [
                    'q' => 'Can we work with you if we already have an agency or an internal team?',
                    'a' => 'Yes. We can plan a full handover or take on only the gaps, such as diagnosis, a specific channel, measurement improvements, production or SEO.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'Marketing services',
                    ],
                ],
                [
                    'q' => 'Do you guarantee results before a project starts?',
                    'a' => 'We cannot determine market response in advance. We agree on success criteria and stopping criteria before we start, then use measurable results to guide the next decision.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'Marketing services',
                    ],
                ],
                [
                    'q' => 'Are you an advertising agency or a software company?',
                    'a' => 'We operate both. Alongside advertising, CPA, rewarded ads, SEO and web builds, we develop and run our own software to solve recurring problems in day-to-day work.',
                    'from' => [
                        [
                            'route' => 'company',
                            'params' => [
                            ],
                        ],
                        'About us',
                    ],
                ],
                [
                    'q' => 'What needs to be in place before a project starts?',
                    'a' => 'We first review your goals, conversion criteria, current data and practical conditions for execution. We move to execution only when the feasible scope and prerequisites are aligned.',
                    'from' => [
                        [
                            'route' => 'company',
                            'params' => [
                            ],
                        ],
                        'About us',
                    ],
                ],
                [
                    'q' => 'Can we ask you to handle only part of the work?',
                    'a' => 'Yes. We can define the scope around the areas you need, such as an account audit, a specific channel, SEO, a web build or measurement setup, as well as full management.',
                    'from' => [
                        [
                            'route' => 'company',
                            'params' => [
                            ],
                        ],
                        'About us',
                    ],
                ],
                [
                    'q' => 'Can we contact you before we know which service we need?',
                    'a' => 'Yes. Tell us your current goals and biggest bottleneck. We will identify what to review first across advertising, measurement, content and your website.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project inquiry',
                    ],
                ],
                [
                    'q' => 'What information should we prepare before a consultation?',
                    'a' => 'It helps to have your current channels and website URLs, monthly budget range, key conversions and recent performance data. If you do not have these, we can start by clarifying your current situation together.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project inquiry',
                    ],
                ],
                [
                    'q' => 'Does sending an inquiry mean we have entered into a contract?',
                    'a' => 'No. We review your inquiry, ask for any further information we need and agree on a feasible scope and next steps. The decision to enter into a contract is made separately.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project inquiry',
                    ],
                ],
                [
                    'q' => 'Should we send sensitive account details or customer data?',
                    'a' => 'Do not send passwords, API keys or customers’ personal information in your first inquiry. Even when access is needed for a review, we first agree on the access method and the scope of information to provide.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project inquiry',
                    ],
                ],
            ],
        ],
        'ads' => [
            'label' => 'Advertising',
            'icon' => 'performance',
            'items' => [
                [
                    'q' => 'Can we start with a small advertising budget?',
                    'a' => 'What matters is how much data you can collect on your target conversions, rather than the budget alone. With a small budget, we reduce the number of channels and test variables so each test addresses a clear hypothesis.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'performance-marketing',
                            ],
                        ],
                        'Performance marketing',
                    ],
                ],
                [
                    'q' => 'Can we continue using our existing ad account?',
                    'a' => 'We first check the account structure and data continuity. Creating a new account is not always the right answer. We identify which assets to retain and which problems to resolve before defining the handover scope.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'performance-marketing',
                            ],
                        ],
                        'Performance marketing',
                    ],
                ],
                [
                    'q' => 'Do you also produce ad creative?',
                    'a' => 'We can coordinate filming, editing and design in-house. We confirm creative formats, quantities and whether filming is needed against the campaign goals and contract scope.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'performance-marketing',
                            ],
                        ],
                        'Performance marketing',
                    ],
                ],
                [
                    'q' => 'Do you guarantee revenue or ROAS?',
                    'a' => 'We do not guarantee specific revenue or ROAS. We agree on target conversions, test criteria and the conditions for stopping, continuing or scaling before we start, then assess results against the same criteria.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'performance-marketing',
                            ],
                        ],
                        'Performance marketing',
                    ],
                ],
                [
                    'q' => 'What will the reports cover?',
                    'a' => 'We focus on agreed business conversions, costs, differences by publisher, campaign and creative, and next actions, as well as impressions and clicks. The specific reporting items and frequency depend on the management scope.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'performance-marketing',
                            ],
                        ],
                        'Performance marketing',
                    ],
                ],
                [
                    'q' => 'Can any action be used for a CPA campaign?',
                    'a' => 'We first need to check whether the action can be measured technically, whether reasonable pricing and suitable publishers are available, and whether the industry and ad claims comply with applicable laws and platform policies.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'cpa-marketing',
                            ],
                        ],
                        'CPA marketing (pay-per-lead)',
                    ],
                ],
                [
                    'q' => 'Do you guarantee the target volume?',
                    'a' => 'We do not offer a blanket guarantee of a fixed volume. We discuss the feasible range after reviewing the difficulty of the action, pricing, schedule, publisher availability and initial campaign data.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'cpa-marketing',
                            ],
                        ],
                        'CPA marketing (pay-per-lead)',
                    ],
                ],
                [
                    'q' => 'How do you handle invalid leads or conversions?',
                    'a' => 'We assess them against acceptance and rejection criteria agreed before the campaign, including duplicates, errors in required fields, whether the person can be contacted and the scope of consent. Criteria may vary by industry and action.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'cpa-marketing',
                            ],
                        ],
                        'CPA marketing (pay-per-lead)',
                    ],
                ],
                [
                    'q' => 'Can data be delivered to our existing CRM or admin system?',
                    'a' => 'We review your current system and the fields to be delivered, then decide which integration methods are feasible. If development or API work is needed, we agree on it in advance as a scope separate from campaign management.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'cpa-marketing',
                            ],
                        ],
                        'CPA marketing (pay-per-lead)',
                    ],
                ],
                [
                    'q' => 'Do you also review personal information consent and ad approval requirements?',
                    'a' => 'We check the consent items, disclosures and publisher approval requirements needed to run the campaign. Final legal compliance and advertiser eligibility must also be checked against applicable laws and current expert and platform guidance.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'cpa-marketing',
                            ],
                        ],
                        'CPA marketing (pay-per-lead)',
                    ],
                ],
                [
                    'q' => 'Which actions can a reward campaign target?',
                    'a' => 'Campaigns can be designed around verifiable actions such as app installation, first launch, registration, tutorial completion, reaching a specific mission, requesting a quote or consultation, and purchasing. Feasibility and pricing depend on the industry, difficulty and validation method.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'Are users acquired through rewarded ads lower quality?',
                    'a' => 'Targeting installs alone can increase one-time participation. Follow-up missions, validity requirements, duplicate participation rules and monitoring metrics need to be designed together to assess quality against the campaign objective. Rewards alone do not determine every user’s value.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'Can you guarantee the volume we want?',
                    'a' => 'We do not guarantee a fixed volume in advance. Available volume depends on targeting, pricing, mission difficulty, duration and publisher conditions. We review participation and acceptance in an initial test before deciding how far to scale.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'Is an SDK always required for publisher integration?',
                    'a' => 'The integration method depends on the app structure and operating scope. We check existing ad placements, WebView and server integration options, and how rewards are processed before agreeing on the development scope and test procedure.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'Can a web service also become a publisher partner?',
                    'a' => 'We first need to review the service structure, login and member identification, reward policy, traffic characteristics and technical feasibility. We assess each service individually rather than assuming the same approach as for an app.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'How do you define invalid conversions?',
                    'a' => 'Before launch, we agree on campaign-specific invalidation criteria and required evidence, such as duplicate participation, unmet requirements, cancellations or refunds, and abnormal patterns. These criteria should not be changed arbitrarily while a campaign is running.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'What should advertisers prepare?',
                    'a' => 'Prepare your target action, preferred schedule and budget range, landing page or app link, conversion verification method, restrictions, creative and brand guidelines. We will turn any missing items into a checklist during the consultation.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
                [
                    'q' => 'What do you check before a publisher partnership?',
                    'a' => 'We review the service and its users, monthly active user volume, desired ad placements, reward policy, development environment and who handles operations, customer support and settlement. We then define the feasible integration scope and sequence.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'reward-network',
                            ],
                        ],
                        'Reward ad network',
                    ],
                ],
            ],
        ],
        'search' => [
            'label' => 'Search & AI visibility',
            'icon' => 'seo',
            'items' => [
                [
                    'q' => 'How long does SEO take?',
                    'a' => 'It depends on the site’s technical condition, competition, existing content and search engine crawl cycles. We do not guarantee a fixed timeframe or a date for reaching a specific ranking. We start by checking leading indicators such as indexing, visibility, clicks and conversions.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'seo',
                            ],
                        ],
                        'SEO',
                    ],
                ],
                [
                    'q' => 'How do search ads differ from SEO?',
                    'a' => 'Search ads provide immediate paid visibility. SEO builds up website and content assets that search engines can discover and understand. They serve different purposes and can be run together according to your business goals.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'seo',
                            ],
                        ],
                        'SEO',
                    ],
                ],
                [
                    'q' => 'Will more backlinks improve our rankings?',
                    'a' => 'Links alone cannot resolve every issue. Crawling and indexing, content that matches search intent, internal links, and the relevance and quality of sources all need to be reviewed together. We do not guarantee a specific number of links or a ranking increase.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'seo',
                            ],
                        ],
                        'SEO',
                    ],
                ],
                [
                    'q' => 'Will AEO and GEO ensure that we appear in AI answers?',
                    'a' => 'No. They improve information accessibility, clarity about entities, and consistency of evidence and sources to increase the likelihood that answer systems will refer to your content. Each search or generative system decides what to display and cite.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'seo',
                            ],
                        ],
                        'SEO',
                    ],
                ],
                [
                    'q' => 'Can you work on our existing site without replacing it?',
                    'a' => 'Yes. We first review your current URLs, search traffic, technical issues and content assets to identify what to retain and what to change. A complete rebuild is not always necessary.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'seo',
                            ],
                        ],
                        'SEO',
                    ],
                ],
                [
                    'q' => 'Can we reuse our existing content?',
                    'a' => 'Yes. We first identify the parts of existing documents that answer real questions and provide evidence. We then reorganize them in the order of conclusions, conditions, exceptions and related documents. Not all content needs to be rewritten.',
                    'from' => [
                        [
                            'route' => 'services.seo.aeo',
                            'params' => [
                            ],
                        ],
                        'AEO',
                    ],
                ],
                [
                    'q' => 'How does AEO differ from conventional SEO?',
                    'a' => 'SEO covers how pages are discovered, understood and trusted. Building on that foundation, AEO focuses more closely on designing units of information and document structures that clearly answer users’ questions.',
                    'from' => [
                        [
                            'route' => 'services.seo.aeo',
                            'params' => [
                            ],
                        ],
                        'AEO',
                    ],
                ],
                [
                    'q' => 'Is adding FAQ structured data enough?',
                    'a' => 'No. Structured data is a supporting tool that describes content actually present on the page. Answer accuracy, evidence, page quality and the search system’s assessment all play a role.',
                    'from' => [
                        [
                            'route' => 'services.seo.aeo',
                            'params' => [
                            ],
                        ],
                        'AEO',
                    ],
                ],
                [
                    'q' => 'How do you measure AEO results?',
                    'a' => 'We record search visibility and clicks by question group, actions and conversions on the relevant pages, and answer visibility and sources in sampled search results. We do not assume that sampled results represent what all users see.',
                    'from' => [
                        [
                            'route' => 'services.seo.aeo',
                            'params' => [
                            ],
                        ],
                        'AEO',
                    ],
                ],
                [
                    'q' => 'Do you guarantee visibility in answer sections or AI summaries?',
                    'a' => 'No. AEO helps create conditions that make content easier for search and answer systems to understand and reference. Each system decides how to display it.',
                    'from' => [
                        [
                            'route' => 'services.seo.aeo',
                            'params' => [
                            ],
                        ],
                        'AEO',
                    ],
                ],
                [
                    'q' => 'How does GEO differ from SEO?',
                    'a' => 'SEO covers search engine crawling, understanding and visibility, as well as search traffic overall. Building on that foundation, GEO focuses more closely on organizing entities and information sources so generative AI can reference companies, people, services and supporting evidence without confusing them.',
                    'from' => [
                        [
                            'route' => 'services.seo.geo',
                            'params' => [
                            ],
                        ],
                        'GEO',
                    ],
                ],
                [
                    'q' => 'Do we need to create all-new content for GEO?',
                    'a' => 'No. We first audit existing official pages, company information, service documentation and content to identify reusable evidence and inconsistencies. We prioritize filling gaps in questions and supporting evidence.',
                    'from' => [
                        [
                            'route' => 'services.seo.geo',
                            'params' => [
                            ],
                        ],
                        'GEO',
                    ],
                ],
                [
                    'q' => 'Do we also need external mentions or citations?',
                    'a' => 'Information published by the brand alone may not provide enough verifiable evidence. The priority is reliable sources that demonstrate actual activities and expertise, together with consistent information, rather than large volumes of irrelevant visibility.',
                    'from' => [
                        [
                            'route' => 'services.seo.geo',
                            'params' => [
                            ],
                        ],
                        'GEO',
                    ],
                ],
                [
                    'q' => 'How do you measure visibility in generative AI?',
                    'a' => 'We select sample questions relevant to the business and record brand mentions, description accuracy, linked sources and context in the answers by date. We also state that results may vary by question, account, location and time.',
                    'from' => [
                        [
                            'route' => 'services.seo.geo',
                            'params' => [
                            ],
                        ],
                        'GEO',
                    ],
                ],
                [
                    'q' => 'Do you guarantee recommendations from ChatGPT or other AI systems?',
                    'a' => 'No. GEO improves the conditions that help generative systems understand and reference brands and information accurately. Each system decides its final answers and recommendations.',
                    'from' => [
                        [
                            'route' => 'services.seo.geo',
                            'params' => [
                            ],
                        ],
                        'GEO',
                    ],
                ],
            ],
        ],
        'self' => [
            'label' => 'Self-serve marketing & BoostingShop',
            'icon' => 'self',
            'items' => [
                [
                    'q' => 'Do you guarantee top rankings?',
                    'a' => 'No. We commit to the deliverables and campaign volume stated on the product page, along with ranking records collected under consistent conditions.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'Self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Are RankFree rankings official NAVER rankings?',
                    'a' => 'No. These are estimates based on our own data collection and analysis. They do not imply approval or endorsement by NAVER — Korea\'s largest search portal.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'Self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Why do the rankings differ from my own searches?',
                    'a' => 'Results can vary with the time of the search, device, location, login status and personalization. Repeating checks under consistent conditions is important.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'Self-serve marketing',
                    ],
                ],
                [
                    'q' => 'What can we use without registering?',
                    'a' => 'The free allowance includes 100 ranking checks and 5 analyses per month. Detailed limits follow RankFree’s current guidance.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'Self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Can you also handle execution after the analysis?',
                    'a' => 'We provide a tailored quote for a managed marketing service covering analysis through execution.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'Self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Are market size and revenue estimates actual transaction values?',
                    'a' => 'No. They are estimates based on our own analysis and do not guarantee actual transaction values or future revenue. Assess them alongside other information, such as product viability, costs and conversion rates.',
                    'from' => [
                        [
                            'route' => 'solutions.rankfree',
                            'params' => [
                            ],
                        ],
                        'RankFree',
                    ],
                ],
                [
                    'q' => 'Will fixing only the low-scoring items improve our rankings?',
                    'a' => 'We cannot conclude that. Scores are signals for comparison and review. Many factors affect how search services reflect changes and the results they produce.',
                    'from' => [
                        [
                            'route' => 'solutions.rankfree',
                            'params' => [
                            ],
                        ],
                        'RankFree',
                    ],
                ],
                [
                    'q' => 'Does buying an SEO package guarantee top rankings?',
                    'a' => 'No. Search engines determine search results using multiple signals and policies. Before purchasing, assess the included work, duration and exclusions.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
                [
                    'q' => 'How should we choose between Basic, Pro and Elite?',
                    'a' => 'Consider site size, how long it has been operating, the number and competitiveness of target keywords, and the current content and links. Compare the details of each package rather than choosing by name alone.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
                [
                    'q' => 'Is the Instagram growth guide safe for our account?',
                    'a' => 'No approach can guarantee safety in every case. Review content, official advertising and collaboration methods, account status, and the latest terms and policies. Use only the minimum permissions needed.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
                [
                    'q' => 'Do you guarantee top-post visibility or engagement counts?',
                    'a' => 'No. The platform determines visibility. The detailed Instagram pages are not order pages selling artificial engagement quantities or specific positions.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
                [
                    'q' => 'Do product prices and package contents always stay the same?',
                    'a' => 'They may change. The latest price, duration, package contents and terms on the detailed page at the time of application take precedence over this hub’s summary.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
                [
                    'q' => 'Where can we find the cancellation and refund rules?',
                    'a' => 'Check each product’s current terms and the application and payment process. If anything is unclear, contact us before paying to confirm which rules apply.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
                [
                    'q' => 'What should we do if we do not know what to buy?',
                    'a' => 'Tell us about your current site or account, goals, budget range and biggest bottleneck. We can first determine whether a product purchase fits your needs or whether an audit or managed-service consultation should come first.',
                    'from' => [
                        [
                            'route' => 'solutions.boostingshop',
                            'params' => [
                            ],
                        ],
                        'BoostingShop',
                    ],
                ],
            ],
        ],
        'crm' => [
            'label' => 'LeadBay & Call2Sale',
            'icon' => 'leadbay',
            'items' => [
                [
                    'q' => 'Who is LeadBay designed for?',
                    'a' => 'It is a CRM for sales organizations, insurance agents and agencies that compare and purchase insurance leads, assign them to team members, and manage consultation, contract, after-sales support and settlement status.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Does a higher quality score mean a higher chance of a contract?',
                    'a' => 'That is not guaranteed. Scores provide comparisons within the service. Actual consultation contact and contracts depend on many factors, including the legality, timing and target audience of the leads, the agent’s consultation and market conditions.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Does a listed supplier automatically guarantee that its leads are lawful?',
                    'a' => 'No. Before a transaction, buyers must check the collection source, scope of consent, purposes of provision and use, retention period and after-sales support terms.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Does LeadBay take over our responsibility for personal information compliance?',
                    'a' => 'No. The service supports management workflows but does not assume the legal or contractual responsibilities of the parties that transact or use the data. Your organization needs its own standards and any necessary expert review.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Does buying leads guarantee consultations or contracts?',
                    'a' => 'No. Results may vary with contactability, willingness to consult, timeliness of the information, lead assignment and consultation quality.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Are after-sales support and settlement rules the same for every purchase?',
                    'a' => 'They may vary by supplier, product and transaction terms. Before purchasing, check the applicable rules, required evidence and processing times in the actual service.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Where should we confirm the final features and terms of use?',
                    'a' => 'This page is an introduction. LeadBay’s current service takes precedence for actual screens, prices, permissions, transaction and settlement features, terms, and personal information handling notices.',
                    'from' => [
                        [
                            'route' => 'solutions.leadbay',
                            'params' => [
                            ],
                        ],
                        'LeadBay',
                    ],
                ],
                [
                    'q' => 'Who is Call2Sale designed for?',
                    'a' => 'It is a CRM for call center operations that assign source leads to agents to generate insurance leads, then handle client orders, delivery, after-sales support and settlement.',
                    'from' => [
                        [
                            'route' => 'solutions.call2sale',
                            'params' => [
                            ],
                        ],
                        'Call2Sale',
                    ],
                ],
                [
                    'q' => 'Does AI call quality analysis accurately assess consultations?',
                    'a' => 'Accuracy is not guaranteed. The analysis supports the identification of patterns and points to review. A manager or reviewer must also check the original call data and consultation context.',
                    'from' => [
                        [
                            'route' => 'solutions.call2sale',
                            'params' => [
                            ],
                        ],
                        'Call2Sale',
                    ],
                ],
                [
                    'q' => 'Can we automate staff performance evaluations using AI scores?',
                    'a' => 'Making important evaluation decisions solely from AI results risks errors and missed context. Evaluation criteria should be disclosed, and a human review of the original data must be part of the process.',
                    'from' => [
                        [
                            'route' => 'solutions.call2sale',
                            'params' => [
                            ],
                        ],
                        'Call2Sale',
                    ],
                ],
                [
                    'q' => 'Do call recording and AI analysis require no separate consent?',
                    'a' => 'That cannot be assumed. Before operations begin, check the disclosures and consent, purposes of use, access permissions, and retention and destruction rules that fit the call method and data processing structure.',
                    'from' => [
                        [
                            'route' => 'solutions.call2sale',
                            'params' => [
                            ],
                        ],
                        'Call2Sale',
                    ],
                ],
                [
                    'q' => 'Does Call2Sale guarantee that leads are lawful?',
                    'a' => 'No. The parties operating the service and conducting transactions must check the basis for collecting, providing and using source leads for marketing, as well as the conditions for delivery to clients.',
                    'from' => [
                        [
                            'route' => 'solutions.call2sale',
                            'params' => [
                            ],
                        ],
                        'Call2Sale',
                    ],
                ],
                [
                    'q' => 'Are electronic contracts and settlement fully automated?',
                    'a' => 'The detailed scope of automation and integration may vary with the current service and contract terms. Review the actual screens and supported scope, then check how they differ from your existing workflow.',
                    'from' => [
                        [
                            'route' => 'solutions.call2sale',
                            'params' => [
                            ],
                        ],
                        'Call2Sale',
                    ],
                ],
            ],
        ],
        'build' => [
            'label' => 'Build & support',
            'icon' => 'wordpress',
            'items' => [
                [
                    'q' => 'How do you decide on design concepts and the number of revisions?',
                    'a' => 'They depend on the number of pages, design approach, approval stages and project schedule. We clearly define the scope of design concepts and revision criteria at the quotation and contract stages.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress build & management',
                    ],
                ],
                [
                    'q' => 'Do you also write website content?',
                    'a' => 'We can plan the content structure and messaging for each page together. We agree in advance on the scope of copywriting, organizing source information, filming and image production, separately from the development scope.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress build & management',
                    ],
                ],
                [
                    'q' => 'Can we migrate while retaining our existing site assets and search traffic?',
                    'a' => 'We first audit existing URLs, search traffic, content and functionality, then define what to retain, consolidate or redirect with 301 redirects. Actual URLs and indexing status also need a separate check after migration.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress build & management',
                    ],
                ],
                [
                    'q' => 'Does building with WordPress guarantee top search rankings?',
                    'a' => 'No. WordPress is simply a tool for creating a structure that search engines can access easily. A technical foundation, content, an assessment of competition and ongoing management are also needed.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress build & management',
                    ],
                ],
                [
                    'q' => 'Can you provide maintenance after launch?',
                    'a' => 'We can review the necessary work, such as security updates, backups, incident response and content edits, and agree on it as a separate scope. Ownership and responsibility for each account are also clarified before handover.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress build & management',
                    ],
                ],
                [
                    'q' => 'Can you immediately recommend support programs open for applications?',
                    'a' => 'Application availability and eligibility vary by timing and each institution’s announcements. During a consultation, we review whether the marketing tasks fit your company information and the program notice. Check the administering institution’s official guidance first for current application status and eligibility.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Korean government SME marketing support programs',
                    ],
                ],
                [
                    'q' => 'Do you guarantee selection or payment of funding?',
                    'a' => 'No. Selection and funding payments depend on the administering institution’s review, agreement and settlement criteria. J-Curve supports task interpretation, execution planning, marketing management and preparation of results documentation within the agreed scope.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Korean government SME marketing support programs',
                    ],
                ],
                [
                    'q' => 'Do you prepare all application documents on our behalf?',
                    'a' => 'The participating company remains the applicant and is responsible for verifying facts. We can review the notice and tasks to help prepare the necessary marketing plan and organize supporting information. The scope of any agency service is confirmed under the program rules and at the contract stage.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Korean government SME marketing support programs',
                    ],
                ],
                [
                    'q' => 'Can program funding cover all marketing costs?',
                    'a' => 'No. Eligible costs, the company’s own contribution, spending periods, supplier requirements and evidence requirements differ by program. Check the administering institution’s notice, agreement and guidelines before contracting or spending.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Korean government SME marketing support programs',
                    ],
                ],
                [
                    'q' => 'Can support cover websites or SEO as well as advertising?',
                    'a' => 'We can consider performance ads, SEO, content, video and web builds according to the scope permitted by the notice and the company’s task goals. Not every item is eligible under every program.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Korean government SME marketing support programs',
                    ],
                ],
            ],
        ],
    ],
];
