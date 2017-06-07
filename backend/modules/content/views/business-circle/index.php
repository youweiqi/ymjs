<?php

use backend\libraries\GoodsLib;
use common\components\Common;
use common\models\BusinessCircle;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\BusinessCircleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商圈列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-circle-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增商圈', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            'circle_name',

            [
                'attribute' => 'back_image_path',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->back_image_path,'100px');
                }
            ],
            'advertising',
            'province',
            'city',
            'radiation_raidus',
            'create_time',
            'update_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return BusinessCircle::dropDown('status', $model->status);
                }
            ],
        ],
    ]); ?>
</div>
