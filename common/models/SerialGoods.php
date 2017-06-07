<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "serial_goods".
 *
 * @property integer $id
 * @property integer $serial_id
 * @property integer $good_id
 * @property integer $order_no
 */
class SerialGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.serial_goods';
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
            [['serial_id', 'good_id', 'order_no'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_id' => '资讯',
            'good_id' => '商品',
            'order_no' => '排序',
        ];
    }
    public function getSerial(){

        return $this->hasOne(Serial::className(),['id'=>'serial_id']);
    }
    public function getGoods(){

        return $this->hasOne(Goods::className(),['id'=>'good_id']);
    }
}
