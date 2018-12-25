<?php
/**
 * Created by PhpStorm.
 * User: scream
 * Date: 23.12.18
 * Time: 20:21
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Recorder
 * @package app\models
 */
class Recorder extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }
}
