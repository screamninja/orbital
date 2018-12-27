<?php

namespace app\controllers;

use app\models\User;
use app\models\ActiveRecordUser;
use app\models\Recorder;
use app\models\Form;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage and "start" page.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new Form();

        $session = Yii::$app->session;
        $session->open(); // открываем сессию, если она не была открыта ранее

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new Recorder();
            $user->username = $model->username;
            $user->save(); // сохраняем пользователя в БД
            $identify = new ActiveRecordUser();
            if ($session->isActive) {
                Yii::$app->user->login($identify::findByUsername($model->username)); // авторизуем пользователья
                $session->set('logged_user', $model->username); // добавляем имя пользователя в сессию
            }
            return $this->render('start', ['model' => $model]); // возвращаем представление "старт"
        }
        if (!Yii::$app->user->isGuest) { // если не гость, то отображаем представление "старт"
            return $this->render('start', ['model' => $model]);
        } else { // если гость, то отображаем страницу приветствия
            return $this->render('index', ['model' => $model]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
