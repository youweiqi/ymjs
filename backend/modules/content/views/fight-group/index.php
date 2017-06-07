<?php

use common\models\Activity;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\FightGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '拼团列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增拼团', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
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
                    'template' => '{update}{delete}',
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

                [
                    'attribute' => 'good_id',
                    'value' => 'goods.name',
                    'label'=>'商品名称'
                ],


                [
                    'attribute' => 'store_id',
                    'value' => 'store.store_name',
                    'label'=>'门店'
                ],
                [
                    'attribute' => 'sale_price',
                    'value' => function ($model) {
                        return $model->sale_price/100;
                    }
                ],
                'start_time',
                'end_time',
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return Activity::dropDown('type', $model->type);
                    },
                ],
                'update_time',

            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Activity::dropDown('status', $model->status);
                },
            ],
            ],

    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增拼团';
$this->params['update_modal_title'] = '更新拼团';
?>

