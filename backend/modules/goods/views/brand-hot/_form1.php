<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\components\Common;
/* @var $this yii\web\View */
/* @var $model common\models\BrandHot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-hot-form">

    <?php $form = ActiveForm::begin([
        'id' => 'hot_form',
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
    <?= $form->field($model, 'brand_id')->textInput(['readonly'=>'readonly']) ?>
    <?= $form->field($model, 'brand_name')->textInput(['readonly'=>'readonly']) ?>
    <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'logo_path',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-5'>{input}</div><div class='col-sm-2'>".Common::getImagePreview($model->logo_path,'hot-logo_path_preview')."</div>"])->label('品牌LOGO')->fileInput()?>


    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('
    $("#brandhot-logo_path").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".hot-logo_path_preview").attr("src", objUrl) ;
        }
    })
    
',3);
?>

