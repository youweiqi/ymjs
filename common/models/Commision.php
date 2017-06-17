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
            'type' => '分佣级别',
            'comment' => '备注',
            'fee' => '分佣金额',
            'result_time' => '分佣处理时间',
            'result' => '结果',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
        ];
    }
    public function getOrder_info(){
        return $this->hasOne(OrderInfo::className(),['id'=>'order_info_id']);
    }

    public function getOrder_object(){
        return $this->hasOne(OrderObject::className(),['id'=>'order_object_id']);
    }

    public function getC_user(){
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }
    public function getC_role(){
        return $this->hasOne(CRole::className(),['level'=>'type']);
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'使用',
            ],
            'result'=>[
                '0'=>'未处理',
                '1'=>'已处理'
            ]
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }

}
