<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Cookies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the cookies page.
    </p>
    
</div>
<hr>

<?php
//\yii\helpers\VarDumper::dump( Yii::$app->session, 11, 1);
\yii\helpers\VarDumper::dump(Yii::$app->session->hasFlash('contactFormSubmitted'), 11, 1); ;
    ?>

