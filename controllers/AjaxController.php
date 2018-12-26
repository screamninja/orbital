<?php

namespace app\controllers;

use app\models\Recorder;
use yii\web\Controller;
use yii\db\Query;
use yii\helpers\Json;
use Yii;

class AjaxController extends Controller
{
    public $activeUser;

    public function actionMove()
    {
        $data = $_POST;

        if ($data) {
            $record = new Recorder();
            $record->username = $data['username'];
            $record->left = $data['left'];
            $record->top = $data['top'];
            $record->save();
        }
    }

    public function actionWatch()
    {
        $json = new Json();
        $session = Yii::$app->session;
        $username = $session->get('logged_user');

        $position = (new Query())
            ->select(['id','username', 'left', 'top'])
            ->from('users')
            ->orderBy(['id' => SORT_DESC])
            ->where(['not like','username', $username, false])
            ->limit(1)
            ->one();
        return $json::encode($position);
    }
}
