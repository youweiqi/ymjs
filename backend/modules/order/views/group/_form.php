<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'order_object_id')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'store_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_lon')->textInput() ?>

    <?= $form->field($model, 'store_lat')->textInput() ?>

    <?= $form->field($model, 'settlement_man')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settlement_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settlement_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'total_settlement_price')->textInput() ?>

    <?= $form->field($model, 'total_cooperate_price')->textInput() ?>

    <?= $form->field($model, 'cash_coin')->textInput() ?>

    <?= $form->field($model, 'promotion_id')->textInput() ?>

    <?= $form->field($model, 'promotion_discount')->textInput() ?>

    <?= $form->field($model, 'total_fee')->textInput() ?>

    <?= $form->field($model, 'commision_fee')->textInput() ?>

    <?= $form->field($model, 'pay_time')->textInput() ?>

    <?= $form->field($model, 'pay_type')->textInput() ?>

    <?= $form->field($model, 'express_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'complete_time')->textInput() ?>

    <?= $form->field($model, 'member_delivery_address_id')->textInput() ?>

    <?= $form->field($model, 'delivery_way')->textInput() ?>

    <?= $form->field($model, 'is_bill')->textInput() ?>

    <?= $form->field($model, 'bill_type')->textInput() ?>

    <?= $form->field($model, 'bill_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'freight')->textInput() ?>

    <?= $form->field($model, 'payment_fee')->textInput() ?>

    <?= $form->field($model, 'link_man')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lon')->textInput() ?>

    <?= $form->field($model, 'lat')->textInput() ?>

    <?= $form->field($model, 'refund_date')->textInput() ?>

    <?= $form->field($model, 'refund_fee')->textInput() ?>

    <?= $form->field($model, 'refund_cash_coin')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'back_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_state')->textInput() ?>

    <?= $form->field($model, 'in_date')->textInput() ?>

    <?= $form->field($model, 'in_verification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'procedure_fee')->textInput() ?>

    <?= $form->field($model, 'bank_in')->textInput() ?>

    <?= $form->field($model, 'pay_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'refund')->textInput() ?>

    <?= $form->field($model, 'comment_status')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'app_id')->textInput() ?>

    <?= $form->field($model, 'mall_store_id')->textInput() ?>

    <?= $form->field($model, 'send_goods_bauser_id')->textInput() ?>

    <?= $form->field($model, 'api_order_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active_status')->textInput() ?>

    <?= $form->field($model, 'team_id')->textInput() ?>

    <?= $form->field($model, 'active_user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
