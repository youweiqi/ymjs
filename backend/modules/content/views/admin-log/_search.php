<?php

use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\search\AdminLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => [
            'class'=>'form-inline',
            'role'=> 'form',
            'style'=> 'padding:10px 10px;border:1px solid #FFFFFF;margin-bottom:20px;'
        ],
        'method' => 'get',
        'fieldConfig' => [
            'template' => "<div style='margin:auto 20px'>{label}&nbsp;&nbsp; {input}</div>",
        ]

    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_name')->label('操作人') ?>

    <?= $form->field($model, 'begin_time')->label('开始时间')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '','class'=>'form-control input-sm'],
        'removeButton' => false,
        'size'=>'sm',
        'pluginOptions' => [
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'autoclose' => true,
            'startDate' => date('Y-m'),
            'minView' => 1,
            'format' => 'yyyy-mm-dd hh:00:00'
        ]
    ]); ?>
    <?= $form->field($model, 'end_time')->label('结束时间')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '','class'=>'form-control input-sm'],
        'removeButton' => false,
        'size'=>'sm',
        'pluginOptions' => [
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'autoclose' => true,
            'startDate' => date('Y-m'),
            'minView' => 1,
            'format' => 'yyyy-mm-dd hh:00:00'
        ]
    ]); ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
