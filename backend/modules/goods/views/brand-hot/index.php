<?php

use common\components\Common;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\BrandHotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '热门品牌';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-hot-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('选择热门品牌', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
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
            'brand_name',
            [
                'attribute' => 'logo_path',
                'label' => '品牌图片',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->logo_path,'60px');
                }
            ],
            'order_no',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$this->params['create_modal_title'] = '选择热门品牌';
$this->params['update_modal_title'] = '更新热门品牌';

?>
