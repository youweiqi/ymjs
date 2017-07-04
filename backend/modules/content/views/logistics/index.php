<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\LogisticsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '物流列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logistics-index">


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增物流', '#', [
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
            'name',
            'name_code',
            'is_all_warehouse',


        ],
    ]); ?>
</div>

<?php
$this->params['create_modal_title'] = '新增物流';
$this->params['update_modal_title'] = '更新物流';

?>
