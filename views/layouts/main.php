<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \yii\widgets\Pjax;

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
        <?php
         /*echo '<br><br><br><br><br>';
          echo (Yii::$app->request->referrer) . '<br>';
          echo (Yii::$app->request->absoluteUrl) . '<br>';
          echo yii\helpers\Url::previous('redirectUrl') . '<br>';
          echo yii\helpers\Url::to(['site/logout'], true) . '<br>';*/
          
          //\yii\helpers\VarDumper::dump(Yii::$app->request->status, 10, 1);
          //print_r(Yii::$app->request);

        $msie           = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
        $hideLayoutHtml = false;

        if (//referre exist
            Yii::$app->request->referrer
            //referrer from our site
            and ( preg_replace('$\?.+$', '', Yii::$app->request->referrer) == preg_replace('$\?.+$', '', Yii::$app->request->absoluteUrl))
            //skip pjax
            and ! Yii::$app->request->isPjax
            //for ie
            and ! $msie
            //for site logout redirect 302
            and yii\helpers\Url::previous('redirectUrl') != yii\helpers\Url::to(['site/logout'], true)
            //for refresh page
            and Yii::$app->request->referrer != Yii::$app->request->absoluteUrl
            
        //or Yii::$app->request->getQueryParam('showLayout')
        //and !empty(Yii::$app->request->getQueryParam('t'))
        ) {
            $hideLayoutHtml = true;
            

            //echo 'да, скрыть!';
            //var_dump(preg_replace('$\?.+$', '', Yii::$app->request->referrer));
            //var_dump(preg_replace('$\?.+$', '',Yii::$app->request->absoluteUrl));
            //var_dump(Yii::$app->response->getStatusCode());
            //var_dump(Yii::$app->getRequest()->getHeaders());
            //var_dump(Yii::$app->request->getQueryParam('t'));
        }

        yii\helpers\Url::remember('unset','redirectUrl');


        //$this->registerJsFile('/js/iframeLogic.js');

        if (empty($hideLayoutHtml)) {
            ?>
            <div class="wrap">
                <?php Pjax::begin(); ?>
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
                        ['label' => 'IFrame', 'url' => ['/site/iframe']],
                        Yii::$app->user->isGuest ? (
                            ['label' => 'Login', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
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

                <div class="container" id='iframeContainer' style="">
                <?php } ?>
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs']
                            : [],
                ])
                ?>

                <?php if ($hideLayoutHtml) { ?>
                    <style>
                        body {
                            background: transparent;
                        }

                    </style>               
                <?php } ?>

                <?php
                /* echo '<br><br><br><br><br>';
                  echo (Yii::$app->request->referrer) . '<br>';
                  echo (Yii::$app->request->absoluteUrl) . '<br>';*/
                ?>
                <?= $content ?>

                <?php
                if (empty($hideLayoutHtml)) {
                    ?>
                </div>
            </div>

            <footer class="footer">
                <div class="container">
                    <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

                    <p class="pull-right"><?= Yii::powered() ?></p>
                </div>
            </footer>
            <?php include_once '_background.php'; ?>
            <?php
            $this->registerJsFile('/js/iframeLogic.js', [
                'depends' => 'app\assets\AppAsset'
            ]);
            ?>
        <?php } ?>
<?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
