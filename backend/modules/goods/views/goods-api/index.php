<?php

use backend\libraries\GoodsLib;
use common\models\Category;
use common\models\Goods;
use common\widgets\link_pager\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\GoodsApiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'API商品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('批量上下架', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-batch-update',
        ]); ?>
        <?= Html::a('批量设置分类', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'set-category',
        ]); ?>
        <?= Html::a('批量设置品牌', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'set-brand',
        ]); ?>
        <?= Html::a('批量设置分佣', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-commission',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model, $key, $index, $grid) {
            if($model->brand_id=='0'||$model->category_parent_id=='0'||$model->category_id=='0'){
                return ['style' => 'background:#DADADA'];
            }else if($model->online_time>date('Y-m-d H:i:s',time())||$model->offline_time<date('Y-m-d H:i:s',time())){
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
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'goods_code',
            'api_goods_id',
            'name',
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
                'value' => function ($model) {
                    return Category::getCategoryNameById($model->category_parent_id);
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return Category::getCategoryNameById($model->category_id);
                }
            ],
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
    'id'=>'batch-update-modal',
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
Modal::begin([
    'id'=>'set-category-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'set-brand-modal',
    'options' => [
        'tabindex' => false
    ],
]);
Modal::end();
$request_batch_update_url = Url::toRoute('up-down-goods');
$request_commission_url = Url::to(['/goods/goods-api/update-goods-commission']);
$request_set_category_url = Url::toRoute('set-category');
$request_set_brand_url = Url::toRoute('set-brand');

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
    
      $('#set-category').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
       if(keys.length>0){
            $('#set-category-modal').modal('toggle')
            $('#set-category-modal').find('.modal-header').html('<h4 class="modal-title">批量设置分类</h4>');
              $.post('{$request_set_category_url}', { ids: keys },
                    function (data) {
                        $('#set-category-modal').find('.modal-body').html(data);
                    }
                );
            
        }else{
            alert('请先选择需要操作的数据');
        }
      });
      $('#set-brand').bind('click', function () {
       var keys = $("#grid").yiiGridView("getSelectedRows");
       if(keys.length>0){
            $('#set-brand-modal').modal('toggle')
            $('#set-brand-modal').find('.modal-header').html('<h4 class="modal-title">批量设置品牌</h4>');
              $.post('{$request_set_brand_url}', { ids: keys },
                    function (data) {
                        $('#set-brand-modal').find('.modal-body').html(data);
                    }
                );
            
        }else{
            alert('请先选择需要操作的数据');
        }
      });

JS;
$this->registerJs($batch_update_modal_js,3);
?>


