<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\SerialGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Serial Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Serial Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'serial_id',
            'good_id',
            'order_no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
