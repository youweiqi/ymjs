<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_vip".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $vip_expenses_id
 * @property string $expense_name
 * @property integer $user_id
 * @property integer $sale_price
 * @property integer $total_price
 * @property integer $sum_number
 * @property integer $cash_coin
 * @property integer $total_fee
 * @property integer $commision_fee
 * @property string $pay_date
 * @property integer $pay_type
 * @property string $complete_date
 * @property integer $is_bill
 * @property integer $bill_type
 * @property string $bill_header
 * @property integer $payment_fee
 * @property string $pay_id
 * @property string $remark
 * @property integer $in_state
 * @property string $in_date
 * @property string $in_verification
 * @property integer $procedure_fee
 * @property integer $bank_in
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class OrderVip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.order_vip';
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
            [['vip_expenses_id', 'user_id', 'sale_price', 'total_price', 'sum_number', 'cash_coin', 'total_fee', 'commision_fee', 'pay_type', 'is_bill', 'bill_type', 'payment_fee', 'in_state', 'procedure_fee', 'bank_in', 'status'], 'integer'],
            [['expense_name'], 'required'],
            [['pay_date', 'complete_date', 'in_date', 'create_time', 'update_time'], 'safe'],
            [['order_sn', 'bill_header'], 'string', 'max' => 100],
            [['expense_name', 'pay_id', 'in_verification'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '订单号',
            'vip_expenses_id' => '开通vip id',
            'expense_name' => '开通vip类型名称',
            'user_id' => '用户id',
            'sale_price' => '售价（单价）',
            'total_price' => '总售价',
            'sum_number' => '总数量',
            'cash_coin' => '现金币',
            'total_fee' => '实际支付金额',
            'commision_fee' => '订单总分佣',
            'pay_date' => '订单支付时间',
            'pay_type' => '支付方式(1.微信支付2.支付宝支付3.公众号支付)',
            'complete_date' => '订单完成时间',
            'is_bill' => '是否开票',
            'bill_type' => '发票类型(1.个人2.公司)',
            'bill_header' => '发票抬头',
            'payment_fee' => '支付回调金额',
            'pay_id' => '支付流水号',
            'remark' => '订单备注',
            'in_state' => '（收入）是否核销 0 未核销,1已核销',
            'in_date' => '收款日期',
            'in_verification' => '收入核销人',
            'procedure_fee' => '手续费',
            'bank_in' => '银行实收',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '订单状态(0禁用,1待支付,2已完成,3取消)',
        ];
    }
}
