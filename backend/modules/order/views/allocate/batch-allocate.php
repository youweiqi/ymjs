<?php

use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="member-journal-add-form">

<?php $form = ActiveForm::begin([
    'id' => 'member-journal-add-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['batch-allocate-validate-form']),
    'options' => [
        'class'=>'form-horizontal',
        'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
    ],
    'fieldConfig' => [
        'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

    ]
]); ?>

<?= $form->field($model, 'ids')->label(false)->hiddenInput() ?>

<?=  $form->field($model, 'team_name')->widget(Select2::classname(), [
    'options' => ['placeholder' => '请选择确认小组...'],
    'data' => [],
    'pluginOptions' => [
        'allowClear' => true,
        'ajax' => [
            'url' => Url::to(['search-team']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {name:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(res) { return res.text; }'),
        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
    ],
]); ?>

<?=  $form->field($model, 'user_name')->widget(Select2::classname(), [
    'options' => ['placeholder' => '请选择确认人...'],
    'data' => [],
    'pluginOptions' => [
        'allowClear' => true,
        'ajax' => [
            'url' => Url::to(['search-user']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) {
                     var team_name = $("#allocateform-team_name option:selected").val();
                    
                     if(!team_name){
                        alert("请先选择确认小组");
                     }else{
                        return {user_name:params.term,team_id:team_name};
                     }
                     }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(res) { return res.text; }'),
        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
    ],
]); ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

<?php ActiveForm::end(); ?>

