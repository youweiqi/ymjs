<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_info".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $user_id
 * @property integer $order_object_id
 * @property integer $store_id
 * @property string $store_name
 * @property string $store_province
 * @property string $store_city
 * @property string $store_area
 * @property string $store_address
 * @property double $store_lon
 * @property double $store_lat
 * @property string $settlement_man
 * @property string $settlement_account
 * @property string $settlement_bank
 * @property integer $total_price
 * @property integer $total_settlement_price
 * @property integer $total_cooperate_price
 * @property integer $cash_coin
 * @property integer $promotion_id
 * @property integer $promotion_discount
 * @property integer $total_fee
 * @property integer $commision_fee
 * @property string $pay_time
 * @property integer $pay_type
 * @property string $express_name
 * @property string $express_code
 * @property string $express_no
 * @property string $complete_time
 * @property integer $member_delivery_address_id
 * @property integer $delivery_way
 * @property integer $is_bill
 * @property integer $bill_type
 * @property string $bill_header
 * @property integer $freight
 * @property integer $payment_fee
 * @property string $link_man
 * @property string $mobile
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $street
 * @property string $address
 * @property double $lon
 * @property double $lat
 * @property string $refund_date
 * @property integer $refund_fee
 * @property integer $refund_cash_coin
 * @property string $remark
 * @property string $back_remark
 * @property integer $in_state
 * @property string $in_date
 * @property string $in_verification
 * @property integer $procedure_fee
 * @property integer $bank_in
 * @property string $pay_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $refund
 * @property integer $comment_status
 * @property integer $type
 * @property integer $app_id
 * @property integer $mall_store_id
 * @property integer $active_status
 * @property integer $active_user_id
 * @property integer $team_id
 * @property integer $send_goods_bauser_id
 */
class OrderInfo extends \yii\db\ActiveRecord
{
    const STATUS = [
        '0'=>'禁用',
        '1'=>'待支付',
        '2'=>'待发货',
        '3'=>'待收货',
        '4'=>'已完成',
        '5'=>'取消',
        '6'=>'交易成功',
        '7'=>'交易失败',
        '8'=>'待拼团'
    ];
    const ACTIVE_STATUS = [
        '0'=>'待分派',
        '1'=>'待审核',
        '2'=>'待打印',
        '3'=>'待校验',
        '4'=>'待发货',

    ];
    const PAY_TYPE = [
        '1'=>'微信支付',
        '2'=>'支付宝支付',
        '3'=>'公众号支付',
        '4'=>'景豆支付',
        '5'=>'蚂蚁钱包'
    ];
    const STORE_TYPE = [
        '1'=>'直营店',
        '2'=>'加盟店',
        '3'=>'电商店'
    ];
    const DELIVERY_WAY= [
        '1'=>'及时送',
        '2'=>'到店取',
        '3'=>'快递送'
    ];
    const REFUND= [
    '0'=>'否',
    '1'=>'是',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.order_info';
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
            [['order_sn', 'user_id', 'settlement_man', 'settlement_account', 'settlement_bank'], 'required'],
            [['team_id','active_user_id','user_id', 'order_object_id', 'store_id', 'total_price', 'total_settlement_price', 'total_cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'commision_fee', 'pay_type', 'member_delivery_address_id', 'delivery_way', 'is_bill', 'bill_type', 'freight', 'payment_fee', 'refund_fee', 'refund_cash_coin', 'in_state', 'procedure_fee', 'bank_in', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id', 'send_goods_bauser_id','active_status'], 'integer'],
            [['store_lon', 'store_lat', 'lon', 'lat'], 'number'],
            [['api_order_sn','pay_time', 'complete_time', 'refund_date', 'in_date', 'create_time', 'update_time'], 'safe'],
            [['order_sn', 'store_name', 'store_address', 'settlement_account', 'express_name', 'express_no', 'bill_header'], 'string', 'max' => 100],
            [['store_province', 'store_city', 'store_area', 'settlement_man', 'mobile', 'province', 'city', 'area', 'in_verification'], 'string', 'max' => 30],
            [['settlement_bank', 'street', 'pay_id'], 'string', 'max' => 50],
            [['express_code', 'address'], 'string', 'max' => 255],
            [['link_man'], 'string', 'max' => 20],
            [['remark', 'back_remark'], 'string', 'max' => 200],
            [['order_sn'], 'unique'],
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
            'user_id' => '用户id',
            'order_object_id' => '父订单id',
            'store_id' => '店铺id',
            'store_name' => '店铺名称',
            'store_province' => '店铺省',
            'store_city' => '店铺所在城市',
            'store_area' => '店铺所在地区',
            'store_address' => '店铺所在街道',
            'store_lon' => '店铺经度',
            'store_lat' => '店铺纬度',
            'settlement_man' => '店铺结算人',
            'settlement_account' => '店铺结算账户',
            'settlement_bank' => '结算银行',
            'total_price' => '实际售价',
            'total_settlement_price' => '结算成本价',
            'total_cooperate_price' => '异业合作价',
            'cash_coin' => '平均现金币',
            'promotion_id' => '优惠劵id',
            'promotion_discount' => '平均优惠劵抵扣金额',
            'total_fee' => '实际支付金额',
            'commision_fee' => '订单总分佣',
            'pay_time' => '子订单支付时间',
            'pay_type' => '支付方式',
            'express_name' => '快递公司',
            'express_code' => '快递公司英文名',
            'express_no' => '快递号',
            'complete_time' => '子订单完成时间',
            'member_delivery_address_id' => '用户配送地址id',
            'delivery_way' => '配送方式',
            'is_bill' => '是否开票',
            'bill_type' => '发票类型(1.个人2.公司)',
            'bill_header' => '发票抬头',
            'freight' => '运费',
            'payment_fee' => '支付回调金额',
            'link_man' => '联系人',
            'mobile' => '手机号',
            'province' => '省份',
            'city' => '市',
            'area' => '区县',
            'street' => '街道',
            'address' => '地址',
            'lon' => '经度',
            'lat' => '纬度',
            'refund_date' => '退款日期',
            'refund_fee' => '退款金额',
            'refund_cash_coin' => '退款现金币金额',
            'remark' => '订单备注',
            'back_remark' => '后台运营备注',
            'in_state' => '（收入）是否核销 0 未核销,1已核销',
            'in_date' => '收款日期',
            'in_verification' => '收入核销人',
            'procedure_fee' => '手续费',
            'bank_in' => '银行实收',
            'pay_id' => '支付流水号',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '订单状态',
            'refund' => '售后中',
            'comment_status' => '评价状态',
            'type' => '类型',
            'app_id' => 'App ID',
            'mall_store_id' => 'Mall Store ID',
            'send_goods_bauser_id' => '发货人id',
            'api_order_sn'=>'Api订单号',
            'active_status' => '操作状态',
            'team_id' => '确认小组',
            'active_user_id' => '确认人'
        ];
    }

    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> self::STATUS,
            'active_status'=> self::ACTIVE_STATUS,
            'pay_type'=> self::PAY_TYPE,
            'store_type'=> self::STORE_TYPE,
            'delivery_way'=> self::DELIVERY_WAY,
            'refund'=>self::REFUND,
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }


    public function getC_user(){
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }
    public function getOrder_object(){
        return $this->hasOne(OrderObject::className(),['id'=>'order_object_id']);
    }
}
