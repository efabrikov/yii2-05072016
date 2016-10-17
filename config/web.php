<?php
$params = require(__DIR__ . '/params.php');

$config = [
    'id'             => 'basic',
    'basePath'       => dirname(__DIR__),
    'bootstrap'      => ['log'],
    'components'     => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'B421jn6KNumvtPOLT9CP3OduGbyfqsjW',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'on afterAction' => function ($event) {
                /*echo '<br><br><br>event';
            \yii\helpers\VarDumper::dump($_COOKIE, 11, 1);
            @\yii\helpers\VarDumper::dump($_SESSION, 11, 1);
            @\yii\helpers\VarDumper::dump(Yii::$app->session->id, 11, 1);
            @\yii\helpers\VarDumper::dump(Yii::$app->request->cookies, 11, 1);*/
    /*if (302 == Yii::$app->response->statusCode) {
        if (Yii::$app->request->isPjax) {
            if ('#contentPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {
                 Yii::$app->response->statusCode = 200;

                  Yii::$app->response->content = '<div id="contentPjax">'
                  . $iframeHtml
                  . '</div>';
            }

            if ('#mainMenuPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {
                Yii::$app->response->statusCode = 200;
                Yii::$app->response->content    = '<div id="mainMenuPjax"></div>';
            }
        }
    }*/

    /*if (Yii::$app->request->isPjax) {
    //echo '<pre>' . htmlentities(Yii::$app->response->content) . '</pre>';

        //Yii::$app->response->data = '';
        //die();
        //Yii::$app->response->headers->add('efabrikov', 'pjax');
        //setcookie('efabrikov', 'pjax');
        //echo 'efabrikov';
    }
    else {
        //Yii::$app->response->headers->add('efabrikov', 'static');
        //setcookie('efabrikov', 'static');
        
    }*/
    //$js = 'console.log("--- pjax reload logic ---");';
    //echo '<script>jQuery(document).ready(function(){' . $js . '});</script>';
    //\yii\helpers\VarDumper::dump(Yii::$app->response->headers, 11, 1);
    //die();
},
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
