<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\QueueTasks */

$this->title = 'Update Queue Tasks: ' . $model->task_id;
$this->params['breadcrumbs'][] = ['label' => 'Queue Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->task_id, 'url' => ['view', 'id' => $model->task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="queue-tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
