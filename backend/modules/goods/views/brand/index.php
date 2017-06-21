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
                'headerOptions' => ['style' => 'min-width:20px'],
            ],
            [
                'attribute' => 'first_char',
                'headerOptions' => ['style' => 'min-width:90px'],
            ],
            [
                'attribute' => 'name_cn',
                'headerOptions' => ['style' => 'min-width:60px'],
            ],
            [
                'attribute' => 'name_en',
                'headerOptions' => ['style' => 'min-width:60px'],
            ],
            [
                'headerOptions' => ['style' => 'min-width:90px'],
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
                'headerOptions' => ['style' => 'min-width:50px'],
                'attribute'=>'status',
                'value'=>function($model){
                    return Brand::dropDown('status',$model->status);
                },
            ],

            [
                'attribute' =>'descriptions',
                'headerOptions' => ['style' => 'min-width:200px'],
                'format' => 'raw',
                'value' => function ($model) {
                    $all = $model->descriptions;
                    $short = mb_substr($all, 0, 38,'utf-8');
                    return '<span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="'.$all.'">'.$short.'</span>';
                }
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增品牌';
$this->params['update_modal_title'] = '更新品牌';
$js = <<<JS
      $("[data-toggle='popover']").popover();
JS;

$this->registerJs($js);
?>

