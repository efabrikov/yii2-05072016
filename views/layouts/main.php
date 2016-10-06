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
        /* echo '<br><br><br>';
          echo 'referrer: ' . (Yii::$app->request->referrer) . '<br>';
          echo 'absoluteUrl: ' . (Yii::$app->request->absoluteUrl) . '<br>';
          //echo yii\helpers\Url::previous('redirectUrl') . '<br>';
          //echo yii\helpers\Url::to(['site/logout'], true) . '<br>';
          echo 'previous: ' . yii\helpers\Url::previous() . '<br>'; */

        //$u = 'http://yii2-05072016/index.php?r=site%2Findex&t=1475567110096';
        //\yii\helpers\VarDumper::dump(Yii::$app->request->status, 10, 1);
        //print_r(Yii::$app->request);

        $msie             = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
        $hideLayoutHtml   = false;
        $referrerNoSearch = preg_replace('$\?.+$', '', Yii::$app->request->referrer);
        $absUrlNoSearch   = preg_replace('$\?.+$', '', Yii::$app->request->absoluteUrl);

        if (//referre exist
            Yii::$app->request->referrer
            //referrer from our site
            and ( $referrerNoSearch == $absUrlNoSearch)
            //skip pjax
            and ! Yii::$app->request->isPjax
            //for ie
            and ! $msie
            //for site logout redirect 302
            and yii\helpers\Url::previous('redirectUrl') != yii\helpers\Url::to(['site/logout'], true)
            //for refresh page
            //and Yii::$app->request->referrer != Yii::$app->request->absoluteUrl
            //for refresh after redirect(logout)
            and yii\helpers\Url::previous() != Yii::$app->request->absoluteUrl
        //or (Yii::$app->request->get('t') and !Yii::$app->request->isPjax)
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

        $isFullPage = !$hideLayoutHtml;
        //$isIframe = Yii::$app->request->get('t');

        yii\helpers\Url::remember('unset', 'redirectUrl');


        //$this->registerJsFile('/js/iframeLogic.js');

        if (empty($hideLayoutHtml)) {
            ?>
            <div class="wrap">
                <?php Pjax::begin(['id' => 'mainMenuPjax']); ?>
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
                        //['label' => 'Cookies', 'url' => ['/site/cookies']],
                        ['label' => 'IFrame', 'url' => ['/site/iframe']],
                        //['label' => 'hidenPjaxLink', 'url' => ['/'] , 'options' => ['style' =>'display:none;', 'id' => 'hidenPjaxLink']],
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

                <?php
                if ($isFullPage) {
                    Pjax::begin(['id' => 'contentPjax']);
                }


                if ('#contentPjax' != Yii::$app->request->get('_pjax')) {

                    /* echo '<br><br><br><br><br>';
                      echo 'referrer: ' . (Yii::$app->request->referrer) . '<br>';
                      echo 'absoluteUrl: ' . (Yii::$app->request->absoluteUrl) . '<br>';
                      echo '_pjax: ' . Yii::$app->request->get('_pjax') . '<br>'; */

                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs']
                                : [],
                    ]);

                    echo $content;
                } else {
                    $iframeHtml = '<iframe ';
                    $iframeHtml .= 'src="' . str_replace('&_pjax=%23contentPjax', '', Yii::$app->request->absoluteUrl) . '" ';
                    $iframeHtml .= 'id="myIframe2" ';
                    $iframeHtml .= 'style="width:100%; height:500px; background: transparent;" ';
                    $iframeHtml .= 'frameborder="0" ';
                    $iframeHtml .= 'marginheight="0" ';
                    $iframeHtml .= 'marginwidth="0" ';
                    $iframeHtml .= 'onLoad="processIframeLoad();" ';
                    $iframeHtml .= '></iframe>';

                    echo $iframeHtml;
                }

                if ($isFullPage) {
                    Pjax::end();
                }
                ?>

                <?php
                if ($isFullPage) {
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
        <?php
        if ($hideLayoutHtml) {
            echo '<style> body { background: transparent; } </style>';
        }
        ?>


        <?php
//fix fore back from external domain; t for ff bug cache
        $absUrl = Yii::$app->request->absoluteUrl;

        if (Yii::$app->request->get('t')) {
            $search = '&t=' . Yii::$app->request->get('t');
            $absUrl = str_replace($search, '', $absUrl);
        }

        yii\helpers\Url::remember($absUrl);
        ?>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
