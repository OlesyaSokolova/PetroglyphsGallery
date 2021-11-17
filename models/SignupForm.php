<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * Signup form
 */
class SignupForm extends Model
{

    public $email;
    public $password;
    public $passwordValidate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким e-mail уже существует.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль должен содержать минимум 6 символов.'],
            ['passwordRepeat', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
       // $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save(false);

        $auth = Yii::$app->authManager;
        $authRole = $auth->getRole('author');
        $auth->assign($authRole, $user->getId());

        return $user;

    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors) && $this->password == $this->passwordValidate;
    }
}
