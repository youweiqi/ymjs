<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%c_login_log}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $create_time 创建时间（登陆时间）
 * @property string $login_ip 登录ip
 * @property int $type 登录端类型（1：android2:ios 3:h5）
 */
class CLoginLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%c_login_log}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'integer'],
            [['create_time'], 'safe'],
            [['login_ip'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'create_time' => 'Create Time',
            'login_ip' => 'Login Ip',
            'type' => 'Type',
        ];
    }
}
