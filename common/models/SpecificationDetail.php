<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "specification_detail".
 *
 * @property integer $id
 * @property integer $specification_id
 * @property string $detail_name
 * @property integer $order_no
 */
class SpecificationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.specification_detail';
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
            [['specification_id', 'order_no'], 'integer'],
            [['order_no'], 'required'],
            [['detail_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'specification_id' => '规格id',
            'detail_name' => '规格详情名称',
            'order_no' => '排序',
        ];
    }
}
