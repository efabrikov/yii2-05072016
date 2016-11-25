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
        <?php include_once '_background.php'; ?>

    </head>
    <body>
        <?php Pjax::begin(['id' => 'beginBodyPjax']); ?>        
        <?php $this->beginBody() ?>
        <?php Pjax::end(); ?>

        <?php
        /* echo '<br><br><br><pre>';
          echo @Yii::$app->session->id;
          echo '<hr>';
          print_r(Yii::$app->request->cookies);
          echo '</pre><hr>'; */
        ?>

        <div class="wrap">

            <?php
            
            Pjax::begin(['id' => 'mainMenuPjax']);
            Yii::$app->session->set('t1', Yii::$app->getView()->js);             
            if (Yii::$app->request->isPjax
                and '#mainMenuPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container']) {
                $js = '$.pjax.efabrikov.queue = ["contentPjax"]';
                $this->registerJs($js);
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
            <?php Yii::$app->session->set('t2', Yii::$app->getView()->js); ?>
            <?php Pjax::end(); ?>
            



            <?php            
            Pjax::begin(['id'      => 'contentPjax',
                'options' => [
                    'class' => 'container'
                ]
            ]);

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

        <span style="display:block;" id = "dataIframeContainer"></span>
        
        <?php Pjax::begin(['id' => 'endBodyPjax']); ?>

        <?php $this->endBody() ?>        

        <?php Pjax::end(); ?>

    </body>
</html>
<?php $this->endPage() ?>
