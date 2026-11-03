<?php

/*
| 일본어 홈 문구 (Claude, 2026-11-03). 대상 = 한국 시장에 진출하려는 일본 기업.
| 사실·숫자는 한국어 홈 그대로. 용어는 docs/intl/GLOSSARY.md. 영어판(lang/en/pages/home.php)과 키 구조가 같다.
*/

return [
    'title' => '韓国のデジタルマーケティング代理店 | J-Curve Interactive',
    'description' => 'J-Curve Interactiveは、韓国市場で成長したい企業のために、パフォーマンス広告、CPA、SEO・AI検索最適化、NAVER・Coupang・カカオのマーケティングを運用します。2026年時点で累計広告運用額373億ウォン以上、キャンペーン15,700件以上。',

    'hero' => [
        'badge' => 'パフォーマンス · CPA · SEO · リワード広告ネットワーク',
        'h1' => '韓国での売上パートナー',
        'brand' => 'J-Curve Interactive',
        'lead' => '成果型広告から検索・AI回答の最適化、自社開発のデータツールまで。数字で語るソウルの総合デジタルマーケティング代理店です。',
        'cta_primary' => 'ご相談はこちら',
        'cta_secondary' => 'サービスを見る',
        'tabs_label' => 'ファーストビューの切り替え',
        'tab_numbers' => '数字で証明',
        'tab_start' => 'すぐに始める',
        'numbers_title' => '約束ではなく、数字で証明します',
        'numbers_meta' => '2026年時点の累計',
        'start_title' => '貴社に合った始め方を',
    ],

    'hero_proof' => [
        ['128万件+', '累計リード獲得数', 600],
        ['15,700件+', 'キャンペーン実施数', 900],
        ['373億ウォン+', '累計広告運用額', 1200],
    ],

    'doors' => [
        ['megaphone', '任せる', 'マーケティングサービス', 'パフォーマンス・CPA・SEO・リワード広告を当社が運用します。', 'services.index'],
        ['self', '自分で注文する', 'セルフマーケティング', 'NAVERプレイス・ショッピングの順位上昇キャンペーンを直接注文できます。', 'self-marketing'],
        ['store', '自社サービスを使う', '自社運営サービス', 'RankFree · BoostingShop · ShopiTrend · LeadBay · Call2Sale', 'solutions.index'],
    ],

    'korea' => [
        'label' => 'WHY A LOCAL PARTNER',
        'h2' => '韓国には、韓国のプラットフォームがあります',
        'text' => '韓国の消費者はNAVERで検索し、CoupangやNAVERショッピングで買い物をし、カカオトークで会話します。グローバルの施策だけでは届きません。当社はこれらのプラットフォームとGoogle・YouTube・Metaで、キャンペーンを設計・運用します。',
        'items' => [
            ['seo', 'NAVER', '韓国最大の検索ポータル。検索結果、ブログ、地図（NAVERプレイス）、NAVERショッピングまで。'],
            ['coupang', 'Coupang（クーパン）', '韓国最大のECモール。独自の検索順位があります。'],
            ['gift', 'カカオトーク', '韓国で最も使われるメッセンジャー。その中のギフトストアがカカオギフトです。'],
            ['performance', 'Google · YouTube · Meta', 'グローバルチャネルも、同じ韓国での売上KPIで運用します。'],
        ],
    ],

    'biz' => [
        'h2' => '任せる、自分で注文する、自社サービスを使う',
        'text' => 'J-Curve Interactiveは、マーケティング代行、セルフマーケティング、自社サービスの運営をひとつの会社で行っています。貴社に合った方法でお始めください。',
        'kicker' => '任せる',
        'col_title' => 'マーケティングサービス',
        'more' => '詳しく見る',
        'consult' => 'ご相談',
        'close' => '詳細を閉じる',
        'all' => 'サービス一覧',
        'self_kicker' => '自分で注文する',
        'self_title' => 'セルフマーケティング',
        'self_text' => 'NAVERプレイス・ショッピングの順位上昇キャンペーンを選んで注文できます。店舗や商品をお知らせいただければ、設定からご案内します。',
        'self_cta' => 'セルフマーケティングについて',
        'ops_kicker' => '自社サービスを使う',
        'ops_title' => '自社運営サービス',
        'ops_all' => '自社運営サービス一覧',
    ],

    'services' => [
        ['performance', 'パフォーマンスマーケティング', 'コンバージョン基準の媒体運用', '広告マーケティング', '広告費の成績表は、売上で受け取ります',
            '媒体の数字ではなく、売上・有効リード・会員登録など、合意したビジネスKPIを基準に広告を運用します。',
            'services.show', ['slug' => 'performance-marketing'], 'performance'],
        ['cpa', 'CPAマーケティング', '有効アクション単位の運用', '広告マーケティング', '有効アクション基準の成果型広告',
            'インストール・会員登録・購入・相談申込など、事前に合意した有効アクションを基準に運用します。トラッキングと精算の仕組みまで設計します。',
            'services.show', ['slug' => 'cpa-marketing'], 'cpa'],
        ['reward', 'リワード広告ネットワーク', '広告主のアクション × アプリの収益化', '広告マーケティング', '広告主のアクションとアプリの収益化をつなぎます',
            '目標アクションを設計する広告主キャンペーンから、オファーウォール・リワード枠を運営するアプリ媒体との提携まで、ひとつの流れでつなぎます。',
            'services.show', ['slug' => 'reward-network'], 'reward'],
        ['seo', 'SEO · AEO · GEO', '検索・AI回答での露出', '検索マーケティング', '検索とAI回答で見つけてもらえる構造',
            'Google・NAVERの検索最適化からAEO・GEOまで。クロール・インデックス・コンテンツ・エンティティ・信頼の根拠と、コンバージョンまでの導線をあわせて整えます。',
            'services.show', ['slug' => 'seo'], 'seo'],
        ['place', 'プレイス・ショッピング', 'NAVER・Coupang・カカオの上位表示', '検索マーケティング', '発見から来店・購入まで',
            'NAVERプレイス・NAVERショッピング・Coupang・カカオギフトで、検索意図と店舗・商品情報、コンバージョン導線をあわせて整えます。',
            'services.seo.sub', ['sub' => 'naver-place'], 'place'],
        ['backlink', '被リンク', '検索のための信頼シグナル設計', '検索マーケティング', '検索のための信頼シグナルを設計します',
            'ページ診断から、リンク元の文脈、アンカーテキスト、リンク状態の点検まで段階的に管理します。',
            'services.seo.sub', ['sub' => 'backlinks'], null],
        ['wordpress', 'WordPress制作・運用', '検索に強いサイト', '制作・支援', '検索とマーケティングを考えたWebサイト',
            'デザインだけでなく、検索・広告・コンテンツ運用とコンバージョン計測まで考えて制作・運用します。',
            'services.show', ['slug' => 'wordpress'], null],
        ['support', '中小企業マーケティング支援事業', '公募・実行・証憑の支援', '制作・支援', '韓国政府の中小企業マーケティング支援事業の実行支援',
            '公募・業務・証憑の基準を確認し、広告、SEO、コンテンツ、動画、Web制作の実行と成果資料の準備を支援します。選定および支援金の支給は保証しません。',
            'services.marketing-support', [], null],
    ],

    'subs' => [
        'performance' => [
            ['Google広告', 'google-ads'],
            ['NAVER GFA', 'services.performance.sub', ['sub' => 'naver-gfa']],
            ['Facebook・Instagram', 'services.performance.sub', ['sub' => 'facebook']],
            ['YouTube', 'services.performance.sub', ['sub' => 'youtube']],
        ],
        'cpa' => [
            ['不動産分譲', 'services.cpa.sub', ['sub' => 'real-estate']],
            ['株式投資リード', 'services.cpa.sub', ['sub' => 'stock']],
            ['保険リード', 'services.cpa.sub', ['sub' => 'insurance']],
            ['暗号資産投資リード', 'services.cpa.sub', ['sub' => 'coin']],
            ['同意取得済みコールリード', 'services.cpa.sub', ['sub' => 'permission-call']],
        ],
        'reward' => [
            ['広告主キャンペーン', 'services.show', ['slug' => 'reward-network'], '#advertisers'],
            ['アプリ媒体との提携', 'services.show', ['slug' => 'reward-network'], '#publishers'],
        ],
        'seo' => [
            ['SEO', 'services.show', ['slug' => 'seo']],
            ['AEO（アンサーエンジン最適化）', 'services.seo.aeo', []],
            ['GEO（生成AI検索最適化）', 'services.seo.geo', []],
        ],
        'place' => [
            ['NAVERプレイス', 'services.seo.sub', ['sub' => 'naver-place']],
            ['NAVERショッピング', 'services.seo.sub', ['sub' => 'naver-shopping']],
            ['Coupang', 'services.seo.sub', ['sub' => 'coupang']],
            ['カカオギフト', 'services.seo.sub', ['sub' => 'kakao-gift']],
        ],
    ],

    'trust' => [
        'h2' => 'キャンペーンを運用したブランド',
        'brands' => ['Netflix', 'LG U+', '現代海上火災保険', 'Yanolja', 'Hamsoa', 'Daemyung Resort', 'Lami Cosmetics', '1300K', 'Yoogane'],
        'proof' => '2026年時点 累計広告運用額373億ウォン · キャンペーン15,700件',
    ],

    'stats' => [
        'label' => 'BY THE NUMBERS',
        'h2' => 'まず、数字がお話しします',
        'text' => '勘ではなく、累計データで証明します。2026年時点。',
        'items' => [
            ['373億ウォン+', '累計広告運用額', '実際のメディア出稿額'],
            ['128万件+', '累計リード獲得数', '成果型・リードキャンペーンの合計'],
            ['15,700件+', 'キャンペーン実施数', '累計実施件数'],
        ],
    ],

    'layers' => [
        'h2' => '媒体から契約まで、5つの層を自社で運営しています',
        'text' => 'ひとつの層だけを担う会社は、別の層で起きた問題を説明できません。J-Curveはアプリ、ネットワーク、露出、コンバージョン、セールスのすべてを自社で運営しています。',
        'items' => [
            ['1', '媒体', 'ユーザーが毎日使うアプリ', 'Kkokko Farm、Saim Cashなどの自社リワードアプリ', '自社アプリを見る', '#apps', 'apps'],
            ['2', 'ネットワーク', '広告主のミッションを媒体へ', 'リワード広告ネットワーク、オファーウォール', 'リワード広告ネットワーク', 'reward', 'network'],
            ['3', '露出', '検索・AI・プラットフォームで見つけてもらう', 'SEO・AEO・GEO、セルフマーケティング、RankFree', 'セルフマーケティング', 'self-marketing', 'seo'],
            ['4', 'コンバージョン', '広告費をお問い合わせと購入に', 'パフォーマンスマーケティング、CPAマーケティング', '広告サービス', 'services.index', 'performance'],
            ['5', 'セールス', '獲得したリードを契約に', 'LeadBay、Call2Sale', '自社運営サービス', 'solutions.index', 'users'],
        ],
    ],

    'products' => [
        'label' => 'OUR PRODUCTS',
        'h2' => 'ツールまで自社で開発しています',
        'text' => '他社のツールを借りることはしません。マーケティングデータから保険営業向けのセールスCRMまで、現場に必要なツールを自社で開発・運営しています。',
        'more' => '詳しく →',
        'items' => [
            ['RankFree（ランクフリー）', 'NAVERの順位・市場分析', 'solutions.rankfree', 'rankfree'],
            ['BoostingShop（ブースティングショップ）', '自分で運用するセルフマーケティング', 'solutions.boostingshop', 'boostingshop'],
            ['ShopiTrend（ショピトレンド）', 'ShopiTrendマーケティングプラットフォーム', 'solutions.shopitrend', 'shopitrend'],
            ['LeadBay（リードベイ）', '保険営業組織向けセールスCRM', 'solutions.leadbay', 'leadbay'],
            ['Call2Sale（コールトゥセール）', '保険リード向けコールセンターCRM', 'solutions.call2sale', 'call2sale'],
        ],
    ],

    'apps' => [
        'h2' => 'いま運営しているリワードアプリ',
        'text' => '自社で企画・開発し、ストアで運営しているアプリです。広告主のミッションはこれらのアプリの中で実行されます。',
        'prev' => '前のアプリ',
        'next' => '次のアプリ',
        'alt' => ':nameのアプリ画面',
        'items' => [
            ['eggfarm-1', 'Kkokko Farm', 'ニワトリを育てて、モバイルギフト券や現金がもらえるポイ活アプリ'],
            ['carrotcash-1', 'Danggeun Cash', 'ニンジンを育てて、モバイルギフト券や現金がもらえるアプリ'],
            ['pigcash-1', 'Kkulkkul Cash', '食事を記録して、モバイルギフト券や現金がもらえるポイ活アプリ'],
            ['cashpang-1', 'Cash Pangpang', '英単語を勉強して、モバイルギフト券や現金がもらえるポイ活アプリ'],
            ['stamptech-1', 'Kkuk Tech', '毎日韓国語を勉強して、モバイルギフト券や現金がもらえるポイ活アプリ'],
            ['moneytree-1', 'Money Tree', '木を育てて、モバイルギフト券や現金がもらえるアプリ'],
        ],
    ],

    'split' => [
        'aria' => '広告主とアプリ媒体',
        'adv_label' => '広告主・ブランド',
        'adv_h2' => '目標アクション単位で運用するリワード広告',
        'adv_text' => 'インストールで終わらず、会員登録、ミッション完了、相談申込、購入まで、必要な深さのアクションを選べます。承認基準は出稿前に書面で合わせ、運用中も同じ基準で確認します。',
        'adv_chips' => ['アプリインストール', '会員登録', 'ミッション完了', '相談申込', '購入'],
        'adv_cta' => 'キャンペーンを相談する',
        'pub_label' => 'アプリ媒体',
        'pub_h2' => '貴社アプリの利用の流れに合わせたオファーウォール収益化',
        'pub_text' => 'サービスの性格に合う接点を選び、ユーザー体験と収益運営をあわせて設計します。媒体の検討から連携、運用の安定化までご一緒します。',
        'pub_chips' => ['オファーウォール導入', 'ユーザー体験設計', '収益運営', '精算基準'],
        'pub_cta' => '媒体提携のお問い合わせ',
    ],

    'insights' => [
        'label' => 'INSIGHTS',
        'h2' => 'マーケティングを、学び続けています',
        'text' => '現場で検証したことだけを記事にしています。',
        'all' => 'インサイト一覧 →',
    ],

    'cta' => [
        'h2' => '韓国での成長をお考えですか？',
        'text' => 'いまのマーケティングの状況をお聞かせください。改善できるポイントからご提案します。',
        'phone' => '電話',
        'email' => 'メール',
        'primary' => 'ご相談はこちら',
        'secondary' => 'サービスを見る',
    ],
];
