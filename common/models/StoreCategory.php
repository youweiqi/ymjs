<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_category".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $parent_category_id
 * @property integer $category_id
 */
class StoreCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_category';
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
            [['store_id', 'parent_category_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长',
            'store_id' => '店铺ID',
            'parent_category_id' => '2级分类ID',
            'category_id' => '3级分类ID',
        ];
    }
}
