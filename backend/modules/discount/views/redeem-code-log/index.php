<?php

use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\discount\models\search\RedeemLogCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '兑换码日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redeem-code-log-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [

            'id',
            'redeem_code.redeem_code',
            'c_user.user_name',
            'create_time',

        ],
    ]); ?>
</div>
