<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrderObject */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-object-view">

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
            'order_sn',
            'user_id',
            'total_price',
            'total_settlement_price',
            'total_cooperate_price',
            'cash_coin',
            'promotion_id',
            'promotion_discount',
            'total_fee',
            'commision_fee',
            'pay_time',
            'pay_type',
            'member_delivery_address_id',
            'delivery_way',
            'is_bill',
            'bill_type',
            'bill_header',
            'freight',
            'payment_fee',
            'link_man',
            'mobile',
            'province',
            'city',
            'area',
            'street',
            'address',
            'lon',
            'lat',
            'refund_date',
            'refund_fee',
            'refund_cash_coin',
            'remark',
            'in_state',
            'in_date',
            'in_verification',
            'procedure_fee',
            'bank_in',
            'refund_start_time:datetime',
            'pay_id',
            'create_time',
            'update_time',
            'status',
            'refund',
            'comment_status',
            'type',
            'app_id',
            'mall_store_id',
            'open_id',
            'api_order_sn',
        ],
    ]) ?>

</div>
