<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\search\OrderDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_object_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'brand_id') ?>

    <?php // echo $form->field($model, 'brand_name') ?>

    <?php // echo $form->field($model, 'good_id') ?>

    <?php // echo $form->field($model, 'good_name') ?>

    <?php // echo $form->field($model, 'label_name') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'spec_name') ?>

    <?php // echo $form->field($model, 'navigate_img1') ?>

    <?php // echo $form->field($model, 'store_id') ?>

    <?php // echo $form->field($model, 'inventory_id') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'product_price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'settlement_price') ?>

    <?php // echo $form->field($model, 'cooperate_price') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'total_settlementprice') ?>

    <?php // echo $form->field($model, 'total_cooperate_price') ?>

    <?php // echo $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'cash_coin') ?>

    <?php // echo $form->field($model, 'promotion_discount') ?>

    <?php // echo $form->field($model, 'talent_serial_id') ?>

    <?php // echo $form->field($model, 'talent_share_good_id') ?>

    <?php // echo $form->field($model, 'talent_serial_editandshare_id') ?>

    <?php // echo $form->field($model, 'share_serial_id') ?>

    <?php // echo $form->field($model, 'share_activity_id') ?>

    <?php // echo $form->field($model, 'talent_id') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'talent_agio') ?>

    <?php // echo $form->field($model, 'applywelfare_id') ?>

    <?php // echo $form->field($model, 'activity_type') ?>

    <?php // echo $form->field($model, 'group_buying_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'refund') ?>

    <?php // echo $form->field($model, 'comment_status') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'app_id') ?>

    <?php // echo $form->field($model, 'mall_store_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
