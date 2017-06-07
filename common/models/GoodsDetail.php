<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_detail".
 *
 * @property integer $id
 * @property integer $good_id
 * @property string $image_path
 * @property integer $image_height
 * @property integer $image_width
 * @property integer $order_no
 */
class GoodsDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_detail';
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
            [['good_id', 'image_height', 'image_width', 'order_no'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
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
            'image_path' => '图片',
            'image_height' => '图片高',
            'image_width' => '图片宽',
            'order_no' => '排序',
        ];
    }
}
