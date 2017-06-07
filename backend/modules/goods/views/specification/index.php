<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\SpecificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Specifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Specification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'order_no',
            'brand_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
