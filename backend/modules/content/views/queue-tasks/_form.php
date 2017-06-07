<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\QueueTasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="queue-tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_type')->textInput() ?>

    <?= $form->field($model, 'task_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'task_status')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'over_time')->textInput() ?>

    <?= $form->field($model, 'task_result')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operater')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
