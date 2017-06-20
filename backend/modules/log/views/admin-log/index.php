<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\log\models\search\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台操作日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'route',
            [
                'attribute'=>'ip',
                'value'=>function($model){
                    return long2ip($model->ip);
                },
            ],
            'description:ntext',
            [
                'attribute'=>'created_at',
                'value'=>function($model){
                    return date('Y-m-d H:i:s', $model->created_at);
                },
            ],
            [
                'attribute'=>'user_id',
                'label'=>'用户名',
                'value'=>'user.username',
            ],
        ],
    ]); ?>
</div>
