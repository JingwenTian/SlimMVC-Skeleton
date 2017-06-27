<?php 

return [
    'settings' => [
        'displayErrorDetails' => env('APP_DEBUG'), // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true, // // Only set this if you need access to route within middleware
        // Renderer settings
        'renderer' => [
            'locale_default' => 'zh_HK', // default lang
            'template_path' => __DIR__ . '/../resources/views/',
            'translations_path' => __DIR__ . '/../resources/translations/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'SLIM',
            'path' => __DIR__ . '/../storage/logs/app-' . date('Y-m-d') . '.log',
            'level' => \Monolog\Logger::INFO,
        ],
        // Mysql settings
        'database' => [
        	'database_type' => 'mysql',
		    'database_name' => 'dbname',
		    'server' 		=> '127.0.0.1',
		    'username' 		=> 'username', 
		    'password' 		=> 'password', 
		    'charset' 		=> 'utf8mb4'
        ],
        // Cache settings
        'cache' => [
            'scheme'        => 'tcp',
            'host'          => '127.0.0.1',
            'port'          => 6379,
            'database'      => 1,
            //'password'      => '',
        ],
        // Qiniu Storage settings
        'upload'    => [
            'driver'    => env('UPLOAD_DRIVER'),
            'drivers'   => [
                'qiniu' => [
                    'domain'        => env('QINIU_DOMAIN'),
                    'access_key'    => env('QINIU_ACCESS_KEY'),
                    'secret_key'    => env('QINIU_SECRET_KEY'),
                    'bucket'        => env('QINIU_BUCKET'),
                    'timeout'       => env('QINIU_TIMEOUT'),
                ]
            ]
        ],
        'session' => [
            'gc_maxlifetime'   => 3600,
        ],
        // Authentication settings
        'httpBasicAuthentication' => [
            "secure"        => false, // 是否开启安全模式: 验证 https和 IP
            "relaxed"       => [], // IP白名单
            "users"         => ['admin' => 'admin'], // 用户名密码
            "path"          => ["/admin"], // 需要鉴权的路径
            "passthrough"   => ["/admin/login"], // 无需鉴权的路径
        ],
        "jwtAuthentication"   => [
            "secure"        => false, // 是否开启安全模式: 验证 https和 IP
            "relaxed"       => [], // IP白名单
            "cookie"        => "token", // 用于鉴权的 token的 cookie 名称
            "secret"        => 'eba7aa43d165fc6bf49c0549a8a55d35', // jwt 秘钥
            "path"          => ["/api"], // 需要鉴权的路径
            "passthrough"   => ["/api/auth"], // 无需鉴权的路径
            "expires"       => "24 hours", // 凭证有效期
        ],
    ],
];
