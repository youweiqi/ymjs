<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'id' => 'advertisement_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'tabindex' => false,
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'


        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('<span style="color: #ff0000;">*</span>') ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'order_no')->textInput()->hint('<span style="color: #ff0000;">*</span>') ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

