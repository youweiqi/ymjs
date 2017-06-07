<?php

use common\models\AfterSales;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\finance\models\search\RefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '售后列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="after-sales-index">

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
                'headerOptions' => ['width' => '75'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {agree} {god-agree}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#view-modal',
                            'class' => 'data-view',
                            'data-id' => $key,
                        ]);
                    },
                    'agree' => function ($url, $model, $key) {
                        if(($model->status ==2&&$model->is_refund==1)||($model->status ==2&&$model->is_refund==2&&$model->send_back==1)){
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
                                'title' => '同意',
                                'aria-label' => '同意',
                                'data-confirm' => '您是否同意该次退款？',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }else{
                            return '';
                        }
                    },
                    'god-agree' => function ($url, $model, $key) {
                        if($model->status ==2){
                            return Html::a('<span class="glyphicon glyphicon-send"></span>', $url, [
                                'title' => '强制完成',
                                'aria-label' => '强制完成',
                                'data-confirm' => '您是否强制退款退款？',
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
            [
                'label'=>'父订单号',
                'value'=>'order_object.order_sn'
            ],
            [
                'attribute'=>'pay_type',
                'value'=>function($model){
                    return AfterSales::dropDown('pay_type',$model->pay_type);
                },
            ],
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return AfterSales::dropDown('status',$model->status);
                },
            ],
            'store_refuse_reason',
            [
                'attribute'=>'is_refund',
                'value'=>function($model){
                    return AfterSales::dropDown('is_refund',$model->is_refund);
                },
            ],
            'c_user.user_name',
            'order_info_sn',
            'product_bn',
            'user_refund_reason',
            'user_first_reason',
            [
                'attribute'=>'refund_money',
                'value'=>function($model){
                    return $model->refund_money/100;
                },
            ],
            'refund_cash_money',
            'courier_company',
            'courier_number',


        ],
    ]); ?>
</div>
