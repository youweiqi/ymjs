<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\PromotionDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promotion-detail-form">

    <?php $form = ActiveForm::begin([
        'id' => 'promotion_detail_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form']),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>
    <?= $form->field($model, 'promotion_id')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'promotion_detail_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->radioList(['1'=>'欧币','2'=>'通用劵','3'=>'品牌劵','5'=>'商品劵'],['class'=>'form-inline']) ?>

    <?=  $form->field($model, 'brand_id')->label('品牌')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请选择指定品牌...'],
        'data' => isset($promotion_data)?$promotion_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/goods/brand/search-brand']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {name:params.term}; }')
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


    <?= $form->field($model, 'is_one')->radioList(['0'=>'否','1'=>'是'],['class'=>'form-inline'])?>

    <?= $form->field($model, 'limited')->textInput() ?>

    <?= $form->field($model, 'is_discount')->radioList(['0'=>'满减','1'=>'折扣'])?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'effective_time')->widget(DateTimePicker::classname(), [
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

    <?= $form->field($model, 'expiration_time')->widget(DateTimePicker::classname(), [
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

    <?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'正常']) ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

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
            $(".field-promotiondetail-limited").removeClass("hidden");
            $(".field-promotiondetail-limited").addClass("show");
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
?>

