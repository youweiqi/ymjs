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
        <?= Html::a('批量领取', '#', [
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
    'id' => 'batch-update-modal',
    'header' => '<h4 class="modal-title">批量领取</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
?>
<?php
$request_batch_update_url = Url::to(['batch-draw']);
$modal_js = <<<JS
 $('#data-batch-update').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
       if(keys.length>0){
           $('#batch-update-modal').modal('toggle')
            $('#batch-update-modal').find('.modal-header').html('<h4 class="modal-title">批量领取</h4>');
              $.post('{$request_batch_update_url}', { ids: keys },
                   /* function (data) {
                        $('#batch-update-modal').find('.modal-body').html(data);
                    }*/
                );
            }else{
            alert('请先选择需要操作的订单');
        }
      });
JS;
$this->registerJs($modal_js,3);
?>
