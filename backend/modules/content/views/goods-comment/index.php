<?php

use common\components\Common;
use common\models\GoodsComment;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\GoodsCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品评价列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-comment-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{update-status}',
                'buttons' => [
                    'update-status' => function($url, $model) {
                        $options = [
                            'title' => '修改状态',
                            'aria-label' => '修改状态',
                            'data-confirm' => '你确认要改变该评论的状态么?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        if ($model->status == 1) {
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, $options);
                        }else{
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                        }
                    }
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'good_id',
            [
                'attribute' => 'goods_name',
                'value' => 'goods.name',
                'label' => '商品名称',
            ],
            [
                'attribute' => 'member_name',
                'value' => 'c_user.user_name',
                'label' => '用户',
            ],
            'comment_text:ntext',
            'spec_name',
            [
                'attribute' => 'image1',
                'format' => 'html',
                'value' => function ($model) {
                    return Common::getImage($model->image1);
                },
            ],
            'create_time',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return GoodsComment::dropDown('status', $model->status);
                },
            ],


        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
