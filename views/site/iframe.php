<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = 'iframe';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
echo (Yii::$app->request->referrer) . '<br>';
echo (Yii::$app->request->absoluteUrl) . '<br>';
//print_r($_SERVER['HTTP_ORIGIN']);
//$_SERVER['HTTP_ORIGIN'];
/*if (!empty($_GET['iframe'])) {
    echo 'iframe:';    
} else {
    echo 'not iframe';

    echo '<iframe src="http://yii2-05072016/index.php?r=site%2Flogin&iframe=1" style="width: 100%;" height="500px;" id="myIframe" frameborder=0 marginheight=0 marginwidth=0 onLoad="" ></iframe>';
}*/
?>
<button type="button" id="btnHello">Hello</button>
<button type="button" id="btnHello2">Hello2</button>
<!--div id='iframeContainer'></div-->

<?php
$js = '
    jQuery("#btnHello").click(function() {
        console.log("click hello");
        let html = \'<iframe src="http://yii2-05072016/index.php?r=site%2Flogin" style="width: 100%;" height="500px;" id="myIframe" frameborder=0 marginheight=0 marginwidth=0 onLoad="" ></iframe>\';
        $("#iframeContainer").html(html);
    });

    jQuery("#btnHello2").click(function() {
        console.log("click hello 2");
        let html = \'<iframe src="http://yii2-05072016/index.php?r=site%2Fabout" style="width: 100%;" height="500px;" id="myIframe" frameborder=0 marginheight=0 marginwidth=0 onLoad="" ></iframe>\';
        $("#iframeContainer").html(html);
    });
';
//$this->registerJs($js);
?>
<hr>
<h2>a target</h2>
<a href="http://www.mit.edu/" target="myIframeName">» Go to MIT.edu</a>
<a href="http://www.weather.gov/" target="myIframeName">» Go to Weather.gov</a>
<a href="http://www.google.com/" target="myIframeName">» Google(error)</a>

<iframe src="http://efabrikov.in.ua/" style="width: 100%;" height="800px;" id="myIframeTest" name="myIframeName" frameborder=0 marginheight=0 marginwidth=0></iframe>
<script>

</script>





