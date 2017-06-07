<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "refund_reason".
 *
 * @property integer $id
 * @property string $reason
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class RefundReason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_order.refund_reason';
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
            [['reason'], 'required'],
            [['type', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => '理由',
            'type' => '类型',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
        ];
    }
    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
            'type'=> [
                '2'=>'待发货',
                '3'=>'待收货',
                '4'=>'已完成',
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
