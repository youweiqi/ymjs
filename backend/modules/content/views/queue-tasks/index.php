<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\widgets\link_pager\LinkPager;
use common\models\QueueTasks;
use common\models\Admin;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\QueueTasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台任务';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="queue-tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [
            'task_id',
            [
                'attribute' => 'task_type',
                'value' => function ($model) {
                    return QueueTasks::dropDown('task_type', $model->task_type);
                },
            ],

            [
                'attribute' => 'task_result',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->task_result){
                        return Html::a($model->task_result,['/content/queue-tasks/down?f='.$model->task_result]);
                    }else{
                        return '';
                    }
                },
            ],

            [
                'attribute' => 'task_status',
                'value' => function ($model) {
                    return QueueTasks::dropDown('task_status', $model->task_status);
                },
            ],
            'create_time',
            [
                'attribute' => 'task_content',
                'contentOptions' =>
                    ['style'=>'max-width: 350px; overflow: auto; word-wrap: break-word;']
            ],
            'over_time',
            [
                'attribute' => 'operater',
                'value' => function ($model) {
                    return Admin::getUserNameByUid($model->operater);
                },
            ]
        ],
    ]); ?>
</div>
