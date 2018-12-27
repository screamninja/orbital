<?php

namespace app\controllers;

use app\models\Recorder;
use yii\web\Controller;
use yii\db\Query;
use yii\helpers\Json;
use Yii;

/**
 * Class AjaxController
 * @package app\controllers
 */
class AjaxController extends Controller
{
    /**
     * Производит запись координат перемещения интерактивного элемента на странице в БД
     * @return void
     */
    public function actionMove(): void
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

    /**
     * На основании данных сессии, направляет запрос в БД по заданным критериям, сравнивает полученный результаты
     * с ранее данными записанными ранее в сессию, если массивы данных не проходят сравнение - отправляет более
     * свежие координаты и заносит их в сессию, если проходят - отправляет команду "пропустить перемещение".
     * @return string
     */
    public function actionWatch(): string
    {
        $json = new Json();
        $session = Yii::$app->session;
        $username = $session->get('logged_user'); // получаем данные о аутентифицированном пользователе в сессии
        $position = (new Query()) // формируем и направляем запрос в БД
            ->select(['id', 'username', 'left', 'top'])
            ->from('users') //
            ->orderBy(['id' => SORT_DESC]) // сортируем по убыванию id
            ->where(['not like', 'username', $username, false]) // исключаем записи запрашивающего пользователя
            ->limit(1)
            ->one();
        $getLastPos = $session->get('last_move'); // получаем последние известные координаты из сессии пользователя
        $session->set('last_move', $position); // добавляем в сессию последние полученные координаты из БД
        if (array_diff($position, $getLastPos) === []) { // сравниваем массивы полученные из БД и из сессии
            return $json::encode('X'); // массивы идентичны, отправляем команду "пропустить перемещение"
        }
        return $json::encode($position); // отправляем массив данных для перемещения элемента
    }
}
