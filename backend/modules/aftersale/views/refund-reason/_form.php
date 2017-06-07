<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RefundReason */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-reason-form">

    <?php $form = ActiveForm::begin([
        'id' => 'refund_reason_form',
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

    <?= $form->field($model, 'reason')->hint('<span style="color: #ff0000;">*</span>')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->hint('<span style="color: #ff0000;">*</span>')->dropDownList(['2'=>'待发货','3'=>'待收货','4'=>'已完成']) ?>

    <?= $form->field($model, 'status')->hint('<span style="color: #ff0000;">*</span>')->radioList(['0'=>'禁用','1'=>'启用'])?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
