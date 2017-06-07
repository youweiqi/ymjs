<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\search\QueueTasksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="queue-tasks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'task_id') ?>

    <?= $form->field($model, 'task_type') ?>

    <?= $form->field($model, 'task_content') ?>

    <?= $form->field($model, 'task_status') ?>

    <?= $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'over_time') ?>

    <?php // echo $form->field($model, 'task_result') ?>

    <?php // echo $form->field($model, 'operater') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
