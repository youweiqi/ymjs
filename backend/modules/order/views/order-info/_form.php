<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-form">

    <div class="order-info-form">
        <?php $form = ActiveForm::begin([
            'id' => 'advertisement_form',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate-form']),
            'options' => [
                'class'=>'form-horizontal',
                'tabindex' => false,
                'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'


            ],
            'fieldConfig' => [
                'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

            ]
        ]); ?>

        <?= $form->field($model, 'back_remark')->textarea(['rows' => 6]) ?>

        <div class="form-group" style="text-align:center">
            <?= Html::submitButton('添加', ['class' => 'btn btn-success']) ?>
            <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>