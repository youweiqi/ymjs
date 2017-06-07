<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrderDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-view">

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
            'order_id',
            'order_object_id',
            'user_id',
            'brand_id',
            'brand_name',
            'good_id',
            'good_name',
            'label_name',
            'product_id',
            'spec_name',
            'navigate_img1',
            'store_id',
            'inventory_id',
            'channel',
            'product_price',
            'sale_price',
            'settlement_price',
            'cooperate_price',
            'quantity',
            'total_price',
            'total_settlementprice',
            'total_cooperate_price',
            'total_fee',
            'cash_coin',
            'promotion_discount',
            'talent_serial_id',
            'talent_share_good_id',
            'talent_serial_editandshare_id',
            'share_serial_id',
            'share_activity_id',
            'talent_id',
            'discount',
            'talent_agio',
            'applywelfare_id',
            'activity_type',
            'group_buying_id',
            'create_time',
            'update_time',
            'status',
            'refund',
            'comment_status',
            'type',
            'app_id',
            'mall_store_id',
        ],
    ]) ?>

</div>
