<?php

use common\models\UserJournal;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\finance\models\search\UserJournalsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-journal-index">

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
            'c_user.user_name',
            'type',
            [
                'attribute'=>'money',
                'value'=>function ($model) {
                    return $model->money/100;
                },
            ],
            [
                'attribute' => 'bank_id',
                'value' => 'c_user_bank.bank_name',
            ],
            [
                'attribute' => 'bank_id',
                'label'=>'银行卡',
                'value' => 'c_user_bank.bank_card',
            ],
            'comment',
            'create_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return UserJournal::dropDown('status', $model->status);
                },
            ],
        ],
    ]); ?>
</div>
