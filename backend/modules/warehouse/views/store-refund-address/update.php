<?php

use common\components\Common;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\StoreRefundAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-refund-address-form">

    <?php $form = ActiveForm::begin([
        'id' => 'refund_address_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>


    <?=  $form->field($model, 'store_id')->label('门店名称')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请选择门店名称...'],
        'data' => isset($store_data)?$store_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'disabled' => true,
            'ajax' => [
                'url' => Url::to(['/store/store/search-store']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {store_name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>

    <?= $form->field($model, 'link_man')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' =>true]) ?>

    <?= $form->field($model, 'province')->dropDownList(ArrayHelper::map(Common::getRegionSearch('中国','province'),'name','name'),
        [
            'prompt' => '请选择省',
        ]) ?>

    <?= $form->field($model, 'city')->dropDownList(ArrayHelper::map(Common::getRegionSearch($model->province,'city'),'name','name'),
        [
            'prompt' => '请选择城市',
        ]) ?>

    <?= $form->field($model, 'area')->dropDownList(ArrayHelper::map(Common::getRegionSearch($model->city,'district'),'name','name'),
        [
            'prompt' => '请选择地区',
        ]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'启用'],['class'=>'form-inline']) ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('
$("#store-image_path").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".store-image_path_preview").attr("src", objUrl) ;
        }
    })
    $("#automatic-acquisition").click(function() {
        var province = $("#store-province").val();
        var city = $("#store-city").val();
        var area = $("#store-area").val();
        var address = $("#store-address").val();
        getLocation(province+city+area+address,city)
    });
    function getRegionSearch(keywords,level)
    {
        var href = "'.Url::to(['/warehouse/store/get-region-search']).'";
        $.ajax({
            "type"  : "POST",
            "url"   : href,
            "data"  : {keywords:keywords,level:level},
            success : function(data) {
                if(level=="district"){
                    $("#storerefundaddress-area").append(data);
                }else{
                    $("#storerefundaddress-"+level).append(data);
                }
            }
        });
    }
    $("#storerefundaddress-province").change(function() {
        var province = $(this).val();
        $("#storerefundaddress-city").html("<option value=\"0\">请选择城市</option>");
        $("#storerefundaddress-area").html("<option value=\"0\">请选择地区</option>");
        if (province!=0) {
            getRegionSearch(province,"city");
        }
    });
    $("#storerefundaddress-city").change(function() {
        var city = $(this).val();
        $("#storerefundaddress-area").html("<option value=\"0\">请选择地区</option>");
        if (city !=0) {
            getRegionSearch(city,"district");
        }
    });
    
');
?>

