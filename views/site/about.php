<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use \yii\widgets\Pjax;

$this->title                   = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<hr>
<a href="http://yii2-05072016/index.php?r=site/preview">preview link</a>
<hr>

<hr>
<a href="<?= yii\helpers\Url::to(['/site/cookies']) ?>">cookies link</a>
<hr>

<h3>Pjax time form</h3>
<?php Pjax::begin(['id'=>'aboutTimeForm', 'clientOptions' => ['skipOuterContainers' => true]]); ?>
<form action="" data-pjax>
    <?php echo time(); ?>
    <input type="submit">
</form>
<?php Pjax::end(); ?>
<hr>

<h3>Pjax get block</h3>
<?php Pjax::begin(['id'=>'aboutPjaxGetBlock', 'enablePushState' => false, 'clientOptions' => ['skipOuterContainers' => true]]); ?>
<?php echo time(); ?>
<a href=""> reload</a>
<?php Pjax::end(); ?>
<hr>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
<hr>
<?php

function createGreeter($who)
{
    return function() use ($who) {
        echo 'Hello ' . $who;
    };
}
$greeter = createGreeter("World");
$greeter();
?>

<hr>