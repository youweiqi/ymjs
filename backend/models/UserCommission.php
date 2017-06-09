<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_commission".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $commission 分佣
 * @property int $indirect_commission 间接分佣
 */
class UserCommission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_commission';
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
            [['user_id', 'commission', 'indirect_commission'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'commission' => '分佣',
            'indirect_commission' => '间接分佣',
        ];
    }
}
