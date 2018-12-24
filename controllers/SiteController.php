<?php

namespace app\controllers;

use app\models\User;
use app\models\ActiveRecordUser;
use app\models\UserRecorder;
use app\models\UserForm;
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $session = Yii::$app->session;

        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new UserRecorder();
            $user->username = $model->username;
            $user->save();
            $identify = new ActiveRecordUser();
            if ($session->isActive) {
                Yii::$app->user->login($identify::findByUsername($model->username));
            }
            return $this->render('start', ['model' => $model]);
        }
        if (!Yii::$app->user->isGuest) {
            return $this->render('start', ['model' => $model]);
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }

    /**
     * @return Response|null
     */
    public function actionStart(): ?Response
    {

        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('entry', ['model' => $model]);
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
