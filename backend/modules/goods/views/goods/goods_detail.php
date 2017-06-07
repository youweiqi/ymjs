<?php
use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>

<div class="good-detail-index">
    <p>
        <?php
        echo Html::a('新增商品详情', '#', [
            'id' => 'create_goods_detail',
            'data-toggle' => 'modal',
            'data-target' => '#create-goods-detail-modal',
            'class' => 'btn btn-success',
        ]); ?>
    </p>
    <?php Pjax::begin(['id'=>'goods_detail_list_pjax','enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'good_id',
            [
                'attribute' => 'image_path',
                'label' => '图片',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->image_path);
                }
            ],
            'image_height',
            'image_width',
            'order_no',

            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{/goods/goods-detail/delete}',
                'buttons' => [
                    '/goods/goods-detail/delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => '删除',
                            'aria-label' => '删除',
                            'data-confirm' => '您确认要删除该商品详情么？',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
Modal::begin([
    'id' => 'create-goods-detail-modal',
    'header' => '<h4 class="modal-title">新增商品详情</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
?>
<?php
$request_create_goods_detail_url = Url::to(['/goods/goods-detail/create','goods_id'=>$goods_id]);
$request_update_goods_detail_url = Url::to(['/goods/goods-detail/update']);
$goods_detail_modal_js = <<<JS
    $('#create_goods_detail').on('click', function () {
        $('#create-goods-detail-modal').find('.modal-body').html('');
        $.get('{$request_create_goods_detail_url}',
            function (data) {
                $('#create-goods-detail-modal').find('.modal-body').html(data);
            }
        );
    });
    $('.data-update-goods_detail').on('click', function () {
        $('#update-goods_detail-modal').find('.modal-body').html('');
        $.get('{$request_update_goods_detail_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#update-goods-detail-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($goods_detail_modal_js,3);
?>
