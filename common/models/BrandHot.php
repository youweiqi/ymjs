<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand_hot".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property string $logo_path
 * @property integer $order_no
 * @property string $brand_name
 */
class BrandHot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.brand_hot';
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
            [['brand_id', 'brand_name'], 'required'],
            [['brand_id', 'order_no'], 'integer'],
            [['logo_path'], 'string', 'max' => 255],
            [['brand_name'], 'string', 'max' => 32],
            ['brand_ids','checkBrand','skipOnEmpty' => false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => '品牌ID',
            'logo_path' => '品牌图',
            'order_no' => '排序',
            'brand_name' => '品牌名',
        ];
    }
    public function checkBrand($attribute, $params)
    {
        if(count($this->brand_ids)!=6){
            $this->addError($attribute, "热门品牌必须要选择6个");}
    }
}
