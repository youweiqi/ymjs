<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\models\Menu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php  if(Menu::checkRule('create')){
        echo  Html::a('新增', '#', [
        'class' => 'btn btn-success btn-sm',
        'id' => 'data-operate',
        'data-toggle' => 'modal',
        'data-target' => '#operate-modal',
        ]);} ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
                'columns' => [


            'id',
            'name',

    [
             'headerOptions' => ['width' => '175'],
             'class' => 'yii\grid\ActionColumn',
             'template' => '{update}  {delete}',
             'header' => '操作',
             'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a("信息", '#', [
                         'title' => '栏目信息',
                         'data-toggle' => 'modal',
                         'data-target' => '#operate-modal',
                         'class' => 'data-operate btn btn-default',
                         'data-id' => $key,
                   ]);
               },
                   'delete' => function ($url, $model, $key) {
                      return Html::a('删除', $url, [
                        'title' => '删除',
                        'class' => 'btn btn-default',
                        'data' => [
                        'confirm' => '确定要删除么?',
                        'method' => 'post',
                           ],
                        ]);
                     },
               ],
    ],
        ],
    ]); ?>
</div>

