<?php
$params = require(__DIR__ . '/params.php');

$config = [
    'id'              => 'basic',
    'basePath'        => dirname(__DIR__),
    'bootstrap'       => ['log'],
    'components'      => [
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
    'on afterRequest' => function ($event) {
    $htmlDom = Sunra\PhpSimple\HtmlDomParser::str_get_html(preg_replace(
                //delete single line comments
                '@[\s]+//.+@', '', Yii::$app->response->data
    ));

    //if (empty($htmlDom)) throw new Exception('$htmlDom can\'t be empty.');

    if (!empty(Yii::$app->params['completedPjaxId'])) {

        //print_r(Yii::$app->request->get());
        //echo \yii\helpers\Url::to('');
        //echo htmlentities(Yii::$app->response->data);
        //echo Yii::$app->request->referrer;
        /* echo '<pre>';
          print_r($_SERVER);
          echo '</pre>';
          exit; */
        //echo '<script>$ = window.parent.$;  $(document).ready(function(){ console.log("iframe load");});</script>';



        function getHtmlBlock($id, &$htmlDom)
        {
            $htmlPart = json_encode($htmlDom->find($id, 0)->innertext);
            //$htmlPart = escapeJavaScriptText2(($html->find($id, 0)->innertext));
            return '$("' . $id . '").html(' . trim($htmlPart) . ');' . PHP_EOL;
        }
        $data = '';
        $data .= '<script>$ = window.parent.$; jQuery = window.parent.jQuery; yii = window.parent.yii;' . PHP_EOL;
        $data .= '$(document).ready(function(){ console.log("run iframe scripts");' . PHP_EOL;

        //$data .= getHtmlBlock('#beginBodyPjax', $htmlDom);

        if ('mainMenuPjax' == Yii::$app->params['completedPjaxId']) {
            $data .= getHtmlBlock('#contentPjax', $htmlDom);
        }

        //$data .= getHtmlBlock('#endBodyPjax', $htmlDom);

        //add new scripts
        $new = print_r(Yii::$app->session->get('jsFilesLog') , 1);
        $old = print_r(Yii::$app->session->get('jsFilesLogPrev') , 1);
        $diff = [];
        foreach (Yii::$app->session->get('jsFilesLog') as $key => $value) {
            //echo Yii::$app->session->get('jsFilesLogPrev')[$key]; die();
            if (empty(Yii::$app->session->get('jsFilesLogPrev')[$key])) {
                $diff[] = $key;
            }
        }       
        
        /*foreach ($diff as $key => $value) {
            $data .= '$("body").append("<script>'
            . 'console.log(\"added script: '.$value.' \"); ' . PHP_EOL
            . htmlentities(file_get_contents(Yii::getAlias('@webroot') .  $value)) . ' '
            . '<\/script>");';
        }*/

        foreach ($diff as $key => $value) {
            $data .= file_get_contents(Yii::getAlias('@webroot') .  $value);
            
        }

        \yii\helpers\VarDumper::dump($new, 11, 1);
        \yii\helpers\VarDumper::dump($old, 11, 1);
        \yii\helpers\VarDumper::dump($diff, 11, 1);        
        //$data .= $new;
//die();
        

        $data .= '});</script>';

        Yii::$app->response->data = $data;
    }

    //clear assets data on refresh page
    /* if (Yii::$app->session->get('savedEndBodyData') and empty(Yii::$app->params['completedPjaxId']) and !Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
      Yii::$app->session->remove('savedEndBodyData');
      } */

    //save assets data on first load
    //if (!Yii::$app->session->get('savedEndBodyData') and Yii::$app->request->isGet and !Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
    //Yii::$app->session->set('savedEndBodyData', $htmlDom->find('#endBodyPjax', 0)->innertext);
    //Yii::$app->session->set('savedEndBodyData', $htmlDom->find('#endBodyPjax', 0)->innertext);
    //}
    //
    if (Yii::$app->session->get('jsFilesLog') and ! Yii::$app->request->isAjax and
        ! Yii::$app->request->isPjax) {
        //echo '<script>alert("s")</script>';

        Yii::$app->response->data .= '<hr>jsFilesLog<hr>';
        Yii::$app->response->data .= \yii\helpers\VarDumper::dumpAsString(Yii::$app->session->get('jsFilesLog'), 11, 1);
        Yii::$app->response->data .= '<hr>jsFilesLogPrev<hr>';
        Yii::$app->response->data .= \yii\helpers\VarDumper::dumpAsString(Yii::$app->session->get('jsFilesLogPrev'), 11, 1);
    }
    /*
      if (Yii::$app->session->get('jsLog') and !Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {

      Yii::$app->response->data .= '<hr>jsLog<hr>';
      Yii::$app->response->data .= \yii\helpers\VarDumper::dumpAsString(Yii::$app->session->get('jsLog'), 11, 1);
      Yii::$app->response->data .= '<hr>jsLogPrev<hr>';
      Yii::$app->response->data .= \yii\helpers\VarDumper::dumpAsString(Yii::$app->session->get('jsLogPrev'), 11, 1);

      } */
},
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    if (empty($_GET['completedPjaxId'])) {
        $config['bootstrap'][]      = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
        ];
    }

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
