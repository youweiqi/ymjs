<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "hot_business_district_v2".
 *
 * @property int $id
 * @property string $businessDistrictName 店铺名称
 * @property string $bdBigImgPath 商圈大图
 * @property string $bdSmallImgPath 商圈小图
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $address 地址
 * @property double $lat 经度
 * @property double $lng 纬度
 * @property int $isRecommend 是否推荐(0.不推荐1.推荐)
 * @property int $state 商圈状态： 0停用1启用
 */
class HotBusinessDistrictV2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration.hot_business_district_v2';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_migration');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['businessDistrictName'], 'required'],
            [['lat', 'lng'], 'number'],
            [['isRecommend', 'state'], 'integer'],
            [['businessDistrictName', 'bdBigImgPath', 'bdSmallImgPath', 'province', 'city', 'area', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'businessDistrictName' => '店铺名称',
            'bdBigImgPath' => '商圈大图',
            'bdSmallImgPath' => '商圈小图',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address' => '地址',
            'lat' => '经度',
            'lng' => '纬度',
            'isRecommend' => '是否推荐(0.不推荐1.推荐)',
            'state' => '商圈状态： 0停用1启用',
        ];
    }
}
