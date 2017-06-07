<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\search\SerialContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serial-content-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'serial_id') ?>

    <?= $form->field($model, 'image_path') ?>

    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'jump_style') ?>

    <?php // echo $form->field($model, 'jump_to') ?>

    <?php // echo $form->field($model, 'img_width') ?>

    <?php // echo $form->field($model, 'img_height') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
