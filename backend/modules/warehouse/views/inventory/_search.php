<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\warehouse\models\search\InventorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-search">

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

    <?= $form->field($model, 'product_bn')->label('货号') ?>

    <?= $form->field($model, 'goods_name')->label('商品名称') ?>

    <?= $form->field($model, 'store_name')->label('店铺名称') ?>

    <?php // echo $form->field($model, 'lock_inventory_num') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'settlement_price') ?>

    <?php // echo $form->field($model, 'is_transfer') ?>

    <?php // echo $form->field($model, 'cooperate_price') ?>

    <?php // echo $form->field($model, 'is_cooperate') ?>

    <?php // echo $form->field($model, 'disabled_cooperate') ?>

    <?php // echo $form->field($model, 'out_start_time') ?>

    <?php // echo $form->field($model, 'out_end_time') ?>

    <?php // echo $form->field($model, 'can_use_membership_card') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
