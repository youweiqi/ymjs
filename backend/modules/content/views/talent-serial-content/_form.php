<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TalentSerialContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="talent-serial-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'talent_serial_id')->textInput() ?>

    <?= $form->field($model, 'image_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <?= $form->field($model, 'jump_style')->textInput() ?>

    <?= $form->field($model, 'jump_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_width')->textInput() ?>

    <?= $form->field($model, 'img_height')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
