<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ActivityDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'activity_id',
            'product_id',
            'inventory_id',
            'inventory_num',
        ],
    ]) ?>

</div>
