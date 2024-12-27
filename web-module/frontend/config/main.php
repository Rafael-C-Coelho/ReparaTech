<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'client/index' => 'client/index',
                'repair/index' => 'repair/index',
                'order/index' => 'order/index',
                'site/painelClient' => 'site/painel-client',
                'site/softwareIssue' => 'site/software-issue',
                'site/checkout' => 'site/checkout',
                'site/hardwareCleaningMaintenance' => 'site/hardware-cleaning-maintenance',
                'site/dataRecovery' => 'site/data-recovery',
                'site/networkIssue' => 'site/network-issue',
                'site/damageButton' => 'site/damage-button',
                'site/batteryIssue' => 'site/battery-issue',
                'site/storageIssue' => 'site/storage-issue',
                'site/cameraIssue' => 'site/camera-issue',
                'site/liquidDamage' => 'site/liquid-damage',
                'site/connectivityIssue' => 'site/connectivity-issue',
                'site/brokenScreen' => 'site/broken-screen',
                'site/audioIssue' => 'site/audio-issue',
                'site/allRepairCategories' => 'site/all-repair-categories',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/product',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/dashboard',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET latest' => 'latest',
                        'GET mostSold' => 'mostSold',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST register' => 'register',
                        'POST requestPasswordReset' => 'requestPasswordReset',
                        'GET profile' => 'profile',
                        'PATCH updateProfile' => 'updateProfile',
                        'POST refreshToken' => 'refreshToken',
                        'POST logout' => 'logout',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/repair',
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET {id}/device' => 'device',
                        'GET {id}/hours-spent-working' => 'hours-spent-working',
                        'GET {id}/description' => 'description',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/budget',
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET {id}/value' => 'value',
                        'GET count' => 'count',
                        'GET {id}/status' => 'status',
                        'GET {id}/description' => 'description',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\ModuleAPI',
        ],
    ],
    'layout' => '@frontend/views/layouts/main.php',
    'params' => $params,
];
