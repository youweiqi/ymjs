<?php

use common\models\AfterSales;
use common\widgets\link_pager\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\aftersale\models\search\ComplainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '申诉列表';
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
                'headerOptions' => ['style' => 'min-width:50px'],
                'template' => '{open}',
                'buttons' => [
                    'open' => function ($url, $model, $key) {
                        return Html::a('<span data-id="'.$model->id. '" data-aftersale_sn="'.$model->after_sn.'" class="open-row glyphicon glyphicon-collapse-up"></span>', 'javascript:;'); },
                ],
            ],

            [
                'header'=>'操作',
                'headerOptions' => ['style' => 'min-width:70px'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {agree} {refuse}  {agree-send-back} {refuse-send-back}',
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
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
                                'title' => '同意',
                                'aria-label' => '同意',
                                'data-confirm' => '您是否同意该次售后申诉？',
                                'data-method' => 'post',
                                'data-pjax' => '0',
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
                                'data-target' => '#complain-refuse-modal',
                                'class' => 'data-complain-refuse',
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
                                'data-target' => '#complain-refuse-modal',
                                'class' => 'data-complain-refuse-send-back',
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
                'headerOptions' => ['style' => 'min-width:20px'],
            ],

            [
                'headerOptions' => ['style' => 'min-width:70px'],
                'attribute'=>'status',
                'value'=>function($model){
                    return AfterSales::dropDown('status',$model->status);
                },
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'attribute'=>'is_refund',
                'value'=>function($model){
                    return AfterSales::dropDown('is_refund',$model->is_refund);
                },
            ],
            [
                'attribute' => 'c_user.user_name',
                'headerOptions' => ['style' => 'min-width:100px'],
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute'=>'after_sn'
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute'=>'order_info_sn'
            ],
            [
                'attribute'=>'order_object.order_sn',
                'label'=>'父订单号',
                'headerOptions' => ['style' => 'min-width:100px'],
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute'=>'product_bn',
            ],
            [
                'headerOptions' => ['style' => 'min-width:120px'],
                'attribute'=>'user_refund_reason',
                'format' => 'raw',
                'value' => function ($model) {
                    $all = $model->user_refund_reason;
                    $short = mb_substr($all, 0, 7,'utf-8');
                    return '<span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="'.$all.'">'.$short.'</span>';
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:160px'],
                'attribute'=>'user_first_reason',
                'format' => 'raw',
                'value' => function ($model) {
                    $all = $model->user_first_reason;
                    $short = mb_substr($all, 0, 7,'utf-8');
                    return '<span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="'.$all.'">'.$short.'</span>';
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'attribute'=>'refund_money',
                'value'=>function($model){
                    return $model->refund_money/100;
                },
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'attribute'=>'refund_cash_money',
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'attribute'=>'courier_company',
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'attribute'=>'courier_number',
            ],
        ],
    ]); ?>
</div>

<?php
Modal::begin([
    'id'=>'complain-refuse-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
?>
<?php
$request_get_aftersale_detail_url = Url::to(['/aftersale/after-sales/get-after-sales-detail-html']);
$request_complain_refuse_url = Url::toRoute('refuse');
$request_complain_refuse_send_back_url = Url::toRoute('refuse-send-back');

$modal_js = <<<JS
      $("[data-toggle='popover']").popover();
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
    $('.data-complain-refuse').on('click', function () {
        $('#complain-refuse-modal').find('.modal-header').html('<h4 class="modal-title">拒绝售后申请</h4>');
        $('#complain-refuse-modal').find('.modal-body').css('height','550px');
        $('#complain-refuse-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_complain_refuse_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#complain-refuse-modal').find('.modal-body').html(data);
            }
        );
    });
$('.data-complain-refuse-send-back').on('click', function () {
        $('#complain-refuse-modal').find('.modal-header').html('<h4 class="modal-title">拒绝售后申请</h4>');
        $('#complain-refuse-modal').find('.modal-body').css('height','550px');
        $('#complain-refuse-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_complain_refuse_send_back_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#complain-refuse-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($modal_js,3);
?>
<?php
$this->params['view_modal_title'] = '查看售后申诉单';
?>

