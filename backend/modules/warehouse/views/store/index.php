<?php

use backend\libraries\StoreBrandLib;
use common\models\Store;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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
            'data-target' => '#operate-modal',
            'class' => 'btn btn-success',
            'id' => 'data-operate',
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
                            'data-target' => '#operate-modal',
                            'class' => 'data-operate',
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





