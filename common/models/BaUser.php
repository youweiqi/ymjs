<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%ba_user}}".
 *
 * @property int $id
 * @property string $user_name 登陆用户名
 * @property string $password 登录密码
 * @property string $nick_name 昵称
 * @property string $picture 头像
 * @property int $lock_status 1锁定 0未锁定
 * @property int $is_black 是否黑名单(1：是 0：否)
 * @property int $is_store 店铺权限（0非，1店员，2店长）
 * @property int $store_id 店铺id
 * @property int $money 账号余额
 * @property string $synopsis 个人介绍
 * @property string $last_login_time 最后登陆时间
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property string $real_name 真实姓名
 * @property string $persion_id 身份ID
 * @property int $sign 身份ID基数
 * @property int $age 年龄
 * @property int $sex 性别(1男,2女)
 * @property int $can_modify_sale_price 该字段只针对店长，店长是否有权修改库存售价,1是可以，0是不可以，默认是1可以修改
 * @property int $can_modify_settlement_price 只针对店长，店长能否修改同行调货价，1是可以，0是不可以，默认是1，可以修改
 */
class BaUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ba_user}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_ba_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lock_status', 'is_black', 'is_store', 'store_id', 'money', 'sign', 'age', 'sex', 'can_modify_sale_price', 'can_modify_settlement_price'], 'integer'],
            [['synopsis'], 'string'],
            [['last_login_time', 'create_time', 'update_time'], 'safe'],
            [['persion_id', 'sign'], 'required'],
            [['user_name'], 'string', 'max' => 11],
            [['password'], 'string', 'max' => 255],
            [['nick_name'], 'string', 'max' => 30],
            [['picture'], 'string', 'max' => 300],
            [['real_name'], 'string', 'max' => 32],
            [['persion_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'password' => 'Password',
            'nick_name' => 'Nick Name',
            'picture' => 'Picture',
            'lock_status' => 'Lock Status',
            'is_black' => 'Is Black',
            'is_store' => 'Is Store',
            'store_id' => 'Store ID',
            'money' => 'Money',
            'synopsis' => 'Synopsis',
            'last_login_time' => 'Last Login Time',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'real_name' => 'Real Name',
            'persion_id' => 'Persion ID',
            'sign' => 'Sign',
            'age' => 'Age',
            'sex' => 'Sex',
            'can_modify_sale_price' => 'Can Modify Sale Price',
            'can_modify_settlement_price' => 'Can Modify Settlement Price',
        ];
    }
}
