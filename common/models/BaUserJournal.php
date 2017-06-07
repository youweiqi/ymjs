<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%ba_user_journal}}".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property string $order_sn 订单号
 * @property int $promotion_detail_id 优惠券id
 * @property int $money 金额
 * @property string $type 收支类型区分，+是收入，-是支出
 * @property int $bank_id 用户银行卡id
 * @property string $comment 备注
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $status 状态(0禁用,1分佣,2提款中,3提款成功,4提款失败,5系统返还,6其他消费,7系统奖励)
 */
class BaUserJournal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ba_user_journal}}';
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
            [['user_id', 'promotion_detail_id', 'money', 'bank_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 10],
            [['comment'], 'string', 'max' => 255],
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
            'order_sn' => 'Order Sn',
            'promotion_detail_id' => 'Promotion Detail ID',
            'money' => 'Money',
            'type' => 'Type',
            'bank_id' => 'Bank ID',
            'comment' => 'Comment',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
