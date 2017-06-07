<?php

use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\discount\models\search\UserPromotionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户优惠劵明细';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-promotion-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
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
                'template' => '{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'class' => 'data-update',
                            'data-id' => $key,
                        ]);
                    },
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'c_user.user_name',
            'promotion_detail.promotion_detail_name',
            'promotion_number',
            'create_time',

        ],
    ]); ?>
</div>
