<?php

namespace common\models;


use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * This is the model class for table "{{%api_users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property int $last_login_time
 * @property int $last_login_ip
 * @property int $allowance
 * @property int $allowance_updated_at
 * @property int $status
 * @property string $api_token
 */
class ApiUsers extends \yii\db\ActiveRecord  implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE  = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_users';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'password', 'salt', 'last_login_time', 'last_login_ip', 'allowance', 'allowance_updated_at'], 'required'],
            [['id', 'last_login_time', 'last_login_ip', 'allowance', 'allowance_updated_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 16],
            [['password'], 'string', 'max' => 60],
            [['salt', 'email'], 'string', 'max' => 32],
            [['api_token'], 'string', 'max' => 64],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'email' => 'Email',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'allowance' => 'Allowance',
            'allowance_updated_at' => 'Allowance Updated At',
            'status' => 'Status',
            'api_token' => 'Api Token',
        ];
    }



    /**
     * @inheritdoc
     * 根据user_backend表的主键（id）获取用户
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }



    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 如果token无效的话，
        if(!static::apiTokenIsValid($token)) {
           // throw new UnauthorizedHttpException("token is invalid.");
            throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

        return static::findOne(['api_token' => $token, 'status' => self::STATUS_ACTIVE]);
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     * 用以标识 Yii::$app->user->id 的返回值
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     * 获取auth_key
     * 用户唯一性
     */
    public function getAuthKey()
    {
        return uniqid($this->username);
//        return $this->auth_key;
    }


    /**
     * @inheritdoc
     * 验证auth_key
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * 生成 "remember me" 认证key
     */
    public function generateAuthKey()
    {
        $this->username = Yii::$app->security->generateRandomString();
    }

    /**
     * 为model的password_hash字段生成密码的hash值
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }



    /**
     * 生成 api_token
     */
    public function generateApiToken()
    {
        $this->api_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * 校验api_token是否有效
     *
     */
    public static function apiTokenIsValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.apiTokenExpire'];
        return $timestamp + $expire >= time();
    }


    /**
     * 根据user_backend表的username获取用户
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * 验证密码的准确性
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


}
