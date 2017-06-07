<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commision".
 *
 * @property integer $id
 * @property integer $order_detail_id
 * @property integer $order_info_id
 * @property integer $order_object_id
 * @property integer $user_id
 * @property integer $type
 * @property string $comment
 * @property integer $fee
 * @property string $result_time
 * @property integer $result
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class Commision extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.commision';
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
            [['order_detail_id', 'order_info_id', 'order_object_id', 'user_id', 'type', 'fee', 'result', 'status'], 'integer'],
            [['user_id', 'comment'], 'required'],
            [['result_time', 'create_time', 'update_time'], 'safe'],
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
            'order_detail_id' => '订单商品详情id',
            'order_info_id' => '子订单号id',
            'order_object_id' => '父订单id',
            'user_id' => '分佣人',
            'type' => '分佣类型  0消费积分...(级别),1001店员,1101店长',
            'comment' => '备注',
            'fee' => '分佣金额',
            'result_time' => '分佣处理时间',
            'result' => '0.未处理1.已处理',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用1使用',
        ];
    }
}
