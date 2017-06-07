<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AfterSales */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'After Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="after-sales-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order_object_id',
            'order_info_id',
            'order_info_sn',
            'order_detail_id',
            'user_id',
            'product_id',
            'product_bn',
            'quantity',
            'after_sn',
            'user_refund_reason',
            'user_first_reason',
            'supplementary_reason',
            'refund_money',
            'refund_cash_money',
            [
                'attribute' => 'img_proof1',
                'label' => '图片1',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['img_proof1'] ? Html::img($model['img_proof1'],['width' => '160px','height'=>'140px']) : $model['img_proof1'];
                }
            ],
            [
                'attribute' => 'img_proof2',
                'label' => '图片2',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['img_proof2'] ? Html::img($model['img_proof2'],['width' => '160px','height'=>'140px']) : $model['img_proof2'];
                }
            ],
            [
                'attribute' => 'img_proof3',
                'label' => '图片3',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['img_proof3'] ? Html::img($model['img_proof3'],['width' => '160px','height'=>'140px']) : $model['img_proof3'];
                }
            ],
            'store_id',
            'store_refuse_reason',
            'store_refuse_reason1',
            'is_refund',
            'type',
            'send_back',
            'courier_company',
            'courier_company_en',
            'courier_number',
            'create_time',
            'update_time',
            'platform_opinion',
            'before_order_status',
            'status',
            'refund_id',
            'pay_type',

        ],
    ]) ?>

</div>
