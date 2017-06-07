<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "share_serial".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $serial_id
 * @property integer $agio
 * @property string $create_time
 */
class ShareSerial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.share_serial';
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
            [['user_id', 'serial_id', 'agio'], 'integer'],
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
            'user_id' => '分享人id',
            'serial_id' => '期咨询id',
            'agio' => '折扣  1 无佣   2半佣   3 全拥',
            'create_time' => '创建时间',
        ];
    }
}
