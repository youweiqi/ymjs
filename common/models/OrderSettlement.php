<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_settlement".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $order_detail_id
 * @property integer $type
 * @property integer $order_status
 * @property string $pay_time
 * @property integer $user_id
 * @property string $product_bn
 * @property string $good_name
 * @property integer $good_id
 * @property integer $total_price
 * @property integer $total_settlementprice
 * @property integer $total_cooperate_price
 * @property integer $quantity
 * @property integer $sale_price
 * @property integer $settlement_price
 * @property integer $cooperate_price
 * @property integer $cash_coin
 * @property integer $promotion_id
 * @property integer $promotion_discount
 * @property integer $total_fee
 * @property integer $operate_costing
 * @property integer $pay_type
 * @property string $link_man
 * @property string $mobile
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $street
 * @property string $address
 * @property integer $delivery_way
 * @property string $express_type
 * @property string $express_no
 * @property integer $store_id
 * @property string $order_create_time
 * @property string $order_update_time
 * @property string $complete_date
 * @property string $remark
 * @property string $settlement_man
 * @property string $settlement_account
 * @property string $settlement_bank
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $after_order_status
 * @property integer $order_type
 * @property integer $app_id
 * @property integer $mall_store_id
 * @property integer $freight
 * @property integer $gy_settle_accounts
 * @property integer $store_agent_settle_accounts
 * @property integer $store_agent_user_id
 * @property integer $store_agent_user_id3
 * @property integer $store_agent_settle_accounts3
 * @property integer $store_agent_user_id6
 * @property integer $store_agent_settle_accounts6
 * @property integer $ccpp_settle_accounts
 */
class OrderSettlement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.order_settlement';
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
            [['order_sn', 'order_detail_id', 'user_id', 'product_bn', 'good_name', 'good_id', 'total_price', 'total_settlementprice', 'quantity', 'sale_price', 'settlement_price', 'total_fee', 'operate_costing', 'link_man', 'mobile', 'store_id', 'settlement_man', 'settlement_account', 'settlement_bank'], 'required'],
            [['order_detail_id', 'type', 'order_status', 'user_id', 'good_id', 'total_price', 'total_settlementprice', 'total_cooperate_price', 'quantity', 'sale_price', 'settlement_price', 'cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'operate_costing', 'pay_type', 'delivery_way', 'store_id', 'status', 'after_order_status', 'order_type', 'app_id', 'mall_store_id', 'freight', 'gy_settle_accounts', 'store_agent_settle_accounts', 'store_agent_user_id', 'store_agent_user_id3', 'store_agent_settle_accounts3', 'store_agent_user_id6', 'store_agent_settle_accounts6', 'ccpp_settle_accounts'], 'integer'],
            [['pay_time', 'order_create_time', 'order_update_time', 'complete_date', 'create_time', 'update_time'], 'safe'],
            [['remark'], 'string'],
            [['order_sn', 'good_name', 'express_type', 'express_no', 'settlement_account'], 'string', 'max' => 100],
            [['product_bn', 'street', 'settlement_bank'], 'string', 'max' => 50],
            [['link_man'], 'string', 'max' => 20],
            [['mobile', 'province', 'city', 'area', 'settlement_man'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '子订单号',
            'order_detail_id' => '订单商品详情id',
            'type' => '结算类型（0售后结算 1正常结算）',
            'order_status' => '子订单状态',
            'pay_time' => '子订单支付时间',
            'user_id' => '用户ID',
            'product_bn' => '货号',
            'good_name' => '商品名称',
            'good_id' => '商品ID',
            'total_price' => '总售价',
            'total_settlementprice' => '总结算成本价',
            'total_cooperate_price' => '总异业合作价',
            'quantity' => '商品数量',
            'sale_price' => '当前售价',
            'settlement_price' => '当前结算成本价',
            'cooperate_price' => '当前异业合作价',
            'cash_coin' => '平均现金币',
            'promotion_id' => '优惠券ID',
            'promotion_discount' => '平均优惠券抵扣额',
            'total_fee' => '实际支付金额',
            'operate_costing' => '运营成本',
            'pay_type' => '支付方式',
            'link_man' => '联系人',
            'mobile' => '联系电话',
            'province' => '省',
            'city' => '城市',
            'area' => '区县',
            'street' => '街道',
            'address' => '地址',
            'delivery_way' => '配送方式',
            'express_type' => '快递公司',
            'express_no' => '快递单号',
            'store_id' => '店铺ID',
            'order_create_time' => '子订单创建时间',
            'order_update_time' => '订单更新时间',
            'complete_date' => '订单完成时间',
            'remark' => '订单备注',
            'settlement_man' => '店铺结算人',
            'settlement_account' => '店铺结算账户',
            'settlement_bank' => '结算银行',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '状态（0禁用 1未结算 2已结算3已结算到虚拟账户4已结算ccpp）',
            'after_order_status' => '下单后处理状态(1未处理2已处理3回退)',
            'order_type' => '类型0自营1同行调货2异业',
            'app_id' => 'App ID',
            'mall_store_id' => 'Mall Store ID',
            'freight' => '运费',
            'gy_settle_accounts' => '贡云结算价',
            'store_agent_settle_accounts' => '门店代理人结算价',
            'store_agent_user_id' => '门店代理人id',
            'store_agent_user_id3' => 'Store Agent User Id3',
            'store_agent_settle_accounts3' => 'Store Agent Settle Accounts3',
            'store_agent_user_id6' => 'Store Agent User Id6',
            'store_agent_settle_accounts6' => 'Store Agent Settle Accounts6',
            'ccpp_settle_accounts' => 'ccpp结算价',
        ];
    }
}
