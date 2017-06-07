<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PromotionDetail;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>
<div class="promotion-detail-index">
    <p>
        <?php
        echo Html::a('新增优惠券', '#', [
            'id' => 'create_promotion_detail',
            'data-toggle' => 'modal',
            'data-target' => '#create-promotion-detail-modal',
            'class' => 'btn btn-success',
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'promotion_id',

            [
                "attribute" => "type",
                "value" => function ($model) {
                    return PromotionDetail::dropDown("type", $model->type);
                },
            ],
            'promotion_detail_name',
            [
                'attribute' => 'is_one',
                'value'=>function($model){
                    return  $model->is_one=='1'?'是':'否';
                },
            ],
            [
                'attribute' => 'is_discount',
                'value'=>function($model){
                    return  $model->is_discount=='1'?'折扣':'满减';
                },
            ],
            [
                'attribute' => 'amount',
                'value'=>function($model){
                   return $model->amount/100;
                },
            ],
            'discount',
            'effective_time',
            'expiration_time',
            [
                'attribute' => 'status',
                'value'=>function($model){
                    return  $model->status=='1'?'启用':'禁用';
                },
            ],

            [
                'header'=>'操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{/discount/promotion-detail/update}&nbsp;&nbsp;{/discount/promotion-detail/delete}',
                'headerOptions' => ['width' => '75'],
                'buttons' => [
                    '/discount/promotion-detail/update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#update-promotion-detail-modal',
                            'class' => 'data-update-promotion-detail',
                            'data-id' => $key,
                        ]);
                    },
                    '/discount/promotion-detail/delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                            [
                                'title' => '删除',
                                'aria-label' => '优惠劵删除',
                                'data-confirm' => '你确认删除该优惠劵么?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'data-id' => $key,
                            ]);
                    },
                ],

            ],
        ],
    ]); ?>
</div>
<?php
Modal::begin([
    'id' => 'update-promotion-detail-modal',
    'header' => '<h4 class="modal-title">更新优惠劵</h4>',
]);
Modal::end();
?>
<?php
$request_update_promotion_detail_url = Url::to(['/discount/promotion-detail/update']);
$promotion_detail_modal_js = <<<JS
  
   $('.data-update-promotion-detail').on('click', function () {
        $('#update-promotion-detail-modal').find('.modal-body').html('');
        $('#update-promotion-detail-modal').find('.modal-body').css('height','550px');
        $('#update-promotion-detail-modal').find('.modal-body').css('overflow-y','auto');
        $.get('{$request_update_promotion_detail_url}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('#update-promotion-detail-modal').find('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($promotion_detail_modal_js,3);
?>
<?php
Modal::begin([
    'id' => 'create-promotion-detail-modal',
    'header' => '<h4 class="modal-title">新增优惠券</h4>',
    'footer' => '',
    'options' => [
        'tabindex' => false
    ],

]);?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'action'=> Url::to(['/discount/promotion-detail/create']),
    'fieldConfig' => [
        'template' => "<div class='col-xs-3 col-sm-3 text-right'>{label} :</div><div class='col-xs-9 col-sm-8'>{input}</div><div class='col-xs-12 col-xs-offset-3 col-sm-3 col-sm-offset-0'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'promotion_id')->textInput(['readonly'=>'readonly']) ?>

<?= $form->field($model, 'promotion_detail_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'type')->radioList(['1'=>'欧币','2'=>'通用券','3'=>'品牌劵','5'=>'商品劵'],['class'=>'form-inline']) ?>

<?=  $form->field($model, 'brand_id')->label('品牌')->widget(Select2::classname(), [
    'options' => ['placeholder' => '请选择指定品牌...'],
    'data' => isset($promotion_data)?$promotion_data:[],
    'pluginOptions' => [
        'allowClear' => true,
        'ajax' => [
            'url' => Url::to(['/goods/brand/search-brand']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(res) { return res.text; }'),
        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
    ],
]); ?>

<?=  $form->field($model, 'good_id')->label('商品')->widget(Select2::classname(), [
    'options' => ['placeholder' => '请选择指定商品...'],
    'data' => isset($promotion_data)?$promotion_data:[],
    'pluginOptions' => [
        'allowClear' => true,
        'ajax' => [
            'url' => Url::to(['/goods/goods/search-good']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {name:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(res) { return res.text; }'),
        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
    ],
]); ?>

<?= $form->field($model, 'is_one')->radioList(['0'=>'否','1'=>'是']) ?>

<?= $form->field($model, 'limited')->textInput() ?>

<?= $form->field($model, 'is_discount')->hint('<span style="color: #ff0000;">*</span>')->radioList(['0'=>'满减','1'=>'折扣'])?>


<?= $form->field($model, 'discount')->textInput() ?>

<?= $form->field($model, 'amount')->textInput() ?>


<?= $form->field($model, 'effective_time')->hint('<span style="color: #ff0000;">*</span>')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => ''],
    'removeButton' => false,
    'pluginOptions' => [
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'autoclose' => true,
        'startDate' => date('Y-m'),
        'minView' => 1,
        'format' => 'yyyy-mm-dd hh:00:00'
    ]
]); ?>

<?= $form->field($model, 'expiration_time')->hint('<span style="color: #ff0000;">*</span>')->widget(DateTimePicker::classname(), [
    'options' => [
        'placeholder' => '',
    ],
    'removeButton' => false,
    'pluginOptions' => [
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'autoclose' => true,
        'startDate' => date('Y-m'),
        'minView' => 1,
        'format' => 'yyyy-mm-dd hh:00:00'
    ],
]); ?>

<?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'启用']) ?>

<hr>
<div class="form-group" style="text-align:center">
    <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
</div>


<?php ActiveForm::end(); ?>


<?php
$this->registerJs('
    (function(){
        $("#create-promotion-detail-modal").find($(".modal-body")).css({
            "height":"500px",
            "overflow-y":"auto",
        });
        $("#w3-tab1 #create-promotion-detail-modal").css("z-index","1060");
    })();
    $("#promotiondetail-type").change(function() {
        var type =$("#promotiondetail-type").find("input[type=\'radio\']:checked").val();;
        reChangeType(type);
    })
    $("#promotiondetail-is_discount").change(function() {
        var is_discount =$(this).find("input[type=\'radio\']:checked").val();;
        reChangeIsDiscount(is_discount);
    })
    function reChangeIsDiscount(is_discount){
        if(is_discount==1){
            $(".field-promotiondetail-discount").removeClass("hidden");
            $(".field-promotiondetail-discount").addClass("show");
            $(".field-promotiondetail-amount").removeClass("show");
            $(".field-promotiondetail-amount").addClass("hidden");
        }else{
            $(".field-promotiondetail-discount").removeClass("show");
            $(".field-promotiondetail-discount").addClass("hidden");
            $(".field-promotiondetail-amount").removeClass("hidden");
            $(".field-promotiondetail-amount").addClass("show");;
        }
    }
    function reChangeType(type){
        if(type==1){
            $(".field-promotiondetail-limited").removeClass("show");
            $(".field-promotiondetail-limited").addClass("hidden");
            $(".field-promotiondetail-is_discount").removeClass("show");
            $(".field-promotiondetail-is_discount").addClass("hidden");
            $(".field-promotiondetail-discount").removeClass("show");
            $(".field-promotiondetail-discount").addClass("hidden");
            $(".field-promotiondetail-brand_id").addClass("hidden");
            $(".field-promotiondetail-good_id").addClass("hidden");
        }else if(type==2){
            $(".field-promotiondetail-limited").removeClass("hidden");
            $(".field-promotiondetail-limited").addClass("show");
            $(".field-promotiondetail-is_discount").removeClass("hidden");
            $(".field-promotiondetail-is_discount").addClass("show");
            $(".field-promotiondetail-discount").removeClass("hidden");
            $(".field-promotiondetail-discount").addClass("show");
            $(".field-promotiondetail-amount").removeClass("hidden");
            $(".field-promotiondetail-amount").addClass("show");
            $(".field-promotiondetail-brand_id").addClass("hidden");
            $(".field-promotiondetail-good_id").addClass("hidden");
            
        }else if(type==3){
            $(".field-promotiondetail-limited").removeClass("hidden");
            $(".field-promotiondetail-limited").addClass("show");
            $(".field-promotiondetail-is_discount").removeClass("hidden");
            $(".field-promotiondetail-is_discount").addClass("show");
            $(".field-promotiondetail-discount").removeClass("hidden");
            $(".field-promotiondetail-discount").addClass("show");
            $(".field-promotiondetail-amount").removeClass("hidden");
            $(".field-promotiondetail-amount").addClass("show");
            $(".field-promotiondetail-brand_id").removeClass("hidden");
            $(".field-promotiondetail-good_id").addClass("hidden");
            
        }else if(type==5){
            $(".field-promotiondetail-limited").removeClass("hidden");
            $(".field-promotiondetail-limited").addClass("show");
            $(".field-promotiondetail-is_discount").removeClass("hidden");
            $(".field-promotiondetail-is_discount").addClass("show");
            $(".field-promotiondetail-discount").removeClass("hidden");
            $(".field-promotiondetail-discount").addClass("show");
            $(".field-promotiondetail-amount").removeClass("hidden");
            $(".field-promotiondetail-amount").addClass("show");
            $(".field-promotiondetail-brand_id").addClass("hidden");
            $(".field-promotiondetail-good_id").removeClass("hidden");
            
        }
    }
');

Modal::end();
?>
