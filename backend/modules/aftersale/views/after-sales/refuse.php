<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfterSales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="after-sales-form">

    <?php $form = ActiveForm::begin([
        'id' => 'after_sales_form',
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

    <?= $form->field($model, 'user_refund_reason')->textarea(['rows' => 4,'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'user_first_reason')->textarea(['rows' => 4,'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'store_refuse_reason')->textarea(['rows' => 4]) ?>


    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
