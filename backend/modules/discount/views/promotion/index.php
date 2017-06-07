<?php

use common\models\Promotion;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\discount\models\search\PromotionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '优惠礼包列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotion-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('新增礼包', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [

            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update}&nbsp;&nbsp;{delete}'
            ],

            'id',
            'name',
            'descripe:ntext',
            'create_time',
            [
                "attribute" => "status",
                "value" => function ($model) {
                    return Promotion::dropDown('status', $model->status);
                },
                "filter" => Promotion::dropDown('status'),
            ],

        ],
    ]); ?>
</div>
