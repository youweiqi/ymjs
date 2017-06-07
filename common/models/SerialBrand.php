<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "serial_brand".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property integer $serial_id
 */
class SerialBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.serial_brand';
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
            [['serial_id'], 'required'],
            [['brand_id', 'serial_id'], 'integer'],
            [['serial_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => '品牌',
            'serial_id' => '期',
        ];
    }
}
