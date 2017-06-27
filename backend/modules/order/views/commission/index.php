<?php

use common\models\Commision;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\search\CommissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单分佣';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commision-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [
            'id',
            [
                'attribute'=>'order_info.order_sn',
                'label'=>'订单号'
            ],
            [
                'attribute'=>'order_object.order_sn',
                'label'=>'父订单号'
            ],
            [
                'attribute'=>'c_user.user_name',
                'label'=>'分佣人'
            ],
            [
                'attribute'=>'c_role.role_name',
                'label'=>'分佣人级别'
            ],
            'comment',
            'fee',
            'result_time',
            [
                'attribute'=>'result',
                'value'=>function($model){
                    return Commision::dropDown('result',$model->result);
                },
            ],
            'create_time',
            'update_time',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Commision::dropDown('status',$model->status);
                },
            ],

            // 'type',
            // 'comment',
            // 'fee',
            // 'result_time',
            // 'result',
            // 'create_time',
            // 'update_time',
            // 'status',


        ],
    ]); ?>

</div>
