<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "talent_serial_goods".
 *
 * @property integer $id
 * @property integer $talent_serial_id
 * @property integer $good_id
 * @property integer $agio
 * @property string $create_time
 */
class TalentSerialGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.talent_serial_goods';
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
            [['talent_serial_id', 'good_id', 'agio'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'talent_serial_id' => '达人期资讯ID',
            'good_id' => '商品id',
            'agio' => '折扣  1 无佣   2半佣   3 全拥',
            'create_time' => '创建时间',
        ];
    }
}
