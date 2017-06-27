<?php
use yii\grid\GridView;
?>
<div class="log-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'created_at',
                'label' => '操作时间',
                'value' => function($model){
                    return date("Y-m-d H:i:s",$model->created_at);
                },
            ],
            [
                'attribute' => 'operator_name',
                'label' => '操作人',
            ],
            [
                'attribute' => 'description',
                'label' => '操作内容',
            ],
        ],
    ]); ?>

</div>
