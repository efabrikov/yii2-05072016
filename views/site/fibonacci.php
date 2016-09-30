<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Fibonacci';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the fibonacci example.
        <br>
        <?php
        // ************************** рекурсия *******************************
        function fibonacci($n)
        {
            if ($n < 3) {
                return 1;
            } else {
                return fibonacci($n - 1) + fibonacci($n - 2);
            }
        }
        for ($index = 0; $index < 10; $index++) {
            echo '[' . $index . '] = ' . fibonacci($index);
            echo '<br>';
        }

        // ************************ без рекурсии *****************************

        function fibonacci2($n)
        {
            $a = 0;
            $b = 1;
            $r = 0; // Определяем переменную с результатом
            for ($i = 0; $i < $n; $i++) {
                $r = $a + $b;
                $a = $b;
                $b = $r;
                echo $r . ' ';
            }
        }
        fibonacci2(50);
        ?>
    </p>
    
</div>
