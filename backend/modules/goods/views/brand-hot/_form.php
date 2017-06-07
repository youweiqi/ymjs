<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\components\Common;
/* @var $this yii\web\View */
/* @var $model common\models\BrandHot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-hot-form">

    <?php $form = ActiveForm::begin([
        'id' => 'brand-hot_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form']),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

        ]
    ]); ?>

    <?=  $form->field($model, 'brand_ids')->hint('<span style="color: #ff0000;">*</span>')->label('热门品牌')->widget(Select2::classname(),  [
        'options' => ['multiple' => true,'placeholder' => '请选择品牌名称...'],
         'data' => isset($brand_hot_name_data)?$brand_hot_name_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'language'=>[
                'errorLoading'=>new JsExpression("function(){return 'Waiting...'}")
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/goods/brand-hot/search-brand']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
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
