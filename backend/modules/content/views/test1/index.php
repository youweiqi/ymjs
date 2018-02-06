<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\Test1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test1s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test1-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增Test', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#operate-modal',
            'class' => 'btn btn-success btn-sm',
            'id' => 'data-operate',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
