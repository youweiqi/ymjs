<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '仓库列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('新增仓库', '#', [
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

            'id',
            'name',
        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增仓库';
$this->params['update_modal_title'] = '更新仓库';
$this->params['modal_height'] = '250';
?>
