<?php

namespace app\models;

use yii\base\Model;

/**
 * UserForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class UserForm extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['username'], 'required'],
        ];
    }
}
