<?php

$reloadQueue = [];

switch (\Yii::$app->request->getHeaders()['X-PJAX-Container']) {
    case '#mainMenuPjax':
        $reloadQueue[] = 'contentPjax';
        $reloadQueue[] = 'bottomMenuPjax';
        break;
    case '#bottomMenuPjax':
        $reloadQueue[] = 'contentPjax';
        $reloadQueue[] = 'mainMenuPjax';
        break;
    case '#contentPjax':
        $reloadQueue[] = 'mainMenuPjax';
        $reloadQueue[] = 'bottomMenuPjax';
        //if example
        //in conroller was added: 
        //\Yii::$app->view->params['isUserSaved'] = true ; 
        if (!empty(\Yii::$app->view->params['isUserSaved'])) {
            $reloadQueue[] = 'userInfoPjax';
        }
        break;
    default :
        break;
}

return $reloadQueue;
