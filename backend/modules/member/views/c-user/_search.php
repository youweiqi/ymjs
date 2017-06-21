<?php

use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\member\models\search\CUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuser-search">

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
    <div class="" style="margin-top:15px">

        <?= $form->field($model, 'user_name')->input('text',['class'=>'form-control input-sm']) ?>

        <?= $form->field($model, 'parent_user_name')->label('上级分销商')->input('text',['class'=>'form-control input-sm']) ?>

        <?= $form->field($model, 'root_user_name')->label('总分销商')->input('text',['class'=>'form-control input-sm']) ?>

        <?= $form->field($model, 'role_id')->dropDownList([''=>'全部','1'=>'普通用户','2'=>'小分销商','3'=>'大分销商']) ?>

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

    </div>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>
