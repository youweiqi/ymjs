<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\thirdparty\models\search\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'goods_code') ?>

    <?= $form->field($model, 'brand_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'spec_desc') ?>

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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
