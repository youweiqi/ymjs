<?php


use common\components\Common;
use common\libraries\ImageLib;
use kartik\time\TimePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin([
        'id' => 'store_form',
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

    <div style="width:100%;height:30px;background-color:#D8DCE3;line-height:30px;color:#696C75;padding-left:20px;margin-bottom:10px;">基础信息</div>

    <?= $form->field($model, 'logo_path',['template' => "<div class='col-sm-3 text-right'>{label} :</div>
        <div class='col-sm-6'>
        <div style='width: 250px;position: relative'>
            <span class='change_img_btn'><i class='fa fa-chain'></i></span>
            <span class='del_img close-modal' id='del_img' onclick='del_img(\"store-logo_path\")'>×</span>
        <img src='".ImageLib::getDefaultImg($model->logo_path)."' class='thumbnail image-preview' name='store-logo_path-preview' id='store-logo_path-preview'>
        {input}</div></div>"])->label('门店LOGO')->fileInput(['onchange' => 'uploadImg("store-logo_path")','class'=>'image-upload']) ?>

    <?php
    echo $form->field($model, 'logo_path')->widget('manks\FileInput', [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
            // 'server' => Url::to('upload/u2'),
            // 'accept' => [
            //     'extensions' => 'png',
            // ],
        ],
    ]); ?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('

    $("#automatic-acquisition").click(function() {
        var province = $("#store-province").val();
        var city = $("#store-city").val();
        var area = $("#store-area").val();
        var address = $("#store-address").val();
        getLocation(province+city+area+address,city)
    });
    function getLocation(address,city)
    {
        var href = "'.Url::to(['/warehouse/store/get-location']).'";
        $.ajax({
            "type"  : "POST",
            "url"   : href,
            "data"  : {address:address,city:city},
            success : function(data) {
             
                 var localtion = JSON.parse(data);
                
                 $("#store-lat").val(localtion.lat);
                 $("#store-lon").val(localtion.lng);
            }
        });
    }
    function getRegionSearch(keywords,level)
    {
        var href = "'.Url::to(['/warehouse/store/get-region-search']).'";
        $.ajax({
            "type"  : "POST",
            "url"   : href,
            "data"  : {keywords:keywords,level:level},
            success : function(data) {
                if(level=="district"){
                    $("#store-area").append(data);
                }else{
                    $("#store-"+level).append(data);
                }
            }
        });
    }
    $("#store-province").change(function() {
        var province = $(this).val();
        $("#store-city").html("<option value=\"0\">请选择城市</option>");
        $("#store-area").html("<option value=\"0\">请选择地区</option>");
        if (province!=0) {
            getRegionSearch(province,"city");
        }
    });
    $("#store-city").change(function() {
        var city = $(this).val();
        $("#store-area").html("<option value=\"0\">请选择地区</option>");
        if (city !=0) {
            getRegionSearch(city,"district");
        }
    });
');
?>

<?php
$this->registerJs('
   
    $("#store-open_flash_express").click(function(){
        var open_flash_express =$(this).find("input[type=\'radio\']:checked").val();
        reChangeOpenFlashExpress1(open_flash_express);
    })
    function reChangeOpenFlashExpress1(open_flash_express){
        if(open_flash_express==0){
                $("#distance").hide();
          }else{
                $("#distance").show();
            }
    }
    $("#store-open_install").click(function(){
        var open_install =$(this).find("input[type=\'radio\']:checked").val();
        reChangeOpenFlashExpress(open_install);
    })
    function reChangeOpenFlashExpress(open_install){
        if(open_install==0){
                $("#install").hide();
          }else{
                $("#install").show();
            }
    }
 
');
?>
