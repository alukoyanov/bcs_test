<?php

Yii::setAlias('@app', dirname(__DIR__));

$config = [
    'id'         => getenv('APP_NAME'),
    'name'       => getenv('APP_TITLE'),
    'basePath'   => '@app',
    'language'   => 'ru-RU',
    'components' => [
        'db' => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => 'mysql:host=' . getenv('MYSQL_VHOST') . ';dbname=' . getenv('MYSQL_DATABASE'),
            'username'            => getenv('MYSQL_USER'),
            'password'            => getenv('MYSQL_PASSWORD'),
            'charset'             => 'utf8',
            'enableSchemaCache'   => true,
            'schemaCacheDuration' => 300,
            'masterConfig'        => [
                'attributes' => [
                    PDO::ATTR_TIMEOUT => 60,
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

return $config;