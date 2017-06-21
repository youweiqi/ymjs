<?php

use backend\libraries\CategoryLib;
use backend\libraries\GoodsLib;
use common\models\Goods;
use common\widgets\link_pager\LinkPager;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增商品', ['create-goods'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('批量上下架', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-batch-update',
        ]); ?>
        <?= Html::a('批量设置分佣', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-commission',
        ]); ?>
    </p>

    <?= GridView::widget([
        'export'=>false,
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model, $key, $index, $grid) {
            if($model->online_time>date('Y-m-d H:i:s',time())||$model->offline_time<date('Y-m-d H:i:s',time())){
                return ['style' => 'background:#A2A2A2'];
            }
            return [];
        },
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
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
                        return Html::a('<span data-id="'.$model->id. '" class="open-row glyphicon glyphicon-collapse-up"></span>', 'javascript:;'); },
                ],
            ],
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'min-width:60px'],
                'template' => '{update}{commission}{view-log}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update-goods','id'=>$key]));
                    },
                    'commission' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-yen"></span>', '#',
                                [
                                    'title' => '商品分佣',
                                    'aria-label' => '商品分佣',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#good-commission-modal',
                                    'class' => 'data-good-commission',
                                    'data-id' => $key,
                                ]);
                    },
                    'view-log' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', '#', [
                            'title' => '查看操作日志',
                            'aria-label' => '查看操作日志',
                            'data-toggle' => 'modal',
                            'data-target' => '#view-log-modal',
                            'class' => 'data-view-log',
                            'data-id' => $key,
                        ]);
                    },
            ],
        ],
            [
                'headerOptions' => ['style' => 'min-width:60px'],
                'attribute' => 'id',
            ],
            [
                'attribute' => 'goods_code',
                'headerOptions' => ['style' => 'min-width:10px'],
            ],
            'label_name',
            [
                'headerOptions' => ['style' => 'min-width:102px'],
                'label' => '商品分佣(%)',
                'value' =>'goods_commission.commission',
            ],

            [
                'headerOptions' => ['style' => 'min-width:107px'],
                'attribute' => 'category_parent_id',
                'label' => '2级分类',
                'value' => function ($model) {
                    return CategoryLib::getCategoryName($model->category_parent_id);
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:107px'],
                'attribute' => 'category_id',
                'label' => '3级分类',
                'value' => function ($model) {
                    return CategoryLib::getCategoryName($model->category_id);
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:107px'],
                'attribute' => 'goods_img',
                'label' => '商品图片',
                'format' => 'html',
                'value' => function ($model) {
                    return GoodsLib::getGoodsImg($model->id,'60px');
                }
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => 'min-width:50px'],
            ]
            ,
            [
                'headerOptions' => ['style' => 'min-width:107px'],
                'label'=>'品牌中文名',
                'attribute' => 'brand_id',
                'value' => 'brand.name_cn',
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'label'=>'品牌英文名',
                'attribute' => 'brand_id',
                'value' => 'brand.name_en',
            ],

            [
                'headerOptions' => ['style' => 'min-width:80px'],
                'attribute' => 'channel',
                'label' => '来源渠道',
                'value' => function ($model) {
                    return Goods::dropDown('channel',$model->channel);
                }
            ],
            [
                'attribute' => 'online_time',
                'headerOptions' => ['style' => 'min-width:100px']
            ],
            [
                'attribute' => 'offline_time',
                'headerOptions' => ['style' => 'min-width:100px']
            ],
        ],
    ]); ?>

</div>
<?php
$this->params['view_log_modal_title'] = '查看商品分佣操作日志';
$this->params['log_type'] = 'goods_commission';
?>
<?php
Modal::begin([
    'id'=>'up-down-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'commission-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
$request_commission_url = Url::to(['/goods/goods/update-goods-commission']);

$modal_js = <<<JS
     $('#data-commission').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
       if(keys.length>0){
           $('#commission-modal').modal('toggle')
            $('#commission-modal').find('.modal-header').html('<h4 class="modal-title">设置分佣</h4>');
              $.post('{$request_commission_url}', { ids: keys },
                    function (data) {
                        $('#commission-modal').find('.modal-body').html(data);
                    }
                );
            
        }else{
            alert('请先选择需要操作的数据');
        }
      });
   
JS;
$this->registerJs($modal_js,3);
?>
<?php
Modal::begin([
    'id'=>'batch-update-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'good-commission-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
$request_batch_update_url = Url::toRoute(['goods/up-down-goods']);
$request_commission1_url = Url::toRoute(['/goods/goods/update-good-commission']);
$batch_update_modal_js = <<<JS

 $('.data-good-commission').on('click', function () {
        $('#good-commission-modal').find('.modal-header').html('<h4 class="modal-title">商品分佣</h4>');
        $('#good-commission-modal').find('.modal-body').html('');
        $('#good-commission-modal').find('.modal-body').css('height','350px');
        $('#good-commission-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_commission1_url}',{ goods_id: $(this).closest('tr').data('key') },
            function (data) {
                $('#good-commission-modal').find('.modal-body').html(data);
            }
        );
    });
  
    $('#data-batch-update').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
       if(keys.length>0){
           $('#batch-update-modal').modal('toggle')
            $('#batch-update-modal').find('.modal-header').html('<h4 class="modal-title">批量上下架</h4>');
              $.post('{$request_batch_update_url}', { ids: keys },
                    function (data) {
                        $('#batch-update-modal').find('.modal-body').html(data);
                    }
                );
            
        }else{
            alert('请先选择需要操作的数据');
        }
      });
JS;
$this->registerJs($batch_update_modal_js,3);
?>
<?php
$this->params['create_modal_title'] = '新增商品';
$this->params['update_modal_title'] = '更新商品';
?>

