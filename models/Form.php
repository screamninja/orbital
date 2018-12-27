<?php

namespace app\models;

use yii\base\Model;

/**
 * Form is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Form extends Model
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
