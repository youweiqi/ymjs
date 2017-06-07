<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\SerialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '期资讯';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-index">


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增期资讯', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success btn-sm',
            'id' => 'data-create',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100'],
                'template' => '{update}&nbsp;&nbsp;{view}&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#look-modal',
                            'class' => 'data-look',
                            'data-id' => $key,
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                            [
                                'title' => '删除',
                                'aria-label' => '期资讯删除',
                                'data-confirm' => '你确认删除该期资讯么?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'data-id' => $key,
                            ]);
                    },
                ],
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            [
                'attribute' => 'title',
                'headerOptions' => ['width' => '275'],
            ],

            [
                'attribute' => 'brand_name',
                'value' => function ($model) {
                    $brand_name = null;
                    if($model->brand['name_cn']||$model->brand['name_en']){
                        $brand_name = $model->brand['name_cn'].'  ('.$model->brand['name_en'].')';
                    }
                    return $brand_name;
                },
                'label' => '品牌',
            ],
            'online_time',
            'offline_time',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    $type_name = '';
                    if($model->type==1){
                        $type_name = '普通期';
                    }elseif ($model->type==2){
                        $type_name = '福利社';
                    }
                    return $type_name;
                },
            ],
            [
                'attribute' => 'is_recommend',
                'value' => function ($model) {
                    return $model->is_recommend==1?'是':'否';
                },
            ],
            [
                'attribute' => 'is_display',
                'value' => function ($model) {
                    return $model->is_display==1?'是':'否';
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status==1?'启用':'禁用';
                },
            ],


        ],
    ]); ?>
</div>
<?php
$this->params['create_modal_title'] = '新增期资讯';
$this->params['update_modal_title'] = '更新期资讯';

?>

<?php
$this->params['create_modal_title'] = '新增期资讯';
?>

<?php
Modal::begin([
    'id' => 'look-modal',
    'header' => '<h4 class="modal-title">查看期资讯</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
?>
<?php
$request_look_url = Url::to(['/content/serial/view']);
$look_modal_js = <<<JS
$('.data-look').on('click', function () {
        $('#look-modal').find('.modal-header').html('<h4 class="modal-title">查看期资讯</h4>');
        $('#look-modal').find('.modal-body').html('');
        $('#look-modal').find('.modal-body').css('height','600px');
        $('#look-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_look_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#look-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($look_modal_js,3);
?>




