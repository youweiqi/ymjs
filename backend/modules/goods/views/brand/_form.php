<?php

use common\components\Common;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$validationUrl=['validate-form'];
if (!$model->isNewRecord){
    $validationUrl['id']=$model->id;
}
?>

    <div class="brand-form">
        <?php $form = ActiveForm::begin([
            'id' => 'brand_form',
            'enableAjaxValidation' => true,
            'validationUrl' =>$validationUrl,
            'options' => [
                'class'=>'form-horizontal',
                'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
            ],
            'fieldConfig' => [
                'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
            ]
        ]); ?>

        <?= $form->field($model, 'first_char')->textInput(['maxlength' => true])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?= $form->field($model, 'name_cn')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descriptions')->textarea(['rows' => 6]) ?>

        <?=  $form->field($model, 'parent_ids')->hint('<span style="color: #ff0000;">*</span>')->label('商品类型')->widget(Select2::classname(), [
            'options' => ['multiple' => true,'placeholder' => '请选择商品类型...'],
            'data' => isset($category_brand_data)?$category_brand_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/goods/category/search-category']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?= $form->field($model, 'logo_path',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-5'>{input}</div><div class='col-sm-2'>".Common::getImagePreview($model->logo_path,'brand-logo_path_preview')."</div>"])->label('品牌LOGO')->fileInput()?>

        <?= $form->field($model, 'background_image_path',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-5'>{input}</div><div class='col-sm-2'>".Common::getImagePreview($model->background_image_path,'brand-background_image_path_preview')."</div>"])->label('背景图片')->fileInput()?>

        <?= $form->field($model, 'status')->hint('<span style="color: #ff0000;">*</span>')->radioList(['0'=>'禁用','1'=>'启用'])?>

        <div class="form-group" style="text-align:center">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
            <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$this->registerJs('
    $("#brand-logo_path").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".brand-logo_path_preview").attr("src", objUrl) ;
        }
    })
    $("#brand-background_image_path").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".brand-background_image_path_preview").attr("src", objUrl) ;
        }
    })
    
',3);
?>