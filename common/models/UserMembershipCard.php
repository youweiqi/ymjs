<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_membership_card}}".
 *
 * @property int $id 主键(卡号)
 * @property int $user_id 用户id
 * @property int $store_id 门店id
 * @property int $membership_card_id 会员卡id
 * @property string $create_time 创建时间
 */
class UserMembershipCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_membership_card}}';
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
            [['user_id', 'store_id', 'membership_card_id'], 'integer'],
            [['create_time'], 'safe'],
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
            'store_id' => 'Store ID',
            'membership_card_id' => 'Membership Card ID',
            'create_time' => 'Create Time',
        ];
    }
}
