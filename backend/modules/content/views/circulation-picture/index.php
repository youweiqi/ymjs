<?php

use common\components\Common;
use common\models\CirculationPicture;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\CirculationPictureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '首页轮播';
$this->params['breadcrumbs'][] = ['label' => '内容', 'url' => ['/content/advertisement/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-picture-index">

    <p>
        <?= Html::a('新增', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view table-scrollable'],
        /* 表格配置 */
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer'],
        /* 重新排版 摘要、表格、分页 */
        'layout' => '{items}<div class=""><div class="col-md-5 col-sm-5">{summary}</div><div class="col-md-7 col-sm-7"><div class="dataTables_paginate paging_bootstrap_full_number" style="text-align:right;">{pager}</div></div></div>',
        /* 配置摘要 */
        'summaryOptions' => ['class' => 'pagination'],
        /* 配置分页样式 */
        'pager' => [
            'options' => ['class'=>'pagination','style'=>'visibility: visible;'],
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'firstPageLabel' => '第一页',
            'lastPageLabel' => '最后页'
        ],
        /* 定义列表格式 */
        'columns' => [
            [
                'class' => \common\core\CheckboxColumn::className(),
                'name'  => 'id',
                'options' => ['width' => '20px;'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $key,'label'=>'<span></span>','labelOptions'=>['class' =>'mt-checkbox mt-checkbox-outline','style'=>'padding-left:19px;']];
                }
            ],
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update} {delete}',
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
                'header' => 'ID',
                'attribute' => 'id',
                'options' => ['width' => '75px;']
            ],
            [
                'attribute' => 'type',
                'options' => ['width' => '100px;'],
                'value' => function ($model) {
                    return CirculationPicture::dropDown('type', $model->type);
                },
                'filter' => CirculationPicture::dropDown('type'),
            ],
            'activity',
            [
                'attribute' => 'image',
                'label' => '图片',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->image);
                },

            ],
            'order_no',
            [
                'attribute' => 'status',
                'options' => ['width' => '100px'],
                'value' => function ($model) {
                    return CirculationPicture::dropDown('status', $model->status);
                },
                'filter' => CirculationPicture::dropDown('status'),
            ],
        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增首页轮播';
$this->params['update_modal_title'] = '更新首页轮播';
?>
