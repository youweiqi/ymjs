<?php

use backend\libraries\MemberLib;
use common\models\CUser;
use common\widgets\link_pager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;



/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\models\search\CUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuser-index">


    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


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
            'user_name',
            'nick_name',
            'money',
            'empiric_value',
           [
                'attribute' => 'role_id',
                'label' => '角色',
                'value' => 'c_role.role_name',

            ],
            [
                'attribute' => 'parent_user_id',
                'value' => function ($model) {
                    return MemberLib::getMember($model->parent_user_id);
                }
            ],
            'create_time',
            'talent_effect_time',
            'talent_failure_time',

            [
                'attribute' => 'lock_status',
                'value' => function ($model) {
                    return CUser::dropDown('lock_status', $model->lock_status);
                },
            ],


        ],
    ]); ?>
</div>

<?php
$this->params['update_modal_title'] = '更新会员';
?>
