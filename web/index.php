<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

//hidden get param from iframe :)
if (!empty($_GET['completedPjaxId'])) {
    //remember
    $clearValue = addslashes(strip_tags($_GET['completedPjaxId']));    
    $config['params']['completedPjaxId'] = $clearValue;
    //clear    
    $_SERVER['QUERY_STRING'] = str_replace('&completedPjaxId=' . $_GET['completedPjaxId'], '', $_SERVER['QUERY_STRING']);
    $_SERVER['REQUEST_URI'] = str_replace('&completedPjaxId=' . $_GET['completedPjaxId'], '', $_SERVER['REQUEST_URI']);

    unset($_GET['completedPjaxId']);
    unset($_REQUEST['completedPjaxId']);
}

/*echo '<hr>get<br>';
print_r($_GET);
echo '<hr>request<br>';
print_r($_REQUEST);
echo '<hr>server<br>';
print_r($_SERVER);
echo '<hr>cookie<br>';
print_r($_COOKIE);
echo '<hr>env<br>';
print_r($_ENV);
echo '<hr>post<br>';
print_r($_POST);
echo '<hr>session<br>';
print_r($_SESSION);
die();*/

(new yii\web\Application($config))->run();
