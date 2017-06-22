<?php

use common\models\OrderObject;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\finance\models\search\OrderObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '父订单号列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-object-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{god-agree}',
                'buttons' => [
                    'god-agree' => function ($url, $model, $key) {
                        if($model->refund_id==''){
                            return Html::a('<span class="glyphicon glyphicon-send"></span>', $url, [
                                'title' => '退运费',
                                'aria-label' => '退运费',
                                'data-confirm' => '您是否退运费？',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }else{
                            return '';
                        }
                    }
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'order_sn',
            'c_user.user_name',
            [
                'attribute' => 'freight',
                'value' => function ($model) {
                    return $model->freight/100;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return OrderObject::dropDown('status', $model->status);
                }
            ],
            // 'cash_coin',
            // 'promotion_id',
            // 'promotion_discount',
            // 'total_fee',
            // 'commision_fee',
            // 'pay_time',
            // 'pay_type',
            // 'member_delivery_address_id',
            // 'delivery_way',
            // 'is_bill',
            // 'bill_type',
            // 'bill_header',
            // 'freight',
            // 'payment_fee',
            // 'link_man',
            // 'mobile',
            // 'province',
            // 'city',
            // 'area',
            // 'street',
            // 'address',
            // 'lon',
            // 'lat',
            // 'refund_date',
            // 'refund_fee',
            // 'refund_cash_coin',
            // 'remark',
            // 'in_state',
            // 'in_date',
            // 'in_verification',
            // 'procedure_fee',
            // 'bank_in',
            // 'refund_start_time:datetime',
            // 'pay_id',
            // 'create_time',
            // 'update_time',
            // 'status',
            // 'refund',
            // 'comment_status',
            // 'type',
            // 'app_id',
            // 'mall_store_id',
            // 'open_id',
            // 'api_order_sn',


        ],
    ]); ?>
</div>
