<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\discount\models\search\PromotionDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promotion-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'promotion_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'promotion_detail_name') ?>

    <?= $form->field($model, 'is_one') ?>

    <?php // echo $form->field($model, 'brand_id') ?>

    <?php // echo $form->field($model, 'good_id') ?>

    <?php // echo $form->field($model, 'effective_time') ?>

    <?php // echo $form->field($model, 'expiration_time') ?>

    <?php // echo $form->field($model, 'limited') ?>

    <?php // echo $form->field($model, 'is_discount') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'mall_store_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'total_number') ?>

    <?php // echo $form->field($model, 'remaining_number') ?>

    <?php // echo $form->field($model, 'used_number') ?>

    <?php // echo $form->field($model, 'for_register') ?>

    <?php // echo $form->field($model, 'for_mall_display') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
