<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Common;
use  yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-service-form">

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('<span style="color: #ff0000;">*</span>')?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-5'>{input}</div><div class='col-sm-2'>".Common::getImagePreview($model->image,'advertisement-image_preview')."</div>"])->label('品牌LOGO')->fileInput()?>

    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('
    
    $("#goodsservice-image").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".advertisement-image_preview").attr("src", objUrl) ;
        }
    })
    
',3);
?>


