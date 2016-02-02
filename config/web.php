<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
	'name'=>'Percobaan',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [    		
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'kw3LTNUf_YOF58EWKcncpOJ6aokovTxO',
        	//json restful ws        	
        	'parsers' => [
        			'application/json' => 'yii\web\JsonParser',
        	],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    	/*	
    	'view' => [
    			'theme' => [
    					'pathMap' => [
    							'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
    					],
    			],
    	],*/ 
    	//custom theme
    	
    	'view' => [
    			'theme' => [
    					'pathMap' => ['@app/views' => '@app/themes/kxtheme'],
    					'baseUrl' => '@web/../themes/kxtheme',
    					],
    	],
    		
    	'urlManager' => [
   				'enablePrettyUrl' => true,
   				'enableStrictParsing' => true,
   				'showScriptName' => false,
   				'rules' => [
	   						'/' => 'site/index',
    						['class' => 
    								'yii\rest\UrlRule', 
    								'controller' => 'barang-ws',
    								'extraPatterns' => [
    										'GET lihat' => 'lihat',
    								],    								
    						],
   						
	   						'<controller:\w+>/<id:\d+>' => '<controller>/view',
   							'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
   							'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
   				],
   		],    		
    ],
	'modules' => [
			'gridview' =>  [
					'class' => '\kartik\grid\Module'
			]
	],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
