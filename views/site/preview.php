<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Preview';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the Preview page.
    </p>
    
</div>
<hr>
<a href="/img/renault_backend_preview.png" target="_blank" />renault_backend_preview.png</a> <br>
<a href="/img/renault_backend_preview2.png" target="_blank" />renault_backend_preview2.png</a> <br>
<hr>
<?php
   $str = "Hello world and me!";
   $mod_str = wordwrap($str,5,"_");
   echo('<pre>'.$mod_str);
?>