<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $spec_info
 * @property string $spec_desc
 * @property string $spec_name
 * @property string $bar_code
 * @property string $product_bn
 * @property integer $supply_threshold
 * @property integer $is_stock_warn
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_del
 * @property integer $status
 * @property integer $api_product_id
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.product';
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
            [['goods_id', 'supply_threshold', 'is_stock_warn', 'is_del', 'status', 'api_product_id'], 'integer'],
            [['spec_info', 'spec_desc'], 'string'],
            [['product_bn'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['spec_name'], 'string', 'max' => 255],
            [['bar_code', 'product_bn'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'spec_info' => '商品规格id组',
            'spec_desc' => '商品规格json',
            'spec_name' => '商品规格名称组合',
            'bar_code' => '货品条码',
            'product_bn' => '货号',
            'supply_threshold' => '供货阈值',
            'is_stock_warn' => '是否缺货提醒：1提醒，0不提醒',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'is_del' => '是否逻辑删除',
            'status' => '状态',
            'api_product_id' => 'API货品ID',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'使用',
            ],
            'is_stock_warn'=>[
                '0'=>'否',
                '1'=>'是'
            ]
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
    public static function getProductBnById($product_id)
    {
        $product = self::findOne($product_id);

        if (is_object($product)) {
            return $product->product_bn;
        }else{
            return '';
        }
    }

    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }
}
