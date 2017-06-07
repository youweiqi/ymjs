<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand_search_word".
 *
 * @property integer $id
 * @property string $search_word
 * @property integer $search_number
 */
class BrandSearchWord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.brand_search_word';
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
            [['search_number'], 'integer'],
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
            'search_word' => '搜索词',
            'search_number' => '搜索次数',
        ];
    }
}
