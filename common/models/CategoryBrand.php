<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_brand".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $category_parent_id
 * @property integer $brand_id
 */
class CategoryBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.category_brand';
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
            [['category_id'], 'required'],
            [['category_id', 'category_parent_id', 'brand_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '品牌父分类id',
            'category_parent_id' => '分类ID',
            'brand_id' => '品牌ID',
        ];
    }
}
