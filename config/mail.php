<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
    'port' => env('MAIL_PORT', 2525),
    "from" => array(
      "address" => "from@example.com",
      "name" => "Example"
    ),
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
     "username" => "6d718dadeb6b00",
    "password" => "b6d791e9c3b260",
    "sendmail" => "/usr/sbin/sendmail -bs",
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
    'log_channel' => env('MAIL_LOG_CHANNEL'),
];
