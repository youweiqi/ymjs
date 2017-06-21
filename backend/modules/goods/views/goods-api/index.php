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
        'afterRow' => function ($model, $key, $index, $grid){
            return '<tr id="id'.$key.'" data-key="'.$key.'" data-index="'.$index.'" style="display:none"><td colspan="14" id = tdid'.$key.'></td></tr>';
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
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'min-width:20px'],
            ],
            'goods_code',
            [
                'attribute' => 'api_goods_id',
                'headerOptions' => ['style' => 'min-width:107px'],
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => 'min-width:90px'],
                'format' => 'raw',
                'value' => function ($model) {
                    $all = $model->name;
                    $short = mb_substr($all, 0, 10,'utf-8');
                    return '<span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="'.$all.'">'.$short.'</span>';
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
                'label' => '商品分佣(%)',
                'value' =>'goods_commission.commission',
            ],
            [
                'headerOptions' => ['style' => 'min-width:70px'],
                'attribute' => 'category_parent_id',
                'value' => function ($model) {
                    return Category::getCategoryNameById($model->category_parent_id);
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:50px'],
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return Category::getCategoryNameById($model->category_id);
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'label'=>'品牌中文名',
                'attribute' => 'brand_id',
                'value' => 'brand.name_cn',
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
                'label'=>'品牌英文名',
                'attribute' => 'brand_id',
                'value' => 'brand.name_en',
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px'],
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
      $("[data-toggle='popover']").popover();
  
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
<?php
$request_get_good_detail_url = Url::to(['/goods/goods-api/get-good-detail-html']);
$open_row_js = <<<JS
    $(".open-row").on("click",function(){ 
        _this = $(this);
        good_id = _this.data("id");
        _this.toggleClass("glyphicon-collapse-up glyphicon-expand");
        is = _this.hasClass("glyphicon-collapse-up");
        if(is){
            $("#id"+good_id).hide();
        }else{
           $.ajax({
                type: "post",
                dataType: "text",
                data: {
                    "good_id": good_id
                },
                url: '{$request_get_good_detail_url}',
                success: function (data) {
                   $("#tdid"+good_id).html(data);
                }
            });
            $("#id"+good_id).show();

        }
    }); 
JS;
$this->registerJs($open_row_js,3);
?>


