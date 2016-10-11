<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();            
        }
        return $this->render('contact', [
                'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays preview page.
     *
     * @return string
     */
    public function actionPreview()
    {
        return $this->render('preview');
    }

    /**
     * Displays promise page.
     *
     * @return string
     */
    public function actionPromise()
    {
        return $this->render('promise');
    }

    /**
     * Displays fibonacci page.
     *
     * @return string
     */
    public function actionFibonacci()
    {
        return $this->render('fibonacci');
    }

    /**
     * Displays iframe page.
     *
     * @return string
     */
    public function actionIframe()
    {
        return $this->render('iframe');
    }

    /**
     * Displays Cookies page.
     *
     * @return string
     */
    public function actionCookies()
    {
        return $this->render('cookies');
    }

    /**
     * Displays Pjax page.
     *
     * @return string
     */
    public function actionPjax()
    {
        $msg = '';

        if (Yii::$app->request->isPjax and '#aboutPjaxGetRedirectBlock' == Yii::$app->request->get('_pjax')) {
            //$this->goHome();
            $msg .= 'isPjax ';
            $msg .= Yii::$app->request->get('_pjax');

            return $this->redirect(['site/about']);
        }

        return $this->render('pjax', [
                'msg' => $msg
        ]);
    }
}