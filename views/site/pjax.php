<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use \yii\widgets\Pjax;

$this->title                   = 'Pjax';
$this->params['breadcrumbs'][] = $this->title;
?>
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

<h3>Pjax get redirect block</h3>
<?php Pjax::begin(['id'=>'aboutPjaxGetRedirectBlock', 'enablePushState' => true, 'clientOptions' => ['skipOuterContainers' => true]]); ?>
<?php

echo $msg . '<br>';
echo time();

?>
<a href=""> reload</a>
<?php Pjax::end(); ?>
<hr>
