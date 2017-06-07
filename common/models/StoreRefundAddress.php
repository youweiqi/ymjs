<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_refund_address".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $link_man
 * @property string $mobile
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class StoreRefundAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_refund_address';
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
            [['store_id'],'unique','message'=>'该店铺已经存在退货地址'],
            [['store_id','status','province','city','area','address'],'required'],
            [['store_id', 'status','mobile'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['link_man', 'mobile', 'province', 'city', 'area', 'address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '店铺id',
            'link_man' => '联系人',
            'mobile' => '手机号码',
            'province' => '省份',
            'city' => '城市',
            'area' => '区县',
            'address' => '详细收货地址',
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
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }

    public function getStore(){
        return $this->hasOne(Store::className(),['id'=>'store_id']);
    }
}
