<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yg_system.queue_tasks".
 *
 * @property int $task_id
 * @property int $task_type "1" 订单导出任务
 * @property string $task_content 任务内容Json
 * @property int $task_status 任务状态(0:初始状态,  1:离线运行状态, 2: 执行成功, 3:执行失败)
 * @property string $create_time 创建时间
 * @property string $over_time
 * @property string $task_result
 * @property string $operater
 */
class QueueTasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_system.queue_tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_type', 'task_content', 'create_time', 'operater'], 'required'],
            [['task_type', 'task_status'], 'integer'],
            [['task_content'], 'string'],
            [['create_time', 'over_time'], 'safe'],
            [['task_result'], 'string', 'max' => 255],
            [['operater'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => '任务id',
            'task_type' => '任务类型',
            'task_content' => '任务内容',
            'task_status' => '任务状态',
            'create_time' => '开始时间',
            'over_time' => '结束时间',
            'task_result' => '结果',
            'operater' => '操作人',
        ];
    }

    public static function dropDown($column, $value = null){
        $dropDownList = [
            'task_type'=>[
                '1'=>'订单导出',
                '2'=>'财务退款订单导出',
                '4'=> '供应链商品导出',
                '5'=>'商品导出'
            ],
            'task_status'=>[
                '0'=>'未开始',
                '1'=>'进行中',
                '2'=>'成功',
                '3'=>'失败'
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
