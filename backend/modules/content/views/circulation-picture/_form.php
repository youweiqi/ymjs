<?php

use common\libraries\ImageLib;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CirculationPicture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="circulation-picture-form">

    <?php $form = ActiveForm::begin([
        'id' => 'circulationpicture_form',
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

    <?= $form->field($model, 'type')->hint('<span style="color: #ff0000;">*</span>')->dropDownList(['0'=>'无','1'=>'商品','2'=>'资讯','3'=>'其他']) ?>

    <?= $form->field($model, 'activity')->textInput(['maxlength' => true,'placeholder'=>'请根据类型填写商品ID、资讯ID或链接']) ?>

    <div style=" text-align:center;width:100%;height:30px;line-height:30px;color:red;padding-left:20px;margin-bottom:10px;">宽高3：1 宽度不小于750,高度不小于300K!</div>
    <?= $form->field($model, 'image',['template' => "<div class='col-sm-3 text-right'>{label} :</div>
        <div class='col-sm-6'>
        <div style='width: 250px;position: relative'>
            <span class='change_img_btn'><i class='fa fa-chain'></i></span>
            <span class='del_img close-modal' id='del_img' onclick='del_img(\"circulationpicture-image\")'>×</span>
        <img src='".ImageLib::getDefaultImg($model->image)."' class='thumbnail image-preview' name='circulationpicture-image-preview' id='circulationpicture-image-preview'>
        {input}</div></div>"])->label('轮播图')->fileInput(['onchange' => 'uploadImg("circulationpicture-image")','class'=>'image-upload']) ?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <?= $form->field($model, 'status')->hint('<span style="color: #ff0000;">*</span>')->radioList(['0'=>'禁用','1'=>'启用']) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
