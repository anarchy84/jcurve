<?php

return [
    'seo' => [
        'parent' => [
            'label' => 'SEO',
            'route' => 'services.show',
            'param' => 'seo',
            'summary' => 'We align technical SEO, content and trust signals to build lasting search traffic.',
        ],
        'items' => [
            'backlinks' => [
                'eyebrow' => 'Link Building',
                'title' => 'Backlink strategy for search',
                'seo_title' => 'Backlink strategy for search | J-Curve Interactive',
                'lead' => 'Backlinks are an external signal that connects other websites to our pages as worthy of reference. J-Curve does not only increase the number of links, but also reviews the content of the page to be linked, the context of the source, and anchor text distribution.',
                'meta_description' => 'Backlink strategy informed by 10 years and over 1,000 SEO projects, with page, source and anchor reviews for Google and NAVER. Ask for a free consultation.',
                'hero_cta' => 'Request a link profile review',
                'body' => [
                    'This is a link building service that adds external trust signals to sites with internal optimization and content prepared.',
                    [
                        'h2' => 'Scope of work',
                        'items' => [
                            'Target Page Diagnosis',
                            'Review of sources and context',
                            'Anchor text distribution',
                            'Check status after posting',
                        ],
                    ],
                    'We do not guarantee search rankings or penalty avoidance, and proceed in a way that lowers risk according to the site status and competitive environment.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'The first thing to look at before a link is the page it points to.',
                        'paragraphs' => [
                            'It\'s difficult to judge the effectiveness of simply adding links to sites with poor content or lingering technical errors. First, you need to check index status, core pages, search intent and content completeness.',
                            'Next, we design which document on which topic should naturally refer to which page and in what context. Backlinks are not a standalone product, but rather a trust layer behind technical SEO and content SEO.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'We proceed in four steps from diagnosis to follow-up confirmation.',
                        'items' => [
                            [
                                'title' => 'Current link profile diagnosis',
                                'text' => 'Check existing inbound links, target pages, unusual repeat patterns and broken links.',
                            ],
                            [
                                'title' => 'Select target pages and topics',
                                'text' => 'Prioritize pages that need links based on your business goals and search intent.',
                            ],
                            [
                                'title' => 'Source, context, anchor design',
                                'text' => 'Avoid excessive repetition by examining topic relevance, document context, and anchor text distribution.',
                            ],
                            [
                                'title' => 'Confirmation and recording of delivery',
                                'text' => 'Check the actual URL and connection status and record any changes or deletions to track them.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Deliverables',
                        'title' => 'Items to check during consultation and progress',
                        'items' => [
                            'Site index status and priority pages',
                            'Existing link source and anchor text bias',
                            'The topic relevance and actual publication context of the linked document',
                            'Management records, including posted URL, connection destination, and confirmation time',
                        ],
                        'note' => 'It is not a product that guarantees increased search rankings, exposure at a specific point in time, or avoidance of search engine actions.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Suitable for sites like this',
                        'items' => [
                            [
                                'title' => 'Site with basic SEO in place',
                                'text' => 'When you want to strengthen external trust signals after establishing the foundation of index, speed, and content.',
                            ],
                            [
                                'title' => 'Site with clear core pages',
                                'text' => 'When priorities are sorted on which service/product pages to grow.',
                            ],
                            [
                                'title' => 'A team that operates with a long-term perspective',
                                'text' => 'When you want to build content and trust assets together rather than short-term ranking promises.',
                            ],
                            [
                                'title' => 'If maintenance is needed first',
                                'text' => 'If your site has just been launched or has little content, we recommend internal optimization first.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Will adding backlinks immediately improve rankings?',
                        'answer' => 'No. Site health, content, competition and multiple signals affect results. Backlinks strengthen external trust signals but do not guarantee rankings or timing.',
                    ],
                    [
                        'question' => 'Are more links always better?',
                        'answer' => 'Relevance, context, source quality and natural distribution matter more than raw numbers. Repetitive or irrelevant links can increase the management burden.',
                    ],
                    [
                        'question' => 'Can you guarantee no search-engine penalties?',
                        'answer' => 'No third party can guarantee a search engine’s judgment. We avoid excessive repetition and abnormal patterns, and explain the scope we can verify and the risks in advance.',
                    ],
                ],
                'cta' => [
                    'title' => 'Before increasing your links, check their current status',
                    'text' => 'Let us know your site and target pages, and we\'ll work together to see if there are any issues to address before link building.',
                    'label' => 'Request a link profile review',
                ],
            ],
            'naver-place' => [
                'eyebrow' => 'Local Search',
                'title' => 'NAVER Place marketing',
                'seo_title' => 'NAVER Place marketing | J-Curve Interactive',
                'lead' => 'NAVER Place — local business listings on NAVER search and maps. NAVER Place Marketing is the task of organizing place assets so that customers who search by region and industry can quickly check the store\'s accurate information and basis for selection. We manage information completeness, content, customer response, and conversion flow together.',
                'meta_description' => 'Improve NAVER Place information, content and the path to calls, directions and bookings for your Korean locations.',
                'hero_cta' => 'Request a Place review',
                'body' => [
                    'We organize place information so that stores can be accurately found in local searches and customers can visit, call, or make reservations.',
                    'We do not guarantee rankings or placements, and we continually improve operational information and content.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'If the information is incorrect, you will lose customers before exposure.',
                        'paragraphs' => [
                            'If business hours, menus, prices, addresses and reservation methods are different, it is difficult for customers to choose a store. Photos are often outdated and blurbs often don\'t describe the industry or location search intent.',
                            'The starting point of place operation is not ranking technology, but accurate and persuasive store information. After searching, it is organized based on the route leading from phone call, directions, and reservation.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Method',
                        'title' => 'Organize store information and customer behavior in order',
                        'items' => [
                            [
                                'title' => 'Status diagnosis',
                                'text' => 'Check basic information, categories, representative images, menus/products, review response, and conversion links.',
                            ],
                            [
                                'title' => 'Analysis of regional and industry intentions',
                                'text' => 'We organize what combination of region name, industry, and situation customers visit the store with.',
                            ],
                            [
                                'title' => 'Improve information and content',
                                'text' => 'We supplement fact-based introductions, photos, menus and news content according to the order of customer questions.',
                            ],
                            [
                                'title' => 'Response confirmation and operation',
                                'text' => 'In addition to exposure, we also look at identifiable behavioral changes such as calling, finding directions, and making reservations.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Check List',
                        'title' => 'Operational items checked by the place',
                        'items' => [
                            'Consistency of basic information such as business name, address, phone number, and business hours',
                            'Currentness of representative images and menu/service information',
                            'Connection between region/industry search intent and introductory text',
                            'Review response principles and phone/direction/reservation conversion flow',
                        ],
                        'note' => 'We do not provide fake reviews, conceal paid reviews or guarantee specific rankings.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'This is especially necessary for stores like this',
                        'items' => [
                            [
                                'title' => 'A store where local customers are important',
                                'text' => 'An offline business where visits, phone calls, and reservations are the core of the sales process.',
                            ],
                            [
                                'title' => 'Stores where information changes frequently',
                                'text' => 'A place that needs to be constantly informed of menus, operating hours, seasonal products and events.',
                            ],
                            [
                                'title' => 'Brands with different operations at each branch',
                                'text' => 'A brand that seeks to unify information quality and customer service standards across branches.',
                            ],
                            [
                                'title' => 'When operational cooperation is difficult',
                                'text' => 'If it is difficult to provide up-to-date information and photos, it is better to first appoint an internal management person.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Do you guarantee top NAVER Place rankings?',
                        'answer' => 'No. Platform policies, competition and user responses affect visibility. We improve verifiable information, content and the conversion path.',
                    ],
                    [
                        'question' => 'Do you write reviews for us?',
                        'answer' => 'We do not provide fake or manipulated reviews. We guide consistent responses to real customer reviews and ways to receive natural feedback through your service.',
                    ],
                    [
                        'question' => 'What should we prepare before a consultation?',
                        'answer' => 'A Place URL, current business information, main menus or services, representative photos and common customer questions help us review it faster.',
                    ],
                ],
                'cta' => [
                    'title' => 'Check the flow of customers finding and selecting a store',
                    'text' => 'If you send us your place URL and current concerns, we will look at it based on information, content, and conversion flow.',
                    'label' => 'Request a Place review',
                ],
            ],
            'naver-shopping' => [
                'eyebrow' => 'Commerce SEO',
                'title' => 'NAVER Shopping SEO',
                'seo_title' => 'NAVER Shopping SEO | J-Curve Interactive',
                'lead' => 'NAVER Shopping — NAVER’s product search and shopping hub. NAVER Shopping SEO is not about changing one line of a product name. We structurally organize product data so that categories, attributes, price/delivery information, representative images, and detailed pages are linked to suit the customer\'s search intent.',
                'meta_description' => 'NAVER Shopping SEO informed by over 10 years of experience, covering product data, images and pages to improve discovery and purchase decisions.',
                'hero_cta' => 'Request a product review',
                'body' => [
                    'This is the NAVER Shopping optimization service that connects product data and search intent to improve clicks and purchase decisions after exposure.',
                    'We do not guarantee search rankings or sales and operate based on platform policies and actual product competitiveness.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'Even if a product is searched, it will not be converted if there is no reason for selection.',
                        'paragraphs' => [
                            'If your categories and attributes are mismatched, it will be difficult to be found in the right search, and if your title is full of keywords, it will be difficult for customers to read the key differences. In some cases, the representative image and the detailed page make different promises.',
                            'J-Curve does not separate exposure and purchase persuasion factors. From the accuracy of product data to the information structure after the click, we view it as one flow.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'From product unit diagnosis to operational standards',
                        'items' => [
                            [
                                'title' => 'Product group and account diagnosis',
                                'text' => 'Check sales products, categories, attributes, options, price/delivery information, and existing performance.',
                            ],
                            [
                                'title' => 'Search intent and competitive landscape analysis',
                                'text' => 'Categorize customer comparison criteria and key search terms by product.',
                            ],
                            [
                                'title' => 'Improved product information',
                                'text' => 'Reorder product names, attributes, images and detail pages based on facts.',
                            ],
                            [
                                'title' => 'Check change history and performance',
                                'text' => 'Record when changes are made and observe the flow of impressions, clicks, and conversions to decide what to do next.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'table',
                        'tone' => 'parchment',
                        'eyebrow' => 'Optimization Scope',
                        'title' => 'Check this for each area:',
                        'columns' => [
                            'area',
                            'Check items',
                            'improvement direction',
                        ],
                        'rows' => [
                            [
                                'product data',
                                'Category·Attribute·Option',
                                'Accuracy and Consistency Maintenance',
                            ],
                            [
                                'Search information',
                                'Product name/key features',
                                'Linking search intent and readability',
                            ],
                            [
                                'click element',
                                'Representative image, price, delivery',
                                'Clarifying key information in the comparison phase',
                            ],
                            [
                                'persuasion to buy',
                                'Detailed page and review operation',
                                'Fact-based information and anxiety relief',
                            ],
                        ],
                        'note' => 'We do not guarantee placement, sales or review results on the Platform.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Suitable for these sellers',
                        'items' => [
                            [
                                'title' => 'Store with increased number of products',
                                'text' => 'When information standards for each product group change and the operating system needs to be reorganized.',
                            ],
                            [
                                'title' => 'Products with exposure but low conversion',
                                'text' => 'When you want to check the persuasion flow between search information and detailed pages.',
                            ],
                            [
                                'title' => 'Team trying to systematically register new products',
                                'text' => 'If you want to create category, attribute, and content standards before launch.',
                            ],
                            [
                                'title' => 'When product competitiveness is unclear',
                                'text' => 'If differences in price, delivery, and product are not resolved, you need to refine your proposal before marketing.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Will changing a product name immediately improve rankings?',
                        'answer' => 'No. Names are one factor alongside categories, attributes, product competitiveness, user response and platform policy. We record changes and compare outcomes.',
                    ],
                    [
                        'question' => 'Do you increase review counts?',
                        'answer' => 'We do not provide fake or manipulated reviews. We prioritize accurate product information and customer experiences that support legitimate buyer feedback.',
                    ],
                    [
                        'question' => 'How many products can we start with?',
                        'answer' => 'We review product groups and goals before setting a quantity. We can start with representative products, then agree how to extend the same criteria to others.',
                    ],
                ],
                'cta' => [
                    'title' => 'Before looking at the product name, let’s look at the entire product data.',
                    'text' => 'If you send us the URL of your store and representative product, we will diagnose the search information and purchase persuasion flow together.',
                    'label' => 'Request a product review',
                ],
            ],
            'kakao-gift' => [
                'eyebrow' => 'Gift Commerce',
                'title' => 'Kakao Gift SEO',
                'seo_title' => 'Kakao Gift SEO | J-Curve Interactive',
                'lead' => 'Kakao Gift — the gifting store inside KakaoTalk. At Kakao Gift, the decision to send the same product to whom, under what circumstances, and why determines the choice. J-Curve organizes product information, images, price ranges, and detailed descriptions in the context of gift discovery.',
                'meta_description' => 'Review gift recipients, occasions, price points, product information and images for Kakao Gift. Request a free consultation.',
                'hero_cta' => 'Discuss your gift products',
                'body' => [
                    'We organize product information and purchase persuasion structure based on the gift recipient and situation.',
                    'We do not guarantee platform approval, placement, or sales performance.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'Even good products are lost in comparison if the context of the gift is not visible.',
                        'paragraphs' => [
                            'The order in which customers check is different for self-use products and gift products. Anxieties such as recipients, anniversaries, packaging, delivery timing and messages need to be resolved quickly.',
                            'Rather than filling the product name with keywords, the priority is to show accurate information about under what circumstances it is best to choose and what the recipient experiences.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Method',
                        'title' => 'Transform your products into the language of your gift choices',
                        'items' => [
                            [
                                'title' => 'Check product/store status',
                                'text' => 'View terms of sale, options, shipping, packaging and current product information.',
                            ],
                            [
                                'title' => 'Classification of gift situations',
                                'text' => 'We organize the reasons for selection by recipient, relationship, anniversary, and price range.',
                            ],
                            [
                                'title' => 'Information and image reconstruction',
                                'text' => 'Arrange the product name, representative image, detailed description, and precautions according to the facts.',
                            ],
                            [
                                'title' => 'Season operation plan',
                                'text' => 'Establish preparation, inspection, and update schedules according to anniversary and season demands.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Check List',
                        'title' => 'Items not to miss in gift items',
                        'items' => [
                            'Key messages that reveal the recipient and gift situation',
                            'Anxiety factors before purchase such as options, packaging, delivery, exchange, etc.',
                            'Representative images and explanation sequences that are quickly understood on mobile screens',
                            'Seasonal preparation schedule and actual inventory and operational range',
                        ],
                        'note' => 'Platform screening and policies are subject to change and do not guarantee store approval or exposure results.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Suitable for these brands',
                        'items' => [
                            [
                                'title' => 'Products with clear gift demand',
                                'text' => 'Products that can specifically explain the purchase situation, such as anniversary, gratitude, or support.',
                            ],
                            [
                                'title' => 'A brand with competitive packaging and delivery',
                                'text' => 'A brand that can support the experience you receive with actual operations.',
                            ],
                            [
                                'title' => 'A team that needs to prepare for the season',
                                'text' => 'If you want to operate according to a pre-scheduled schedule without rushing to change it right before the event.',
                            ],
                            [
                                'title' => 'When basic operations are not ready',
                                'text' => 'If inventory, delivery, and CS standards are unclear, the operating system must be determined before exposure.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Do you guarantee Kakao Gift store approval?',
                        'answer' => 'No. Store and product approval depend on the platform’s review and policies. We organize product information and marketing structure for submission and operation.',
                    ],
                    [
                        'question' => 'Can we start just before a holiday or anniversary?',
                        'answer' => 'It depends on the product and operational readiness. Allowing time for review, content and inventory is preferable. Tell us your target season during consultation.',
                    ],
                    [
                        'question' => 'Do you guarantee rankings or sales volume?',
                        'answer' => 'No. Policies, competition, product strength and customer response affect visibility and sales. We improve verifiable product information and the selection experience.',
                    ],
                ],
                'cta' => [
                    'title' => 'Show the reason for gifting, not just the product.',
                    'text' => 'Provide us with your product URL and target season and we\'ll look at the information structure from a gift discovery perspective.',
                    'label' => 'Discuss your gift products',
                ],
            ],
            'coupang' => [
                'eyebrow' => 'Marketplace SEO',
                'title' => 'Coupang product SEO',
                'seo_title' => 'Coupang product SEO | J-Curve Interactive',
                'lead' => 'Coupang — Korea’s largest e-commerce marketplace. Coupang SEO is not just about refining the product name, but also about adjusting categories, options, images, shipping/sales information, and detailed pages to the customer\'s comparison process. Record data before and after changes to prioritize improvements.',
                'meta_description' => 'Review Coupang categories, options, product names, images, shipping and detail pages. Request a free consultation.',
                'hero_cta' => 'Request a Coupang product review',
                'body' => [
                    'By connecting product information and customers’ comparison criteria, we improve purchase decisions after search.',
                    'We do not guarantee search rankings, sales or review results.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'When product data is scattered, it is difficult for both customers and algorithms to understand.',
                        'paragraphs' => [
                            'It is difficult to compare products if the categories do not match or the option names are different. If the promise of the representative image, the detailed page information, and the actual delivery conditions are different, the bounce rate after clicking increases.',
                            'Rather than looking at exposure alone, you must also check the accuracy of product information, click factors, pre-purchase questions, and operating conditions.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'Organize data and rearrange it into customer comparison order',
                        'items' => [
                            [
                                'title' => 'Product group diagnosis',
                                'text' => 'Check category, options, price, delivery, images and detailed information by product group.',
                            ],
                            [
                                'title' => 'Search and competition context analysis',
                                'text' => 'We organize what expressions and criteria customers use to compare similar products.',
                            ],
                            [
                                'title' => 'Improved product information',
                                'text' => 'Reduce duplication and omission by dividing the roles of product name, options, images, and detailed descriptions.',
                            ],
                            [
                                'title' => 'Observation after change',
                                'text' => 'Determine the next test by looking at the change history and impression, click, and conversion flow together.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Deliverables',
                        'title' => 'Key items to check for each product',
                        'items' => [
                            'Accuracy and consistency of categories, options, and required attributes',
                            'Key differences conveyed in product names and representative images',
                            'Pre-purchase decision-making information such as price, delivery, and returns',
                            'Order of information on detail page and record of performance after change',
                        ],
                        'note' => 'We do not provide methods to circumvent platform policies or manipulate reviews or exposure.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Start with this situation',
                        'items' => [
                            [
                                'title' => 'Seller with increased number of products',
                                'text' => 'When registration standards change and data quality for each product group needs to be unified.',
                            ],
                            [
                                'title' => 'Products with high bounce rate after clicks',
                                'text' => 'When you want to check whether the representative information and the promise on the detail page are connected.',
                            ],
                            [
                                'title' => 'Team preparing to launch a new product',
                                'text' => 'If you want to create an information structure in advance to reduce repeated revisions after registration.',
                            ],
                            [
                                'title' => 'When operating conditions are unstable',
                                'text' => 'If inventory, delivery, and CS are unstable, operational issues need to be resolved before marketing.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Do you guarantee top Coupang search rankings?',
                        'answer' => 'No. Platform policy, competition, product strength and customer response all affect search results and sales.',
                    ],
                    [
                        'question' => 'Do you only change product names?',
                        'answer' => 'No. We also review categories, options, images, price and shipping information, and detail pages that affect comparison and purchase decisions.',
                    ],
                    [
                        'question' => 'Do you buy or create reviews?',
                        'answer' => 'We do not provide fake or manipulated reviews. We prioritize accurate product information, real customer experiences and legitimate feedback.',
                    ],
                ],
                'cta' => [
                    'title' => 'Try structurally diagnosing a product URL first.',
                    'text' => 'If you send us your representative products and current concerns, we will look at the flow of data, clicks, and purchase persuasion together.',
                    'label' => 'Request a Coupang product review',
                ],
            ],
        ],
    ],
    'cpa' => [
        'parent' => [
            'label' => 'CPA marketing (pay-per-lead)',
            'route' => 'services.show',
            'param' => 'cpa-marketing',
            'summary' => 'We connect action definitions, consent, tracking, validation and operational feedback in pay-per-action campaigns.',
        ],
        'items' => [
            'real-estate' => [
                'eyebrow' => 'Real Estate CPA',
                'title' => 'Real estate pre-sale leads',
                'lead' => 'CPA for real estate sales is not an advertisement that only counts the fact that a consultation application has been received. Quality can be managed only by accurately explaining the business location and supply conditions, and linking the customer\'s contact consent, valid leads standards, and feedback after consultation.',
                'meta_description' => 'Plan Korean real estate pre-sale lead campaigns around project facts, consent, qualified-lead criteria, tracking and consultation feedback.',
                'hero_cta' => 'Discuss your pre-sale lead campaign',
                'body' => [
                    'This is a real estate sales CPA service that first agrees on the definition and operating standards of the consultation application according to the business location and customer conditions.',
                    'Applying for a consultation does not imply an actual visit or contract and does not guarantee the performance of the contract.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'Even if there are many leads, performance cannot be judged if the consultation standards are different.',
                        'paragraphs' => [
                            'If there is no standard for whether it is valid if only the region is correct and how to handle uncontactability, duplication, or incorrect information input, advertising and sales will see different numbers.',
                            'Before a campaign begins, business facts, target customers, validity/invalid criteria and consultation response times must be agreed upon so that advertising data can be linked to sales results.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'Design standards and flow before collection',
                        'items' => [
                            [
                                'title' => 'Check expressions in business sites and advertisements',
                                'text' => 'Confirm supply information, schedules, target locations and fact sheets to use in your advertising.',
                            ],
                            [
                                'title' => 'Valid consensus based on leads',
                                'text' => 'Determine required items, handling of duplicates, incorrect inputs, uncontactability, and feedback methods.',
                            ],
                            [
                                'title' => 'Landing, consent, tracking configuration',
                                'text' => 'Design explanations, contact consent and conversion record points that your customers will understand.',
                            ],
                            [
                                'title' => 'Feedback on consultation results',
                                'text' => 'After inflow, the consultation status is classified and reflected in improving media, materials, and targeting.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Before Launch',
                        'title' => 'Items to check together before execution',
                        'items' => [
                            'Base materials to be used for business site/supply conditions and advertising expressions',
                            'Target area/customer conditions and required consultation application items',
                            'Statement of consent to collection and use of personal information and contact for consultation',
                            'Validity processing criteria and person in charge, such as duplication, incorrect input, and inability to contact',
                        ],
                        'note' => 'You must check related laws and media review standards, and we do not guarantee consultation applications, visits, or sales contracts.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'The more operationally ready your site is, the clearer your data will be.',
                        'items' => [
                            [
                                'title' => 'A site with a consultation response system',
                                'text' => 'If there is a person in charge who will quickly contact you after the influx and record the consultation status.',
                            ],
                            [
                                'title' => 'Site where business information has been confirmed',
                                'text' => 'When it is possible to provide a basis for advertising explanation such as price, schedule, location, etc.',
                            ],
                            [
                                'title' => 'A team where you can share feedback',
                                'text' => 'leads If you want to use not only the quantity but also the consultation results to improve your campaign.',
                            ],
                            [
                                'title' => 'If you only want guaranteed contracts',
                                'text' => 'CPA is a structure that creates consultation opportunities and cannot confirm the outcome of a contract on your behalf.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Does every lead represent a customer ready to sign?',
                        'answer' => 'No. A lead is an application with the required information and consent to consultation contact. Visits and contracts depend on the offer, consultation quality and the customer’s decision.',
                    ],
                    [
                        'question' => 'Who defines a qualified lead?',
                        'answer' => 'The advertiser and J-Curve agree before launch on verifiable criteria, including required fields and handling of duplicates, incorrect entries and unreachable contacts.',
                    ],
                    [
                        'question' => 'Do you help design the consent flow?',
                        'answer' => 'We review clarity around collection purposes, data fields, retention and who will contact the customer. The advertiser must also review final wording and legal compliance.',
                    ],
                ],
                'cta' => [
                    'title' => 'Start by matching the business location information with the valid leads standard.',
                    'text' => 'Please let us know your target location, consulting organization and current advertising structure and we will review the scope in detail.',
                    'label' => 'Discuss your pre-sale lead campaign',
                ],
            ],
            'stock' => [
                'eyebrow' => 'Finance Lead CPA',
                'title' => 'Stock-investor leads',
                'lead' => 'Stock-related CPA is a campaign that measures consultation requests from customers interested in investing. Instead of exaggerating expectations of profit, the actual scope and risk information of the service should be clearly explained, and consent to contact and validity criteria should be recorded.',
                'meta_description' => 'Stock-investor lead campaigns with ad suitability reviews, consultation consent, qualified-lead criteria and tracking.',
                'hero_cta' => 'Discuss campaign suitability',
                'body' => [
                    'This is a CPA service that truthfully explains the scope of services and risk information and measures applications for consent to consultation contact.',
                    'There is no guarantee of investment return, principal, subscription or conversion of advice.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'An accurate explanation is better than a strong promise.',
                        'paragraphs' => [
                            'In the investment world, exaggeration to get clicks can lead to regulatory and brand risk. The service provider, actual provided content, and cost/risk information must not be hidden.',
                            'J-Curve reviews ad copy, landing description, contact consent and conversion definitions as one flow. The feasibility of a campaign is also determined before creating the material.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'From suitability confirmation to consultation feedback',
                        'items' => [
                            [
                                'title' => 'Confirmation of business/advertisement suitability',
                                'text' => 'Confirm the service entity, scope of provision, required notices and advertising terms.',
                            ],
                            [
                                'title' => 'Design of consultation application criteria',
                                'text' => 'Agree on validity criteria such as required information, consent to contact, duplication and incorrect input.',
                            ],
                            [
                                'title' => 'Landing/tracking configuration',
                                'text' => 'Lay out information and conversion recording points to understand your service without exaggerating.',
                            ],
                            [
                                'title' => 'Improvement based on consultation results',
                                'text' => 'Contact/consultation status is classified and reflected in material and targeting improvement.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Required Review',
                        'title' => 'Information required for campaign delivery review',
                        'items' => [
                            'Business operators/service providers and actual content provided',
                            'Advertising copy and required risk notices',
                            'Personal information collection/consultation contact consent and retention standards',
                            'Effective leads definition, consultation person and result feedback method',
                        ],
                        'note' => 'We do not conduct campaigns that imply or guarantee profit, principal, or performance of specific items. Final execution must meet relevant laws and media reviews.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'It can be reviewed only when these conditions are met',
                        'items' => [
                            [
                                'title' => 'A business operator with a clear scope of service',
                                'text' => 'If you can clearly explain in your documentation and landing who is providing what.',
                            ],
                            [
                                'title' => 'Team that accepts notice and review',
                                'text' => 'In cases where explanations that meet legal and media standards are given priority over exaggerated hooks.',
                            ],
                            [
                                'title' => 'Organization that records consultation results',
                                'text' => 'If you can improve your campaign by sharing post-inflow status.',
                            ],
                            [
                                'title' => 'When requesting guaranteed profits',
                                'text' => 'Expressions of guarantee or structures that cause misunderstanding are not subject to processing.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Can you recruit only customers who will make investment returns?',
                        'answer' => 'No. CPA measures consultation interest and applications, not investment outcomes. Claims implying investment returns also require review.',
                    ],
                    [
                        'question' => 'Can you run any ad copy?',
                        'answer' => 'No. Business type, laws and media policies can restrict advertising. Unsupported return claims, principal guarantees and misleading wording are not permitted.',
                    ],
                    [
                        'question' => 'How is application information managed?',
                        'answer' => 'We agree on collection purposes, consent scope, recipients and retention rules before processing data within those boundaries. Operational procedures are finalized with the advertiser.',
                    ],
                ],
                'cta' => [
                    'title' => 'Before execution, we check the suitability of the business and advertising.',
                    'text' => 'If you send us an introduction to the service and the advertising text you are considering, we will first check whether the structure is feasible.',
                    'label' => 'Discuss campaign suitability',
                ],
            ],
            'insurance' => [
                'eyebrow' => 'Consent-based insurance leads',
                'title' => 'Insurance leads, consent and sales operations',
                'lead' => 'insurance a lead is not a product that delivers a single phone number. Ad inflow, consent verification call, consent/recording confirmation, overlapping criteria, region/condition matching, meeting coordination, after-sales support and sales feedback must be followed to create an actual consultation opportunity.',
                'meta_description' => 'Understand insurance leads, consent calls, recordings, duplicates and after-sales support, with custom scripts and LeadBay CRM operations.',
                'hero_cta' => 'Discuss insurance lead operations',
                'contact_interest' => 'cpa-insurance',
                'inquiry_template' => '[Insurance CPA·consent-based leads inquiry]

Organization type/number of planners: 
Hope leads Type: 
Preferred area: 
Desired monthly quantity: 
Current leads purchase and distribution method: 
Scope of need: Advertising Inflow / leads Delivery / LeadBay / Call2Sale
Currently valid, based on after-sales support: 
Expected start date:',
                'local_nav' => [
                    [
                        'label' => 'Full structure',
                        'href' => '#insurance-overview',
                    ],
                    [
                        'label' => 'Consent-based leads',
                        'href' => '#permission-db',
                    ],
                    [
                        'label' => 'Progress',
                        'href' => '#insurance-process',
                    ],
                    [
                        'label' => 'Quality·after-sales support',
                        'href' => '#insurance-quality',
                    ],
                    [
                        'label' => 'LeadBay',
                        'href' => '#leadbay-operations',
                    ],
                    [
                        'label' => 'Compliance standards',
                        'href' => '#insurance-compliance',
                    ],
                    [
                        'label' => 'FAQ',
                        'href' => '#faq',
                    ],
                ],
                'body' => [
                    'This is an insurance CPA service that connects applications that have agreed to consultation contact with consent verification call·inspection·distribution·consultation feedback.',
                    'We do not guarantee insurance coverage, meeting rates, contract rates or operating profits.',
                ],
                'sections' => [
                    [
                        'id' => 'insurance-overview',
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'End-to-End Insurance Lead',
                        'title' => 'Advertising inflow, leads supply, and sales management are viewed as one structure.',
                        'lead' => 'The consent-based leads operation and LeadBay functions, which were strengths of the existing insurance landing, have been linked to the current J-Curve service structure.',
                        'items' => [
                            [
                                'title' => 'J-Curve insurance CPA',
                                'text' => 'Design advertising materials and landing, consultation application, contact agreement, consent verification call and effective leads standards.',
                            ],
                            [
                                'title' => 'LeadBay · purchasing organization',
                                'text' => 'We manage the sales organization\'s utilization process from comparison of leads companies and conditions to distribution, consultation schedule, contract, and settlement with after-sales support.',
                                'href' => '/solutions/leadbay',
                                'label' => 'LeadBay view details',
                            ],
                            [
                                'title' => 'Call2Sale · supply organization',
                                'text' => 'Manages insurance leads call center\'s source leads, agent distribution, call quality, delivery, and settlement tasks with after-sales support.',
                                'href' => '/solutions/call2sale',
                                'label' => 'Call2Sale view details',
                            ],
                            [
                                'title' => 'Advertising feedback of consultation results',
                                'text' => 'Contact, meeting, consultation, and contract status are recorded using the same criteria to determine which inflow and script can be improved.',
                            ],
                        ],
                        'note' => 'The scope of actual advertising, leads supply and solution integration is confirmed after confirming the organization\'s contract structure, system and personal information processing role.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'dark',
                        'eyebrow' => 'Operating Record',
                        'title' => 'Rather than inflating insurance alone, it is displayed on a company-wide cumulative basis.',
                        'items' => [
                            [
                                'title' => 'KRW 37.3B+',
                                'text' => 'As of 2026 · cumulative ad spend managed, company-wide',
                            ],
                            [
                                'title' => '1.28M+',
                                'text' => 'As of 2026 · cumulative leads collected, company-wide',
                            ],
                            [
                                'title' => '15,700+',
                                'text' => 'As of 2026 · cumulative campaigns run, company-wide',
                            ],
                            [
                                'title' => '2009',
                                'text' => 'J-Curve Interactive incorporated',
                            ],
                        ],
                        'note' => 'Figures for daily output, advertiser counts, meeting rates and conversion rates from the old insurance page are not presented as current results until their calculation basis and recency are verified. The figures above are cumulative company-wide records, not guarantees for insurance campaigns.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'parchment',
                        'eyebrow' => 'Where Insurance Leads Break',
                        'title' => 'Insurance leads problems mostly surface after collection',
                        'items' => [
                            [
                                'title' => 'Source and consent are unclear',
                                'text' => 'If you don\'t know what advertisements and phrases you applied for or who is contacting you and for what purpose, trust is broken from the first call.',
                            ],
                            [
                                'title' => 'Delivery is late',
                                'text' => 'The longer the time between application and first contact, the more the customer\'s memory and intentions change, and the more work the staff has to do.',
                            ],
                            [
                                'title' => 'The criteria for duplication are different',
                                'text' => 'If the duplication period and identification criteria are different for each advertiser or supplier, rejection and settlement disputes will be repeated.',
                            ],
                            [
                                'title' => 'Consultation results do not come back',
                                'text' => 'If you don\'t know whether it\'s a failure to contact you, a refusal to meet, or a problem with the product or script, your ads will repeat the same mistakes.',
                            ],
                            [
                                'title' => 'After-sales support becomes an emotional battle',
                                'text' => 'Without the number of contacts, processing deadlines, and conditions for proof and exchange, even the same case is judged differently.',
                            ],
                            [
                                'title' => 'Leads and sales management are separated',
                                'text' => 'If purchasing, distribution, consultation, contract, after-sales support, and settlement are in different Excels, it is difficult to view organizational performance by the same standards.',
                            ],
                        ],
                    ],
                    [
                        'id' => 'permission-db',
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Permission Marketing',
                        'title' => 'Consent-based a lead is not a checkbox, but the contact expected by the customer.',
                        'paragraphs' => [
                            'permission Marketing is the concept of starting a relationship with the customer\'s prior permission. The point of this perspective, popularized by Seth Godin, is not about getting more contacts, but making sure customers understand what they agreed to and how they will be contacted next.',
                            'Insurance consent-based leads may include an additional step after the initial ad or landing-page application. Depending on the campaign, we reconfirm who will contact the customer, the consultation purpose, third-party disclosure or processing arrangements, and the customer’s intent.',
                            'However, just because there is consent does not mean that all calls, indefinite storage, or free re-provision are permitted. Collection items, purpose, recipients, retention period, withdrawal method and actual consultation flow must match.',
                        ],
                        'note' => 'This page does not constitute legal advice. For actual campaigns, applicable laws, financial and insurance advertising standards, personal information processing roles, and advertisers\' internal compliance standards must be checked separately.',
                    ],
                    [
                        'type' => 'table',
                        'tone' => 'dark',
                        'eyebrow' => 'Application leads vs consent-based leads',
                        'title' => 'The difference between general application leads and consent-based a lead is ‘confirmation before delivery’',
                        'caption' => 'The actual scope of provision for each campaign may vary depending on the contract/consent structure.',
                        'columns' => [
                            'judgment item',
                            'General landing application leads',
                            'permission Verified leads',
                        ],
                        'rows' => [
                            [
                                'customer awareness',
                                'Information entered at landing',
                                'Additional confirmation of who is contacting you and for what purpose',
                            ],
                            [
                                'Consent and Proof',
                                'Application screen record center',
                                'Manage consent phrases and timing and call confirmation records when necessary',
                            ],
                            [
                                'Consultation readiness',
                                'Difficulty knowing depth of interest and availability times',
                                'Reconfirm the agreed upon conditions such as consultation doctor, topic, region, schedule, etc.',
                            ],
                            [
                                'sales fatigue',
                                'Counselors directly classify causes of absence, misidentification, and duplication',
                                'Direction to reduce unnecessary contact based on confirmation before delivery',
                            ],
                            [
                                'Unit price judgment',
                                'Easy to compare price per item',
                                'Comparison of actual costs including validity standards, confirmation process, and after-sales support conditions',
                            ],
                            [
                                'after-sales support judgment',
                                'Posthumous claims may be conflicting.',
                                'Judgment based on contact records, meeting status, proof of consent, and pre-agreed rules',
                            ],
                        ],
                        'note' => 'permission confirmation does not guarantee a meeting or contract. The meeting rate and conversion rate emphasized by the existing page are results by campaign, organization, and period and are not used as fixed promises.',
                    ],
                    [
                        'id' => 'insurance-process',
                        'type' => 'steps',
                        'tone' => 'light',
                        'eyebrow' => 'Lead Production Flow',
                        'title' => 'From advertising influx to face-to-face meetings and feedback',
                        'items' => [
                            [
                                'title' => 'Advertisement/landing design',
                                'text' => 'We explain the actual scope of provision, including insurance remodeling, coverage analysis, and consultation, without exaggeration, and align with the purpose of the application.',
                            ],
                            [
                                'title' => 'Initial application and consent records',
                                'text' => 'We record the minimum information required, purpose of contact, scope of collection, use and provision, and point of consent.',
                            ],
                            [
                                'title' => 'Consent verification call·doctor reconfirmation',
                                'text' => 'Depending on the campaign conditions, we reconfirm the consultation topic, contact person, region, possible schedule and key intentions.',
                            ],
                            [
                                'title' => 'Recording/validity inspection',
                                'text' => 'Check necessary notices and consents, incorrect inputs, duplication, regional and product conditions using an agreed-upon checklist.',
                            ],
                            [
                                'title' => 'Distribution to advertisers and people in charge',
                                'text' => 'Check sales region, organization, existing leads and overlap criteria to assign a person in charge and record delivery time.',
                            ],
                            [
                                'title' => 'Meeting/counseling status management',
                                'text' => 'Manage contact, schedule confirmation, meeting, hold, rejection, contract, and re-call status using the same standards.',
                            ],
                            [
                                'title' => 'After-sales support·advertising feedback',
                                'text' => 'We check the after-sales support proof agreed upon in advance and reflect the consultation results in material, targeting, script, and next volume judgment.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'parchment',
                        'eyebrow' => 'Four Operating Principles',
                        'title' => 'Four principles from the original insurance page, restated as operating standards',
                        'items' => [
                            [
                                'title' => '01. Manage lead handoff timing',
                                'text' => 'Record application, confirmation, and delivery times, and agree on the delivery cycle and expected volume for each campaign to ensure that old leads and new leads are not mixed.',
                            ],
                            [
                                'title' => '02. Consent and call-recording evidence',
                                'text' => 'The consent wording and timing, items confirmed by consent verification call, and the scope of access, storage, and provision of recordings are determined in accordance with the role and contract.',
                            ],
                            [
                                'title' => '03. Duplicate and exclusivity criteria',
                                'text' => 'Whether it is exclusive to one advertiser, duplicate verification period, identification value, comparison of existing leads, and scope of prohibition of re-provision are documented before execution.',
                            ],
                            [
                                'title' => '04. Custom scripts for each organization',
                                'text' => 'Insurance remodeling explanations, reconfirmation of meetings, and adjustment of confirmation questions and delivery information according to region, consultation type, and sales method.',
                            ],
                        ],
                        'note' => '‘Real-time’, ‘full inspection’, ‘no duplication’, and ‘after-sales support possible’ are not automatic guarantees. Actual application levels and exceptions will be confirmed after confirming the campaign contract, systems and operational personnel.',
                    ],
                    [
                        'type' => 'chips',
                        'tone' => 'dark',
                        'eyebrow' => 'Decision Variables',
                        'title' => 'These names must be defined before the price tag',
                        'items' => [
                            'consent-based leads',
                            'semi-silver leads',
                            'silver leads',
                            'Confirmed leads',
                            'Insurance Remodeling',
                            'face to face meeting',
                            'desired area',
                            'Monthly desired quantity',
                            'Exclusive/Public use',
                            'Duplicate verification period',
                            'after-sales support availability period',
                            'delivery schedule',
                        ],
                        'note' => 'Do not judge lead quality by the product name alone. Define each type’s required checks, level of consultation intent, evidence and after-sales support scope in the contract.',
                    ],
                    [
                        'id' => 'insurance-quality',
                        'type' => 'table',
                        'tone' => 'light',
                        'eyebrow' => 'Validity & AS Matrix',
                        'title' => 'Validity, invalidity, after-sales support are determined before a case occurs.',
                        'caption' => 'Below is an example for creating operating rules, and the actual application standards are confirmed by contract.',
                        'columns' => [
                            'situation',
                            'Verification materials required',
                            'Processing principles to be agreed upon in advance',
                        ],
                        'rows' => [
                            [
                                'suspected duplicate',
                                'Phone number/identification value, comparison period, existing possession point',
                                'Define what will be considered duplicates within the same campaign/advertiser/period',
                            ],
                            [
                                'Unable to contact/incorrect input',
                                'Minimum number of contacts and times, call and text records',
                                'Define processing deadlines and whether to exchange obvious number errors',
                            ],
                            [
                                'Inconsistency in consultation content',
                                'Landing phrase, consent verification call confirmation items, recording/memo',
                                'Check whether the advertised promise was different from the actual consultation doctor',
                            ],
                            [
                                'Regional/condition mismatch',
                                'Application area, allocation criteria, product/organization restrictions',
                                'Defining responsibility and reassignment standards for targeting and distribution errors',
                            ],
                            [
                                'Meeting no-show/non-response',
                                'When to make an appointment, whether to reconfirm it, and a record of follow-up contact',
                                'Separate agreement on whether to include after-sales support and recognition period and evidence',
                            ],
                            [
                                'contract not concluded',
                                'Consultation status and reasons for refusal',
                                'The contract result is not a basic after-sales support reason and is classified as advertising/consultation improvement data.',
                            ],
                        ],
                        'note' => 'Rather than rejecting an application based solely on subjective “bad quality,” both parties should be able to make a judgment based on the same data and deadline.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'parchment',
                        'eyebrow' => 'Custom Script & Allocation',
                        'title' => 'The same a lead is operated differently depending on the advertiser\'s size and business method.',
                        'items' => [
                            [
                                'title' => 'Insurance a lead is the first organization',
                                'text' => 'Learn with a small pilot everything from the type name to valid/duplicate/after-sales support standards, first contact speed, and how to enter the contact person\'s status.',
                            ],
                            [
                                'title' => 'Small GA/team',
                                'text' => 'Prioritizes a structure that narrows down the volume and region that can be handled and receives consultation feedback without missing distribution to each person in charge.',
                            ],
                            [
                                'title' => 'High-volume advertisers',
                                'text' => 'First, compare overlap with existing leads, distribution by branch/team, quantity schedule, authority, and settlement standards.',
                            ],
                            [
                                'title' => 'Remodeling-focused consultation',
                                'text' => 'We design a script that accurately explains and reconfirms the customer\'s expected consultation scope and meeting purpose.',
                            ],
                            [
                                'title' => 'Regionally focused organization',
                                'text' => 'Targeting and distribution conditions are adjusted based on the actual response area and staff capacity.',
                            ],
                            [
                                'title' => 'Existing call center holding organization',
                                'text' => 'Responsibilities are divided so that internal consent verification call, transcription, quality inspection and supplier roles do not overlap.',
                            ],
                        ],
                    ],
                    [
                        'id' => 'leadbay-operations',
                        'type' => 'points',
                        'tone' => 'dark',
                        'eyebrow' => 'LeadBay Features',
                        'title' => 'After purchasing leads, you will continue to manage your affairs in LeadBay.',
                        'lead' => 'The LeadBay functions introduced in existing insurance landings have been organized into the actual work order of the insurance sales organization.',
                        'items' => [
                            [
                                'title' => 'Leads purchase management',
                                'text' => 'Compare the call center information, reviews, scores, and delivery speed displayed on the service with the after-sales support policy and check delivery options.',
                            ],
                            [
                                'title' => 'Apply for after-sales support',
                                'text' => 'Check the after-sales support availability period, application status, approval/rejection results, and necessary evidence for each leads in one flow.',
                            ],
                            [
                                'title' => 'Consultation schedule management',
                                'text' => 'Leave consultation schedules, notes, contact information, and progress status so you don\'t miss out on follow-up with the person in charge.',
                            ],
                            [
                                'title' => 'Team member/branch performance analysis',
                                'text' => 'We compare the step-by-step conversion of leads, contact, meeting, consultation and contract by team member, month and branch.',
                            ],
                            [
                                'title' => 'Customer management automation',
                                'text' => 'We manage customer schedules such as birthdays, contract anniversaries, and renewal dates, and send messages within the consent/unsubscribe criteria.',
                            ],
                            [
                                'title' => 'Mobile counseling app',
                                'text' => 'Organize consultation history and recordings while working outside and use the AI summary as review aid. The final decision is confirmed by the person in charge along with the original data.',
                            ],
                        ],
                        'note' => 'LeadBay\'s latest services and terms of use take precedence over screens, score calculations, automation, AI, arbitration, settlement functions and fees.',
                        'link' => [
                            'href' => '/solutions/leadbay',
                            'label' => 'Check out all features of LeadBay',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'light',
                        'eyebrow' => 'LeadBay Core Workflow',
                        'title' => 'Comparison, purchase, consultation, after-sales support, and settlement lead to one record',
                        'items' => [
                            [
                                'title' => 'Call center leads market',
                                'text' => 'Compare the leads type, quality/delivery/after-sales support information, remaining quantity, and expected completion date to provide a basis for your purchase decision.',
                            ],
                            [
                                'title' => 'My leads sales management',
                                'text' => 'Manage status from no contact to re-call, meeting, consultation, contract, after-sales support, and connect schedule, memo, and recording history in units of leads.',
                            ],
                            [
                                'title' => 'After-sales support request and proof',
                                'text' => 'after-sales support Tracks available dates and processing status and uses purchase, consultation, and contract history as dispute review data.',
                            ],
                            [
                                'title' => 'Organizational performance and settlement',
                                'text' => 'Assignment and performance by team and branch, authority by position, point payment, and monthly settlement information are managed within the scope of current provision.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'parchment',
                        'eyebrow' => 'Supply-Side Operations',
                        'title' => 'If call center produces and supplies leads, it leads to Call2Sale.',
                        'items' => [
                            [
                                'title' => 'Source leads and agent distribution',
                                'text' => 'The supply organization manages which agent the collected source a lead is assigned to and what status it is in.',
                            ],
                            [
                                'title' => 'Call quality and transcription review',
                                'text' => 'Script compliance and consultation quality are recorded, and AI analysis is used as supplementary material to help managers review.',
                            ],
                            [
                                'title' => 'Order receipt, delivery, after-sales support connection',
                                'text' => 'Manage each advertiser\'s order, delivery status, after-sales support request and processing history through the same workflow.',
                            ],
                            [
                                'title' => 'Electronic contract and settlement',
                                'text' => 'We manage contracts, points, and post-settlement tasks according to the scope of current system provision and organizational authority.',
                            ],
                        ],
                        'note' => 'LeadBay focuses on the flow of the purchasing and sales organization that utilizes leads, and Call2Sale focuses on the flow of the supply organization that produces and delivers leads.',
                        'link' => [
                            'href' => '/solutions/call2sale',
                            'label' => 'Check the overall structure of Call2Sale',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Pilot To Scale',
                        'title' => 'Instead of ordering in large quantities from the beginning, we order in small quantities.',
                        'items' => [
                            [
                                'title' => 'Organization/product/region diagnosis',
                                'text' => 'Check the consulting entity, number of planners, corresponding region, product range and current leads operation issues.',
                            ],
                            [
                                'title' => 'Leads type/valid/after-sales support agreement',
                                'text' => 'Document required verification items, duplication, uncontactability, no-shows, and certification/processing deadlines.',
                            ],
                            [
                                'title' => 'Setting up scripts and delivery flows',
                                'text' => 'We match advertising text, consent verification call questions, recording review, and distribution/contact SLA to personnel.',
                            ],
                            [
                                'title' => 'Pilot operation',
                                'text' => 'Check contact rate, meeting status, reason for rejection, and quality of input from the person in charge in small areas and volumes.',
                            ],
                            [
                                'title' => 'Quality improvement and volume expansion',
                                'text' => 'Only the scope where inflow, script, distribution, and consultation feedback is stable is expanded step by step.',
                            ],
                        ],
                    ],
                    [
                        'id' => 'insurance-compliance',
                        'type' => 'checklist',
                        'tone' => 'light',
                        'eyebrow' => 'Compliance Boundary',
                        'title' => '“leads with consent” does not end in one sentence',
                        'items' => [
                            'Distinguish between advertiser, call center, and platform who actually collects, uses, provides, and entrusts personal information.',
                            'Confirm that the advertisement/landing text seen by the customer matches the actual contact entity, purpose, and scope of insurance consultation',
                            'Confirm collected fields, third-party recipients, purposes, retention and use periods, and ways to refuse or withdraw consent.',
                            'consent verification call Check recording notice, access rights, provision method, storage period and destruction standards',
                            'Confirm operating procedures to reflect consent to receive advertising calls and text messages, refusal to receive them, and requests to limit contact',
                            'Minimize identification value, period, and access rights used to compare existing leads and determine duplicates',
                            'Review advertising expressions, insurance solicitation/counseling role, and possibility of customer misunderstanding based on advertiser compliance standards',
                            'Apply retention and deletion standards after achievement of purpose, termination or cancellation of contract in accordance with relevant obligations and contracts',
                        ],
                        'note' => 'Although permissions resolve content copyright issues, they do not automatically guarantee the legality of individual campaigns. Before actual disclosure and execution, it is necessary to confirm the current standards of personal information and financial advertising personnel.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'parchment',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Insurance leads only works to your sales organization\'s level of readiness',
                        'items' => [
                            [
                                'title' => 'GA introducing insurance leads for the first time',
                                'text' => 'An organization that must establish everything from terminology, validity, duplication, after-sales support to distribution of personnel and first contact standards.',
                            ],
                            [
                                'title' => 'An organization that operates multiple branches and design agencies',
                                'text' => 'An organization that wants to see the distribution of regions and personnel, authority, and consulting/contract funnels for each team on the same basis.',
                            ],
                            [
                                'title' => 'Advertisers with frequent quality disputes with existing leads',
                                'text' => 'An organization that seeks to change subjective quality evaluation into operating rules centered on evidence, deadlines, and status values.',
                            ],
                            [
                                'title' => 'A team that wants to connect advertising and sales data',
                                'text' => 'The team is trying to return the consultation results to improvements in creatives, targeting, landing, and consent verification call.',
                            ],
                            [
                                'title' => 'If you want to receive a guaranteed contract rate',
                                'text' => 'insurance a lead is an input value that creates a consultation opportunity and does not confirm a meeting, contract, or sales.',
                            ],
                            [
                                'title' => 'When the scope of consent cannot be confirmed',
                                'text' => 'If the source, purpose of contact, and provision relationship cannot be confirmed, the compliance structure must be established first before advertising or delivering leads.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'What are insurance leads?',
                        'answer' => 'Here, insurance leads mean application information collected and delivered for insurance-related consultation contact. Manage the application purpose, consent records, validity criteria, delivery time and consultation status alongside the phone number.',
                    ],
                    [
                        'question' => 'How do standard and consent-based insurance leads differ?',
                        'answer' => 'Standard application leads may be passed on from a landing-page form. Depending on the campaign, consent-based leads include additional confirmation of the contacting party, consultation purpose, region, timing and customer intent, with records. Exact checks vary by contract.',
                    ],
                    [
                        'question' => 'Does one insurance lead mean a meeting or contract?',
                        'answer' => 'No. A lead is a consultation opportunity meeting agreed criteria. Meetings and purchases depend on customer needs, product fit, delivery timing, adviser quality and the customer’s decision.',
                    ],
                    [
                        'question' => 'Can we receive leads in real time?',
                        'answer' => 'Delivery frequency and expected volume depend on ad traffic, consent-call and review staffing, region and criteria. We agree on campaign-specific delivery SLAs and exceptions rather than promising real-time delivery for every campaign.',
                    ],
                    [
                        'question' => 'Does consent allow delivery to any advertiser?',
                        'answer' => 'No. Consent wording, recipients, purposes, fields and retention must match the actual transfer and contact flow. Third-party disclosure or outsourced-processing arrangements must reflect actual roles and relationships.',
                    ],
                    [
                        'question' => 'Can we receive all call recordings?',
                        'answer' => 'Recording, access, disclosure, retention and deletion depend on the campaign, contract and applicable requirements. Because recordings contain personal information, access is limited to what is necessary and authorized.',
                    ],
                    [
                        'question' => 'Will a lead never be supplied elsewhere?',
                        'answer' => 'Exclusivity and duplicate rules must be agreed by contract. Their meaning varies by advertiser, campaign, identifier and comparison period. We first agree on validation and evidence rather than absolute promises.',
                    ],
                    [
                        'question' => 'Do unreachable contacts and meeting no-shows always qualify for after-sales support?',
                        'answer' => 'No. Eligible reasons, contact attempts and times, request deadlines, evidence and replacement or remediation scope must be documented before delivery.',
                    ],
                    [
                        'question' => 'Can we specify regions and monthly volume?',
                        'answer' => 'We can review them, but availability depends on region, targeting, script, price, timing and validation. A small pilot helps confirm the actual supply and consultation flow.',
                    ],
                    [
                        'question' => 'How do LeadBay and Call2Sale differ?',
                        'answer' => 'LeadBay supports sales teams comparing and buying insurance leads, then allocating them and managing consultations, contracts, support and settlement. Call2Sale supports call centers producing, reviewing and delivering leads. Check each service’s current features and integration terms.',
                    ],
                    [
                        'question' => 'What should we prepare before consultation?',
                        'answer' => 'Share your organization type, adviser count, service regions, desired lead types and monthly volume, purchasing and allocation flow, existing CRM, validity, duplicate and support criteria, and preferred start date.',
                    ],
                ],
                'cta' => [
                    'title' => 'Meet the validity·after-sales support·distribution standards before the insurance leads quote.',
                    'text' => 'If you tell us the size of your organization, desired region/quantity, type of leads, and current operation method, we will provide you with the specific range you need among advertising inflow, consent verification call, LeadBay, and Call2Sale.',
                    'label' => 'Discuss insurance lead operations',
                ],
            ],
            'coin' => [
                'eyebrow' => 'Digital Asset Lead CPA',
                'title' => 'Crypto-investor leads',
                'lead' => 'CPAs related to virtual assets should measure the consultation requests of interested customers, but should not promise price increases or profit potential. We first review the scope of service provision, volatility risk, availability of advertising, and consent to personal information.',
                'meta_description' => 'Crypto-investor lead campaigns begin with business and ad suitability, risk disclosures, consultation consent and qualified-lead criteria.',
                'hero_cta' => 'Discuss campaign suitability',
                'body' => [
                    'Describes the actual scope and risks of virtual asset services and measures applications consenting to consultation contact.',
                    'There are no guarantees of price, return, principal or investment results.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'The more volatile the market, the clearer the boundaries of advertising must be.',
                        'paragraphs' => [
                            'Virtual asset advertisements can easily overstimulate customer expectations, and execution restrictions may vary depending on business type and medium. Creating strong copy first is not appropriate.',
                            'J-Curve determines whether a campaign is possible after checking the business entity, service scope, required notices, consultation application, and consent structure.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'We only design ranges that have passed conformance review',
                        'items' => [
                            [
                                'title' => 'Check business/media availability',
                                'text' => 'First check the restrictions by service type, provider, and medium.',
                            ],
                            [
                                'title' => 'Summary of advertising expressions and risk notices',
                                'text' => 'Eliminate unsubstantiated profit statements and clarify the risks customers need to know.',
                            ],
                            [
                                'title' => 'Consent/conversion standard design',
                                'text' => 'Agree on the purpose of the contact, required information and criteria for determining validity.',
                            ],
                            [
                                'title' => 'Operation based on consultation feedback',
                                'text' => 'After application, we classify the status and improve materials and targeting within the permitted range.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Required Review',
                        'title' => 'Materials to prepare before consultation',
                        'items' => [
                            'Business operators/service providers and actual provided functions',
                            'Region/media you wish to advertise in and the grounds needed for screening',
                            'Key risks to notify customers, such as price volatility',
                            'Personal information consent, consultation subject and valid leads processing standards',
                        ],
                        'note' => 'We do not run advertisements that mislead people about profits, price increases, guaranteed principal, or investment decisions. Campaign eligibility may vary depending on laws and media policies.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'We only review businesses that meet these criteria',
                        'items' => [
                            [
                                'title' => 'A business operator with a clear service entity',
                                'text' => 'If you can explain with factual information what you are providing and who is responsible.',
                            ],
                            [
                                'title' => 'A team that accepts risk notices',
                                'text' => 'When an accurate understanding of customers and screening standards are prioritized over conversion.',
                            ],
                            [
                                'title' => 'Organization with records of consultation operations',
                                'text' => 'When the contact/counseling status can be managed and the scope of consent can be maintained.',
                            ],
                            [
                                'title' => 'If you need a copy that promises guaranteed results',
                                'text' => 'It is difficult to run a campaign that only works if you promise profits and results.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Can ads emphasize crypto investment returns?',
                        'answer' => 'Unsupported returns, price-rise claims and implied principal guarantees are not allowed. Advertising scope must be checked against the business type, laws and media policies first.',
                    ],
                    [
                        'question' => 'Can every crypto-related service advertise?',
                        'answer' => 'No. Restrictions depend on service type, operating regions, licensing or registration and media policy. We review business information during consultation.',
                    ],
                    [
                        'question' => 'Does CPA cover investment outcomes after consultation?',
                        'answer' => 'CPA charges for agreed consultation applications. It does not guarantee investment decisions, outcomes, service contracts or returns.',
                    ],
                ],
                'cta' => [
                    'title' => 'Before launching a campaign, make sure it is a viable business.',
                    'text' => 'If you send us an introduction to the service and the scope you wish to advertise, we will review it for suitability and required notices.',
                    'label' => 'Discuss campaign suitability',
                ],
            ],
            'permission-call' => [
                'eyebrow' => 'Permission Marketing',
                'title' => 'Consent-based call leads',
                'lead' => 'consent verification call is not just about getting a checkbox. Customers must understand and agree to who is contacting them, for what purpose, and through which channels, and there must be records to prove the scope and timing of contact and withdrawal procedures.',
                'meta_description' => 'Design consent-based call lead collection, consent records, transfers, call operations and withdrawal procedures.',
                'hero_cta' => 'Discuss consent-based operations',
                'body' => [
                    'We design the collection, delivery, and call operation flow so that customers understand and agree to the purpose and subject of the consultation contact.',
                    'Consent does not allow unrestricted access to all contacts and relevant criteria must be checked together.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'Consent is not a phrase, it is the entire contact flow',
                        'paragraphs' => [
                            'If the consent received at landing is different from the actual caller and purpose, the customer may receive unexpected contact. It is difficult to respond to complaints if you cannot find the timing and wording of consent.',
                            'Collection screen, consent log, leads delivery, consultation script, opt-out and retention period must be designed as one operating system.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'Create a traceable flow from collection to withdrawal',
                        'items' => [
                            [
                                'title' => 'Definition of purpose/subject of contact',
                                'text' => 'First, decide who will contact you through what service and through what channel.',
                            ],
                            [
                                'title' => 'Consent screen and record design',
                                'text' => 'We record collection items, purpose, scope of provision and retention, and time of consent.',
                            ],
                            [
                                'title' => 'Delivery/consultation operation connection',
                                'text' => 'Communicate to responsible personnel within acceptable limits and manage scripts and contact status.',
                            ],
                            [
                                'title' => 'Withdrawal and response to complaints',
                                'text' => 'We have procedures in place to reflect unsubscribe and deletion requests and check related records.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Compliance Check',
                        'title' => 'Essential checklist for consent-based operations',
                        'items' => [
                            'Personal information collection items, purpose, retention period and contact person',
                            'Third-party disclosure or outsourced processing, and the explanation shown to customers',
                            'Records to confirm consent phrase, version, time, and inflow path',
                            'Refusal of receipt, withdrawal/deletion request, and complaint response procedures',
                        ],
                        'note' => 'The validity of consent and the legality of actual operations may vary depending on the specific business structure and laws, so final legal review is required.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'This is the structure needed for this type of organization.',
                        'items' => [
                            [
                                'title' => 'Organizations contacted by multiple agents',
                                'text' => 'When you need to consistently manage leads distribution, contact status, and reflection of opt-out.',
                            ],
                            [
                                'title' => 'Business of exchanging leads with external partners',
                                'text' => 'Cases where the provision/entrustment relationship and scope of responsibility need to be clarified.',
                            ],
                            [
                                'title' => 'Team that needs evidence to respond to complaints',
                                'text' => 'You want to create a system of record to quickly verify the wording and timing of consent.',
                            ],
                            [
                                'title' => 'When consent is viewed as a disclaimer',
                                'text' => 'This does not fit the idea that all contact is allowed with just one checkbox.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Does consultation consent allow calls at any time?',
                        'answer' => 'No. Operations must stay within the disclosed purpose, contacting party, channel and retention period, and honor withdrawal and opt-out requests.',
                    ],
                    [
                        'question' => 'Can we immediately use our existing leads?',
                        'answer' => 'Review the original consent wording, purpose, permitted disclosures and retention period first. Reconsider use if it does not fit the campaign purpose or the legal basis cannot be verified.',
                    ],
                    [
                        'question' => 'What should a consent record include?',
                        'answer' => 'It must allow the actual consent to be reconstructed, including wording and version, time, acquisition source and the customer’s selections. Exact requirements depend on legal review and the system.',
                    ],
                ],
                'cta' => [
                    'title' => 'Create a provable consent flow, not a checkbox',
                    'text' => 'Please let us know your current landing and leads delivery/call operation method and we will check the disconnected point.',
                    'label' => 'Discuss consent-based operations',
                ],
            ],
        ],
    ],
    'performance' => [
        'parent' => [
            'label' => 'Performance marketing',
            'route' => 'services.show',
            'param' => 'performance-marketing',
            'summary' => 'We connect conversion definitions, media operations, creative and measurement in one performance framework.',
        ],
        'items' => [
            'naver-gfa' => [
                'eyebrow' => 'Naver GFA',
                'title' => 'NAVER GFA advertising',
                'lead' => 'NAVER GFA is NAVER’s display ad platform. NAVER is Korea’s largest search portal. NAVER GFA is an advertisement that reaches audiences on various display surfaces of the NAVER service. J-Curve first determines the campaign purpose, conversion measurement, targeting, and creative hypothesis, and then adjusts the budget and creative by looking at the data.',
                'meta_description' => 'Connect NAVER GFA campaign goals, conversion measurement, audiences, creative tests and operating reports for your Korean marketing.',
                'hero_cta' => 'Request a GFA account review',
                'body' => [
                    'We operate NAVER GFA campaign goals, measurement, audience and material testing in one flow.',
                    'We do not guarantee any specific conversion rate or ad performance.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'Just because it gets a lot of exposure doesn\'t mean it\'s a good campaign.',
                        'paragraphs' => [
                            'If your campaign objectives and conversion events don\'t match, your advertising system will learn the wrong behavior. Even if you just narrow down your targeting or keep one or two materials for a long time, it\'s difficult to isolate the cause.',
                            'Operational data can be used to make decisions by first organizing what results you will see, which customers and messages you will test, and where they will churn.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Method',
                        'title' => 'A repeatable structure from goal to material improvement',
                        'items' => [
                            [
                                'title' => 'Define goals/transitions',
                                'text' => 'Determine actions and measurement points that are meaningful to your business, such as sales, consultations, and sign-ups.',
                            ],
                            [
                                'title' => 'Account/landing diagnosis',
                                'text' => 'Check the campaign structure, conversion tags, budget, and landing page bounce factors.',
                            ],
                            [
                                'title' => 'Audience/material testing',
                                'text' => 'Test your message and creative hypotheses by limiting the number of changes you make at a time.',
                            ],
                            [
                                'title' => 'Budget adjustments and reports',
                                'text' => 'Move your budget based on conversion quality and cost and record the reasons for your next test.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Operation Scope',
                        'title' => 'Items checked during operation',
                        'items' => [
                            'Are campaign goals aligned with actual business KPIs?',
                            'Measurable status of conversion tags, events and landing pages',
                            'Material hypothesis and test history by audience',
                            'Operational reports including cost as well as conversion quality',
                        ],
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Suitable for these advertisers',
                        'items' => [
                            [
                                'title' => 'Brands with conversion goals',
                                'text' => 'If you want to operate based on behavior such as consultation, subscription, or purchase rather than exposure.',
                            ],
                            [
                                'title' => 'Teams needing material testing',
                                'text' => 'If you want to repeatedly verify the message and visuals without choosing by feel.',
                            ],
                            [
                                'title' => 'Advertisers who can improve landing',
                                'text' => 'If you can fix issues not only on the medium but also on the conversion page.',
                            ],
                            [
                                'title' => 'If you only want guaranteed performance',
                                'text' => 'Media results vary depending on market, product, budget, and data, making it difficult to guarantee in advance.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Who owns the ad account?',
                        'answer' => 'Where possible, we recommend operating with shared access to an advertiser-owned account. This supports data continuity, asset ownership and transparent operating history.',
                    ],
                    [
                        'question' => 'Will GFA alone immediately increase revenue?',
                        'answer' => 'We cannot guarantee that. Product strength, the offer, landing page, budget and measurement all matter. An account review also checks bottlenecks outside the ad platform.',
                    ],
                    [
                        'question' => 'Is creative production included?',
                        'answer' => 'We agree on formats, quantities and filming or design requirements before deciding whether production is included in the operating scope. Reworking existing assets is also possible.',
                    ],
                ],
                'cta' => [
                    'title' => 'Start by checking the learning structure of your current GFA account.',
                    'text' => 'If you tell us your goals, budget, and account status, we will diagnose it from a measurement, campaign, and material perspective.',
                    'label' => 'Request a GFA account review',
                ],
            ],
            'facebook' => [
                'eyebrow' => 'Meta Advertising',
                'title' => 'Facebook & Instagram advertising',
                'lead' => 'Meta advertising doesn\'t end with just targeting settings. You need to co-design conversion events and funnels, creatives that speak to customers, and landing experiences, and manage test units to avoid losing training data.',
                'meta_description' => 'Connect Meta conversion measurement, funnels, audiences, creative tests and budget management for Facebook & Instagram ads.',
                'hero_cta' => 'Request a Meta ad review',
                'body' => [
                    'It is a meta advertising service that operates conversion measurement, audience, creative and landing page together.',
                    'We do not guarantee any specific ROAS or conversion results.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'Before changing your targeting, you need to see what you\'re learning',
                        'paragraphs' => [
                            'If you duplicate ad sets frequently and keep changing goals and events, your data becomes scattered. Conversely, if you keep the same material for a long time, it is difficult to distinguish between fatigue and messaging issues.',
                            'It is necessary to simplify the account structure, organize messages and conversion signals for each customer journey, and verify one hypothesis at a time.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Method',
                        'title' => 'Measurement and material move in the same cycle',
                        'items' => [
                            [
                                'title' => 'Define funnel/conversion events',
                                'text' => 'From awareness to purchase and consultation, we determine step-by-step actions and final KPIs.',
                            ],
                            [
                                'title' => 'Account/data diagnosis',
                                'text' => 'Check current measurement status, including pixels, campaign structure, and duplicate events.',
                            ],
                            [
                                'title' => 'Material hypothesis production',
                                'text' => 'We prepare testable material by sharing the customer\'s problem, evidence, suggestions and format.',
                            ],
                            [
                                'title' => 'Improved learning, budget, and landing',
                                'text' => 'We look at conversion quality, adjust budget and materials, and even address landing bottlenecks.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Deliverables',
                        'title' => 'Things to leave behind from operation',
                        'items' => [
                            'Campaign objectives and conversion event definitions',
                            'Account structure, measurement, and landing diagnosis results',
                            'Hypothesis, change history and learning content for each material',
                            'Report including reasons for budget moves and next tests',
                        ],
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'I fit well with this team.',
                        'items' => [
                            [
                                'title' => 'Brands that require material rotation',
                                'text' => 'If you want to test your message continuously rather than relying on one ad.',
                            ],
                            [
                                'title' => 'Advertisers with scattered conversion data',
                                'text' => 'When you want to reorganize your event and account structure to create decision-making criteria.',
                            ],
                            [
                                'title' => 'A team that can change the landing',
                                'text' => 'If the experience after clicking on an ad can also be improved.',
                            ],
                            [
                                'title' => 'If you want to set it once and leave it alone',
                                'text' => 'Meta ads may not be suitable because they require continuous management of materials and data learning.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Can we keep our existing ad account?',
                        'answer' => 'We assess the account and assets, then identify what to keep and improve. A new account is not always better; existing learning and operating history matter.',
                    ],
                    [
                        'question' => 'Can you set up the Conversions API?',
                        'answer' => 'We review the website, server environment and current measurement setup before agreeing on the integration scope. The same approach does not work in every environment.',
                    ],
                    [
                        'question' => 'Do you guarantee ROAS?',
                        'answer' => 'No. Product, price, brand, budget, market and landing experience affect results. We manage measurable hypotheses and the improvement process transparently.',
                    ],
                ],
                'cta' => [
                    'title' => 'Before creating more creatives, see what your account learns',
                    'text' => 'If you tell us your current account and conversion goals, we will diagnose structure, measurement, and creative together.',
                    'label' => 'Request a Meta ad review',
                ],
            ],
            'youtube' => [
                'eyebrow' => 'YouTube Marketing',
                'title' => 'YouTube marketing',
                'lead' => 'YouTube Marketing is not about uploading a lot of videos or buying views. Decide who will explain what problem to you and in what format, and divide the roles of advertisements and channel content to create a flow that leads to searches, visits, and inquiries after viewing.',
                'meta_description' => 'Connect YouTube channel goals, audiences, video planning and production, ad operations and conversion measurement.',
                'hero_cta' => 'Discuss your YouTube strategy',
                'body' => [
                    'We design post-view behavior by dividing the roles of video advertisements and channel content.',
                    'We do not guarantee views, subscribers or conversion results.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'There are videos, but there are many cases where there is no reason to watch them.',
                        'paragraphs' => [
                            'If you explain your brand story at length, viewers will leave early. Conversely, if there is only a strong hook and no follow-up action, even if the views remain, they will not lead to business results.',
                            'Short videos for advertising, searchable information content, and channel content that builds trust have different purposes. You need to first break down each role and measurement criteria.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'From goals to improvements for the next video',
                        'items' => [
                            [
                                'title' => 'Define channel/campaign goals',
                                'text' => 'Decide on the role the video will play among awareness, search traffic, inquiries, and purchases.',
                            ],
                            [
                                'title' => 'Audience/topic design',
                                'text' => 'Organize formats and content topics based on customer questions and search intent.',
                            ],
                            [
                                'title' => 'Hook, composition, production',
                                'text' => 'Create a script and video to connect the initial reason, text evidence, and next action.',
                            ],
                            [
                                'title' => 'Distribution, measurement, improvement',
                                'text' => 'We divide advertising and channel distribution and reflect viewer retention, click and conversion data in the next plan.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Scope',
                        'title' => 'What to organize in your project',
                        'items' => [
                            'Defining channel/advertising goals and core audiences',
                            'Content topic, format and role of each video',
                            'Required production scope, including script, filming, and editing',
                            'Metrics including retention, clicks and conversions',
                        ],
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Suitable for these brands',
                        'items' => [
                            [
                                'title' => 'Products and services where description is important',
                                'text' => 'When it is more effective to aid understanding with video than text and images.',
                            ],
                            [
                                'title' => 'Team seeking to accumulate expertise',
                                'text' => 'If you want to consistently create searchable content assets rather than a single viral piece.',
                            ],
                            [
                                'title' => 'Brands looking to connect advertising and channels',
                                'text' => 'If you want to drive paid reach and own channel growth by role.',
                            ],
                            [
                                'title' => 'If you only want guaranteed views',
                                'text' => 'We do not provide a method to confirm the number of views and subscriptions.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Can we start ads with existing videos?',
                        'answer' => 'Yes, after checking the campaign goal, opening message, aspect ratio and next action. We can discuss re-editing existing footage or producing new creative if needed.',
                    ],
                    [
                        'question' => 'Can you handle filming and editing?',
                        'answer' => 'We define planning, filming and editing after reviewing project goals, available assets, locations and the number of videos needed.',
                    ],
                    [
                        'question' => 'Do you guarantee views or subscriber growth?',
                        'answer' => 'No. Results depend on topic, content quality, channel history, distribution and market response. We improve using verifiable viewing, click and conversion data.',
                    ],
                ],
                'cta' => [
                    'title' => 'Before the next video, decide on the role of the video',
                    'text' => 'If you tell us your channel URL, goals, and videos you own, we will look at the content, advertising, and measurement structure together.',
                    'label' => 'Discuss your YouTube strategy',
                ],
            ],
        ],
    ],
    'boostingshop' => [
        'parent' => [
            'label' => 'BoostingShop',
            'route' => 'solutions.boostingshop',
            'param' => null,
            'summary' => 'Choose the marketing tasks you need before committing to full agency management.',
        ],
        'items' => [
            'basic' => [
                'eyebrow' => 'SEO Basic',
                'title' => 'SEO Basic — build a search foundation',
                'lead' => 'Basic is an introductory campaign for new and small sites to determine core search topics and priority pages and create the basis for index, page structure, and content. Rather than grabbing a bunch of keywords all at once, create a measurable starting point.',
                'meta_description' => 'SEO Basic builds the search foundation for new or small websites: search topics, indexing, core pages and content.',
                'hero_cta' => 'Discuss SEO Basic',
                'body' => [
                    'This is an introductory configuration for new and small sites to reorganize their search base and priority pages.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'Don\'t chase many keywords from the beginning',
                        'paragraphs' => [
                            'If your site is not read properly by search engines or your core service pages are not clear, it will be difficult to evaluate even if you increase your content.',
                            'Basic narrows down topics that are close to the business and establishes minimum standards for technology, pages, and content to lay the foundation for future work.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'From basic diagnosis to next priority',
                        'items' => [
                            [
                                'title' => 'Check site/search status',
                                'text' => 'Check the index, top pages, search traffic and underlying technical health.',
                            ],
                            [
                                'title' => 'Selection of key topics',
                                'text' => 'Narrow down the search intent closest to your business and decide on a target page first.',
                            ],
                            [
                                'title' => 'Page and content maintenance',
                                'text' => 'Align your titles, structure, internal links and key descriptions to basic standards.',
                            ],
                            [
                                'title' => 'Change history and next plans',
                                'text' => 'Record your reflections and suggest topics for future expansion and a sequence for improvement.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Scope',
                        'title' => 'Range checked at Basic',
                        'items' => [
                            'Search engine access/indexing and key page status',
                            'First, search topics and roles for each page.',
                            'Basic meta/body structure and internal links',
                            'Change history and next step recommendations',
                        ],
                        'note' => 'Specific keyword rankings and implementation timings are not guaranteed. Priority actions may vary depending on site conditions.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'If Basic is correct',
                        'items' => [
                            [
                                'title' => 'New site',
                                'text' => 'When you need to start with search operation criteria and key pages.',
                            ],
                            [
                                'title' => 'Small service site',
                                'text' => 'If you have limited topics and pages and want to keep your priorities clear.',
                            ],
                            [
                                'title' => 'Team new to SEO',
                                'text' => 'When you need diagnosis and implementation standards on what to change first.',
                            ],
                            [
                                'title' => 'When targeting multiple markets simultaneously',
                                'text' => 'If you have a lot of keywords and pages, the Pro or higher configuration may be more suitable.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Does Basic guarantee a number 1 search ranking?',
                        'answer' => 'We do not guarantee this. Basic is a configuration that overhauls the search base and core pages. Rankings depend on competition, content, site trust and search engine judgment.',
                    ],
                    [
                        'question' => 'Is the starting amount shown on the current page the final amount?',
                        'answer' => 'This is the starting point for existing guidance, and the actual scope is confirmed after confirming the site size, condition, and required work. Depending on the diagnostic results, different configurations may be recommended.',
                    ],
                    [
                        'question' => 'Can I start a new site right away?',
                        'answer' => 'It is possible. However, if there is little content and service information, you need to organize not only the technical settings but also the core page composition.',
                    ],
                ],
                'cta' => [
                    'title' => 'Build a minimal foundation to start your search',
                    'text' => 'If you tell us the site URL and core service, we will first check whether the Basic range is correct.',
                    'label' => 'Discuss SEO Basic',
                ],
            ],
            'pro' => [
                'eyebrow' => 'SEO Pro',
                'title' => 'SEO Pro — connect pages and topics',
                'lead' => 'Pro is an expandable campaign for sites with some core services and content to systematically grow multiple search topics and pages. Technical diagnostics, topic structure, content and internal linking are run through the same plan.',
                'meta_description' => 'SEO Pro connects multiple search topics and pages through technical SEO, content structure and internal links.',
                'hero_cta' => 'Discuss SEO Pro',
                'body' => [
                    'A configuration that expands multiple core pages and content into a single search topic structure.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Problem',
                        'title' => 'As the number of pages increases, the problem of competition arises.',
                        'paragraphs' => [
                            'If you keep publishing posts with similar keywords, it can become unclear which pages should show up in search results. Important service pages are sometimes isolated.',
                            'Professionals design page roles for each search intent and connect content and internal links by topic so that the entire site builds signals in one direction.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'Diagnosis, structure, content, and measurement in one cycle',
                        'items' => [
                            [
                                'title' => 'Technology/content inventory',
                                'text' => 'Check for indexing issues and duplication/omission of existing pages and content.',
                            ],
                            [
                                'title' => 'Topic/page map design',
                                'text' => 'Determine the role of representative pages and supporting content for each search intent.',
                            ],
                            [
                                'title' => 'First page improvement',
                                'text' => 'It reflects the body structure, internal links and any new content needed in order of execution.',
                            ],
                            [
                                'title' => 'Performance observation and relocation',
                                'text' => 'Determine next priorities by looking at search exposure, inflow, and conversion flow before and after the change.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Scope',
                        'title' => 'Key deliverables of a professional campaign',
                        'items' => [
                            'Technology, index, and existing content diagnosis results',
                            'Topic and page role maps by search intent',
                            'Priority page improvement plan and content execution list',
                            'Change history, observed metrics and next priorities',
                        ],
                        'note' => 'We do not guarantee the ranking of specific keywords or performance within the schedule, and the actual scope of execution is determined after site diagnosis.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'If the pro is right',
                        'items' => [
                            [
                                'title' => 'Site with multiple services',
                                'text' => 'When you need to reorganize search intent and priorities by page.',
                            ],
                            [
                                'title' => 'Site with accumulated content',
                                'text' => 'When you want to organize duplicate and isolated content and create a topic structure.',
                            ],
                            [
                                'title' => 'Companies with internal execution teams',
                                'text' => 'When proposed page/content improvements can be implemented and recorded together.',
                            ],
                            [
                                'title' => 'A site with no foundation at all',
                                'text' => 'It may be efficient to first clear the base with the Basic range.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'What is the biggest difference between Basic and Pro?',
                        'answer' => 'Basic focuses on creating core pages and a search base, while Pro expands the scope of operations by linking multiple pages and content into a topic structure.',
                    ],
                    [
                        'question' => 'Can I use existing blog posts as well?',
                        'answer' => 'It is possible. Check the search intent, duplication, and recency of existing articles and divide them into maintenance, integration, improvement, and organization targets. We don’t just increase new posts unconditionally.',
                    ],
                    [
                        'question' => 'Can you tell me when the ranking will go up?',
                        'answer' => 'The exact timing cannot be guaranteed. The search engine updates and competitive environment are different, so we observe the change history and exposure/inflow flow to determine the next action.',
                    ],
                ],
                'cta' => [
                    'title' => 'Connect scattered pages into one search asset',
                    'text' => 'If you tell us the site URL and the topic you are currently targeting, we will diagnose whether the pro configuration is correct.',
                    'label' => 'Discuss SEO Pro',
                ],
            ],
            'elite' => [
                'eyebrow' => 'SEO Elite',
                'title' => 'SEO Elite — integrated operations',
                'lead' => 'Elite is a scalable campaign that manages multiple highly competitive search topics and multiple pages together from a technical, content, and trust signal perspective. Focus on creating a system of cross-departmental execution, priorities and ongoing verification rather than one-off tasks.',
                'meta_description' => 'SEO Elite manages competitive search topics and multiple pages through technical SEO, content and trust signals.',
                'hero_cta' => 'Discuss SEO Elite',
                'body' => [
                    'It is a configuration that integrates and operates multiple pages and competing topics from the perspective of technology, content, and trust signals.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'High-competition SEO doesn’t end with one or two page edits',
                        'paragraphs' => [
                            'In markets where sites are large and competitors are constantly building content and links, technical issues, duplicate pages, brand trust and content production all impact each other.',
                            'Elite combines the execution of multiple teams into one roadmap and places important pages and tasks in stages to create a long-term operational system.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Process',
                        'title' => 'From enterprise diagnosis to repeatable operating system',
                        'items' => [
                            [
                                'title' => 'Complete site and market diagnosis',
                                'text' => 'We understand technology, information structure, content, competition and external signals together.',
                            ],
                            [
                                'title' => 'Priority roadmap',
                                'text' => 'Tasks and sequences for each department are determined based on impact and execution difficulty.',
                            ],
                            [
                                'title' => 'Page·content·trust execution',
                                'text' => 'Improve key pages, linking content clusters with the external signals you need.',
                            ],
                            [
                                'title' => 'Review/redesign',
                                'text' => 'Changes and market reactions are regularly reviewed to redeploy resources for the next cycle.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Scope',
                        'title' => 'Topics covered in Elite operations',
                        'items' => [
                            'Diagnosis of technology, index, and information structure of large-scale sites',
                            'Pages and content roadmap by business/search intent',
                            'Work standards and change history with internal execution and development teams',
                            'Report on competition/performance changes and next cycle priorities',
                        ],
                        'note' => 'We do not guarantee performance within a specific ranking or period for highly competitive keywords. Actual scope is confirmed by checking diagnostic and implementation capabilities.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Fit Check',
                        'title' => 'Organizations needing Elite',
                        'items' => [
                            [
                                'title' => 'Companies with many pages and business groups',
                                'text' => 'When the priorities of multiple services and categories need to be managed in an integrated manner.',
                            ],
                            [
                                'title' => 'Highly competitive market',
                                'text' => 'When you need to operate your content and trust assets over the long term, not just technical fixes.',
                            ],
                            [
                                'title' => 'Organization with a development and content execution team',
                                'text' => 'When cross-departmental challenges can be reflected and verified in practice.',
                            ],
                            [
                                'title' => 'If you only need short-term rankings',
                                'text' => 'Elite focuses on long-term operating systems and may be overkill for one-off requests.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Is Elite absolutely the best choice?',
                        'answer' => 'No. Suitable when site size, competition, and internal execution capacity are sufficient. For small sites or basic maintenance stages, Basic·Pro may be more efficient.',
                    ],
                    [
                        'question' => 'Does this include collaboration between development and content teams?',
                        'answer' => 'Collaborate by organizing diagnostic results into actionable tasks and aligning priorities with the responsible team. The actual scope of development and production is negotiated according to project conditions.',
                    ],
                    [
                        'question' => 'Are you guaranteed rankings for highly competitive keywords?',
                        'answer' => 'We do not guarantee this. Because we cannot control competitors\' activities, search engine changes, and site execution status, we transparently record changes and results and make improvements.',
                    ],
                ],
                'cta' => [
                    'title' => 'Make high-competition SEO an operating system rather than a personal instinct',
                    'text' => 'If you tell us the site size, business group, and internal execution environment, we will determine whether Elite configuration is necessary.',
                    'label' => 'Discuss SEO Elite',
                ],
            ],
            'instagram-popular' => [
                'eyebrow' => 'Instagram Discovery Guide',
                'title' => 'Instagram discovery strategy',
                'lead' => 'J-Curve does not sell or accept the location or period of specific popular posts or artificial responses. Improve content relevance, real customer response and explainable distribution paths, assuming the platform determines final exposure.',
                'meta_description' => 'Review Instagram content relevance, real audience responses, official ads and collaborations to improve discoverability without placement promises.',
                'hero_cta' => 'Discuss your discovery strategy',
                'body' => [
                    'Recommendation and search exposure are influenced by content, account, user response, and platform policy, and the location or retention period cannot be confirmed externally.',
                    'Products exposed through artificial reactions are not provided as public services.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'Popular posts are not advertising spaces that can be owned or pinned externally.',
                        'paragraphs' => [
                            'Instagram\'s recommendations and search screens continually change based on multiple signals, including content relevance, account status, and user-specific context and reactions. It cannot be said that J-Curve controls any particular location or retention period.',
                            'Therefore, rather than a single screen capture or temporary response numbers, we need to create a structure that leads customers to discover content and save, share, and visit profiles.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Discovery Options',
                        'title' => 'Explainable and measurable path to discovery',
                        'items' => [
                            [
                                'title' => 'Summary of topics and search context',
                                'text' => 'Match the expressions and content topics your customers are looking for to your account\'s area of expertise.',
                            ],
                            [
                                'title' => 'Improved content format',
                                'text' => 'Check the home screen, copy, image/video structure, and reasons for saving and sharing.',
                            ],
                            [
                                'title' => 'Utilize official advertising',
                                'text' => 'If your goals and budget are in line, we\'ll consider getting your content in front of the right audience through official advertising on the platform.',
                            ],
                            [
                                'title' => 'Collaboration and cross-flow',
                                'text' => 'Collaborating with brands and creators, connecting customer channels and websites to create inflows whose sources can be verified.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Measurement',
                        'title' => 'Metrics to check with exposure screen',
                        'items' => [
                            'Changes in Reach and Non-Follower Reach',
                            'Confirmable inflow paths such as search, recommendation, profile, etc.',
                            'Save, share, comment and profile visit behavior',
                            'Follow-up actions that are close to business, such as clicking links, making inquiries and making purchases.',
                        ],
                        'note' => 'Entry into popular posts, placement and duration are not guaranteed. Do not give an external provider your account password or two-factor authentication codes.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Policy Gate',
                        'title' => 'Criteria required before confirming it as a public service',
                        'items' => [
                            [
                                'title' => 'Description of operation method',
                                'text' => 'You must be able to clearly explain to customers the source of inflow and response and the actual performance.',
                            ],
                            [
                                'title' => 'Policy compliance',
                                'text' => 'You must have a basis for verifying compliance with the latest platform terms and community guidelines.',
                            ],
                            [
                                'title' => 'Minimize account access',
                                'text' => 'It must be possible to operate with only the minimum required privileges without a password or authentication code.',
                            ],
                            [
                                'title' => 'No guarantee of results',
                                'text' => 'Exposure locations, periods, and sales that cannot be controlled should not be sold as if they were confirmed results.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Are entry and retention periods for popular posts guaranteed?',
                        'answer' => 'We do not guarantee this. It cannot be said that J-Curve controls any specific location or time period, as the platform determines the final exposure.',
                    ],
                    [
                        'question' => 'Do you add artificial responses to popular posts?',
                        'answer' => 'No. We do not sell or accept artificial responses or exposure positions. We only look at ways to describe and measure the funnel, such as content, formal advertising and collaborations.',
                    ],
                    [
                        'question' => 'What discovery strategies can you advise on?',
                        'answer' => 'You can review ways to describe and measure your funnel, such as content topics and formats, official platform advertising, creator/brand collaborations, and connecting with existing customer channels.',
                    ],
                ],
                'cta' => [
                    'title' => 'Rather than buying exposure, create a reason to be discovered',
                    'text' => 'If you tell us your account URL, representative posts, and target actions, we will organize discovery paths to review during content, advertising, and collaboration.',
                    'label' => 'Discuss your discovery strategy',
                ],
            ],
            'instagram-followers' => [
                'eyebrow' => 'Instagram Growth Guide',
                'title' => 'Instagram follower growth guide',
                'lead' => 'J-Curve does not sell or accept artificial numbers of followers. We review explainable growth methods such as content, formal advertising, and collaboration based on platform policies, account safety, and actual customer contributions.',
                'meta_description' => 'Plan Instagram audience growth with content, profile optimization, official advertising and collaboration for real customer relationships.',
                'hero_cta' => 'Discuss audience growth',
                'body' => [
                    'Follower count and actual reach/engagement/inquiries are not the same metric. Determine how to grow based on account goals and customer behavior.',
                    'External quantity supply is not provided as a public service.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'Follower count and actual customer growth are not the same metric',
                        'paragraphs' => [
                            'As the number of followers increases, content saves, comments, clicks, inquiries, and sales do not increase at the same rate. You need to separate your account management goals from how you actually grow.',
                            'If the number of accounts whose origins and interests are unclear increases, the participation rate and customer interpretation may be distorted, even if the total number increases. Rather than looking at the growth numbers, you should look at who is following, why and what they do afterward.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Growth Options',
                        'title' => 'Describeable and measurable growth path',
                        'items' => [
                            [
                                'title' => 'Profile conversion overhaul',
                                'text' => 'The introduction, pinned posts, and links make it immediately clear who the account provides and what it provides.',
                            ],
                            [
                                'title' => 'Content series design',
                                'text' => 'Create repeatable chunks of topics and formats that give customers a reason to come back and follow you.',
                            ],
                            [
                                'title' => 'Utilize official advertising',
                                'text' => 'If your goals and budget are in line, we\'ll consider using official advertising on the platform to promote your content and account to the right users.',
                            ],
                            [
                                'title' => 'Collaboration and cross-flow',
                                'text' => 'Collaborate with brands and creators and connect existing customer channels and websites to create inflows whose sources can be verified.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Measurement',
                        'title' => 'Metrics to check along with number of followers',
                        'items' => [
                            'Ratio of reach and non-followers by content',
                            'Save, share, comment and profile visit behavior',
                            'Changes in follow conversions compared to profile visits',
                            'Follow-up actions that are close to business, such as clicking links, making inquiries and making purchases.',
                        ],
                        'note' => 'More followers do not guarantee reach, engagement or purchases. Do not give an external provider your account password or two-factor authentication codes.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Policy Gate',
                        'title' => 'Criteria required before confirming it as a public service',
                        'items' => [
                            [
                                'title' => 'Description of operation method',
                                'text' => 'You must be able to clearly explain your funnel and what you actually do to your customers.',
                            ],
                            [
                                'title' => 'Policy compliance',
                                'text' => 'You must have a basis for verifying compliance with the latest platform terms and community guidelines.',
                            ],
                            [
                                'title' => 'Minimize account access',
                                'text' => 'It must be possible to operate with only the minimum required privileges without a password or authentication code.',
                            ],
                            [
                                'title' => 'Separation of performance and interpretation',
                                'text' => 'Surface numbers should not be overstated by actual customers, sales or referral impressions.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Can I purchase the number of followers I want?',
                        'answer' => 'No. We do not sell or guarantee artificial follower quantities. We only look at ways to describe and measure the funnel, such as content, formal advertising and collaborations.',
                    ],
                    [
                        'question' => 'What growth methods can you advise on?',
                        'answer' => 'You can review ways to describe and measure your funnel, such as profile and content structure, official platform advertising, creator/brand collaborations, and linking to existing customer channels.',
                    ],
                    [
                        'question' => 'Will sales increase as followers increase?',
                        'answer' => 'Not guaranteed. Since the number of followers and actual interest/purchase intent may differ, you must check reach, saves/comments, profile visits, link clicks, and inquiries separately.',
                    ],
                ],
                'cta' => [
                    'title' => 'Rather than delivering numbers, create a path for actual customers to come in.',
                    'text' => 'Let us know your account URL, core customers, and target actions, and we will organize growth paths to consider among content, advertising, and collaboration.',
                    'label' => 'Discuss audience growth',
                ],
            ],
            'instagram-likes' => [
                'eyebrow' => 'Instagram Engagement Guide',
                'title' => 'Instagram engagement guide',
                'lead' => 'J-Curve does not sell or accept artificial amounts of likes. Based on platform policies, post/account safety, and actual customer contributions, we review explainable ways to increase participation such as content, official advertising, and collaboration.',
                'meta_description' => 'Use Instagram likes as one signal alongside saves, comments, inquiries and purchases, supported by content and official advertising.',
                'hero_cta' => 'Discuss meaningful engagement',
                'body' => [
                    'The number of likes and actual saves, shares, and inquiries are not the same indicator. Determine how to increase engagement based on the purpose of the post and customer behavior.',
                    'External quantity supply is not provided as a public service.',
                ],
                'sections' => [
                    [
                        'type' => 'prose',
                        'tone' => 'light',
                        'eyebrow' => 'Definition',
                        'title' => 'The number of likes and content performance must be viewed separately.',
                        'paragraphs' => [
                            'Likes are only one of the reactions shown on a post and do not replace saves, shares, comments, profile visits, inquiries or sales. Application purposes and performance judgment indicators must be separated.',
                            'Responses of unclear origin and interest can distort content learning and customer interpretation, even if the surface numbers are high. You need to find out why certain users reacted and what they did afterwards.',
                        ],
                    ],
                    [
                        'type' => 'steps',
                        'tone' => 'dark',
                        'eyebrow' => 'Engagement Options',
                        'title' => 'Explainable and measurable path to increased participation',
                        'items' => [
                            [
                                'title' => 'Define the purpose of your post',
                                'text' => 'First determine the key actions your content will create: awareness, saving, conversation, or profile visit.',
                            ],
                            [
                                'title' => 'Message/format improvements',
                                'text' => 'Check whether the home screen, copy, image/video structure, and call to action help customers respond.',
                            ],
                            [
                                'title' => 'Utilize official advertising',
                                'text' => 'If your goals and budget are in line, we\'ll consider getting your post in front of the right audience through official advertising on the platform.',
                            ],
                            [
                                'title' => 'Collaboration and cross-flow',
                                'text' => 'By collaborating with brands and creators, connecting customer channels and websites, we create responses that can verify the source.',
                            ],
                        ],
                    ],
                    [
                        'type' => 'checklist',
                        'tone' => 'parchment',
                        'eyebrow' => 'Measurement',
                        'title' => 'Metrics to check along with number of likes',
                        'items' => [
                            'Reach by post and non-follower reach ratio',
                            'Save, share, comment and profile visit behavior',
                            'Key behaviors for each format, such as retention and carousel navigation',
                            'Follow-up actions that are close to business, such as clicking links, making inquiries and making purchases.',
                        ],
                        'note' => 'More likes do not guarantee popular-post placement, saves, inquiries or revenue. Do not give an external provider your account password or two-factor authentication codes.',
                    ],
                    [
                        'type' => 'points',
                        'tone' => 'light',
                        'eyebrow' => 'Policy Gate',
                        'title' => 'Criteria required before confirming it as a public service',
                        'items' => [
                            [
                                'title' => 'Description of operation method',
                                'text' => 'You must be able to clearly explain to customers the flow of responses and what is actually being done.',
                            ],
                            [
                                'title' => 'Policy compliance',
                                'text' => 'You must have a basis for verifying compliance with the latest platform terms and community guidelines.',
                            ],
                            [
                                'title' => 'Minimize account access',
                                'text' => 'It must be possible to operate with only the minimum required privileges without a password or authentication code.',
                            ],
                            [
                                'title' => 'Separation of performance and interpretation',
                                'text' => 'Surface numbers should not be overstated by actual customers, sales or referral impressions.',
                            ],
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'question' => 'Can I purchase the number of likes I want?',
                        'answer' => 'No. We do not sell or guarantee artificial quantities of likes. We only look at ways to describe and measure the funnel, such as content, formal advertising and collaborations.',
                    ],
                    [
                        'question' => 'What ways to expand participation can you advise?',
                        'answer' => 'You can look at ways to describe and measure your funnel, such as content messaging and formats, official platform advertising, creator/brand collaborations, and connecting with existing customer channels.',
                    ],
                    [
                        'question' => 'If there are a lot of likes, does the exposure or sales of popular posts increase?',
                        'answer' => 'Not guaranteed. Platform exposure is determined by various signals, and the number of likes and actual interest/purchase intent may vary. You should check your saves, shares, profile visits, and inquiries together.',
                    ],
                ],
                'cta' => [
                    'title' => 'Create a structure that generates actual customer reactions rather than surface numbers.',
                    'text' => 'If you tell us your account URL, representative posts, and target actions, we will organize a path to expand participation to consider among content, advertising, and collaboration.',
                    'label' => 'Discuss meaningful engagement',
                ],
            ],
        ],
    ],
];
