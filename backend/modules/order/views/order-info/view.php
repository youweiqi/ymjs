<?php

use common\components\Common;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-view">

    <div class=" col-sm-6">
        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view'],
            'model' => $model,
            'attributes' => [
                'order_sn',
                'order_object_id',
                'store_id',
                'store_name',
                [
                    'attribute' => 'total_price',
                    'format'=>'raw',
                    'value'=>$model->total_price/100
                ],
                [
                    'attribute' => 'total_settlement_price',
                    'format'=>'raw',
                    'value'=>$model->total_settlement_price/100
                ],
                'cash_coin',
                'promotion_id',
                [
                    'attribute' => 'promotion_discount',
                    'format'=>'raw',
                    'value'=>$model->promotion_discount/100
                ],
                [
                    'attribute' => 'total_fee',
                    'format'=>'raw',
                    'value'=>$model->total_fee/100
                ],
                [
                    'attribute' => 'commision_fee',
                    'format'=>'raw',
                    'value'=>$model->commision_fee/100
                ],
                'pay_type',
                'express_name',
                'express_no',
                'delivery_way',

            ],
        ]) ?>
    </div>
    <div class=" col-sm-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'province',
                'city',
                'area',
                'street',
                'address',
                'is_bill',
                'bill_type',
                'bill_header',
                'freight',
                'link_man',
                'mobile',
                'remark',
                'status',
                'back_remark',
            ],
        ]) ?>
    </div>
    <?php
    foreach ($order_details as $order_detail){
        echo DetailView::widget([
            'model' => $order_detail,
            'attributes' => [
                [
                    'attribute' => 'navigate_img1',
                    'label' => '商品图片',
                    'format'=>'raw',
                    'value'=>Common::getImage($order_detail->navigate_img1)
                ],
                'good_name',
                'product_id',
                'channel',
                'quantity',
                [
                    'attribute' => 'total_price',
                    'format'=>'raw',
                    'value'=>$order_detail->total_price/100
                ],
                [
                    'attribute' => 'total_settlementprice',
                    'format'=>'raw',
                    'value'=>$order_detail->total_settlementprice/100
                ],
            ],
        ]);
    }
    ?>
    <div class=" col-sm-6">
        <?php
            if(!empty($user_address)){
                echo  DetailView::widget([
                    'model' => $user_address,
                    'attributes' => [
                        'id_number'
                    ],
                ]);
            }

       ?>
    </div>



</div>
