<?php

$config = require(__DIR__ . '/common.php');

$config = \yii\helpers\ArrayHelper::merge($config, [
    'modules'    => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
            'basePath' => '@app/modules/v1',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'POST v1/user' => 'v1/user/create',
                'GET v1/user/<id:\d+>' => 'v1/user/view',
                'PUT v1/user/<id:\d+>' => 'v1/user/update',
                'DELETE v1/user/<id:\d+>' => 'v1/user/delete',
            ],
        ],
        'request' => [
            'cookieValidationKey' => getenv('APP_COOKIE_VALIDATION_KEY'),
        ],
        'response' => [
            'format' =>  \yii\web\Response::FORMAT_JSON
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
    ],
]);

if (getenv('YII_DEBUG')) {
    $config['bootstrap'][] = 'debug';
    $config['components']['log'] = [
        'traceLevel' => 3,
    ];
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;