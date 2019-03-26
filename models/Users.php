<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $name
 * @property string $fname
 * @property integer $datecreate
 * @property integer $lastupdate
 * @property integer $role
 * @property integer $status
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'authKey', 'accessToken', 'datecreate', 'lastupdate', 'role', 'status'], 'required'],
            [['datecreate', 'lastupdate', 'role', 'status'], 'integer'],
            ['password', 'required', 'on' => 'create'],
            [['email', 'password', 'authKey', 'accessToken'], 'string', 'max' => 250],
            [['name', 'fname'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Login',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'name' => 'Name',
            'fname' => 'Fname',
            'datecreate' => 'Datecreate',
            'lastupdate' => 'Lastupdate',
            'role' => 'Role',
            'status' => 'Status',
        ];
    }
}
