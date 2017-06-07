<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\SpecificationDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Specification Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specification-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Specification Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'specification_id',
            'detail_name',
            'order_no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
