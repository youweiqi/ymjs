<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\goods\models\search\GoodsApiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search">

    <div class="goods-search">

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

<?= $form->field($model, 'goods_code') ?>

<?= $form->field($model, 'brand_id')->label('品牌') ?>

<?= $form->field($model, 'name') ?>

<?php // echo $form->field($model, 'service_desc') ?>

<?php // echo $form->field($model, 'label_name') ?>

<?php // echo $form->field($model, 'suggested_price') ?>

<?php // echo $form->field($model, 'lowest_price') ?>

<?php // echo $form->field($model, 'unit') ?>

<?php // echo $form->field($model, 'remark') ?>

<?php // echo $form->field($model, 'category_parent_id') ?>

<?php // echo $form->field($model, 'category_id') ?>

<?php // echo $form->field($model, 'online_time') ?>

<?php // echo $form->field($model, 'offline_time') ?>

<?php // echo $form->field($model, 'talent_limit') ?>

<?php // echo $form->field($model, 'threshold') ?>

<?php // echo $form->field($model, 'ascription') ?>

<?php // echo $form->field($model, 'talent_display') ?>

<?php // echo $form->field($model, 'discount') ?>

<?php // echo $form->field($model, 'operate_costing') ?>

<?php // echo $form->field($model, 'score_rate') ?>

<?php // echo $form->field($model, 'self_support') ?>

<?php // echo $form->field($model, 'create_time') ?>

<?php // echo $form->field($model, 'wx_small_imgpath') ?>

<?php // echo $form->field($model, 'channel') ?>

<?php // echo $form->field($model, 'api_goods_id') ?>

    <div class="" style="margin-top:20px;margin-left:18px">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
        <?= Html::submitButton('导出', ['class' => 'btn btn-primary btn-sm','value'=>'export', 'name' => 'sub']) ?>
    </div>

<?php ActiveForm::end(); ?>