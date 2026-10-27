<?php

return [
    'enabled' => env('RANKFREE_API_ENABLED', false),
    'api_key' => env('RANKFREE_API_KEY'),
    'submission_enabled' => env('RANKFREE_ORDER_SUBMISSION_ENABLED', false),

    // Operator-reviewed product ID => customer field keys. Empty means no approved products.
    'product_fields' => [],
];
