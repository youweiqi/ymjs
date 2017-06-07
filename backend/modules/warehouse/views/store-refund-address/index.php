<?php

use common\models\StoreRefundAddress;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\warehouse\models\search\StoreRefundAddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺退货地址列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-refund-address-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('新增退货地址', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'class' => 'data-update',
                            'data-id' => $key,
                        ]);
                    },
                ],
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'store.store_name',
            'link_man',
            'mobile',
            'province',
            'create_time',
            'update_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return StoreRefundAddress::dropDown('status', $model->status);
                },
            ],


        ],
    ]); ?>
</div>

<?php
$this->params['create_modal_title'] = '新增退货地址';
$this->params['update_modal_title'] = '更新退货地址';
?>
