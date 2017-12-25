<?php

define('OK', 0);
define('EXCEPTION', 2);
define('NETWORK_ERROR', 3);

define('STATUS',[
    'ok' => [
        'code' => OK,
    ],
    'exception' => [
        'code' => EXCEPTION,
    ],
    'network_error' => [
        'code' => NETWORK_ERROR,
    ],
]);

return new \Phalcon\Config([
    'version' => '1.0',
    'appName' => $appName,

    'application' => [
        'providersDir' => APP_PATH . '/providers/',
    ],

    'logger' => [
        'adapter' => 'file',
        'name'    => LOG_PATH . '/' . $appName . '_info_' . date('Ymd') . '.log',
    ],

    'smsProviderName' => getenv('SMS_PROVIDER_NAME'),
    'smsProviders' => [
        'netease' => [
            'appKey' => getenv('NETEASE_ACCESS_KEY'),
            'appSecret' => getenv('NETEASE_ACCESS_SECRET'),
            'templates' => [
                'vcode' => [
                    'id' => '3139031',
                    'api' => getenv('NETEASE_VCODE_API'),
                    'signName' => getenv('SMS_SIGN_NAME'),
                    'vcodeSize' => getenv('SMS_VCODELEN'),
                ],
            ],
            'class' => Sms\Providers\Netease::class,
        ],

        'alidayu' => [
            'appKey' => getenv('ALIDAYU_ACCESS_KEY'),
            'appSecret' => getenv('ALIDAYU_ACCESS_SECRET'),
            'templates' => [
                'vcode' => [
                    'id' => 'SMS_109495212',
                    'api' => getenv('ALIDAYU_SMS_API'),
                    'signName' => getenv('SMS_SIGN_NAME'),
                    'vcodeSize' => getenv('SMS_VCODELEN'),
                ]
            ],
            'class' => Sms\Providers\Alidayu::class,
        ],
    ],

]);

