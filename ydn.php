<?php

return [
    // sandbox account or production account
    'api_account_id'       => env('YDN_TECHLOCO_API_ACCOUNT_ID'),
    'api_account_password' => env('YDN_TECHLOCO_API_ACCOUNT_PASSWORD'),
    'techloco_license'     => env('YDN_TECHLOCO_LICENSE'),
    
    // sandbox or production
    'env'                  => env('YDN_ENV'),
    'api_version'          => env('YDN_API_VERSION'),
    'service_path'         => env('YDN_API_SERVICE_PATH'),
    'services'             => [
        'AccountAdProductService' => [
            'method'          => 'get',
            'service_name'    => 'AccountAdProductService',
            'xml_header_name' => 'RequestHeader',
            'namespace'       => 'http://im.yahooapis.jp',
        ],
    ],
];