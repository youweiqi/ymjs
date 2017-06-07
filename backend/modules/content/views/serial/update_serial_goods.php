<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
?>
<p>
    <?php
    echo Html::a('新增期资讯商品', '#', [
        'id' => 'create_serial_good',
        'data-toggle' => 'modal',
        'data-target' => '#create-serial-good-modal',
        'class' => 'btn btn-success',
    ]); ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'serial.title',
            'label' => '期资讯标题',
        ],
        [
            'attribute' => 'goods.name',
            'label' => '商品名称',
        ],
        'order_no',
        [
            'header'=>'操作',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '75'],
            'template' => '{add} {/content/serial-goods/delete}',
            'buttons' => [
                'add' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#',[
                                'data-toggle' => 'modal',
                                'data-target' => '#add-modal',
                                'class' => 'data-add',
                                'data-id' => $key,
                            ]);
                    },
                '/content/serial-goods/delete'=>function($url,$model,$key){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => '删除',
                                'aria-label' => '删除',
                                'data-confirm' => '您是否删除该商品？',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                        ]);
                }


            ]
        ],
    ],
]); ?>
<?php
Modal::begin([
    'id' => 'add-modal',
    'header' => '<h4 class="modal-title">更新期资讯商品</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
Modal::begin([
    'options' => [
        'id' => 'create-serial-good-modal',
        'tabindex'=>false,
    ],
    'header' => '<h4 class="modal-title">新增期资讯商品</h4>',
    'footer' => '',

]);
$form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'action'=> Url::to(['/content/serial-goods/create']),
    'fieldConfig' => [
        'template' => "<div class='col-xs-3 text-right'>{label} :</div><div class='col-xs-6'>{input}</div><div class='col-xs-3'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'serial_id')->textInput(['readonly'=>'readonly']) ?>

<?=  $form->field($model, 'good_id')->label('商品名称')->widget(Select2::classname(), [
    'options' => ['placeholder' => '请输入商品名称...'],
    'data' => isset($goods_data)?$goods_data:[],
    'pluginOptions' => [
        'allowClear' => true,
        'ajax' => [
            'url' => Url::to(['/content/serial-goods/search-goods','serial_id'=>$model->serial_id]),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {goods_name:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(res) { return res.text; }'),
        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
    ],
]); ?>

<?= $form->field($model, 'order_no')->textInput() ?>
<hr>
<div class="form-group" style="text-align:center">
    <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
</div>


<?php ActiveForm::end();
Modal::end();
?>

<?php
$request_add_url = Url::to(['/content/serial-goods/update']);
$modal_js = <<<JS
$('.data-add').on('click', function () {
        $('#add-modal').find('.modal-header').html('<h4 class="modal-title">更新期资讯商品</h4>');
        $('#add-modal').find('.modal-body').html('');
        $('#add-modal').find('.modal-body').css('height','400px');
        $('#add-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_add_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#add-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($modal_js,3);
?>
