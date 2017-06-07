<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goods_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spec_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'service_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'label_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suggested_price')->textInput() ?>

    <?= $form->field($model, 'lowest_price')->textInput() ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_parent_id')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'online_time')->textInput() ?>

    <?= $form->field($model, 'offline_time')->textInput() ?>

    <?= $form->field($model, 'talent_limit')->textInput() ?>

    <?= $form->field($model, 'threshold')->textInput() ?>

    <?= $form->field($model, 'ascription')->textInput() ?>

    <?= $form->field($model, 'talent_display')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'operate_costing')->textInput() ?>

    <?= $form->field($model, 'score_rate')->textInput() ?>

    <?= $form->field($model, 'self_support')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'wx_small_imgpath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
