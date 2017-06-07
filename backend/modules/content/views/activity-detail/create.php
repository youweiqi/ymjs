<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ActivityDetail */

$this->title = 'Create Activity Detail';
$this->params['breadcrumbs'][] = ['label' => 'Activity Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
