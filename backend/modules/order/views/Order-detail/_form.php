<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_object_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'brand_id')->textInput() ?>

    <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'good_id')->textInput() ?>

    <?= $form->field($model, 'good_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'spec_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'navigate_img1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'inventory_id')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput() ?>

    <?= $form->field($model, 'product_price')->textInput() ?>

    <?= $form->field($model, 'sale_price')->textInput() ?>

    <?= $form->field($model, 'settlement_price')->textInput() ?>

    <?= $form->field($model, 'cooperate_price')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'total_settlementprice')->textInput() ?>

    <?= $form->field($model, 'total_cooperate_price')->textInput() ?>

    <?= $form->field($model, 'total_fee')->textInput() ?>

    <?= $form->field($model, 'cash_coin')->textInput() ?>

    <?= $form->field($model, 'promotion_discount')->textInput() ?>

    <?= $form->field($model, 'talent_serial_id')->textInput() ?>

    <?= $form->field($model, 'talent_share_good_id')->textInput() ?>

    <?= $form->field($model, 'talent_serial_editandshare_id')->textInput() ?>

    <?= $form->field($model, 'share_serial_id')->textInput() ?>

    <?= $form->field($model, 'share_activity_id')->textInput() ?>

    <?= $form->field($model, 'talent_id')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'talent_agio')->textInput() ?>

    <?= $form->field($model, 'applywelfare_id')->textInput() ?>

    <?= $form->field($model, 'activity_type')->textInput() ?>

    <?= $form->field($model, 'group_buying_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'refund')->textInput() ?>

    <?= $form->field($model, 'comment_status')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'app_id')->textInput() ?>

    <?= $form->field($model, 'mall_store_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
