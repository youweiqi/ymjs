<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\TeamUserRelationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '小组成员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-user-relation-index">


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增小组成员', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            'id',
            'team.team_name',
            [
                'attribute' => 'user_id',
                'label' => '小组成员',
                'value' => 'user.username',
            ],
        ],
    ]); ?>
</div>

<?php
$this->params['create_modal_title'] = '新增小组成员';
$this->params['update_modal_title'] = '更新小组成员';
$this->params['modal_height'] = '350';
?>
