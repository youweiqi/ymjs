<?php

use common\components\Common;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsNavigate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-navigate-form">

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

    <?= $form->field($model, 'good_id')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'navigate_image',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-5'>{input}</div><div class='col-sm-2'>".Common::getImagePreview($model->navigate_image,'goodsnavigate-navigate_image_preview')."</div>"])->label('商品主图')->fileInput()?>

    <?= $form->field($model, 'order_no')->textInput() ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('
$("#goodsnavigate-navigate_image").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        console.log(this.files[0]);
        var objUrl = getObjectURL(this.files[0]);
        console.log(objUrl);
        if (objUrl) {
            $(".goodsnavigate-navigate_image_preview").attr("src", objUrl) ;
        }
    })
');
?>
