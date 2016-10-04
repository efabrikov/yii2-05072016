<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<hr>
<a href="http://yii2-05072016/index.php?r=site/preview">preview link</a>
<hr>
<?php 
//header("Location: http://yii2-05072016/index.php?r=site%2Fabout");
//exit();
?>
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
function createGreeter($who) {
    return function() use ($who) {
        echo 'Hello ' . $who;
    };
}

$greeter = createGreeter("World");
$greeter();

?>

<hr>