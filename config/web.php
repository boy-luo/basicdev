<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'IccUDWiqQiOjWnkDmqegUZgmbpSkpP7k',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],

        // todo: Yii 提供了两套授权管理器： yii\rbac\PhpManager 和 yii\rbac\DbManager。前者使用 PHP 脚本存放授权数据， 而后者使用数据库存放授权数据。
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
//        'urlManager' => [
////            'enablePrettyUrl' => true,
////            'showScriptName' => false,
////            'enableStrictParsing' => true,
//            'suffix' => '.html',
//            // 上面的配置允许URL管理器识别或生成带 .html 后缀的 URL
        // Note：当你配置 URL 后缀时，如果请求的 URL 没有此后缀，系统将认为此 URL 无法识别。 这是 SEO（搜索引擎优化）的最佳实践。
        // Tip：你可以设置URL后缀为 / 让所有的 URL 以斜线结束。
////            'rules' => [
////                // ...
////            ],
//        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */

        // 使用函数注册"search" 组件
//        'search' => function () {
//            return new app\components\SolrService;
//        },
    ],
    'params' => $params,
//    'catchAll' => ['site/offline'],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'] // 按需调整这里
    ];
}

return $config;
