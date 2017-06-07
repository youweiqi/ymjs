<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goods_id')->textInput() ?>

    <?= $form->field($model, 'spec_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'spec_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'spec_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bar_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_bn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supply_threshold')->textInput() ?>

    <?= $form->field($model, 'is_stock_warn')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'is_del')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
