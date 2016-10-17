<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use \yii\widgets\Pjax;
use yii\helpers\Url;

$this->title                   = 'Pjax';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$js = '$("#contentPjax a").unbind("click"); $("#contentPjax a").unbind("pjax:click");console.log("unbind pjax click");';
//$this->registerJs($js);
?>

<h3>Pjax time form</h3>
<?php Pjax::begin(['id'=>'aboutTimeForm', 'clientOptions' => ['skipOuterContainers' => true]]); ?>
<form action="<?= Url::to(''); ?>" data-pjax="1">
    <?php echo time(); ?>
    <input type="submit">
</form>
<?php Pjax::end(); ?>
<hr>

<h3>Pjax get block</h3>
<?php Pjax::begin(['id'=>'aboutPjaxGetBlock', 'enablePushState' => false]); ?>
<?php echo time(); ?>
<a href=""> reload</a>
<?php Pjax::end(); ?>
<hr>

<h3>Pjax get redirect block</h3>
<?php Pjax::begin(['id'=>'aboutPjaxGetRedirectBlock', 'clientOptions' => ['skipOuterContainers' => true]]); ?>
<?php

echo $msg . '<br>';
echo time();

?>
<a href=""> reload</a>
<?php Pjax::end(); ?>
<hr>
