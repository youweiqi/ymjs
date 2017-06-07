<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\warehouse\models\search\StoreSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-search">

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

    <?= $form->field($model, 'store_name') ?>

    <?= $form->field($model, 'brand_name')->label('品牌') ?>

    <?php  echo $form->field($model, 'status')->dropDownList([''=>'全部','0'=>'禁用','1'=>'启用']) ?>


    <?php // echo $form->field($model, 'back_image_path') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'settlement_account') ?>

    <?php // echo $form->field($model, 'settlement_bank') ?>

    <?php // echo $form->field($model, 'settlement_man') ?>

    <?php // echo $form->field($model, 'settlement_interval') ?>

    <?php // echo $form->field($model, 'open_flash_express') ?>

    <?php // echo $form->field($model, 'flash_express_begin_time') ?>

    <?php // echo $form->field($model, 'flash_express_end_time') ?>

    <?php // echo $form->field($model, 'open_install') ?>

    <?php // echo $form->field($model, 'install_begin_time') ?>

    <?php // echo $form->field($model, 'install_end_time') ?>

    <?php // echo $form->field($model, 'open_express') ?>

    <?php // echo $form->field($model, 'store_type') ?>

    <?php // echo $form->field($model, 'is_show_commit') ?>

    <?php // echo $form->field($model, 'is_show_map') ?>

    <?php // echo $form->field($model, 'is_modify_inventory') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'checkout_type') ?>

    <?php // echo $form->field($model, 'commisionlimit') ?>

    <?php // echo $form->field($model, 'lon') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'price_no_freight') ?>

    <?php // echo $form->field($model, 'cooperate_type') ?>

    <?php // echo $form->field($model, 'agent_user_id') ?>

    <?php // echo $form->field($model, 'agent_user_id3') ?>

    <?php // echo $form->field($model, 'agent_user_id6') ?>

    <?php // echo $form->field($model, 'commision_target') ?>

    <?php // echo $form->field($model, 'sale_target') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'qr_code') ?>

    <?php // echo $form->field($model, 'distance') ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
