<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auto_refund_log".
 *
 * @property integer $id
 * @property integer $order_object_id
 * @property string $refund_sn
 * @property string $refund_id
 * @property integer $pay_type
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class AutoRefundLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.auto_refund_log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_order');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_object_id', 'pay_type', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['refund_sn', 'refund_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_object_id' => '父订单ID',
            'refund_sn' => '退款单号',
            'refund_id' => '退款流水',
            'pay_type' => '支付类型',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用 1使用',
        ];
    }
}
