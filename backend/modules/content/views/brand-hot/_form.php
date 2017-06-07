<?php

use common\libraries\ImageLib;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BrandHot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-hot-form">

    <?php $form = ActiveForm::begin([
        'id' => 'brand-hot_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'enctype' => 'multipart/form-data',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?=  $form->field($model, 'brand_id')->label('品牌名称')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请输入品牌名称...'],
        'data' => isset($brand_data)?$brand_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'language'=>[
                'errorLoading'=>new JsExpression("function(){return 'Waiting...'}")
            ],
            'ajax' => [
                'url' => Url::to(['/content/brand-hot/search-brand']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>

    <?= $form->field($model, 'logo_path',['template' => "<div class='col-sm-3 text-right'>{label} :</div>
        <div class='col-sm-6'>
        <div style='width: 250px;position: relative'>
            <span class='change_img_btn'><i class='fa fa-chain'></i></span>
            <span class='del_img close-modal' id='del_img' onclick='del_img(\"brandhot-logo_path\")'>×</span>
            <img src='".ImageLib::getDefaultImg($model->logo_path)."' class='thumbnail image-preview' name='brandhot-logo_path-preview' id='brandhot-logo_path-preview'>
        {input}</div></div>"])->label('品牌图')->fileInput(['onchange' => 'uploadImg("brandhot-logo_path")','class'=>'image-upload']) ?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
