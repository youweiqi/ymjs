<?php

use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="member-journal-add-form">

<?php $form = ActiveForm::begin([
    'id' => 'up_down_goods_form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-up-down-goods-form']),
    'options' => [
        'class'=>'form-horizontal',
        'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
    ],
    'fieldConfig' => [
        'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

    ]
]); ?>

<?= $form->field($model, 'ids')->label(false)->hiddenInput() ?>

<?= $form->field($model, 'online_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => ''],
    'removeButton' => false,
    'pluginOptions' => [
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'autoclose' => true,
        'startDate' => date('Y-m'),
        'format' => 'yyyy-mm-dd hh:ii:00'
    ]
]); ?>

<?= $form->field($model, 'offline_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => ''],
    'removeButton' => false,
    'pluginOptions' => [
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'autoclose' => true,
        'startDate' => date('Y-m'),
        'format' => 'yyyy-mm-dd hh:ii:00'
    ]
]); ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

<?php ActiveForm::end(); ?>