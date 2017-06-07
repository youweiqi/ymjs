<?php

use common\components\Common;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessCircle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="business-circle-form">

    <?php $form = ActiveForm::begin(
        [
            'id' => 'validate-form',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate-form']),
            'options' => [
                'class'=>'form-horizontal',
                'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
            ],
            'fieldConfig' => [
                'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
            ]
        ]
    ); ?>

    <?= $form->field($model, 'circle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'back_image_path',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-5'>{input}</div><div class='col-sm-2'>".Common::getImagePreview($model->back_image_path,'advertisement-image_preview')."</div>"])->label('商圈LOGO')->fileInput()?>


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
    <?= $form->field($model, 'address')->textInput(['maxlength'=> true]) ?>
    <?= $form->field($model, 'lon')->textInput() ?>

    <?= $form->field($model, 'lat',['template' => "<div class='col-md-3 text-right'>{label} :</div><div class='col-md-3'>{input}</div><div id='automatic-acquisition' class='col-md-2 btn btn-success'>自动获取</div>"])->textInput() ?>

    <?= $form->field($model, 'radiation_raidus')->textInput() ?>

    <?= $form->field($model, 'advertising')->textInput() ?>

    <?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'启用']) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('

    $("#businesscircle-back_image_path").change(function() {
    if( !this.value.match( /.jpg|.gif|.png|.bmp|.jpeg/i ) ){
        alert("图片格式无效！");
        $("#businesscircle-back_image_path").val(\'\');
        return false;
    }
     var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".advertisement-image_preview").attr("src", objUrl) ;
                 }
        });
    $("#automatic-acquisition").click(function() {
        var province = $("#businesscircle-province").val();
        var city = $("#businesscircle-city").val();
        var area = $("#businesscircle-area").val();
        var address = $("#businesscircle-address").val();
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
                 
                 $("#businesscircle-lat").val(localtion.lat);
                 $("#businesscircle-lon").val(localtion.lng);
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
                    $("#businesscircle-area").append(data);
                }else{
                    $("#businesscircle-"+level).append(data);
                }
            }
        });
    }
    $("#businesscircle-province").change(function() {
        var province = $(this).val();
        $("#businesscircle-city").html("<option value=\"0\">请选择城市</option>");
        $("#businesscircle-area").html("<option value=\"0\">请选择地区</option>");
        if (province!=0) {
            getRegionSearch(province,"city");
        }
    });
    $("#businesscircle-city").change(function() {
        var city = $(this).val();
        $("#businesscircle-area").html("<option value=\"0\">请选择地区</option>");
        if (city !=0) {
            getRegionSearch(city,"district");
        }
    });
');
?>

