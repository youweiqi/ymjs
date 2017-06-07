<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_ba_user}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $ba_user_id 商户通用户id
 * @property int $store_id 门店id
 * @property int $brand_id 品牌id
 * @property string $create_time
 * @property string $update_time
 */
class UserBaUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_ba_user}}';
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
            [['user_id', 'ba_user_id', 'store_id', 'brand_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
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
            'ba_user_id' => 'Ba User ID',
            'store_id' => 'Store ID',
            'brand_id' => 'Brand ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
