<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PromotionDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promotion Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotion-detail-view">

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
            'promotion_id',
            'type',
            'promotion_detail_name',
            'is_one',
            'brand_id',
            'good_id',
            'effective_time',
            'expiration_time',
            'limited',
            'is_discount',
            'amount',
            'discount',
            'create_time',
            'update_time',
            'mall_store_id',
            'status',
            'total_number',
            'remaining_number',
            'used_number',
            'for_register',
            'for_mall_display',
        ],
    ]) ?>

</div>
