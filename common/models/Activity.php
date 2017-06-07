<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property integer $good_id
 * @property integer $store_id
 * @property integer $sale_price
 * @property integer $total_inventory_num
 * @property string $start_time
 * @property string $end_time
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $num
 * @property string $show_time
 * @property integer $app_show
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.activity';
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
            [['good_id', 'store_id','total_inventory_num', 'type', 'status', 'num', 'app_show'], 'integer'],
            [['start_time', 'end_time', 'create_time', 'update_time', 'show_time'], 'safe'],
            [['type'], 'required'],
            ['num','required',
                'when'=>function($model){
                    return $model->type=='4';
                },'message'=>'拼团所需人数必填',],
            [['sale_price'], 'double', 'numberPattern' => '/^([1-9]\d*|0)(\.\d{1,2})?$/','message'=>'必须为最多两位小数的正数'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'good_id' => '商品id',
            'store_id' => '门店id',
            'sale_price' => '实际销售价',
            'total_inventory_num' => '活动总库存',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'type' => '类型',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '状态',
            'num' => '几人团',
            'show_time' => '秒杀提前显示时间',
            'app_show' => 'app是否显示',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用'
            ],
            'type'=> [
                '2'=>'福利社',
                '3'=>'体验',
                '4'=>'拼团',
                '5'=>'秒杀'
            ],
            'app_show'=> [
                '0'=>'不显示',
                '1'=>'显示'
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
    public function getStore()
    {
        return $this->hasOne(Store::className(),['id'=>'store_id']);
    }
    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'good_id']);
    }
}
