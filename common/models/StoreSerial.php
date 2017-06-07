<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_serial".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $serial_id
 */
class StoreSerial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_serial';
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
            [['store_id', 'serial_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '店铺ID',
            'serial_id' => '期ID',
        ];
    }
}
