<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TgLink */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tg Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-link-view">

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
            'channel_id',
            'promotion_detail_id',
            'promotion_total_num',
            'promotion_person_num',
            'identifier',
            'create_time',
            'type',
            'serial_id',
            'memo:ntext',
        ],
    ]) ?>

</div>
