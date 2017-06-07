<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\GoodsServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品服务列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-service-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增服务', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success btn-sm',
            'id' => 'data-create',
        ]); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
            'name',
            'content:ntext',
            [
                'attribute' => 'image',
                'label' => '服务图片',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['image'] ? Html::img($model['image'],['width' => '30px','height'=>'30px']) : $model['image'];
                }
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$this->params['create_modal_title'] = '新增服务';
$this->params['update_modal_title'] = '更新服务';
?>

