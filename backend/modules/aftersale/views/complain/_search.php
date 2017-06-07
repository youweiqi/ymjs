<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\aftersale\models\search\ComplainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="after-sales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => [
            'class'=>'form-inline',
            'role'=> 'form',
            'style'=> 'padding:10px 10px;border:1px solid #FFFFFF;margin-bottom:20px;'
        ],
        'method' => 'get',
        'fieldConfig' => [
            'template' => "<div style='margin:auto 20px'>{label}&nbsp;&nbsp; {input}</div>",
        ]

    ]); ?>

    <?= $form->field($model, 'order_object_bn')->label('父订单号') ?>

    <?= $form->field($model, 'order_info_sn') ?>

    <?= $form->field($model, 'after_sn') ?>

    <?php  echo $form->field($model, 'user_name')->label('手机号码') ?>

    <?php  echo $form->field($model, 'store_name')->label('店铺') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'product_bn') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'after_sn') ?>

    <?php // echo $form->field($model, 'user_refund_reason') ?>

    <?php // echo $form->field($model, 'user_first_reason') ?>

    <?php // echo $form->field($model, 'supplementary_reason') ?>

    <?php // echo $form->field($model, 'refund_money') ?>

    <?php // echo $form->field($model, 'refund_cash_money') ?>

    <?php // echo $form->field($model, 'img_proof1') ?>

    <?php // echo $form->field($model, 'img_proof2') ?>

    <?php // echo $form->field($model, 'img_proof3') ?>

    <?php // echo $form->field($model, 'store_id') ?>

    <?php // echo $form->field($model, 'store_refuse_reason') ?>

    <?php // echo $form->field($model, 'store_refuse_reason1') ?>

    <?php // echo $form->field($model, 'is_refund') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'send_back') ?>

    <?php // echo $form->field($model, 'courier_company') ?>

    <?php // echo $form->field($model, 'courier_company_en') ?>

    <?php // echo $form->field($model, 'courier_number') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'platform_opinion') ?>

    <?php // echo $form->field($model, 'before_order_status') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'refund_id') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'app_id') ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
