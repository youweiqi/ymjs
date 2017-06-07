<?php

use common\models\Product;
use common\models\Store;
use common\widgets\link_pager\LinkPager;


use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\warehouse\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '货号列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('批量插入库存表', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-batch-update',
        ]); ?>
    </p>
    <?php
    $model=new Store();
    ?>
    <?php $form = ActiveForm::begin([
        'id' => 'store',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form']),
        'options' => [
            'class'=>'form-inline',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [

            //'template' => "<div style='margin:auto 10px'>{label}&nbsp;&nbsp; {input}</div>",
            'template' => "<div class='col-sm-8 text-left'>{label}:</div><div style='margin: auto' class='col-sm-12'>{input}</div><div>{hint}</div><div class='col-sm-8 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?=  $form->field($model, 'id')->label('门店')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请选择门店...'],
        'data' => isset($inventory_store_data)?$inventory_store_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/warehouse/store/search-store']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {store_name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],

    ]); ?>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
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
            'id',
            'product_bn',
            'goods.name',
            'spec_name',
            'bar_code',
            // 'supply_threshold',
            // 'is_stock_warn',
            // 'create_time',
            // 'update_time',
            // 'is_del',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Product::dropDown('status', $model->status);
                },
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$request_batch_update_url = Url::toRoute(['product/insert-inventory']);

$batch_update_modal_js = <<<JS
      $('body').on('click','#data-batch-update', function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        var store_id=$("#store-id").val();
        console.log(keys,store_id);
        if(keys.length>0&&store_id!==''){
          $.post('{$request_batch_update_url}',{ ids:keys,store_id:store_id});
                }else{
            alert('请先选择需要操作的数据');
       }
      });
    
JS;
$this->registerJs($batch_update_modal_js,3);
?>
