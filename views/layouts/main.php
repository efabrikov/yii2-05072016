<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
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
        <?php $this->beginBody() ?>        

        <?php
        if (!empty($this->params['msg'])) {
            echo '<script>console.log("' . $this->params['msg'] . '");</script>';
        }
        ?> 
        <div class="wrap">

            <?php include_once '_topMenu.php'; ?>

            <?php
            Pjax::begin(['id' => 'contentPjax',
                'options' => [
                    'class' => 'container'
                ]
            ]);

            echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);

            echo $content;

            Pjax::end();
            ?>
        </div>       

        <?php Pjax::begin(['id' => 'userInfoPjax']); ?>
        some user data example. t = <?php echo time(); ?>
        <?php Pjax::end(); ?>

        <?php include_once '_bottomMenu.php'; ?>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>        

        <span style="display:block;" id = "dataIframeContainer"></span>                

<?php $this->endBody() ?>        

    </body>
</html>
<?php $this->endPage() ?>
