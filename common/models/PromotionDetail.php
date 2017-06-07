<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promotion_detail".
 *
 * @property integer $id
 * @property integer $promotion_id
 * @property integer $type
 * @property string $promotion_detail_name
 * @property integer $is_one
 * @property integer $brand_id
 * @property integer $good_id
 * @property string $effective_time
 * @property string $expiration_time
 * @property integer $limited
 * @property integer $is_discount
 * @property integer $amount
 * @property integer $discount
 * @property string $create_time
 * @property string $update_time
 * @property integer $mall_store_id
 * @property integer $status
 * @property integer $total_number
 * @property integer $remaining_number
 * @property integer $used_number
 * @property integer $for_register
 * @property integer $for_mall_display
 */
class PromotionDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.promotion_detail';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['limited'], 'safe',
                'when' => function($model) {
                    return $model->type==1;
                },'enableClientValidation'=>false
            ],
            [['promotion_id', 'type', 'is_one', 'brand_id', 'limited','good_id','is_discount', 'amount', 'discount', 'mall_store_id', 'status', 'total_number', 'remaining_number', 'used_number', 'for_register', 'for_mall_display'], 'integer'],

            [['effective_time', 'expiration_time', 'create_time', 'update_time'], 'safe'],
            [['promotion_detail_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promotion_id' => '优惠券礼包id',
            'type' => '优惠类型',
            'promotion_detail_name' =>'优惠券名称',
            'is_one' => '仅能使用一次',
            'brand_id' => '品牌id',
            'good_id' => '商品id',
            'effective_time' => '生效时间',
            'expiration_time' => '过期时间',
            'limited' => '满多少可使用',
            'is_discount' => '折扣方式',
            'amount' => '满减金额',
            'discount' => '折扣率',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
        ];
    }

    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
            'type'=> [
                '1'=>'欧币',
                '2'=>'通用券',
                '3'=>'品牌券',
                '5'=>'商品券',

            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
