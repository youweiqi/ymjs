<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsCommission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-commission-form">

    <?php $form = ActiveForm::begin([
        'id' => 'goods_commission_form',
        'action' => ['/goods/goods/update-goods-commission'],
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['goods-commission-validate-form']),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

        ]

    ]); ?>
    <?= $form->field($model, 'ids')->label(false)->hiddenInput() ?>

    <?= $form->field($model, 'commission')->textInput() ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
