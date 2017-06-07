<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "talent_serial_editandshare".
 *
 * @property integer $id
 * @property integer $talent_id
 * @property integer $talent_serial_id
 * @property integer $agio
 * @property string $create_time
 */
class TalentSerialEditandshare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.talent_serial_editandshare';
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
            [['talent_id', 'talent_serial_id', 'agio'], 'integer'],
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
            'talent_id' => '达人用户id',
            'talent_serial_id' => '达人期咨询id',
            'agio' => '折扣  1 无佣   2半佣   3 全拥',
            'create_time' => '创建时间',
        ];
    }
}
