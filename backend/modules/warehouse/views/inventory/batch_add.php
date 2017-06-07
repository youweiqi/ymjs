<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\UserJournal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-journal-batch-update-form">

    <?php $form = ActiveForm::begin([
        'id' => 'user-journal_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form']),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

        ]
    ]); ?>

    <?= $form->field($model, 'ids')->label(false)->hiddenInput() ?>

    <?=  $form->field($model, 'freight_template_id')->label('邮费模板')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请选择邮费模板...'],
        'data' => isset($store_data)?$store_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/warehouse/store-goods-freight/search-freight']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {freight_name:params.term}; }')
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

</div>
