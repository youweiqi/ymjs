<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $goods_code
 * @property integer $brand_id
 * @property string $name
 * @property string $spec_desc
 * @property string $service_desc
 * @property string $label_name
 * @property integer $suggested_price
 * @property integer $lowest_price
 * @property string $unit
 * @property string $remark
 * @property integer $category_parent_id
 * @property integer $category_id
 * @property string $online_time
 * @property string $offline_time
 * @property integer $talent_limit
 * @property integer $threshold
 * @property integer $ascription
 * @property integer $talent_display
 * @property integer $discount
 * @property integer $operate_costing
 * @property integer $score_rate
 * @property integer $self_support
 * @property string $create_time
 * @property string $wx_small_imgpath
 * @property integer $channel
 * @property integer $api_goods_id
 */
class Goods extends \yii\db\ActiveRecord
{
    const SCENARIO_NEW_CREATE = 'new_create';
    const SCENARIO_NEW_UPDATE = 'new_update';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_ONE = 'one';
    const SCENARIO_TWO = 'two';
    const SCENARIO_THREE = 'three';
    const CHANNEL = [
        '1'=>'电商',
        '2'=>'门店',
        '3'=>'海淘'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }
    public function attributes()
    {
        $attributes = ['service_ids','classify_id','spec_id','store','store_ids'];
        return array_merge(parent::attributes(),$attributes);
    }
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_ONE => ['label_name','goods_code','brand_id','name','suggested_price', 'category_parent_id', 'category_id', 'ascription','service_desc','service_ids','channel'],
            self::SCENARIO_CREATE => ['goods_code','brand_id','name', 'label_name','suggested_price', 'category_parent_id',
                'category_id', 'ascription','service_desc','service_ids','classify_id','spec_id'],
            self::SCENARIO_UPDATE => ['goods_code','brand_id','name', 'label_name','suggested_price', 'category_parent_id',
                'category_id', 'ascription','service_desc','service_ids','self_support'],
            self::SCENARIO_NEW_CREATE => ['label_name','goods_code','brand_id','name','suggested_price', 'category_parent_id', 'category_id', 'ascription','service_desc','service_ids','channel','spec_desc'],
            self::SCENARIO_NEW_UPDATE=> ['label_name','goods_code','brand_id','name','suggested_price', 'category_parent_id', 'category_id', 'ascription','service_desc','service_ids','channel','spec_desc'],

        ];
        return array_merge(parent::scenarios(),$scenarios);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_code', 'brand_id', 'name', 'category_parent_id', 'category_id', 'ascription', 'channel'], 'required'],
            [['brand_id', 'lowest_price', 'category_parent_id', 'category_id', 'talent_limit', 'threshold', 'ascription', 'talent_display', 'discount', 'operate_costing', 'score_rate', 'self_support', 'channel','api_goods_id'], 'integer'],
            [['spec_desc', 'service_desc', 'remark'], 'string'],
            [['service_ids','online_time', 'offline_time', 'create_time'], 'safe'],
            [['goods_code', 'name'], 'string', 'max' => 100],
            [['label_name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 20],
            [['wx_small_imgpath'], 'string', 'max' => 500],
            [['suggested_price'], 'double', 'numberPattern' => '/^([1-9]\d*|0)(\.\d{1,2})?$/','message'=>'必须为最多两位小数的正数'],
            [['talent_limit','score_rate'],'compare','compareValue' => 100, 'operator' => '<='],
            [['talent_limit','score_rate'],'compare','compareValue' => 0, 'operator' => '>=']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品ID',
            'goods_code' => '商品编码',
            'brand_name' => '品牌',
            'name' => '商品名称',
            'spec_desc' => '商品使用规格值序列化',
            'service_desc' => '服务json实例化',
            'label_name' => '商品别名',
            'suggested_price' => '建议售价(元)',
            'lowest_price' => '最低价格',
            'unit' => '商品单位',
            'remark' => '备注',
            'category_parent_id' => '父分类',
            'category_id' => '分类',
            'online_time' => '上线时间',
            'offline_time' => '下线时间',
            'talent_limit' => '会员佣金比例(%)',
            'threshold' => '阈值',
            'ascription' => '商品归属分类',
            'talent_display' => '当（ascription为1必选）达人app显示 1是 0 否',
            'discount' => '折扣率',
            'operate_costing' => '运营成本',
            'score_rate' => '返欧币比例(%)',
            'self_support' => '是否自营',
            'create_time' => '创建时间',
            'wx_small_imgpath' => '商品分享的微信小图',
            'channel' => '进货渠道',
            'api_goods_id' => '第三方商品ID'
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'channel'=> self::CHANNEL,
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
    /**
     * 关联品牌表
     * @return mixed
     */

    public function getBrand()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    public function getProduct()
    {
        return $this->hasOne(Product::className(),['goods_id'=>'id']);
    }
    /**
     * 关联goods_navigate表
     * @return mixed
     */
    public function getGoods_navigate()
    {
        return $this->hasMany(GoodsNavigate::className(),['good_id'=>'id']);
    }
    public function getGoods_commission()
    {
        return $this->hasOne(GoodsCommission::className(),['good_id'=>'id']);
    }
    public function getCommission()
    {
        $model = $this->hasOne(GoodsCommission::className(),['good_id'=>'id'])->one();
        if($model) {
            return $model;
        }else{
            return (new GoodsCommission());
        }

    }


    /**
     * 通过商品ID获取商品编号
     * @param  integer $id
     * @return mixed
     */
    public static function getGoodsCodeById($id)
    {
        $goods = self::findOne($id);
        return empty($goods)?$id:$goods->goods_code;
    }
    /**
     * 通过规格的json串获取规格的ID数组
     * @param  string $spec_desc
     * @return mixed
     */
    public static function getSpecIdArr($spec_desc)
    {
        $spec_desc_arr = json_decode($spec_desc,true);
        $spec_id_arr['classify_id'] = $spec_desc_arr[0]['specificationId'];
        $spec_id_arr['spec_id'] = $spec_desc_arr[1]['specificationId'];
        return $spec_id_arr;

    }
    static public function getProductCodeName($product_code_id)
    {
        $product_code = self::findOne($product_code_id);
        if(empty($product_code)){
            return $product_code_id;
        }
        return $product_code->goods_code;
    }
    public function getCategory()
    {
        return $this->hasMany(Category::className(),['id'=>'id']);
    }

}
