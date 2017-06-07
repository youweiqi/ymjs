<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "logistics_status".
 *
 * @property integer $id
 * @property string $order_sn
 * @property string $logistics_sessage
 * @property integer $is_finish
 * @property string $com
 * @property string $no
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class LogisticsStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.logistics_status';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_order');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn'], 'required'],
            [['logistics_sessage'], 'string'],
            [['is_finish', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 100],
            [['com'], 'string', 'max' => 255],
            [['no'], 'string', 'max' => 244],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '子订单号',
            'logistics_sessage' => '物流消息',
            'is_finish' => '是否完成该订单  0否  1完成',
            'com' => '快递公司英文名',
            'no' => '快递单号',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
