<?php

use backend\libraries\StoreBrandLib;
use common\models\Store;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\warehouse\models\search\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺管理列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('新增店铺', '#', [
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
            'store_name',

            [
                'attribute' => 'brand_id',
                'label'=>'品牌',
                'value' => function ($model) {
                    return StoreBrandLib::getStoreBrands($model->id);
                }


            ],
            [
                'label'=>'门店余额',
                'attribute'=>'money',
                'value'=>function ($model) {
                    return $model->money?$model->money/100:'0';
                },
            ],
            'province',
            'city',
            'area',

            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Store::dropDown('status', $model->status);
                },
            ],


        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增店铺';
$this->params['update_modal_title'] = '更新店铺';
?>

