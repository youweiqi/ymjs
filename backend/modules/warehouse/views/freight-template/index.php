<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\warehouse\models\search\FreightTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '运费模板列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freight-template-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('新增运费模板', '#', [
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
            'name',
            [
                'attribute'=>'default_freight',
                'value'=>function ($model) {
                    return $model->default_freight/100;
                },
            ],



        ],
    ]); ?>
</div>

<?php
$this->params['create_modal_title'] = '新增运费模板';
$this->params['update_modal_title'] = '更新运费模板';
?>
