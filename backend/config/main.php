<?php

use backend\components\TestComponent;
use yii\bootstrap5\BootstrapAsset;
use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
             // enter optional module parameters below - only if you need to  
             // use your own export download action or custom translation 
             // message source
             // 'downloadAction' => 'gridview/export/download',
             // 'i18n' => []
         ]
     ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers'=>[ //to send json data in api
                'application/json'=>JsonParser::class,
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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

        'assetManager'=>[
            'bundles'=>[
                BootstrapAsset::class=>false,
            ]
        ],

        'test'=>[ //add new component
            'class'=>TestComponent::class,
            
        ],
        
        'urlManager' => [

            'enablePrettyUrl'       => true,

            'showScriptName'        => false,

          //  'enableStrictParsing'   => false,

            'rules' => [

                ['class'=>UrlRule::class,'controller'=>['product-api','api/user','api/user-address']],
                [
                    'pattern'=>'user/<userid:\d+>/address',
                    'route'=>'api/user-address/index',
                ]

            ],

        ],
            
    ],
    'params' => $params,
];
