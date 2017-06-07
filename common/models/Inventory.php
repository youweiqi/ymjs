<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $goods_id
 * @property integer $store_id
 * @property integer $inventory_num
 * @property integer $lock_inventory_num
 * @property integer $sale_price
 * @property integer $settlement_price
 * @property integer $is_transfer
 * @property integer $cooperate_price
 * @property integer $is_cooperate
 * @property integer $disabled_cooperate
 * @property string $out_start_time
 * @property string $out_end_time
 * @property integer $can_use_membership_card
 * @property integer $status
 * @property integer $api_inventory_id
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.inventory';
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
            [['product_id', 'store_id', 'inventory_num', 'sale_price', 'settlement_price'], 'required'],
            [['product_id', 'store_id'], 'unique', 'targetAttribute' => ['product_id', 'store_id'],'message'=>'该仓库内已经存在该货号的货品。'],
            [['product_id', 'goods_id', 'store_id', 'inventory_num', 'api_inventory_id'], 'integer'],
            ['lock_inventory_num','safe'],
            [[ 'sale_price', 'settlement_price'], 'double', 'numberPattern' => '/^([1-9]\d*|0)(\.\d{1,2})?$/','message'=>'价格必须为最多两位小数的正数'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'product_id' => '货品',
            'goods_id' => '商品',
            'store_id' => '店铺',
            'inventory_num' => '库存',
            'lock_inventory_num' => '订单锁住库存',
            'sale_price' => '实际销售价',
            'settlement_price' => '结算价',
            'is_transfer' => '是否同行调货',
            'cooperate_price' => '异业合作价',
            'is_cooperate' => '是否异业合作',
            'disabled_cooperate' => '无效异业合作',
            'out_start_time' => '不可使用开始',
            'out_end_time' => '不可使用结束',
            'can_use_membership_card' => '是否可用会员卡',
            'status' => '状态',
            'api_inventory_id' => 'API库存ID',
        ];
    }

    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }

    public function getProduct(){
        return $this->hasOne(Product::className(),['id'=>'product_id']);
    }
    public function getStore(){
        return $this->hasOne(Store::className(),['id'=>'store_id']);
    }
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }
}
