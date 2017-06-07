<?php

use common\components\Common;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\CategorySelectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '精选分类列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-select-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php
        if($count < 8){
            echo Html::a('新增', '#', [
                'data-toggle' => 'modal',
                'data-target' => '#create-modal',
                'class' => 'btn btn-success',
                'id' => 'data-create',
            ]);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
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
            'name',
            'category_id',
            'ico_path',
            [
                'attribute' => 'ico_path',
                'label' => '分类展示图片',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->ico_path);
                },
            ],
            [
                'attribute' => 'order_no',
                'options' => ['width' => '75px;']
            ],

        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增精选分类';
$this->params['update_modal_title'] = '更新精选分类';
?>
