<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \yii\widgets\Pjax;
use linslin\yii2\curl;
use Sunra\PhpSimple\HtmlDomParser;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            
            <?php Pjax::begin(['id' => 'mainMenuPjax']); ?>
            <?php

            if (Yii::$app->request->isPjax
                and '#mainMenuPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {

                $absUrl = str_replace('&_pjax=%23contentPjax', '', str_replace('?_pjax=%23contentPjax', '', Yii::$app->request->absoluteUrl));

                //Init curl
                $curl = new curl\Curl();

                $curl->setOption(CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

                if ($_COOKIE) {
                    $cookies = null;

                    foreach ($_COOKIE as $key => $value) {
                        $cookies[] = $key . '=' . $value;
                    }

                    $cookies = implode('; ', $cookies);
                    
                    //$curl->setOption(CURLOPT_COOKIE, $cookies);
                }           

                $response = $curl->get($absUrl);
                $htmlDom  = HtmlDomParser::str_get_html(preg_replace(
                            //delete single line comments
                            '@[\s]+//.+@', '', $response
                ));

                function includeHtmlBlock($id, &$htmlDom, &$view)
                {
                    $htmlPart = json_encode($htmlDom->find($id, 0)->innertext);

                    //$htmlPart = escapeJavaScriptText2(($html->find($id, 0)->innertext));

                    $js = 'jQuery(document).ready(function(){'
                        . '$("' . $id . '").html(' . $htmlPart . ');'
                        . '});';

                    $view->registerJs($js);
                }
                includeHtmlBlock('#contentPjax', $htmlDom, $this);
                includeHtmlBlock('#assetsPjax', $htmlDom, $this);
            }
            ?>
            <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                    'id'    => 'mainMenu'
                ],
            ]);
            echo Nav::widget([
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
                    ['label' => 'Curl', 'url' => ['/site/curl']],
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
            NavBar::end();
            ?>
            <?php Pjax::end(); ?>



            <?php
            Pjax::begin(['id'      => 'contentPjax',
                'options' => [
                    'class' => 'container'
                ]
            /* , 'clientOptions' => [
              'pushRedirect' => true,
              'replaceRedirect' => false
              ] */            ]);



            echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs']
                        : [],
            ]);

            echo $content;

            Pjax::end();
            ?>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php include_once '_background.php'; ?>

        <style> body { background: transparent; } </style>

        <?php Pjax::begin(['id' => 'assetsPjax']); ?>
        <?php
        if (Yii::$app->request->isPjax
            and '#assetsPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {

        }
        ?>

        <?php $this->endBody() ?>
        <?php Pjax::end(); ?>
    </body>
</html>
<?php $this->endPage() ?>
