<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_mall_commission".
 *
 * @property integer $id
 * @property integer $good_id
 * @property integer $store_id
 * @property integer $commission
 * @property integer $non_self_commission
 */
class GoodsMallCommission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_mall_commission';
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
            [['good_id', 'store_id', 'commission', 'non_self_commission'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'good_id' => '商品id',
            'store_id' => '店铺id',
            'commission' => '自有库存分佣',
            'non_self_commission' => '非自有库存分佣',
        ];
    }
}
