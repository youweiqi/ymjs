<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_navigate".
 *
 * @property integer $id
 * @property integer $good_id
 * @property string $navigate_image
 * @property integer $order_no
 */
class GoodsNavigate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_navigate';
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
            [['good_id', 'order_no'], 'integer'],
            [['navigate_image'], 'string', 'max' => 255],
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
            'navigate_image' => '商品介绍图片',
            'order_no' => '排序',
        ];
    }
}
