<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TeamUserRelation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-user-relation-form">

    <?php $form = ActiveForm::begin([
        'id' => 'team-user-relation-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?=  $form->field($model, 'team_id')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请选择小组名称...'],
        'data' => isset($store_data)?$store_data:[],
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

    <?=  $form->field($model, 'user_id')->widget(Select2::classname(), [
        'options' => ['multiple' => true,'placeholder' => '请选择小组成员...'],
        'data' => isset($store_data)?$store_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['search-user']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <button id="submit_form_btn" class="btn btn-success" style="margin-right: 20px">保存</button>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
