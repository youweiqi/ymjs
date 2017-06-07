<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\finance\models\search\OrderObjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-object-search">

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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'user_name')->label('手机号码') ?>

    <?php // echo $form->field($model, 'total_cooperate_price') ?>

    <?php // echo $form->field($model, 'cash_coin') ?>

    <?php // echo $form->field($model, 'promotion_id') ?>

    <?php // echo $form->field($model, 'promotion_discount') ?>

    <?php // echo $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'commision_fee') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'member_delivery_address_id') ?>

    <?php // echo $form->field($model, 'delivery_way') ?>

    <?php // echo $form->field($model, 'is_bill') ?>

    <?php // echo $form->field($model, 'bill_type') ?>

    <?php // echo $form->field($model, 'bill_header') ?>

    <?php // echo $form->field($model, 'freight') ?>

    <?php // echo $form->field($model, 'payment_fee') ?>

    <?php // echo $form->field($model, 'link_man') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'lon') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'refund_date') ?>

    <?php // echo $form->field($model, 'refund_fee') ?>

    <?php // echo $form->field($model, 'refund_cash_coin') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'in_state') ?>

    <?php // echo $form->field($model, 'in_date') ?>

    <?php // echo $form->field($model, 'in_verification') ?>

    <?php // echo $form->field($model, 'procedure_fee') ?>

    <?php // echo $form->field($model, 'bank_in') ?>

    <?php // echo $form->field($model, 'refund_start_time') ?>

    <?php // echo $form->field($model, 'pay_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'refund') ?>

    <?php // echo $form->field($model, 'comment_status') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'app_id') ?>

    <?php // echo $form->field($model, 'mall_store_id') ?>

    <?php // echo $form->field($model, 'open_id') ?>

    <?php // echo $form->field($model, 'api_order_sn') ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
