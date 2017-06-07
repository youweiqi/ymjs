<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_specification_images".
 *
 * @property integer $id
 * @property integer $specification_detail_id
 * @property integer $goods_id
 * @property string $image_path
 */
class GoodsSpecificationImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_specification_images';
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
            [['specification_detail_id', 'goods_id'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['specification_detail_id', 'goods_id'], 'unique', 'targetAttribute' => ['specification_detail_id', 'goods_id'], 'message' => 'The combination of 规格详情id and 商品id has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'specification_detail_id' => '规格详情id',
            'goods_id' => '商品id',
            'image_path' => '图片路径',
        ];
    }
}
