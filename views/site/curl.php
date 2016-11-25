<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use linslin\yii2\curl;
use Sunra\PhpSimple\HtmlDomParser;

$this->title                   = 'Curl';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>get request</h3>
<?php
//Init curl
$curl                          = new curl\Curl();
$response                      = $curl->get(Url::to(['site/contact'], true));
$htmlDom                       = HtmlDomParser::str_get_html(preg_replace(
            //delete single line comments
            '@[\s]+//.+@', ' ', $response
    ));

echo htmlentities($htmlDom->find('#contentPjax', 0)->innertext);

function includeHtmlBlock($id, &$htmlDom, &$view)
{
    $htmlPart = json_encode($htmlDom->find($id, 0)->innertext);

    //$htmlPart = escapeJavaScriptText2(($html->find($id, 0)->innertext));

    $js = 'jQuery(document).ready(function(){'
        . 'setTimeout(function(){ '
        . '$("' . $id . '").html(' . $htmlPart . ');'
        . '}, 3000);'
        . '});';

    $view->registerJs($js);
}
//includeHtmlBlock('#contentPjax', $htmlDom, $this);
//includeHtmlBlock('#assetsPjax', $htmlDom, $this);
?>
<hr>
<?php
$curl                          = new curl\Curl();
$response                      = $curl->get(Url::to(['site/contact'], true));
echo htmlentities($response);
?>

