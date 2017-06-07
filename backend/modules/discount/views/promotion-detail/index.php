<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\discount\models\search\PromotionDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promotion Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotion-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Promotion Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'promotion_id',
            'type',
            'promotion_detail_name',
            'is_one',
            // 'brand_id',
            // 'good_id',
            // 'effective_time',
            // 'expiration_time',
            // 'limited',
            // 'is_discount',
            // 'amount',
            // 'discount',
            // 'create_time',
            // 'update_time',
            // 'mall_store_id',
            // 'status',
            // 'total_number',
            // 'remaining_number',
            // 'used_number',
            // 'for_register',
            // 'for_mall_display',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
