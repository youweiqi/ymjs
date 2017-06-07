<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "business_circle".
 *
 * @property integer $id
 * @property string $circle_name
 * @property string $back_image_path
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property double $lon
 * @property double $lat
 * @property integer $radiation_raidus
 * @property integer $advertising
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class BusinessCircle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.business_circle';
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
            [['lon', 'lat'], 'number'],
            [['radiation_raidus', 'advertising', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['circle_name'], 'string', 'max' => 100],
            [['back_image_path'], 'string', 'max' => 255],
            [['province', 'city', 'area','address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'circle_name' => '商圈名称',
            'back_image_path' => '背景图片',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address'=>'详细地址',
            'lon' => '经度',
            'lat' => '纬度',
            'radiation_raidus' => '辐射半径(米)',
            'advertising' => '广告位(倒序)',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用'
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
