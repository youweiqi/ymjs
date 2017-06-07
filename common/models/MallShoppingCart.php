<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mall_shopping_cart".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $good_id
 * @property integer $product_id
 * @property integer $inventory_id
 * @property integer $store_id
 * @property integer $product_num
 * @property integer $talent_share_good_id
 * @property integer $talent_id
 * @property integer $mall_store_id
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 */
class MallShoppingCart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.mall_shopping_cart';
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
            [['user_id', 'good_id', 'product_id', 'inventory_id', 'store_id', 'product_num', 'talent_share_good_id', 'talent_id', 'mall_store_id', 'type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'good_id' => '商品id',
            'product_id' => '货品id',
            'inventory_id' => '库存id',
            'store_id' => '店铺id',
            'product_num' => '货品数量',
            'talent_share_good_id' => '分享商品id',
            'talent_id' => '分享用户id',
            'mall_store_id' => '微商城门店id',
            'type' => '类型0自营1同行调货2异业',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
        ];
    }
}
