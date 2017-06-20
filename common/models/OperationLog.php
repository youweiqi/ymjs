<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%operation_log}}".
 *
 * @property int $id 业务日志ID
 * @property int $obj_id 操作对象ID
 * @property string $obj_name 操作对象名称
 * @property string $module 模块
 * @property string $operate_type 操作对象类型
 * @property string $route 操作标识
 * @property int $operator_id 操作员ID
 * @property string $operator_name 操作员名称
 * @property int $created_at
 * @property string $description 描述
 * @property int $ip IP地址
 */
class OperationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%operation_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obj_id', 'operator_id', 'created_at', 'ip'], 'integer'],
            [['description'], 'string'],
            [['obj_name'], 'string', 'max' => 50],
            [['module', 'operate_type', 'operator_name'], 'string', 'max' => 30],
            [['route'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '业务日志ID',
            'obj_id' => '操作对象ID',
            'obj_name' => '操作对象名称',
            'module' => '模块',
            'operate_type' => '操作对象类型',
            'route' => '操作标识',
            'operator_id' => '操作员ID',
            'operator_name' => '操作员名称',
            'created_at' => 'Created At',
            'description' => '描述',
            'ip' => 'IP地址',
        ];
    }
}
