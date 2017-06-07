<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SpecificationDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="specification-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'specification_id')->textInput() ?>

    <?= $form->field($model, 'detail_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
