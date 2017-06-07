<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "after_sales".
 *
 * @property integer $id
 * @property integer $order_object_id
 * @property integer $order_info_id
 * @property string $order_info_sn
 * @property integer $order_detail_id
 * @property integer $user_id
 * @property integer $product_id
 * @property string $product_bn
 * @property integer $quantity
 * @property string $after_sn
 * @property string $user_refund_reason
 * @property string $user_first_reason
 * @property string $supplementary_reason
 * @property integer $refund_money
 * @property integer $refund_cash_money
 * @property string $img_proof1
 * @property string $img_proof2
 * @property string $img_proof3
 * @property integer $store_id
 * @property string $store_refuse_reason
 * @property string $store_refuse_reason1
 * @property integer $is_refund
 * @property integer $type
 * @property integer $send_back
 * @property string $courier_company
 * @property string $courier_company_en
 * @property string $courier_number
 * @property string $create_time
 * @property string $update_time
 * @property integer $platform_opinion
 * @property integer $before_order_status
 * @property integer $status
 * @property string $refund_id
 * @property integer $pay_type
 * @property integer $app_id
 */
class AfterSales extends \yii\db\ActiveRecord
{
    const STATUS= [
        '0'=>'平台拒绝',
        '1'=>'待处理',
        '2'=>'已同意',
        '3'=>'已完成',
        '4'=>'已拒绝',
    ];
    const IS_REFUND = [
        '1'=>'仅退款',
        '2'=>'退货退款',
    ];
    const PAY_TYPE = [
        '1'=>'微信支付',
        '2'=>'支付宝支付',
        '3'=>'公众号支付',
        '4'=>'景豆支付'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.after_sales';
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
            [['order_object_id', 'order_info_id', 'order_detail_id', 'user_id', 'product_id', 'quantity', 'refund_money', 'refund_cash_money', 'store_id', 'is_refund', 'type', 'send_back', 'platform_opinion', 'before_order_status', 'status', 'pay_type',], 'integer'],
            [['create_time', 'update_time','app_id'], 'safe'],
            [['order_info_sn'], 'string', 'max' => 100],
            [['product_bn', 'after_sn', 'courier_company', 'courier_company_en', 'courier_number', 'refund_id'], 'string', 'max' => 50],
            [['user_refund_reason', 'user_first_reason', 'supplementary_reason', 'img_proof1', 'img_proof2', 'img_proof3', 'store_refuse_reason', 'store_refuse_reason1'], 'string', 'max' => 255],
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
            'order_info_id' => '子订单ID',
            'order_info_sn' => '子订单号',
            'order_detail_id' => '订单详情ID',
            'user_id' => '用户ID',
            'product_id' => '货品ID',
            'product_bn' => '货号',
            'quantity' => '商品数量',
            'after_sn' => '售后单号',
            'user_refund_reason' => '用户退款理由',
            'user_first_reason' => '用户首次填写的说明',
            'supplementary_reason' => '用户退款补充说明（申诉时）',
            'refund_money' => '退款金额',
            'refund_cash_money' => '退款欧币',
            'img_proof1' => 'Img Proof1',
            'img_proof2' => 'Img Proof2',
            'img_proof3' => 'Img Proof3',
            'store_id' => '店铺ID',
            'store_refuse_reason' => '商户理由',
            'store_refuse_reason1' => '拒绝申诉的理由',
            'is_refund' => '售后类型',
            'type' => '售后类型',
            'send_back' => '是否回寄',
            'courier_company' => '快递公司',
            'courier_company_en' => '快递公司编号',
            'courier_number' => '快递单号',
            'create_time' => '创建时间',
            'update_time' => '处理时间',
            'platform_opinion' => '平台意见',
            'before_order_status' => '发起售后时的订单状态',
            'status' => '状态',
            'refund_id' => '退款流水号',
            'pay_type' => '支付方式',
            'app_id' => 'App ID',
        ];
    }

    public static function dropDown($column,$value=null){
        $dropDownList=[
            'status'=>self::STATUS,
            'is_refund'=>self::IS_REFUND,
            'pay_type'=>self::PAY_TYPE
        ];
        if ($value!==null){
            return array_key_exists($column,$dropDownList)? $dropDownList[$column][$value]:false;
        }else{
            return array_key_exists($column,$dropDownList)? $dropDownList[$column]:false;
        }
    }

    public function getOrder_object()
    {
        return $this->hasOne(OrderObject::className(),['id'=>'order_object_id']);
    }

    public function getC_user()
    {
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }
    public function getStore()
    {
        return $this->hasOne(Store::className(),['id'=>'store_id']);
    }
}
