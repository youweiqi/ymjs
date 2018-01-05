<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $store_name
 * @property integer $money
 * @property string $logo_path
 * @property string $back_image_path
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $settlement_account
 * @property string $settlement_bank
 * @property string $settlement_man
 * @property integer $settlement_interval
 * @property integer $open_flash_express
 * @property string $flash_express_begin_time
 * @property string $flash_express_end_time
 * @property integer $open_install
 * @property string $install_begin_time
 * @property string $install_end_time
 * @property integer $open_express
 * @property integer $store_type
 * @property integer $is_show_commit
 * @property integer $is_show_map
 * @property integer $is_modify_inventory
 * @property string $tel
 * @property integer $checkout_type
 * @property integer $commisionlimit
 * @property double $lon
 * @property double $lat
 * @property integer $price_no_freight
 * @property integer $cooperate_type
 * @property integer $agent_user_id
 * @property integer $agent_user_id3
 * @property integer $agent_user_id6
 * @property integer $commision_target
 * @property integer $sale_target
 * @property string $channel
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property string $qr_code
 * @property double $distance
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store';
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
        $attributes = ['brand_ids'];
        return array_merge(parent::attributes(),$attributes);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id','settlement_interval', 'open_flash_express', 'open_install', 'open_express', 'store_type', 'is_show_commit', 'is_show_map', 'is_modify_inventory', 'checkout_type', 'commisionlimit',  'cooperate_type', 'agent_user_id', 'agent_user_id3', 'agent_user_id6', 'commision_target', 'sale_target', 'status'], 'integer'],
            [['brand_ids','flash_express_begin_time', 'flash_express_end_time', 'install_begin_time', 'install_end_time', 'create_time', 'update_time'], 'safe'],
            [['lon', 'lat', 'distance'], 'number'],
            [['store_name', 'settlement_man', 'qr_code'], 'string', 'max' => 100],
            [['logo_path', 'back_image_path', 'province', 'city', 'area', 'address', 'settlement_account'], 'string', 'max' => 255],
            [['settlement_bank'], 'string', 'max' => 120],
            [['tel'], 'string', 'max' => 25],
            [['channel'], 'string', 'max' => 20],
            [['money'], 'double', 'numberPattern' => '/^-?([1-9]\d*|0)(\.\d{1,2})?$/','message'=>'最多为两位小数'],
            [['price_no_freight'], 'double', 'numberPattern' => '/^([1-9]\d*|0)(\.\d{1,2})?$/','message'=>'最多为两位小数的正数'],
            [['open_express'],'requiredByOne'],
            ['logo_path','safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => '供应商id',
            'store_name' => '店铺名称',
            'money' => '门店虚拟金额',
            'logo_path' => '店铺logo',
            'back_image_path' => '背景图片',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address' => '地址',
            'settlement_account' => '结算账户',
            'settlement_bank' => '结算银行',
            'settlement_man' => '结算人',
            'settlement_interval' => '结算周期（天）',
            'open_flash_express' => '是否及时送',
            'flash_express_begin_time' => '及时送开始时间',
            'flash_express_end_time' => '及时送结束时间',
            'open_install' => '是否到店取',
            'install_begin_time' => '到店取开始时间',
            'install_end_time' => '到店取结束时间',
            'open_express' => '是否开通快递送',
            'store_type' => '店铺类型',
            'is_show_commit' => '是否返佣',
            'is_show_map' => '是否显示在地图上',
            'is_modify_inventory' => '是否可修改库存',
            'tel' => '店铺电话',
            'checkout_type' => '是否可修改价格',
            'commisionlimit' => 'APP下单最低佣金比率',
            'lon' => '经度',
            'lat' => '纬度',
            'price_no_freight' => '满多少包邮',
            'cooperate_type' => '异业类型(0商品,1库存)',
            'agent_user_id' => '门店代理人用户id',
            'agent_user_id3' => '门店代理人3用户id',
            'agent_user_id6' => '门店代理人6用户id',
            'commision_target' => '分佣目标',
            'sale_target' => '销售额目标',
            'channel' => '进货渠道',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
            'qr_code' => '店铺二维码图片上传后的地址',
            'distance' => '及时送距离',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [

            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
            'channel'=>[
                '1'=>'电商',
                '2'=>'门店',
                '3'=>'海淘'
            ],
            'store_type'=>[
                '1'=>'直营店',
                '2'=>'加盟店',
                '3'=>'电商店'
            ]
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id'])->viaTable('yg_goods.store_brand', ['store_id' => 'id']);
    }

    public function requiredByOne($attribute, $params)
    {
        if($this->$attribute=='0'&&$this->open_install=='0'&&$this->open_flash_express=='0'){
            $this->addError($attribute, "配送方式不能都关闭");
        }
    }

}
