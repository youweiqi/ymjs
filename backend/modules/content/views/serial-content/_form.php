<?php

use common\components\Common;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SerialContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serial-content-form">

    <?php $form = ActiveForm::begin([
        'id' => 'content_form',
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

    <?= $form->field($model, 'serial_id')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'image_path',
        [
            'template' => "<div class='col-md-3 text-right'>{label} :</div>
         <div class='col-md-2'>{input}</div>
         <div class='col-md-1'>". Common::getImagePreview($model->image_path,'serialcontent-image_path_preview')."</div>
         <div class='col-md-3 text-left'>{hint}</div>"
        ])->hint('<label for="serialcontent-image_path" class="control-label" style="color: red">(推荐尺寸: 640*320)</label>')->fileInput()
    ?>
    <?= $form->field($model, 'img_width')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'img_height')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'jump_style')->dropDownList(['1'=>'不跳转','2'=>'商品详情','3'=>'H5','4'=>'其他期资讯']) ?>

    <?= $form->field($model, 'jump_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
