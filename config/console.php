<?php

$config = require(__DIR__ . '/common.php');

$config = \yii\helpers\ArrayHelper::merge($config, [
    'id' => getenv('APP_NAME') . '-console',
    'controllerNamespace' => 'app\commands',
]);

return $config;