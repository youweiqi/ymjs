<?php
use common\components\Common;
use common\models\Serial;
use common\models\SerialContent;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

?>
<p>
    <?php
    echo Html::a('新增期资讯内容', '#', [
        'id' => 'create_serial_content',
        'data-toggle' => 'modal',
        'data-target' => '#create-serial-content-modal',
        'class' => 'btn btn-success',
    ]); ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        array(
            'attribute' => 'serial_id',
            'label' => '期资讯标题',
            'value'=>function($model){
                return Serial::getSerialTitleById($model->serial_id);
            },
        ),
        [
            'attribute' => 'image_path',
            'label' => '图片',
            'format' => 'html',
            'value' => function ($model) {
                return Common::getImage($model->image_path);
            }
        ],
        [
            'attribute' => 'jump_style',

            'value'=>function($model){
                return SerialContent::dropDown('jump_style',$model->jump_style);
            },
        ],

        'jump_to',
        'img_height',
        'img_width',
        'order_no',
        [
            'header'=>'操作',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '75'],
            'template' => '{add1} {/content/serial-content/delete}',
            'buttons' => [
                'add1' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#',[
                            'data-toggle' => 'modal',
                            'data-target' => '#add1-modal',
                            'class' => 'data-add1',
                            'data-id' => $key,
                        ]);
                },

                    '/content/serial-content/delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => '删除',
                            'aria-label' => '删除',
                            'data-confirm' => '您确认要删除该内容么？',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],


        ],
    ],
]); ?>
<?php
Modal::begin([
    'id' => 'add1-modal',
    'header' => '<h4 class="modal-title">更新期资讯内容</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ]
]);
Modal::end();
Modal::begin([
    'id' => 'create-serial-content-modal',
    'header' => '<h4 class="modal-title">新增期资讯内容</h4>',
    'footer' => '',
]);?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'action'=> Url::to(['/content/serial-content/create']),
    'fieldConfig' => [
        'template' => "<div class='col-md-3 text-right'>{label} :</div><div class='col-md-6'>{input}</div><div class='col-md-3'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'serial_id')->textInput(['readonly'=>'readonly']) ?>

<?= $form->field($model, 'image_path',
    [
        'template' => "<div class='col-md-3 text-right'>{label} :</div>
         <div class='col-md-2'>{input}</div>
         <div class='col-md-1'>". Common::getImagePreview($model->image_path,'serialcontent-image_path_preview')."</div>
         <div class='col-md-3 text-left'>{hint}</div>"
    ])->hint('<label for="serialcontent-image_path" class="control-label" style="color: red">(推荐尺寸: 640*320)</label>')->fileInput()
?>

<?= $form->field($model, 'img_height')->textInput(['readonly'=>'readonly']) ?>

<?= $form->field($model, 'img_width')->textInput(['readonly'=>'readonly']) ?>

<?= $form->field($model, 'jump_style')->dropDownList(['1'=>'不跳转','2'=>'商品详情','3'=>'H5','4'=>'其他期资讯']) ?>

<?= $form->field($model, 'jump_to')->textInput() ?>

<?= $form->field($model, 'order_no')->textInput() ?>

<hr>
<div class="form-group" style="text-align:center">
    <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php
$this->registerJs('
    $("#serialcontent-image_path").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".serialcontent-image_path_preview").attr("src", objUrl);
            setImgInfo(objUrl,"serialcontent-img_width","serialcontent-img_height");
        }
    })
');
Modal::end();
?>
<?php
$request_add1_url = Url::to(['/content/serial-content/update']);
$modal_js = <<<JS
$('.data-add1').on('click', function () {
        $('#add1-modal').find('.modal-header').html('<h4 class="modal-title">新增期资讯内容</h4>');
        $('#add1-modal').find('.modal-body').html('');
        $('#add1-modal').find('.modal-body').css('height','500px');
        $('#add1-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_add1_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#add1-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($modal_js,3);
?>

