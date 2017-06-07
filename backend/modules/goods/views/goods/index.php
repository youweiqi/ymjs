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
        <?= Html::a('新增商品', ['create'], ['class' => 'btn btn-success']) ?>

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
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100'],
                'template' => '{update}',
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'goods_code',
            'label_name',
            [
                'attribute'=>'score_rate',
                'class'=>'kartik\grid\EditableColumn',
                'editableOptions'=>[
                'asPopover' => false,
                     ],
            ],
            [
                'attribute'=>'talent_limit',
                'class'=>'kartik\grid\EditableColumn',
                'editableOptions'=>[
                    'asPopover' => false,
                ],
            ],
            [
                'attribute' => 'category_parent_id',
                'label' => '2级分类',
                'value' => function ($model) {
                    return CategoryLib::getCategoryName($model->category_parent_id);
                }
            ],
            [
                'attribute' => 'goods_img',
                'label' => '商品图片',
                'format' => 'html',
                'value' => function ($model) {
                    return GoodsLib::getGoodsImg($model->id,'60px');
                }
            ],
            'name',
            [
                'label'=>'品牌中文名',
                'attribute' => 'brand_id',
                'value' => 'brand.name_cn',
            ],
            [
                'label'=>'品牌英文名',
                'attribute' => 'brand_id',
                'value' => 'brand.name_en',
            ],

            [
                'attribute' => 'channel',
                'label' => '来源渠道',
                'value' => function ($model) {
                    return Goods::dropDown('channel',$model->channel);
                }
            ],
            'online_time',
            'offline_time',

        ],
    ]); ?>

</div>
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
            $('#commission-modal').find('.modal-header').html('<h4 class="modal-title">批量设置分佣</h4>');
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
$request_batch_update_url = Url::toRoute(['goods/up-down-goods']);

$batch_update_modal_js = <<<JS
  
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

