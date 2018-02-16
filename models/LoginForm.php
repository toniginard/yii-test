<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Logs in a user using the provided username and password. Calls function
     * validatePassword() to check the password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        // $this->validate() calls validatePassword() to check password
        if ($this->validate()) {
            // logs in the user
            return Yii::$app->user->login($this->user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     *
     * @return bool
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (Yii::$app->getSecurity()->validatePassword($this->password, $user->password_hash)) {
                // All good, logging user in
                return true;
            } else {
                // Wrong password
                $this->addError($attribute, 'Incorrect username or password.');
                return false;
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {

        if ($this->_user === false) {
            $this->_user = User::findOne(['username' => Yii::$app->request->post('LoginForm')['username']]);
        }

        return $this->_user;
    }
}
