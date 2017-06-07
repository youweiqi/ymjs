<?php

use common\widgets\link_pager\LinkPager;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\thirdparty\models\search\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '第三方品牌列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => LinkPager::className(),
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'value'=>'id',
                'headerOptions' => ['width' => '100'],
                'label'=>'品牌Id'
            ],

            [
                'attribute' => 'firstChar',
                'value'=>'firstChar',
                'headerOptions' => ['width' => '100'],
                'label'=>'品牌缩写'
            ],
            [
                'attribute' => 'nameCn',
                'value'=>'nameCn',
                'headerOptions' => ['width' => '100'],
                'label'=>'品牌中文名'
            ],
            [
                'attribute' => 'nameEn',
                'value'=>'nameEn',
                'headerOptions' => ['width' => '100'],
                'label'=>'品牌英文名'
            ],
            'descriptions',
            // 'logo_path',
            // 'background_image_path',
            // 'like_count',
            // 'status',
            // 'order_no',


        ],
    ]); ?>
</div>
