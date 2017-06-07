<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_char')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_cn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriptions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'background_image_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'like_count')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
