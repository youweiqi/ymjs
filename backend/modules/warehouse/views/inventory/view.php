<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Inventory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-view">

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
            'product_id',
            'goods_id',
            'store_id',
            'inventory_num',
            'lock_inventory_num',
            'sale_price',
            'settlement_price',
            'is_transfer',
            'cooperate_price',
            'is_cooperate',
            'disabled_cooperate',
            'out_start_time',
            'out_end_time',
            'can_use_membership_card',
            'status',
        ],
    ]) ?>

</div>
