<?php

return [
    'connections_enabled' => env('RANKFREE_CONNECTIONS_ENABLED', false),
    'enabled' => env('RANKFREE_API_ENABLED', false),
    'submission_enabled' => env('RANKFREE_ORDER_SUBMISSION_ENABLED', false),

    // Operator-reviewed product ID => customer field keys. Empty means no approved products.
    'product_fields' => [],
];
