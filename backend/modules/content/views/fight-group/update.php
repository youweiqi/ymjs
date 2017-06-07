<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Activity */

$this->title = 'Update Activity: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-update">

    <?= $this->render('_form', [
        'model' => $model,
        'store_data' => $store_data,
        'goods_data' => $goods_data,
        'activity_details' => $activity_details,
    ]) ?>

</div>
