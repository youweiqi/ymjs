<?php

use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\warehouse\models\search\StoreGoodsFreightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '运费明细表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-goods-freight-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],

            'store.store_name',
            'goods.name',
            [
                'attribute' => 'freight_template.name',
                'headerOptions' => ['width' => '275'],
            ],

        ],
    ]); ?>
</div>
