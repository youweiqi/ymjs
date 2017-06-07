<?php

use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="inventory-form">

        <?php $form = ActiveForm::begin([
            'id' => 'inventory_form',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate-form']),
            'options' => [
                'class'=>'form-horizontal',
                'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
            ],
            'fieldConfig' => [
                'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
            ]
        ]); ?>

        <?=  $form->field($model, 'product_id')->label('货号')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入货号...'],
            'data' => isset($product_bn_data)?$product_bn_data:[],
            'disabled' => true,
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/goods/product/search-product']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {product_bn:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?=  $form->field($model, 'store_id')->label('门店名称')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入门店名称...'],
            'data' => isset($store_name_data)?$store_name_data:[],
            'disabled' => true,
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/warehouse/store/search-store']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {store_name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?= $form->field($model, 'inventory_num')->textInput() ?>

        <?= $form->field($model, 'sale_price')->textInput() ?>

        <?= $form->field($model, 'settlement_price')->textInput() ?>

        <?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'启用'],['class'=>'form-inline']) ?>

        <hr>
        <div class="form-group" style="text-align:center">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
            <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

