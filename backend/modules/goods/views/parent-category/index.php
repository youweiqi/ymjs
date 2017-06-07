<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\ParentCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '父分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增父分类', '#', [
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

            'id',
            'name',
            'en_name',
            'order_no',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增分类';
$this->params['update_modal_title'] = '更新分类';
$this->params['modal_height'] = '400px';
?>