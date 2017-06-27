<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SystemBizConfig */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'System Biz Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-biz-config-view">

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
            'code',
            'value',
            'description',
            'type',
            'status',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
