<?php

use kaabar\jwt\JwtHttpBearerAuth;

return [
    'id' => 'repara-tech',
    'name' => 'Repara Tech',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use PhpManager for file-based storage
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'] // TODO: restrict this
        ],
    ],
];
