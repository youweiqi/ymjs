<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfterSales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="after-sales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_object_id')->textInput() ?>

    <?= $form->field($model, 'order_info_id')->textInput() ?>

    <?= $form->field($model, 'order_info_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_detail_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'product_bn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'after_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_refund_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_first_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplementary_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_money')->textInput() ?>

    <?= $form->field($model, 'refund_cash_money')->textInput() ?>

    <?= $form->field($model, 'img_proof1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_proof2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_proof3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'store_refuse_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_refuse_reason1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_refund')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'send_back')->textInput() ?>

    <?= $form->field($model, 'courier_company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'courier_company_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'courier_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'platform_opinion')->textInput() ?>

    <?= $form->field($model, 'before_order_status')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'refund_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_type')->textInput() ?>

    <?= $form->field($model, 'app_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
