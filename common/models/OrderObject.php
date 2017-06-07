<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order_object".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $user_id
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
 * @property integer $in_state
 * @property string $in_date
 * @property string $in_verification
 * @property integer $procedure_fee
 * @property integer $bank_in
 * @property integer $refund_start_time
 * @property string $pay_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $refund
 * @property integer $comment_status
 * @property integer $type
 * @property integer $app_id
 * @property integer $mall_store_id
 * @property string $open_id
 */
class OrderObject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.order_object';
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
            [['order_sn', 'user_id'], 'required'],
            [['user_id', 'total_price', 'total_settlement_price', 'total_cooperate_price', 'cash_coin', 'promotion_id', 'promotion_discount', 'total_fee', 'commision_fee', 'pay_type', 'member_delivery_address_id', 'delivery_way', 'is_bill', 'bill_type', 'freight', 'payment_fee', 'refund_fee', 'refund_cash_coin', 'in_state', 'procedure_fee', 'bank_in', 'refund_start_time', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id'], 'integer'],
            [['pay_time', 'refund_date', 'in_date', 'create_time', 'update_time'], 'safe'],
            [['lon', 'lat'], 'number'],
            [['order_sn', 'bill_header'], 'string', 'max' => 100],
            [['link_man'], 'string', 'max' => 20],
            [['mobile', 'province', 'city', 'area', 'in_verification'], 'string', 'max' => 30],
            [['street', 'pay_id'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['remark', 'open_id'], 'string', 'max' => 200],
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
            'total_price' => '总实际售价',
            'total_settlement_price' => '总结算成本价',
            'total_cooperate_price' => '总异业合作价',
            'cash_coin' => '现金币',
            'promotion_id' => '优惠劵id',
            'promotion_discount' => '优惠劵抵扣',
            'total_fee' => '总实际支付金额',
            'commision_fee' => '订单总分佣',
            'pay_time' => '订单支付时间',
            'pay_type' => '支付方式(1.微信支付2.支付宝支付3.公众号支付)',
            'member_delivery_address_id' => '用户配送地址id',
            'delivery_way' => '配送方式（1.及时送2.到店取3.快递送）',
            'is_bill' => '是否开票',
            'bill_type' => '发票类型(1.个人2.公司)',
            'bill_header' => '发票抬头',
            'freight' => '总运费',
            'payment_fee' => '总支付回调金额',
            'link_man' => '联系人',
            'mobile' => '联系电话',
            'province' => '省份',
            'city' => '市',
            'area' => '区县',
            'street' => '街道',
            'address' => '地址',
            'lon' => '经度',
            'lat' => '纬度',
            'refund_date' => '退款日期',
            'refund_fee' => '总退款金额',
            'refund_cash_coin' => '总退款现金币金额',
            'remark' => '订单备注',
            'in_state' => '（收入）是否核销 0 未核销,1已核销',
            'in_date' => '收款日期',
            'in_verification' => '收入核销人',
            'procedure_fee' => '手续费',
            'bank_in' => '银行实收',
            'refund_start_time' => '售后综合时间分钟',
            'pay_id' => '支付流水号',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '订单状态',
            'refund' => '售后中(0否 1是)',
            'comment_status' => '评价状态(0 可评价 1不可评价)',
            'type' => '类型0自营1同行调货2异业',
            'app_id' => 'App ID',
            'mall_store_id' => 'Mall Store ID',
            'open_id' => 'Open ID',
        ];
    }
    public static function dropDown ($column, $value = null)
    {
        $dropDownList = [
            "status"=> [
                "0"=>"禁用",
                "1"=>"待支付",
                "2"=>"待发货",
                "3"=>"待收货",
                "4"=>"已完成",
                "5"=>"取消",
                "6"=>"交易成功",
                "7"=>"交易失败",
                '8'=>'待拼团'
            ],
            'pay_type'=>[
                '1'=>'微信支付',
                '2'=>'支付宝支付',
                '3'=>'公众号支付',
                '20'=>'易宝微信支付',
                '21'=>'易宝支付宝支付',
                '22'=>'易宝公众号支付',
                '23'=>'易宝快捷支付',
            ],
            'is_bill'=>[
                '0'=>'否',
                '1'=>'是'
            ],
            'bill_type'=>[
                '1'=>'个人',
                '2'=>'公司'
            ],
            'refund'=>[
                '0'=>'否',
                '1'=>'是'
            ]

        ];
        if ($value !== null)
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        else
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
    }
    public function getC_user()
    {
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }

    public static function getObject_sn($order_object_id)
    {
        $object = self::findOne($order_object_id);
        return $object->order_sn;
    }

    public static function getOrderObjectByIds($ids)
    {
        $result = self::find()->where(['in','id',$ids])->asArray()->all();
        if(!empty($result))
        {
            return ArrayHelper::index($result,'id');
        }else{
            return [];
        }
    }

}
