<?php

use backend\libraries\StoreLib;
use common\models\Inventory;
use common\widgets\link_pager\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\warehouse\models\search\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '库存列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>



        <?php if(Yii::$app->user->id=='1'){
            echo  Html::a('新增库存', '#', [
                'data-toggle' => 'modal',
                'data-target' => '#operate-modal',
                'class' => 'btn btn-success',
                'id' => 'data-operate',
            ]);
        }
        ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],

        'options'=>[
            'class'=>'grid-view',
            'style'=>'overflow:auto',
            'id'=>'grid'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name'=>'id'
            ],
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#operate-modal',
                            'class' => 'data-operate',
                            'data-id' => $key,
                        ]);
                    },
                ],
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'product.product_bn',
            'product.spec_name',
            'goods.name',
            [
                'label' =>'店铺',
                'value'=>function ($model) {
                    if($model->store_id =='0'){
                        $store_name = '贡云商城';
                    }else{
                        $store_name = StoreLib::getStoreName($model->store_id);
                    }
                    return $store_name;
                }
            ],
            'inventory_num',
            [
                'attribute'=>'sale_price',
                'value'=>function ($model) {
                    return $model->sale_price/100;
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Inventory::dropDown('status', $model->status);
                },
            ],


        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增库存';
$this->params['update_modal_title'] = '更新库存';
?>
<?php
Modal::begin([
    'id'=>'batch-update-modal',
    'options' => [
        'tabindex' => false,
        'style' => 'margin-top:80px',
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();

Modal::begin([
    'id'=>'batch-inventory-modal',
    'options' => [
        'tabindex' => false,
        'style' => 'margin-top:80px',
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'batch-import-modal',
    'header'=>'<button type="button" class="close" data-dismiss="modal"></button><h4 class="modal-title">批量导入库存</h4>',
    'options' => [
        'tabindex' => false,
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();

$request_batch_update_url = Url::to(['/warehouse/inventory/batch-add']);
$request_batch_inventory_url = Url::to(['/warehouse/inventory/batch-inventory']);
$request_batch_import_url = Url::to(['/warehouse/inventory/import-inventory']);

$batch_update_modal_js = <<<JS
    $('#data-batch-update').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
         if(keys.length>0){
           $('#batch-update-modal').modal('toggle')
            $('#batch-update-modal').find('.modal-header').html('<h4 class="modal-title">批量加运费模板</h4>');
              $.post('{$request_batch_update_url}', { ids: keys },
                    function (data) {
                        $('#batch-update-modal').find('.modal-body').html(data);
                    }
                );
            
        }else{
            alert('请先选择需要操作的数据');
        }
      });
$('#data-batch-inventory').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
       if(keys.length>0){
           $('#batch-inventory-modal').modal('toggle')
            $('#batch-inventory-modal').find('.modal-header').html('<h4 class="modal-title">批量添加库存</h4>');
              $.post('{$request_batch_inventory_url}', { ids: keys },
                    function (data) {
                        $('#batch-inventory-modal').find('.modal-body').html(data);
                    }
                );
        }else{
            alert('请先选择需要操作的数据');
        }
      });
 $('#data-batch-import').on('click', function () {
        $('.modal-body').html('');
        $('#data-batch-import').find('.modal-body').css('height','550px');
        $('#data-batch-import').find('.modal-body').css('overflow-y','auto');
        $.post('{$request_batch_import_url}',
            function (data) {
                $('#batch-import-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($batch_update_modal_js,3);
?>
<?php


?>

