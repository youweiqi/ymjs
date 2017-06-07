<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier_usually_goods".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $goods_id
 */
class SupplierUsuallyGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.supplier_usually_goods';
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
            [['supplier_id', 'goods_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => '供应商id',
            'goods_id' => '商品id',
        ];
    }
}
