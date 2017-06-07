<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vip_expenses".
 *
 * @property integer $id
 * @property string $expense_name
 * @property integer $money
 * @property integer $commission1
 * @property integer $commission2
 * @property integer $commission3
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class VipExpenses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.vip_expenses';
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
            [['expense_name'], 'required'],
            [['money', 'commission1', 'commission2', 'commission3', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['expense_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expense_name' => '费用名称',
            'money' => '金额',
            'commission1' => '一级分佣',
            'commission2' => '2级分佣',
            'commission3' => '3级分佣',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '0禁用1使用',
        ];
    }
}
