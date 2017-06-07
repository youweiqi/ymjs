<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RedeemCodeLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redeem-code-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'redeem_code_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
