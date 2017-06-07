<?php

use common\models\Brand;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '品牌列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增品牌', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success btn-sm',
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
                'template' => '{/goods/category/update}',
                'buttons' => [
                    '/goods/category/update' => function ($url, $model, $key) {
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
            'first_char',
            'name_cn',
            'name_en',
            [
                'attribute' => 'logo_path',
                'label' => 'LOGO图片',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['logo_path'] ? Html::img($model['logo_path'],['width' => '60px','height'=>'40px']) : $model['logo_path'];
                }
            ],
            [
                'attribute' => 'background_image_path',
                'label' => '背景图片',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['background_image_path'] ? Html::img($model['background_image_path'],['width' => '60px','height'=>'40px']) : $model['background_image_path'];
                }
            ],

            [
                'attribute'=>'status',
                'headerOptions' => ['width' => '75'],
                'value'=>function($model){
                    return Brand::dropDown('status',$model->status);
                },
            ],

            [
                'attribute' =>'descriptions',
                'headerOptions' => ['width' => '800'],
            ]





        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增品牌';
$this->params['update_modal_title'] = '更新品牌';
?>

