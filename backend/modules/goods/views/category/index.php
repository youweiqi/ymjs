<?php

use common\models\Category;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">



    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增分类', '#', [
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
            'id' => 'data-create',
        ]); ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'afterRow' => function ($model, $key, $index, $grid){
            return '<tr id="id'.$key.'" data-key="'.$key.'" data-index="'.$index.'" style="display:none"><td colspan="14" id = tdid'.$key.'></td></tr>';
        },
        'columns' => [

            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '75'],
                'template' => '{create-child-category} {update}',
                'buttons' => [
                    'create-child-category' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#create-child-category-modal',
                            'class' => 'data-create-child-category',
                            'data-id' => $key,
                        ]);
                    },
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
                'header'=>'',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '15'],
                'template' => '{open}',
                'buttons' => [
                    'open' => function ($url, $model, $key) {
                        return Html::a('<span data-id="'.$model->id. '"class="open-row glyphicon glyphicon-collapse-up"></span>', 'javascript:;'); },
                ],
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '75'],
            ],
            'name',
            'en_name',

            [
                'attribute' => 'ico_path',
                'label' => '小图标',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['ico_path'] ? Html::img($model['ico_path'],['width' => '30px','height'=>'30px']) : $model['ico_path'];
                }
            ],
            'order_no',
            [
                'attribute' => 'parent_id',
                'label' => '父类名称',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['parent_id'] ? Category::getCategoryNameById($model['parent_id']) : $model['en_name'];
                }
            ],
           'deep',
            [
                'attribute'=>'status',
                'headerOptions' => ['width' => '75'],
                'value'=>function($model){
                    return Category::dropDown('status',$model->status);
                },
            ],
        ],
    ]); ?>

</div>
<?php
$this->params['create_modal_title'] = '新增分类';
$this->params['update_modal_title'] = '更新分类';
$this->params['modal_height'] = '400px';
Modal::begin([
    'id'=>'create-child-category-modal',
    'header'=>'<button type="button" class="close" data-dismiss="modal"></button><h4 class="modal-title">新增子分类</h4>',
    'options' => [
        'tabindex' => false,
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();
Modal::begin([
    'id'=>'update-child-category-modal',
    'header'=>'<button type="button" class="close" data-dismiss="modal"></button><h4 class="modal-title">更新子分类</h4>',
    'options' => [
        'tabindex' => false,
        'data-backdrop' => 'static',
        'data-keyboard' => false
    ],
]);
Modal::end();
?>
<?php
$request_create_child_category_url = Url::to(['/goods/category/create-child-category']);
$request_update_child_category_url = Url::to(['/goods/category/update-child-category']);
$request_get_category_url = Url::to(['/goods/category/get-child-category-html']);
$open_row_js = <<<JS
    $(".open-row").on("click",function(){ 
        _this = $(this);
        category_id = _this.data("id");
        _this.toggleClass("glyphicon-collapse-up glyphicon-expand");
        is = _this.hasClass("glyphicon-collapse-up");
        if(is){
            $("#id"+category_id).hide();
        }else{
           $.ajax({
                type: "post",
                dataType: "text",
                data: {
                    "category_id": category_id
                },
                url: '{$request_get_category_url}',
                success: function (data) {
                   $("#tdid"+category_id).html(data);
                   $('.data-update-child-category').bind('click', function () {
                        $('.modal-body').html('');
                        $('#update-child-category-modal').find('.modal-body').css('overflow-y','auto');
                        $.get('{$request_update_child_category_url}', { id: $(this).closest('tr').data('key') },
                            function (data) {
                                $('#update-child-category-modal').find('.modal-body').html(data);
                            }
                        );
                    });
                }
            });
            $("#id"+category_id).show();
        }
    }); 
    $('.data-create-child-category').on('click', function () {
        $('.modal-body').html('');
        $('#create-child-category-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_create_child_category_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#create-child-category-modal').find('.modal-body').html(data);
            }
        );
    });
    
JS;
$this->registerJs($open_row_js,3);
?>

