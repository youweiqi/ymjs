<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\Common;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model common\models\Serial */

$this->title = '新增期资讯';
$this->params['breadcrumbs'][] = ['label' => '期资讯列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-create">

    <div class="serial-form">

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

        <div style="width:100%;height:30px;background-color:#D8DCE3;line-height:30px;color:#696C75;padding-left:20px;margin-bottom:10px;">基本信息</div>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?= $form->field($model, 'label_name')->textInput(['maxlength' => true])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?= $form->field($model, 'jump_style')->dropDownList(['1'=>'无','2'=>'商品','3'=>'URL','4'=>'期'])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?= $form->field($model, 'jump_to')->textInput(['maxlength' => true,'placeholder'=>'请根据类型填写商品ID、资讯ID或链接']) ?>


        <?= $form->field($model, 'cover_imgpath')->label('封面图')->fileInput()->hint('<span style="color: #ff0000;">*</span>') ?>

        <div class='form-group'>
            <div class='col-sm-6 col-sm-offset-3'>
                <?php echo Common::getImagePreview($model->cover_imgpath,'serial-cover_imgpath_preview',['width'=>'250px','height'=>'125px']) ?>
            </div>
            <div class='col-sm-3'></div>
        </div>


        <?= $form->field($model, 'wx_big_imgpath')->label('背景图')->fileInput() ?>

        <div class='form-group'>
            <div class='col-sm-6 col-sm-offset-3'>
                <?php echo Common::getImagePreview($model->wx_big_imgpath,'serial-wx_big_imgpath_preview',['width'=>'125px','height'=>'125px']) ?>
            </div>
            <div class='col-sm-3'></div>
        </div>


        <?= $form->field($model, 'is_recommend')->radioList(['1'=>'是','0'=>'否'],['class'=>'form-inline'])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?= $form->field($model, 'is_display')->radioList(['1'=>'是','0'=>'否'],['class'=>'form-inline'])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?= $form->field($model, 'type')->dropDownList(['1'=>'普通期'])->hint('<span style="color: #ff0000;">*</span>') ?>

        <?=  $form->field($serial_brand_model, 'brand_id')->label('所属品牌')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入品牌名称...'],
            'data' => isset($serial_brand_data)?$serial_brand_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/goods/brand/search-brand']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?= $form->field($model, 'online_time')->hint('<span style="color: #ff0000;">*</span>')->widget(DateTimePicker::classname(), [
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
        <?= $form->field($model, 'offline_time')->hint('<span style="color: #ff0000;">*</span>')->widget(DateTimePicker::classname(), [
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

        <?= $form->field($model, 'cover_imgwidth',['template' => "<div class='col-sm-2'>{input}</div>"])->label(false)->hiddenInput() ?>

        <?= $form->field($model, 'cover_imgheight',['template' => "<div class='col-sm-2'>{input}</div>"])->label(false)->hiddenInput() ?>


        <?= $form->field($model, 'status')->radioList(['1'=>'启用','0'=>'禁用'],['class'=>'form-inline'])->hint('<span style="color: #ff0000;">*</span>') ?>
        <hr>
        <div class="form-group" style="text-align:center">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
            <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php
$this->registerJs('
    $("#serial-cover_imgpath").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            this.value="";
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".serial-cover_imgpath_preview").attr("src", objUrl);
            setImgInfo(objUrl,"serial-cover_imgwidth","serial-cover_imgheight");
        }
    })
    
    $("#serial-wx_big_imgpath").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            this.value="";
            return false;
        }
        var objUrl = getObjectURL(this.files[0])
        if (objUrl) {
            $(".serial-wx_big_imgpath_preview").attr("src", objUrl);
        }
    })
   ',3);
?>
