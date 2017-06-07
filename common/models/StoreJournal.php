<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store_journal".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $order_sn
 * @property integer $money
 * @property string $type
 * @property string $comment
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class StoreJournal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.store_journal';
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
            [['store_id', 'money', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 10],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '门店ID',
            'order_sn' => '订单号',
            'money' => '金额',
            'type' => '收支类型区分，+是收入，-是支出',
            'comment' => '备注',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态(0禁用,1结算,2提款中,3提款成功,4提款失败,5系统返还)',
        ];
    }
}
