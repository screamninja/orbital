<?php

namespace app\controllers;

use app\models\Recorder;
use yii\web\Controller;
use yii\db\Query;

class AjaxController extends Controller
{
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
//        $ask = $_POST['who\'s there'];
//
//        if ($ask) {
//            $position = (new Query())
//                ->select(['id','username', 'left', 'top'])
//                ->from('users')
//                -where(['id'])
//
//        }
    }
}
