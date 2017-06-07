<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\QueueTasks */

$this->title = 'Create Queue Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Queue Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="queue-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
