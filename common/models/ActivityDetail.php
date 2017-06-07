<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity_detail".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property integer $product_id
 * @property integer $inventory_id
 * @property integer $inventory_num
 */
class ActivityDetail extends \yii\db\ActiveRecord
{
    public $product_bn;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.activity_detail';
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
            [['activity_id', 'product_id', 'inventory_id', 'inventory_num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => '活动id',
            'product_id' => '货品ID',
            'inventory_id' => '库存id',
            'inventory_num' => '库存数',
        ];
    }
}
