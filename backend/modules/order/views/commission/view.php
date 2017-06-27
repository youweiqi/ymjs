<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Commision */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Commisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commision-view">

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
            'order_detail_id',
            'order_info_id',
            'order_object_id',
            'user_id',
            'type',
            'comment',
            'fee',
            'result_time',
            'result',
            'create_time',
            'update_time',
            'status',
        ],
    ]) ?>

</div>
