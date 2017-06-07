<?php

use common\components\Common;
use common\models\Goods;
use common\models\Product;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<div class="goods-navigate-index">

    <p>
        <?php
        echo Html::a('新增商品主图', '#', [
            'id' => 'create_goods_navigate',
            'data-toggle' => 'modal',
            'data-target' => '#create-goods-navigate-modal',
            'class' => 'btn btn-success',
        ]); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'good_id',
                'label' => '商品编号',
                'value'=>function($model){
                    return Goods::getGoodsCodeById($model->good_id);
                }
            ],
            [
                'attribute' => 'navigate_image',
                'label' => '商品主图',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->navigate_image);
                }
            ],
            'order_no',
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update-goods-navigate} {/goods/goods-navigate/delete}',
                'buttons' => [
                    'update-goods-navigate' => function ($url, $model, $key) {
                        $options = [
                            'title' =>  '更新',
                            'aria-label' =>  '更新',
                            'data-toggle' => 'modal',
                            'data-target' => '#update-goods-navigate-modal',
                            'class' => 'data-update-goods-navigate',
                            'data-id' => $key,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', $options);
                    },
                    '/goods/goods-navigate/delete' => function ($url, $model, $key) {
                        $options = [
                            'title' =>  '删除',
                            'aria-label' =>  '删除',
                            'data-confirm' => '您确定要删除该项？',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ]

            ],
        ],
    ]); ?>
</div>
<?php
Modal::begin([
    'id' => 'create-goods-navigate-modal',
    'header' => '<h4 class="modal-title">新增商品主图</h4>',
]);
Modal::end();
Modal::begin([
    'id' => 'update-goods-navigate-modal',
    'header' => '<h4 class="modal-title">更新商品主图</h4>',
]);
Modal::end();
?>
<?php
$request_create_goods_navigate_url = Url::to(['/goods/goods-navigate/create','goods_id'=>$goods_id]);
$request_update_goods_navigate_url = Url::to(['/goods/goods-navigate/update']);
$goods_navigate_modal_js = <<<JS
    $('#create_goods_navigate').on('click', function () {
        $('#create-goods-navigate-modal').find('.modal-body').html('');
        $.get('{$request_create_goods_navigate_url}',
            function (data) {
                $('#create-goods-navigate-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-update-goods-navigate').on('click', function () {
        $('#update-goods-navigate-modal').find('.modal-body').html('');
        $.get('{$request_update_goods_navigate_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#update-goods-navigate-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($goods_navigate_modal_js,3);
?>

