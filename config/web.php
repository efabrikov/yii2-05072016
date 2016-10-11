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
    /* echo '<br><br><br><br>afterAction';
      echo Yii::$app->request->referrer;
      echo Yii::$app->response->statusCode; */
    if (302 == Yii::$app->response->statusCode) {
        yii\helpers\Url::remember(Yii::$app->request->absoluteUrl, 'redirectUrl');
        //yii\helpers\Url::remember(302, 'statusCode');
        //Yii::$app->response->body



        if (Yii::$app->request->isPjax) {
            //\yii\helpers\VarDumper::dump( Yii::$app->request->getHeaders()['X-PJAX-Container'], 12, 1);
            //die();

            #
            //echo json_encode(Yii::$app->response->content = '<div id="contentPjax">redirect content</div>');
            //die();
            //X-Pjax-Url
            //$redirectUrl = Yii::$app->response->getHeaders()['X-Pjax-Url'];
            //Yii::$app->response->content = '<div id="contentPjax" class="container">redirect content. $redirectUrl = '.$redirectUrl.'</div>';
            //echo '<div id="contentPjax" class="container">redirect content</div>';
            //yii\helpers\Url::remember(302, 'statusCode');

            if ('#contentPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {
                Yii::$app->response->statusCode = 200;

                $iframeSrc = Yii::$app->response->getHeaders()['X-Pjax-Url'];
                $iframeSrc = str_replace('&_pjax=%23contentPjax', '', $iframeSrc);
                $iframeSrc = str_replace('?_pjax=%23contentPjax', '', $iframeSrc);

                $iframeHtml = '<iframe ';
                $iframeHtml .= 'src="' . $iframeSrc . '" ';
                $iframeHtml .= 'id="myIframe2" ';
                $iframeHtml .= 'style="width:1200px; height:500px; background: transparent; display:none; overflow: hidden;" ';
                $iframeHtml .= 'frameborder="0" ';
                $iframeHtml .= 'marginheight="0" ';
                $iframeHtml .= 'marginwidth="0" ';
                $iframeHtml .= 'onLoad="parent.processIframeLoad();" ';
                $iframeHtml .= '></iframe>';

                Yii::$app->response->content = '<div id="contentPjax">'
                    . $iframeHtml
                    . '</div>';
            }

            if ('#mainMenuPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {
                Yii::$app->response->statusCode = 200;
                //Yii::$app->response->content    = '<div id="mainMenuPjax">';

                \yii\widgets\Pjax::begin(['id' => 'mainMenuPjax']);
                yii\bootstrap\NavBar::begin([
                    'brandLabel' => 'My Company',
                    'brandUrl'   => Yii::$app->homeUrl,
                    'options'    => [
                        'class' => 'navbar-inverse navbar-fixed-top',
                        'id'    => 'mainMenu'
                    ],
                ]);
                echo yii\bootstrap\Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items'   => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'About', 'url' => ['/site/about']],
                        ['label' => 'Preview', 'url' => ['/site/preview']],
                        ['label' => 'Promise', 'url' => ['/site/promise']],
                        ['label' => 'Contact', 'url' => ['/site/contact']],
                        ['label' => 'Fibonacci', 'url' => ['/site/fibonacci']],
                        ['label' => 'Cookies', 'url' => ['/site/cookies']],
                        ['label' => 'IFrame', 'url' => ['/site/iframe']],
                        ['label' => 'Pjax', 'url' => ['/site/pjax']],
                        Yii::$app->user->isGuest ? (
                            ['label' => 'Login', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form', 'data-pjax' => true])
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link']
                            )
                            . Html::endForm()
                            . '</li>'
                            )
                    ],
                ]);
                yii\bootstrap\NavBar::end();
                \yii\widgets\Pjax::end();
                //Yii::$app->response->content .= 'xxx</div>';
                 
            }
        }
    }
},
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /* $config['bootstrap'][] = 'debug';
      $config['modules']['debug'] = [
      'class' => 'yii\debug\Module',
      ]; */

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
