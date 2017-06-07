<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TgLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tg-link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'channel_id')->textInput() ?>

    <?= $form->field($model, 'promotion_detail_id')->textInput() ?>

    <?= $form->field($model, 'promotion_total_num')->textInput() ?>

    <?= $form->field($model, 'promotion_person_num')->textInput() ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'serial_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
