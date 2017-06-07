<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_search_word".
 *
 * @property integer $id
 * @property string $search_word
 * @property integer $search_number
 * @property integer $store_id
 */
class GoodsSearchWord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_search_word';
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
            [['search_number', 'store_id'], 'integer'],
            [['search_word'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'search_word' => '搜索关键词',
            'search_number' => '搜索次数',
            'store_id' => '店铺ID',
        ];
    }
}
