<?php

namespace app\models\forms;

use app\models\dao\User;
use Yii;
use yii\base\Model;

/**
 * SignUpForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 */
class SignUpForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password_repeat', 'email', 'password'], 'required'],
            [['email'], 'unique', 'targetClass' => User::className()],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Hesla se neshodují"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Heslo',
            'password_repeat' => 'Heslo znovu',
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User(['password' => $this->password, 'email' => $this->email]);
            if ($user->save()) {
                Yii::$app->user->login($user, 3600 * 24 * 30);
                return true;
            }
        }
        return false;
    }
}
