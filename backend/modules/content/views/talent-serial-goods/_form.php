<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TalentSerialGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="talent-serial-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'talent_serial_id')->textInput() ?>

    <?= $form->field($model, 'good_id')->textInput() ?>

    <?= $form->field($model, 'agio')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
