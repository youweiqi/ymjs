<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_cooperate_goods".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property integer $store_id
 * @property integer $good_id
 * @property string $create_time
 */
class StoreCooperateGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_cooperate_goods';
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
            [['brand_id', 'store_id', 'good_id'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => '品牌id',
            'store_id' => '门店id',
            'good_id' => '商品id',
            'create_time' => '创建时间',
        ];
    }
}
