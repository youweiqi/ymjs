<?php

use common\models\CUser;
use common\models\OrderInfo;
use common\models\OrderObject;
use common\models\Product;
use common\widgets\link_pager\LinkPager;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\search\OrderInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <P>
        <?= Html::a('批量分派', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-batch-update',
        ]); ?>
    </P>

    <?php
    echo  GridView::widget([
        'tableOptions' => [
            'style' => 'display:block;overflow:auto;',
            'class' => 'table table-striped table-bordered'
        ],
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model, $key, $index, $grid) {
            //有售后的显示红色
            if($model->refund=='1'){
                return ['style' => 'background:#FFC903'];
            }else{
                return [];
            }
        },

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'afterRow' => function ($model, $key, $index, $grid){
            return '<tr id="id'.$key.'" data-key="'.$key.'" data-index="'.$index.'" style="display:none"><td colspan="20" id = tdid'.$key.'></td></tr>';},
        'options'=>[
            "id"=>"grid",
            "class"=>"grid-view",
            "style"=>"overflow:auto"
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
            ],
            [
                'header'=>'查看',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'min-width:50px'],
                'template' => '{open}',
                'buttons' => [
                    'open' => function ($url, $model, $key) {
                        return Html::a('<span data-id="'.$model->id. '" data-order_sn="'.$model->order_sn.'" class="open-row glyphicon glyphicon-collapse-up"></span>', 'javascript:;'); },
                ],
            ],
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'min-width:70px'],
                'template' => '{add}',
                'buttons' =>[
                    'add' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-flag"></span>','#',[
                            'data-toggle' => 'modal',
                            'data-target' => '#add-modal',
                            'class' => 'data-add',
                            'data-id' => $key,
                        ]);
                    },
                ]
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute'=>'order_sn'
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'active_status',
                'value' => function ($model) {
                    return OrderInfo::dropDown('active_status', $model->active_status);
                }
            ],

            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'status',
                'value' => function ($model) {
                    return OrderInfo::dropDown('status', $model->status);
                }
            ],
            [
                'attribute' => 'create_time',
                'headerOptions' => ['style' => 'min-width:100px']
            ],
            [
                'attribute' => 'user_id',
                'value' => 'c_user.user_name',
                'label'=>'会员',
                'headerOptions' => ['style' => 'min-width:100px']
            ],
            [
                'attribute' => 'order_object_id',
                'value' => 'order_object.order_sn',
                'label'=>'父订单号',
                'headerOptions' => ['style' => 'min-width:100px']
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'store_name',
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'refund',
                'value' => function ($model) {
                    return OrderInfo::dropDown('refund', $model->refund);
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'pay_type',
                'value' => function ($model) {
                    return OrderInfo::dropDown('pay_type', $model->pay_type);
                }
            ],
            [
                'attribute' => 'link_man',
                'headerOptions' => ['style' => 'min-width:100px'],
            ],
            [
                'attribute' => 'mobile',
                'headerOptions' => ['style' => 'min-width:100px'],
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'total_price',
                'value' => function ($model) {
                    return $model->total_price/100;
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'attribute' => 'delivery_way',
                'value' => function ($model) {
                    return OrderInfo::dropDown('delivery_way', $model->delivery_way);
                },
            ],
            [
                'headerOptions' => ['style' => 'min-width:50px'],
                'attribute' => 'procedure_fee',
                'label'=>'运费',
                'value' => function ($model) {
                    return $model->order_object->freight/100;
                }
            ],


        ],
    ]); ?>
</div>

<?php
$request_get_order_detail_url = Url::to(['/order/order-detail/get-order-detail-html']);
$open_row_js = <<<JS
    $(".open-row").on("click",function(){ 
        _this = $(this);
        order_id = _this.data("id");
        _this.toggleClass("glyphicon-collapse-up glyphicon-expand");
        is = _this.hasClass("glyphicon-collapse-up");
        if(is){
            $("#id"+order_id).hide();
        }else{
           $.ajax({
                type: "post",
                dataType: "text",
                data: {
                    "order_id": order_id
                },
                url: '{$request_get_order_detail_url}',
                success: function (data) {
                   $("#tdid"+order_id).html(data);
                }
            });
            $("#id"+order_id).show();

        }
    }); 
JS;
$this->registerJs($open_row_js,3);
?>

<?php
Modal::begin([
    'id' => 'view-modal',
    'header' => '<h4 class="modal-title">订单明细</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
Modal::begin([
    'id' => 'add-modal',
    'header' => '<h4 class="modal-title">订单备注</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();

Modal::begin([
    'id' => 'delivery-modal',
    'header' => '<h4 class="modal-title">订单发货</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
?>
<?php
$request_delivery_url = Url::to(['/order/order-info/delivery']);
$request_view_url = Url::to(['/order/order-info/view']);
$request_add_url = Url::to(['/order/order-info/update']);
$modal_js = <<<JS
    $('.data-delivery').on('click', function () {
        $('#delivery-modal').find('.modal-header').html('<h4 class="modal-title">订单发货</h4>');
        $('#delivery-modal').find('.modal-body').html('');
        $.get('{$request_delivery_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#delivery-modal').find('.modal-body').html(data);
            }
        );
    });
$('.data-view').on('click', function () {
        $('#view-modal').find('.modal-header').html('<h4 class="modal-title">订单明细</h4>');
        $('#view-modal').find('.modal-body').html('');
        $('#view-modal').find('.modal-body').css('height','600px');
        $('#view-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_view_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#view-modal').find('.modal-body').html(data);
            }
        );
    });
$('.data-add').on('click', function () {
        $('#add-modal').find('.modal-header').html('<h4 class="modal-title">订单备注</h4>');
        $('#add-modal').find('.modal-body').html('');
        $('#add-modal').find('.modal-body').css('height','300px');
        $('#add-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_add_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#add-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($modal_js,3);
?>
