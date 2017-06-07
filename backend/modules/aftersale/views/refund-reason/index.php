<?php

use common\models\RefundReason;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\aftersale\models\search\RefundReasonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '售后原因列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-reason-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增售后原因', '#', [
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
            'reason',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return RefundReason::dropDown('type', $model->type);
                },
            ],
            'create_time',
            'update_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return RefundReason::dropDown('status', $model->status);
                },
            ],


        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增售后原因';
$this->params['update_modal_title'] = '更新售后原因';
?>
