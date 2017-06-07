<?php

use common\components\Common;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'id' => 'advertisement_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'tabindex' => false,
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'


        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",

        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('2级分类名称')->hint('<span style="color: #ff0000;">*</span>') ?>

    <?=  $form->field($model, 'parent_id')->label('父类名称')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请输入父类名称...'],
        'data' => isset($category_data)?$category_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'language'=>[
                'errorLoading'=>new JsExpression("function(){return 'Waiting...'}")
            ],
            'ajax' => [
                'url' => Url::to(['/goods/category/search-category']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>

    <?= $form->field($model, 'en_name')->label('2级分类英文名称')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'order_no')->textInput()->hint('<span style="color: #ff0000;">*</span>') ?>

    <?= $form->field($model, 'ico_path',['template' => " <div class='col-sm-3 text-right'>{label} :</div><div class='col-sm-4'>{input}</div><div class='col-sm-3'>".Common::getImagePreview($model->ico_path,'category-ico_path_preview')."</div>"])->label('图标图片路径')->fileInput() ?>

    <div class="form-group">
        <div class='col-sm-6 col-sm-offset-3'><span style="color: red">(图片比例为 4:1)</span></div>
    </div>
    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$category_js = <<<JS
$("#category-ico_path").change(function() {
    if( !this.value.match( /.jpg|.gif|.png|.bmp|.jpeg/i ) ){
        alert("图片格式无效！");
        $("#category-ico_path").val('');
        return false;
    }else{
        var objUrl = getObjectURL(this.files[0]);
        if (objUrl) {
            getImgInfo(objUrl,function (obj) {
                if(obj.width/obj.height!=4){
                    alert('图片宽高比例必须为4:1！');
                    $("#category-ico_path").val('');
                    return false;
                }else {
                    $(".category-ico_path_preview").attr("src", objUrl) ;
               }
            })
        }
    }
})
JS;

$this->registerJs($category_js,3);
?>