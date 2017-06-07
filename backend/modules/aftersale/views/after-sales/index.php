<?php

use common\models\AfterSales;
use common\widgets\link_pager\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\aftersale\models\search\AfterSalesSearch */
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
        'afterRow' => function ($model, $key, $index, $grid){
            return '<tr id="id'.$key.'" data-key="'.$key.'" data-index="'.$index.'" style="display:none"><td colspan="18" id = tdid'.$key.'></td></tr>';
        },
        'columns' => [
            [
                'header'=>'查看',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '15'],
                'template' => '{open}',
                'buttons' => [
                    'open' => function ($url, $model, $key) {
                        return Html::a('<span data-id="'.$model->id. '" data-aftersale_sn="'.$model->after_sn.'" class="open-row glyphicon glyphicon-collapse-up"></span>', 'javascript:;'); },
                ],
            ],

            [
                'header'=>'操作',
                'headerOptions' => ['width' => '75'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {agree} {refuse} {agree-send-back} {refuse-send-back}',
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
                        if($model->status ==1){
//                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
//                                'title' => '同意',
//                                'aria-label' => '同意',
//                                'data-confirm' => '您是否同意该次售后？',
//                                'data-method' => 'post',
//                                'data-pjax' => '0',
//                            ]);
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', '#', [
                                'title' => '同意',
                                'aria-label' => '同意',
                                'data-toggle' => 'modal',
                                'data-target' => '#aftersale-agree-modal',
                                'class' => 'data-aftersale-agree',
                                'data-id' => $key,
                            ]);
                        }else{
                            return '';
                        }
                    },
                    'refuse' => function ($url, $model, $key) {
                        if($model->status ==1){
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>', '#', [
                                'title' => '拒绝',
                                'aria-label' => '拒绝',
                                'data-toggle' => 'modal',
                                'data-target' => '#aftersale-refuse-modal',
                                'class' => 'data-aftersale-refuse',
                                'data-id' => $key,
                            ]);
                        }else{
                            return '';
                        }
                    },
                    'agree-send-back' => function ($url, $model, $key) {
                        if($model->status ==2 && $model->is_refund==2 && $model->send_back==1){
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
                                'title' => '同意回寄的货品',
                                'aria-label' => '同意回寄的货品',
                                'data-confirm' => '您是否确认回寄的货品？',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }else{
                            return '';
                        }
                    },
                    'refuse-send-back' => function ($url, $model, $key) {
                        if($model->status ==2 && $model->is_refund==2 && $model->send_back==1){
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>', '#', [
                                'title' => '拒绝回寄的货品',
                                'aria-label' => '拒绝回寄的货品',
                                'data-toggle' => 'modal',
                                'data-target' => '#aftersale-refuse-modal',
                                'class' => 'data-aftersale-refuse-send-back',
                                'data-id' => $key,
                            ]);
                        }else{
                            return '';
                        }
                    },
                ],
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'create_time',
            'update_time',

            [
                'attribute'=>'store.store_name',
                'label'=>'店铺',
                 'headerOptions' => ['width' => '150'],
            ],
            [
                'attribute'=>'order_object.order_sn',
                'label'=>'父订单号'
            ],
            'after_sn',
            'order_info_sn',
            'c_user.user_name',
            [
                'attribute'=>'pay_type',
                'value'=>function($model){
                    return AfterSales::dropDown('pay_type',$model->pay_type);
                },
            ],
            [
                'attribute'=>'is_refund',
                'value'=>function($model){
                    return AfterSales::dropDown('is_refund',$model->is_refund);
                },
            ],
            'product_bn',
            'quantity',
            [
                'attribute'=>'refund_money',
                'value'=>function($model){
                    return $model->refund_money/100;
                },
            ],
            'user_refund_reason',
            'user_first_reason',

            [
                'attribute'=>'status',
                'value'=>function($model){
                    return AfterSales::dropDown('status',$model->status);
                },
            ],
            // 'after_sn',
            // 'user_refund_reason',
            // 'user_first_reason',
            // 'supplementary_reason',
            // 'refund_money',
            // 'refund_cash_money',
            // 'img_proof1',
            // 'img_proof2',
            // 'img_proof3',

            // 'store_refuse_reason',
            // 'store_refuse_reason1',
            // 'is_refund',
            // 'type',
            // 'send_back',
            // 'courier_company',
            // 'courier_company_en',
            // 'courier_number',
            // 'create_time',
            // 'update_time',
            // 'platform_opinion',
            // 'before_order_status',



        ],
    ]); ?>
</div>

<?php
Modal::begin([
    'id'=>'aftersale-refuse-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();

Modal::begin([
    'id'=>'aftersale-agree-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
?>
<?php
$request_get_aftersale_detail_url = Url::to(['/aftersale/after-sales/get-after-sales-detail-html']);
$request_aftersale_refuse_url = Url::toRoute('refuse');
$request_aftersale_agree_url = Url::toRoute('agree');
$request_aftersale_refuse_send_back_url = Url::toRoute('refuse-send-back');
$modal_js = <<<JS
$(".open-row").on("click",function(){ 
        _this = $(this);
        aftersale_id = _this.data("id");
        _this.toggleClass("glyphicon-collapse-up glyphicon-expand");
        is = _this.hasClass("glyphicon-collapse-up");
        if(is){
            $("#id"+aftersale_id).hide();
        }else{
           $.ajax({
                type: "get",
                dataType: "text",
                data: {
                    "aftersale_id": aftersale_id
                },
                url: '{$request_get_aftersale_detail_url}',
                success: function (data) {
                   $("#tdid"+aftersale_id).html(data);
                }
            });
            $("#id"+aftersale_id).show();

        }
    }); 

    $('.data-aftersale-refuse').on('click', function () {
        $('#aftersale-refuse-modal').find('.modal-header').html('<h4 class="modal-title">拒绝售后申请</h4>');
        $('#aftersale-refuse-modal').find('.modal-body').css('height','550px');
        $('#aftersale-refuse-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_aftersale_refuse_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#aftersale-refuse-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-aftersale-agree').on('click', function () {
        $('#aftersale-agree-modal').find('.modal-header').html('<h4 class="modal-title">同意售后申请</h4>');
        $('.modal-body').html('');
        $('#aftersale-agree-modal').find('.modal-body').css('height','550px');
        $('#aftersale-agree-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_aftersale_agree_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#aftersale-agree-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-aftersale-refuse-send-back').on('click', function () {
        $('#aftersale-refuse-modal').find('.modal-header').html('<h4 class="modal-title">拒绝售后申请</h4>');
        $('#aftersale-refuse-modal').find('.modal-body').css('height','550px');
        $('#aftersale-refuse-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_aftersale_refuse_send_back_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#aftersale-refuse-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($modal_js,3);
?>
<?php
$this->params['view_modal_title'] = '查看售后申请单';
?>
