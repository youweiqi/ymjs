<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\SerialContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Serial Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Serial Content', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'serial_id',
            'image_path',
            'order_no',
            'jump_style',
            // 'jump_to',
            // 'img_width',
            // 'img_height',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
