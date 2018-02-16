<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Security;

class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_VIEW = 'view';
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return 'user';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_VIEW => [
                'username',
                'first_name',
                'last_name',
                'email',
                'status',
                'created_at',
                'updated_at',
            ],
            self::SCENARIO_INSERT => [
                'username',
                'first_name',
                'last_name',
                'email',
                'status',
                'password_hash',
                'created_at',
                'updated_at',
            ],
            self::SCENARIO_UPDATE => [
                'username',
                'first_name',
                'last_name',
                'email',
                'status',
                'password_hash',
                'created_at',
                'updated_at',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required', 'on' => self::SCENARIO_INSERT],
            [['username'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['email'], 'email'],
            [['status'], 'integer'],
            [['username'], 'unique'],
            [['username', 'password_hash', 'first_name', 'last_name'], 'string', 'max' => 80],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     *
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     *
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return '';
    }

    /**
     * @param string $authKey
     *
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if (isset($this->password_hash)) {
                    $this->password_hash = Security::generatePasswordHash($this->password_hash, 10);
                }
            }
            if (empty($this->password_hash)) {
                // Don't modify password
                unset($this->password_hash);
            } else {
                $this->password_hash = Security::generatePasswordHash($this->password_hash, 10);
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Add default role after user creation
        if ($this->scenario == self::SCENARIO_INSERT) {
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole('General');
            $auth->assign($role, $this->getId());

            return true;
        }
    }

}
