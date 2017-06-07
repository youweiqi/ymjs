<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_object_id
 * @property integer $user_id
 * @property integer $brand_id
 * @property string $brand_name
 * @property integer $good_id
 * @property string $good_name
 * @property string $label_name
 * @property integer $product_id
 * @property string $spec_name
 * @property string $navigate_img1
 * @property integer $store_id
 * @property integer $inventory_id
 * @property integer $channel
 * @property integer $product_price
 * @property integer $sale_price
 * @property integer $settlement_price
 * @property integer $cooperate_price
 * @property integer $quantity
 * @property integer $total_price
 * @property integer $total_settlementprice
 * @property integer $total_cooperate_price
 * @property integer $total_fee
 * @property integer $cash_coin
 * @property integer $promotion_discount
 * @property integer $talent_serial_id
 * @property integer $talent_share_good_id
 * @property integer $talent_serial_editandshare_id
 * @property integer $share_serial_id
 * @property integer $share_activity_id
 * @property integer $talent_id
 * @property integer $discount
 * @property integer $talent_agio
 * @property integer $applywelfare_id
 * @property integer $activity_type
 * @property integer $group_buying_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $refund
 * @property integer $comment_status
 * @property integer $type
 * @property integer $app_id
 * @property integer $mall_store_id
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.order_detail';
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
            [['order_id', 'order_object_id', 'user_id', 'brand_id', 'good_id', 'product_id', 'store_id', 'inventory_id', 'channel', 'product_price', 'sale_price', 'settlement_price', 'cooperate_price', 'quantity', 'total_price', 'total_settlementprice', 'total_cooperate_price', 'total_fee', 'cash_coin', 'promotion_discount', 'talent_serial_id', 'talent_share_good_id', 'talent_serial_editandshare_id', 'share_serial_id', 'share_activity_id', 'talent_id', 'discount', 'talent_agio', 'applywelfare_id', 'activity_type', 'group_buying_id', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id'], 'integer'],
            [['good_name'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['brand_name', 'good_name', 'label_name'], 'string', 'max' => 100],
            [['spec_name', 'navigate_img1'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '子订单id',
            'order_object_id' => '父订单id',
            'user_id' => '用户id',
            'brand_id' => '品牌id',
            'brand_name' => '品牌名称',
            'good_id' => '商品id',
            'good_name' => '商品名称',
            'label_name' => '商品别名',
            'product_id' => '货品id',
            'spec_name' => '商品规格名称组合',
            'navigate_img1' => '商品图片介绍图1',
            'store_id' => '店铺id',
            'inventory_id' => '库存id',
            'channel' => '进货渠道 1电商；2门店；3海淘',
            'product_price' => '商品价格（没有任何优惠的价格）',
            'sale_price' => '当前售价',
            'settlement_price' => '当前结算成本价',
            'cooperate_price' => '异业合作价',
            'quantity' => '商品数量',
            'total_price' => '总售价',
            'total_settlementprice' => '总结算成本价',
            'total_cooperate_price' => '总异业合作价',
            'total_fee' => '实际支付金额',
            'cash_coin' => '现金币折扣',
            'promotion_discount' => '优惠劵折扣金额',
            'talent_serial_id' => '达人期编辑与分享id',
            'talent_share_good_id' => '分享商品id',
            'talent_serial_editandshare_id' => '达人期分享id',
            'share_serial_id' => '品牌期分享id',
            'share_activity_id' => '分享活动id',
            'talent_id' => '分享用户id',
            'discount' => '折扣%',
            'talent_agio' => '当前佣金比例',
            'applywelfare_id' => '活动id',
            'activity_type' => '活动类型(2.福利社 3体验 4拼团)',
            'group_buying_id' => '拼团id',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '订单状态(0禁用,1待支付,2待发货,3待收货,4已完成,5取消,6交易成功,7交易关闭,8待拼团)',
            'refund' => '售后中(0否 1是)',
            'comment_status' => '评价状态(0 未评价 1已评价)',
            'type' => '类型0自营1同行调货2异业',
            'app_id' => 'App ID',
            'mall_store_id' => 'Mall Store ID',
        ];
    }
    public function getOther()
    {
        return '';
    }
    public function getOrder_info()
    {
        return $this->hasOne(OrderInfo::className(), ['id' => 'order_id']);
    }
    public function getOrder_object()
    {
        return $this->hasOne(OrderObject::className(), ['id' => 'order_object_id']);
    }
    public function getc_user()
    {
        return $this->hasOne(CUser::className(), ['id' => 'user_id']);
    }
}
