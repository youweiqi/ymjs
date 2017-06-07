<?php

use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RedeemCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redeem-code-form">

    <?php $form = ActiveForm::begin([
        'id' => 'inventory_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'redeem_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usable_times')->textInput() ?>

    <?= $form->field($model, 'used_times')->textInput() ?>

    <?=  $form->field($model, 'promotion_id')->hint('<span style="color: #ff0000;">*</span>')->label('优惠礼包')->widget(Select2::classname(),  [
        'options' => ['placeholder' => '请选择优惠礼包...'],
        'data' => isset($promotion_data)?$promotion_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'language'=>[
                'errorLoading'=>new JsExpression("function(){return 'Waiting...'}")
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/discount/redeem-code/search-promotion']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>
    <?= $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'removeButton' => false,
        'pluginOptions' => [
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'autoclose' => true,
            'startDate' => date('Y-m'),
            'minView' => 1,
            'format' => 'yyyy-mm-dd hh:00:00'
        ]
    ]); ?>
    <?= $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'removeButton' => false,
        'pluginOptions' => [
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'autoclose' => true,
            'startDate' => date('Y-m'),
            'minView' => 1,
            'format' => 'yyyy-mm-dd hh:00:00'
        ]
    ]); ?>

    <?= $form->field($model, 'status')->hint('<span style="color: #ff0000;">*</span>')->radioList(['0'=>'禁用','1'=>'启用'])?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>
