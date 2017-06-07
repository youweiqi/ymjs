<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\tgtools\models\search\TgLinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推广链接';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-link-index">

    <h1><?= Html::encode($this->title) ?></h1>
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增商品券推广链接', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#goods-tg-modal',
            'class' => 'btn btn-success btn-sm',
            'id' => 'data-goods-tg',
        ]); ?>
        <?= Html::a('新增品牌券推广链接', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#brand-tg-modal',
            'class' => 'btn btn-success btn-sm',
            'id' => 'data-brand-tg',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' =>'链接Id',
            ],
            [
                'attribute' => 'identifier',
                'label' =>'唯一标识',
            ],
            [
                'attribute' => 'channel_id',
                'value' => 'channel.name',
                'label' =>'所属渠道',
            ],
            [
                'attribute' => 'promotion_detail_id',
                'value' => 'promotionDetail.promotion_detail_name',
                'label' =>'优惠券名称',
            ],
            [
                'attribute' => 'type',
                'label' =>'券类型',
                'value' => function($model)
                {
                    return \common\models\TgLink::DropDown('type',$model->type);
                }
            ],
            [
                'attribute' => 'promotion_total_num',
                'label' =>'此链接可以发券数',
            ],
            [
                'attribute' => 'promotion_person_num',
                'label' =>'单用户可以领券数',
            ],
            [
                'value' => function($model){
                    return $model->type == 1?TG_H5_GOODS_URL.$model->identifier:TG_H5_BRAND_URL.$model->identifier;
                },
                'label' =>'链接',
            ],
            // 'create_time',
            // 'type',
            // 'serial_id',
            // 'memo:ntext',
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '10'],
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => $model->type == 1 ? '#goods-tg-modal' : '#brand-tg-modal','',
                            'class' => $model->type == 1 ? 'tg-goods-update' : 'tg-brand-update',
                            'data-id' => $model->id,
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>
</div>
<?php
Modal::begin([
    'id'=>'goods-tg-modal',
    'header'=>'<h4 class="modal-title">添加商品券推广链接</h4>',
    'options' => [
        'tabindex' => false,
        'style' => 'margin-top:80px',
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();

Modal::begin([
    'id'=>'brand-tg-modal',
    'header'=>'<h4 class="modal-title">添加品牌券推广链接</h4>',
    'options' => [
        'tabindex' => false,
        'style' => 'margin-top:80px',
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();

$create_goods_tg_url = Url::toRoute('goods-tg-create');
$create_brand_tg_url = Url::toRoute('brand-tg-create');

$update_goods_tg_url = Url::toRoute('goods-tg-update');
$update_brand_tg_url = Url::toRoute('brand-tg-update');

$modal_js = <<<JS
$('#data-goods-tg').on('click', function () {
        $('#goods-tg-modal').find('.modal-title').html('添加商品券推广链接');
        $('#goods-tg-modal').find('.modal-body').html('');
        $('#goods-tg-modal').find('.modal-body').css('height','500px');
        $('#goods-tg-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$create_goods_tg_url}',
            function (data) {
                $('#goods-tg-modal').find('.modal-body').html(data);
            }
        );
    });
$('#data-brand-tg').on('click', function () {
    $('#brand-tg-modal').find('.modal-title').html('添加品牌券推广链接');
    $('#brand-tg-modal').find('.modal-body').html('');
    $('#brand-tg-modal').find('.modal-body').css('height','500px');
    $('#brand-tg-modal').find('.modal-body').css('overflow-y','auto');
    $.get('{$create_brand_tg_url}',
        function (data) {
            $('#brand-tg-modal').find('.modal-body').html(data);
        }
    );
});
$('.tg-goods-update').on('click', function () {
        $('#goods-tg-modal').find('.modal-title').html('编辑 商品券推广链接');
        $('#goods-tg-modal').find('.modal-body').html('');
        $('#goods-tg-modal').find('.modal-body').css('height','500px');
        $('#goods-tg-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$update_goods_tg_url}',{id:$(this).data('id')},
            function (data) {
                $('#goods-tg-modal').find('.modal-body').html(data);
            }
        );
    });
$('.tg-brand-update').on('click', function () {
    $('#brand-tg-modal').find('.modal-title').html('编辑品牌券推广链接');
    $('#brand-tg-modal').find('.modal-body').html('');
    $('#brand-tg-modal').find('.modal-body').css('height','500px');
    $('#brand-tg-modal').find('.modal-body').css('overflow-y','auto');
    $.get('{$update_brand_tg_url}',{id:$(this).data('id')},
        function (data) {
            $('#brand-tg-modal').find('.modal-body').html(data);
        }
    );
});
JS;


$this->registerJs($modal_js);

?>
