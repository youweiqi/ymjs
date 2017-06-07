<?php
use common\models\Goods;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<p>
    <?php
    echo Html::a('新增货品', '#', [
        'id' => 'create_product',
        'data-toggle' => 'modal',
        'data-target' => '#create-product-modal',
        'class' => 'btn btn-success',
    ]); ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'goods_id',
            'label' => '商品编码',
            'value'=>function($model){
                return Goods::getGoodsCodeById($model->goods_id);
            },
        ],

        'product_bn',
        'spec_name',
        'bar_code',
        'update_time',
        [
            'attribute' => 'status',
            'value'=>function($model){
                return  $model->status=='1'?'启用':'禁用';
            },
        ],
        [
            'header'=>'操作',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '75'],
            'template' => '{update-product}',
            'buttons' => [
                'update-product' => function ($url, $model, $key) {
                    $options = [
                        'title' =>  '更新',
                        'aria-label' =>  '更新',
                        'data-toggle' => 'modal',
                        'data-target' => '#update-product-modal',
                        'class' => 'data-update-product',
                        'data-id' => $key,
                    ];
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', $options);
                },
            ]
        ],
    ],
]); ?>
<?php
Modal::begin([
    'id' => 'create-product-modal',
    'header' => '<h4 class="modal-title">新增货品</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
Modal::begin([
    'id' => 'update-product-modal',
    'header' => '<h4 class="modal-title">更新货品</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
?>
<?php
$request_create_product_url = Url::to(['/goods/product/create','goods_id'=>$goods_id]);
$request_update_product_url = Url::to(['/goods/product/update']);
$product_modal_js = <<<JS
    $('#create_product').on('click', function () {
        $('#create-product-modal').find('.modal-body').html('');
        $.get('{$request_create_product_url}',
            function (data) {
                $('#create-product-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-update-product').on('click', function () {
        $('#update-product-modal').find('.modal-body').html('');
        $.get('{$request_update_product_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#update-product-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($product_modal_js,3);
?>
