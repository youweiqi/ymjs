<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserJournal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Journals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-journal-view">

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
            'user_id',
            'order_sn',
            'promotion_detail_id',
            'money',
            'type',
            'bank_id',
            'comment',
            'create_time',
            'update_time',
            'status',
            'mall_store_id',
        ],
    ]) ?>

</div>
