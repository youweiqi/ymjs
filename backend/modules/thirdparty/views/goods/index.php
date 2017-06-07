<?php
use backend\modules\thirdparty\models\form\NumForm;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\thirdparty\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'API 商品';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <p>
        <?= Html::a('批量插入', '#', [
            'class' => 'btn btn-success  gridview',
            'id' => 'data-batch-update',
        ]); ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>[
            'id'=>'grid',
            'class'=>'grid-view',
            'style'=>'overflow:auto'
        ],
        'rowOptions' => function($model, $key, $index, $grid)  {
            if($model['exist']){
                return ['style' => 'background:#FFEDAC'];
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
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'header'=>'查看',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '50'],
                'template' => '{open}',
                'buttons' => [
                    'open' => function ($url, $model, $key) {
                        return Html::a('<span data-id="'.$key. '" data-order_sn="'.$key.'" class="open-row glyphicon glyphicon-collapse-up"></span>', 'javascript:;'); },
                ],
            ],
            [
                'attribute' => 'goodsId',
                'value'=>'goodsId',
                'label'=>'商品Id'
            ],

            [
                'attribute' => 'brandId',
                'value'=>'brandId',
                'label'=>'品牌Id'
            ],

            [
                'attribute' => 'goodsCode',
                'value'=>'goodsCode',
                'label'=>'商品编码'
            ],
            [
                'attribute' => 'name',
                'value'=>'name',
                'label'=>'商品名称'
            ],
            [
                'attribute' => 'suggestedPrice',
                'value'=>'suggestedPrice',
                'label'=>'吊牌价(分)'
            ]

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
$request_batch_update_url = Url::to(['/thirdparty/goods/add-api-goods']);

$batch_update_modal_js = <<<JS
    $('#data-batch-update').on('click', function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if(keys.length>0){
            $.post('{$request_batch_update_url}',{ ids:keys });
            console.log(keys)
        }else{
            alert('请先选择需要操作的数据');
        }
    });
JS;
$this->registerJs($batch_update_modal_js,3);
?>
<?php
$request_get_order_detail_url = Url::to(['/thirdparty/goods/get-goods-html']);
$open_row_js = <<<JS
    $(".open-row").on("click",function(){ 
        _this = $(this);
        goods_id = _this.data("goodsId");
        _this.toggleClass("glyphicon-collapse-up glyphicon-expand");
        is = _this.hasClass("glyphicon-collapse-up");
        if(is){
            $("#id"+goods_id).hide();
        }else{
           $.ajax({
                type: "post",
                dataType: "text",
                data: {
                    "goods_id": goods_id
                },
                url: '{$request_get_order_detail_url}',
                success: function (data) {
                   $("#tdid"+goods_id).html(data);
                }
            });
            $("#id"+goods_id).show();

        }
    }); 
JS;
$this->registerJs($open_row_js,3);
?>
