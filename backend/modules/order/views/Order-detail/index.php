<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\search\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_id',
            'order_object_id',
            'user_id',
            'brand_id',
            // 'brand_name',
            // 'good_id',
            // 'good_name',
            // 'label_name',
            // 'product_id',
            // 'spec_name',
            // 'navigate_img1',
            // 'store_id',
            // 'inventory_id',
            // 'channel',
            // 'product_price',
            // 'sale_price',
            // 'settlement_price',
            // 'cooperate_price',
            // 'quantity',
            // 'total_price',
            // 'total_settlementprice',
            // 'total_cooperate_price',
            // 'total_fee',
            // 'cash_coin',
            // 'promotion_discount',
            // 'talent_serial_id',
            // 'talent_share_good_id',
            // 'talent_serial_editandshare_id',
            // 'share_serial_id',
            // 'share_activity_id',
            // 'talent_id',
            // 'discount',
            // 'talent_agio',
            // 'applywelfare_id',
            // 'activity_type',
            // 'group_buying_id',
            // 'create_time',
            // 'update_time',
            // 'status',
            // 'refund',
            // 'comment_status',
            // 'type',
            // 'app_id',
            // 'mall_store_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
