<?php

return [
    'title' => 'FAQ | J-Curve Interactive',
    'description' => 'Answers about Korean marketing, ads, SEO, self-serve marketing, CRM, websites and support programs. Contact J-Curve about your project.',
    'heading' => 'Frequently asked questions',
    'breadcrumb_aria' => 'Current location',
    'home' => 'Home',
    'support' => 'Support',
    'lead' => 'Answers to the questions we hear most often about each service. If you cannot find yours, send us an inquiry.',
    'search_label' => 'Search questions',
    'search_placeholder' => 'Search a topic — guarantees, accounts, refunds, reports',
    'questions' => 'questions',
    'results' => 'results',
    'inquiry' => 'Contact us',
    'project_direct' => 'Project inquiry (1:1)',
    'project' => 'Project inquiry',
    'list_aria' => 'Question list',
    'categories_aria' => 'Question categories',
    'all' => 'All',
    'related' => 'Related page',
    'empty_before' => 'No questions found for “',
    'empty_after' => '”.',
    'empty_text' => 'Try another term, or send us an inquiry and we will review it before replying.',
    'cta_heading' => 'Still looking for an answer?',
    'cta_text' => 'Send us your question. For project discussions, the direct project inquiry form is the fastest route.',
    'phone' => 'Phone',
    'email' => 'Email',
    'categories' => [
        'start' => [
            'label' => 'Getting started & consultations',
            'icon' => 'megaphone',
            'items' => [
                [
                    'q' => 'Which service should we start with?',
                    'a' => 'Choose your most urgent goal: validating sales quickly, generating qualified actions, activating app users, building search assets or creating your own web channel. If the goal is unclear, we start with the largest drop-off in your current data.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'marketing services',
                    ],
                ],
                [
                    'q' => 'Can you run several services together?',
                    'a' => 'Yes. We first align conversion definitions and measurement criteria. Once that foundation is in place, learning from paid ads can inform SEO, your website and reward campaigns.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'marketing services',
                    ],
                ],
                [
                    'q' => 'Can we work with you alongside an existing agency or internal team?',
                    'a' => 'Yes. We can take on specific gaps, including diagnosis, a particular channel, measurement, production or SEO, as well as full management.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'marketing services',
                    ],
                ],
                [
                    'q' => 'Do you guarantee results in advance?',
                    'a' => 'We cannot determine market response in advance. We agree on success and stopping criteria before starting, then use measurable results to guide the next decision.',
                    'from' => [
                        [
                            'route' => 'services.index',
                            'params' => [
                            ],
                        ],
                        'marketing services',
                    ],
                ],
                [
                    'q' => 'Are you an ad agency or a software company?',
                    'a' => 'Both. We run ads, CPA, reward, SEO and web projects, and develop and operate our own products to solve recurring problems in the field.',
                    'from' => [
                        [
                            'route' => 'company',
                            'params' => [
                            ],
                        ],
                        'Company Introduction',
                    ],
                ],
                [
                    'q' => 'How does a project start?',
                    'a' => 'We first review your goals, conversion criteria, current data and execution conditions. We proceed when the scope of work and prerequisites are aligned.',
                    'from' => [
                        [
                            'route' => 'company',
                            'params' => [
                            ],
                        ],
                        'Company Introduction',
                    ],
                ],
                [
                    'q' => 'Can we hand over only part of the work?',
                    'a' => 'Yes. We can scope an account audit, a specific channel, SEO, a website or measurement setup, as well as full operations.',
                    'from' => [
                        [
                            'route' => 'company',
                            'params' => [
                            ],
                        ],
                        'Company Introduction',
                    ],
                ],
                [
                    'q' => 'Can we contact you before choosing a service?',
                    'a' => 'Yes. Describe your goals and biggest bottleneck. We will identify where to start across ads, measurement, content and your website.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project Inquiry',
                    ],
                ],
                [
                    'q' => 'What should we prepare before a consultation?',
                    'a' => 'Your current channels and website URLs, monthly budget range, important conversions and recent results are useful. If you do not have these materials, we can start by understanding your current situation.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project Inquiry',
                    ],
                ],
                [
                    'q' => 'Does an inquiry create a contract?',
                    'a' => 'No. We review your inquiry, request any additional information and align the possible scope and next steps. A contract is a separate decision.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project Inquiry',
                    ],
                ],
                [
                    'q' => 'Should we send sensitive account or customer information?',
                    'a' => 'Do not send passwords, API keys or customer personal information in your first inquiry. If access is needed for a review, we first agree on the access method and scope.',
                    'from' => [
                        [
                            'route' => 'contact',
                            'params' => [
                            ],
                        ],
                        'Project Inquiry',
                    ],
                ],
            ],
        ],
        'ads' => [
            'label' => 'Advertising',
            'icon' => 'performance',
            'items' => [
                [
                    'q' => 'Can we start with a small ad budget?',
                    'a' => 'The amount of useful conversion data matters more than budget size alone. With a small budget, we limit channels and variables so each test answers a clear question.',
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
                    'q' => 'Can we keep our existing ad account?',
                    'a' => 'We review its structure and data continuity first. A new account is not always the right answer. We identify assets to keep and issues to resolve before defining the handover.',
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
                    'q' => 'Do you produce ad creative?',
                    'a' => 'We can connect filming, editing and design in-house. Creative formats, quantities and filming requirements are confirmed against campaign goals and the contract scope.',
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
                    'a' => 'We do not guarantee specific revenue or ROAS. We first agree on target conversions, test criteria and the conditions to stop, continue or scale, then assess results against those criteria.',
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
                    'q' => 'What is included in reporting?',
                    'a' => 'Alongside impressions and clicks, we cover agreed business conversions, costs, differences by channel, campaign and creative, and next actions. Items and frequency depend on the operating scope.',
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
                    'a' => 'We first check technical measurability, feasible pricing, available media, and whether the industry and ad claims meet legal and platform requirements.',
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
                    'q' => 'Do you guarantee a target volume?',
                    'a' => 'We do not guarantee a fixed volume across campaigns. We discuss a feasible range after reviewing action difficulty, pricing, timing, media availability and initial data.',
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
                    'q' => 'How are invalid leads or conversions handled?',
                    'a' => 'We use approval and rejection criteria agreed before launch, including duplicates, required-field errors, contactability and consent scope. Criteria vary by industry and action.',
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
                    'q' => 'Can leads be delivered to our existing CRM or admin system?',
                    'a' => 'We review your system and required fields before choosing an integration method. Any separate development or API work is agreed in advance as a separate scope.',
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
                    'q' => 'Do you review consent and ad approval requirements?',
                    'a' => 'We review the consent items, disclosures and media approval conditions needed for the campaign. Final legal compliance and advertiser eligibility also require current legal, expert and platform guidance.',
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
                    'q' => 'Which actions can a reward campaign measure?',
                    'a' => 'Examples include app installation, first launch, registration, tutorial completion, reaching a mission, requesting a quote or consultation, and purchasing. Availability and pricing depend on the industry, difficulty and validation method.',
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
                    'q' => 'Are users from rewarded ads always lower quality?',
                    'a' => 'An install-only goal can attract one-time participation. We assess quality against the campaign objective using follow-up missions, validity rules, duplicate criteria and observation metrics. Rewards alone do not determine every user’s value.',
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
                    'a' => 'We do not guarantee a fixed volume in advance. Availability depends on targeting, pricing, mission difficulty, duration and media conditions. We check participation and approval in an initial test before deciding how far to scale.',
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
                    'a' => 'It depends on the app and operating scope. We review existing placements, webview and server integration options, and reward processing before agreeing on development and testing.',
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
                    'q' => 'Can a web service become a publisher partner?',
                    'a' => 'We review the service structure, login and user identification, reward policy, traffic and implementation feasibility individually. We do not assume the integration works the same way as an app.',
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
                    'a' => 'Before launch, we agree on campaign-specific invalidity rules and evidence, covering duplicates, unmet conditions, cancellations, refunds and abnormal patterns. Rules should not change arbitrarily during delivery.',
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
                    'a' => 'Prepare the target action, preferred timing and budget range, landing or app link, conversion validation method, restrictions, creative and brand guidelines. We turn missing items into a consultation checklist.',
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
                    'a' => 'We review the service and audience, monthly active usage, desired placements, reward policy, development environment and responsibility for operations, support and settlement. This informs the integration scope and sequence.',
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
                    'a' => 'It depends on technical health, competition, existing content and search-engine crawl cycles. We do not guarantee a fixed duration or ranking date. We start with leading indicators such as indexing, impressions, clicks and conversions.',
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
                    'q' => 'How do search ads and SEO differ?',
                    'a' => 'Search ads pay for immediate visibility. SEO builds a website and content that search engines can discover and understand. Their roles differ, so they can work together toward your business goals.',
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
                    'q' => 'Will more backlinks alone improve rankings?',
                    'a' => 'Links alone do not solve the problem. Crawling, indexing, search-intent alignment, internal links, and the relevance and quality of sources all matter. We do not guarantee link counts or ranking gains.',
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
                    'q' => 'Do AEO and GEO guarantee inclusion in AI answers?',
                    'a' => 'No. We improve information access, entity clarity and consistent evidence and sources so answer systems can more readily reference your content. Each search or generative system decides final visibility and citations.',
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
                    'q' => 'Can we keep our existing website?',
                    'a' => 'Yes. We audit current URLs, search traffic, technical issues and content to decide what to keep and improve. A full rebuild is not always necessary.',
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
                    'q' => 'Can existing content be reused?',
                    'a' => 'Yes. We find existing answers and evidence, then organize them as conclusions, conditions, exceptions and related documents. You do not need to rewrite everything.',
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
                    'q' => 'How does AEO differ from regular SEO?',
                    'a' => 'SEO covers page discovery, understanding and trust overall. AEO builds on that foundation to focus on clear answer units and document structures that address user questions.',
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
                    'a' => 'No. Structured data supports the description of content actually visible on the page. Answer accuracy, evidence, page quality and the search system’s judgment also matter.',
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
                    'q' => 'How is AEO performance measured?',
                    'a' => 'We record impressions and clicks by question group, page behavior and conversions, plus answer visibility and sources in sample results. We do not assume samples represent every user’s results.',
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
                    'q' => 'Do you guarantee answer-box or AI-summary visibility?',
                    'a' => 'No. AEO makes content easier for search and answer systems to understand and reference. Each system decides how to display it.',
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
                    'a' => 'SEO covers crawling, understanding, visibility and search traffic. GEO builds on this foundation, focusing on entities and sources so generative AI can reference companies, people, services and evidence without confusing them.',
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
                    'q' => 'Does GEO require all-new content?',
                    'a' => 'No. We audit official pages, company materials, service documents and content for reusable evidence and inconsistencies. We prioritize missing questions and evidence.',
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
                    'q' => 'Do external mentions and citations matter?',
                    'a' => 'A brand’s own statements may not provide enough verifiable evidence. Relevant, credible sources that substantiate real activity and expertise, and consistent information, matter more than unrelated mass visibility.',
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
                    'a' => 'We choose sample business questions and record brand mentions, explanation accuracy, linked sources and context by date. We also note that results can vary by question, account, region and time.',
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
                    'q' => 'Do you guarantee recommendations from ChatGPT or other AI?',
                    'a' => 'No. GEO improves the conditions for generative systems to understand and reference a brand accurately. Each system decides its answers and recommendations.',
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
                    'a' => 'No. We commit to the deliverables and delivery volume listed on the product page, and ranking records collected under consistent conditions.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Are RankFree rankings official NAVER rankings?',
                    'a' => 'No. They are estimates based on our own collection and analysis, and do not mean approval or endorsement by NAVER, Korea’s largest search portal.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Why do RankFree rankings differ from my own searches?',
                    'a' => 'Results vary by search time, device, location, login and personalization. Repeated checks under consistent conditions are important.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'self-serve marketing',
                    ],
                ],
                [
                    'q' => 'What can I use without registering?',
                    'a' => 'The free tier includes 100 ranking checks and 5 analyses per month. Refer to RankFree’s current guidance for detailed limits.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Can you handle execution after the analysis?',
                    'a' => 'We can provide a tailored agency proposal covering analysis through execution.',
                    'from' => [
                        [
                            'route' => 'self-marketing',
                            'params' => [
                            ],
                        ],
                        'self-serve marketing',
                    ],
                ],
                [
                    'q' => 'Are market-size and revenue estimates actual transaction values?',
                    'a' => 'No. They are estimates from our own analysis and do not guarantee actual transaction values or future revenue. Assess them alongside product appeal, costs, conversion rates and other data.',
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
                    'q' => 'Will fixing only low-scoring items improve rankings?',
                    'a' => 'That cannot be assumed. Scores support comparison and review. Search systems and results are affected by multiple factors.',
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
                    'q' => 'Does buying an SEO product guarantee top rankings?',
                    'a' => 'No. Search engines determine results using multiple signals and policies. Assess the offered work, duration and exclusions before buying.',
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
                    'q' => 'How should we choose Basic, Pro or Elite?',
                    'a' => 'Consider site size, operating history, target keyword count and competition, and existing content and links. Compare the details of each package rather than choosing by name alone.',
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
                    'q' => 'Does the Instagram growth guide guarantee account safety?',
                    'a' => 'No approach guarantees safety in every case. Review content, official ads, collaborations, account status and current terms and policies. Use only the permissions needed.',
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
                    'q' => 'Do you guarantee popular-post placement or engagement counts?',
                    'a' => 'No. The platform decides visibility. Our Instagram detail pages do not sell artificial engagement quantities or placements.',
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
                    'q' => 'Are prices and package contents fixed?',
                    'a' => 'They can change. Current prices, duration, contents and terms on the detail page at application take precedence over this hub’s summary.',
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
                    'q' => 'Where can I check cancellation and refund rules?',
                    'a' => 'Check each product’s current terms and the application and payment flow. If anything is unclear, contact us before paying to confirm the rules.',
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
                    'q' => 'What if we do not know what to buy?',
                    'a' => 'Tell us your site or account, goals, budget and biggest bottleneck. We can review whether a product purchase, a diagnosis or an agency consultation is the right starting point.',
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
                    'q' => 'Who is LeadBay for?',
                    'a' => 'It is a CRM for insurance sales teams, advisers and agencies that compare and buy insurance leads, assign them internally, and manage consultations, contracts, after-sales support and settlement.',
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
                    'q' => 'Does a high quality score guarantee a contract?',
                    'a' => 'No. Scores are comparison information within the service. Contact and contract outcomes depend on lead legality, timing, audience, the adviser’s consultation and market conditions.',
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
                    'q' => 'Does being a listed supplier guarantee lawful leads?',
                    'a' => 'No. Before buying, check collection sources, consent scope, disclosure and use purposes, retention periods and after-sales support terms.',
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
                    'q' => 'Does LeadBay take over privacy-compliance responsibility?',
                    'a' => 'No. The service supports workflows but does not replace the legal and contractual responsibilities of parties who trade in or use the leads. Organizational standards and appropriate expert review are still needed.',
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
                    'a' => 'No. Outcomes depend on contactability, willingness to consult, information freshness, allocation and consultation quality.',
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
                    'q' => 'Are after-sales support and settlement rules the same everywhere?',
                    'a' => 'They can vary by supplier, product and transaction terms. Check the applicable rules, evidence requirements and processing periods in the current service before buying.',
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
                    'q' => 'Where can we confirm features and terms?',
                    'a' => 'This is an introduction. LeadBay’s current service is authoritative for screens, prices, permissions, transaction and settlement features, terms and privacy information.',
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
                    'q' => 'Who is Call2Sale for?',
                    'a' => 'It is a CRM for call-center operators that assign source leads to agents, produce insurance leads, and manage client orders, delivery, after-sales support and settlement.',
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
                    'q' => 'Does AI call analysis assess consultations accurately?',
                    'a' => 'Accuracy is not guaranteed. Analysis helps identify patterns and review points. A manager or reviewer must check the original call materials and consultation context.',
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
                    'q' => 'Can AI scores automate staff evaluations?',
                    'a' => 'Finalizing important evaluations from AI output alone risks errors and missing context. Disclose evaluation criteria and establish human review of the original materials.',
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
                    'q' => 'Can recording and AI analysis be used without additional consent?',
                    'a' => 'That cannot be assumed. Before operating, check appropriate notice and consent, purposes, access permissions, and retention and deletion rules for your call and data-processing setup.',
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
                    'q' => 'Does Call2Sale guarantee lawful leads?',
                    'a' => 'No. The operating and trading parties must verify the basis for collecting, sharing and marketing with source leads, and the terms of delivery to clients.',
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
                    'a' => 'Automation and integration depend on the current service and contract terms. Check the actual screens and support scope against your existing work.',
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
                    'q' => 'How are design drafts and revision rounds agreed?',
                    'a' => 'They depend on page count, design approach, approval stages and project timing. Draft scope and revision criteria are defined at proposal and contract stages.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress production and operation',
                    ],
                ],
                [
                    'q' => 'Can you also write website content?',
                    'a' => 'We can plan the content structure and page messages together. Writing, research organization, filming and image production are scoped separately from development in advance.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress production and operation',
                    ],
                ],
                [
                    'q' => 'Can you migrate our site while preserving search traffic?',
                    'a' => 'We audit existing URLs, search traffic, content and functions, then define what to keep, consolidate or redirect with 301s. Actual URLs and index status also need separate checks after migration.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress production and operation',
                    ],
                ],
                [
                    'q' => 'Does WordPress guarantee top rankings?',
                    'a' => 'No. WordPress can support a search-accessible structure, but technical foundations, content, competition and ongoing operations also matter.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress production and operation',
                    ],
                ],
                [
                    'q' => 'Can you maintain the site after launch?',
                    'a' => 'Security updates, backups, incident response and content changes can be agreed as a separate scope. Ownership and responsibility for each account are clarified before handover.',
                    'from' => [
                        [
                            'route' => 'services.show',
                            'params' => [
                                'slug' => 'wordpress',
                            ],
                        ],
                        'WordPress production and operation',
                    ],
                ],
                [
                    'q' => 'Can you immediately recommend an open support program?',
                    'a' => 'Applications and eligibility vary by date and the administering organization’s notice. We review marketing-task fit against your company information and the notice. Current availability and eligibility must be confirmed through official guidance.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Marketing support project',
                    ],
                ],
                [
                    'q' => 'Do you guarantee program selection or funding?',
                    'a' => 'No. Selection and funding payments follow the administrator’s review, agreement and settlement criteria. Within the agreed scope, we support task interpretation, execution planning, marketing operations and result documentation.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Marketing support project',
                    ],
                ],
                [
                    'q' => 'Will you complete every application document?',
                    'a' => 'The participating company remains responsible for the application and factual accuracy. We can support marketing plans and materials after reviewing the notice and tasks. The permitted agency scope is determined by program rules and the contract.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Marketing support project',
                    ],
                ],
                [
                    'q' => 'Can a grant cover every marketing cost?',
                    'a' => 'No. Eligible costs, company contributions, spending periods, supplier requirements and evidence vary by program. Check official notices, agreements and guidelines before contracting or spending.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Marketing support project',
                    ],
                ],
                [
                    'q' => 'Can support cover a website or SEO as well as ads?',
                    'a' => 'Depending on the notice’s eligible scope and your task goals, we can review performance ads, SEO, content, video and web builds. Not every program accepts every item.',
                    'from' => [
                        [
                            'route' => 'services.marketing-support',
                            'params' => [
                            ],
                        ],
                        'Marketing support project',
                    ],
                ],
            ],
        ],
    ],
];
