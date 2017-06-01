<?php 

return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../resources/views/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'lmtest',
            'path' => __DIR__ . '/../storage/logs/app-' . date('Y-m-d') . '.log',
            'level' => \Monolog\Logger::INFO,
        ],
        'database' => [
        	'database_type' => 'mysql',
		    'database_name' => 'test',
		    'server' 		=> '127.0.0.1',
		    'username' 		=> 'root', 
		    'password' 		=> 'tjw199022', 
		    'charset' 		=> 'utf8mb4'
        ]
    ],
];