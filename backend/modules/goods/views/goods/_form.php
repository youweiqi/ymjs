<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin([
        'id' => 'inventory_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['goods-commission-validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-5'>{input}</div><div>{hint}</div><div class='col-sm-4 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'id')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model->goods_commission, 'commission')->label('分佣')->textInput(['maxlength' => true]) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
