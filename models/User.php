<?php

namespace app\models;

use Yii;
use yii\base\Object;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const ROLE_USER=1;
    const ROLE_ADMIN=2;

    const STATUS_ACTIVE=1;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public static function isUserAdmin($username)
    {
        if (static::findOne(['email' => $username, 'role' => self::ROLE_ADMIN]))
            return true;
        else
            return false;
    }

    public static function findByLogin($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function checkRole($role){
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->role==$role)
                return true;
        }
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password))
           return true;
        return false;
    }

    public static function generateString($int){
        return Yii::$app->security->generateRandomString($int);
    }
}
