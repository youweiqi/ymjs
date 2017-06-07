<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%c_user_info}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $real_name 真实姓名
 * @property string $persion_id 身份ID
 * @property int $sign 身份ID基数
 * @property int $age 年龄
 * @property int $sex 性别(1男,2女)
 * @property string $located 常驻地编码
 * @property string $located_name 常驻地名
 * @property string $address 地址
 * @property string $wechat_no 微信号
 */
class CUserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%c_user_info}}';
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
            [['user_id', 'sign', 'age', 'sex'], 'integer'],
            [['sign'], 'required'],
            [['real_name'], 'string', 'max' => 32],
            [['persion_id'], 'string', 'max' => 20],
            [['located'], 'string', 'max' => 100],
            [['located_name', 'wechat_no'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 500],
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
            'real_name' => 'Real Name',
            'persion_id' => 'Persion ID',
            'sign' => 'Sign',
            'age' => 'Age',
            'sex' => 'Sex',
            'located' => 'Located',
            'located_name' => 'Located Name',
            'address' => 'Address',
            'wechat_no' => 'Wechat No',
        ];
    }
}
