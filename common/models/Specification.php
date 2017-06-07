<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "specification".
 *
 * @property integer $id
 * @property string $name
 * @property integer $order_no
 * @property integer $brand_id
 */
class Specification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.specification';
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
            [['order_no'], 'required'],
            [['order_no', 'brand_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '规格名',
            'order_no' => '排序',
            'brand_id' => '品牌ID',
        ];
    }
}
