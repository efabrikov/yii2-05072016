<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use \yii\widgets\Pjax;


Pjax::begin(['id' => 'mainMenuPjax']);

if (Yii::$app->request->isPjax and '#mainMenuPjax' == Yii::$app->request->getHeaders()['X-PJAX-Container'] and ! Yii::$app->request->get('isPjaxReload')) {
    $js = '$.pjax.efabrikov.queue = ["contentPjax", "bottomMenuPjax"]';

    $this->registerJs($js);
}
?>

<?php

NavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
        'id' => 'mainMenu'
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
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
