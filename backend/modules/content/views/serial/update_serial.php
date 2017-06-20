<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Serial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serial-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class='col-md-2 text-right'>{label} :</div><div class='col-md-4'>{input}</div><div class='col-md-6 col-md-offset-0'>{error}</div>",
        ]
    ]); ?>


    <?= $form->field($model, 'jump_style')->textInput(['readonly' => 'readonly'])?>

    <?= $form->field($model, 'jump_to')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'online_time')->widget(DateTimePicker::classname(), [
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
    <?= $form->field($model, 'offline_time')->widget(DateTimePicker::classname(), [
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover_imgpath',
        [
            'template' => "<div class='col-md-2 text-right'>{label} :</div>
                             <div class='col-md-1'>{input}</div>
                             <div class='col-md-1'>". Html::img($model->cover_imgpath,['width' => '30px','height'=>'30px','class'=>'serial-cover_imgpath_preview'])."</div>
                             <div class='col-md-2 text-left'>{hint}</div>"
        ])->hint('<label for="serial-cover_imgpath" class="control-label" style="color: red">(推荐尺寸: 640*320)</label>')->fileInput()
    ?>

    <?= $form->field($model, 'cover_imgwidth')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'cover_imgheight')->textInput(['readonly'=>'readonly']) ?>

    <!--<?//= $form->field($model, 'like_count')->textInput(['placeholder'=>'请填写整数']) ?>-->

    <?= $form->field($model, 'see_count')->textInput(['placeholder'=>'请填写整数']) ?>

    <!--<?//= $form->field($model, 'share_count')->textInput(['placeholder'=>'请填写整数']) ?>-->

    <?= $form->field($model, 'is_recommend')->radioList(['0'=>'否','1'=>'是'])  ?>

    <?= $form->field($model, 'is_display')->radioList(['0'=>'否','1'=>'是'])  ?>

    <?=  $form->field($serial_brand_model, 'brand_id')->label('所属品牌')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请输入品牌名称...'],
        'data' => isset($serial_brand_data)?$serial_brand_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/goods/brand/search-brand']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>
    <?= $form->field($model, 'wx_big_imgpath',
        [
            'template' => "<div class='col-md-2 text-right'>{label} :</div>
                             <div class='col-md-2'>{input}</div>
                             <div class='col-md-1'>". Html::img($model->wx_big_imgpath,['width' => '30px','height'=>'30px','class'=>'serial-wx_big_imgpath_preview'])."</div>
                             <div class='col-md-1 text-left'>{hint}</div>"
        ])->hint('<label for="serial-wx_big_imgpath" class="control-label" style="color: red">(200*200)</label>')->fileInput()->label('背景图')
    ?>
    <?= $form->field($model, 'type')->dropDownList(['1'=>'普通期'],['prompt' => '请选择资讯分类','disabled'=>'disabled']) ?>

    <?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'启用'])  ?>
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-3 col-md-offset-3"></div>
    </div>

    <?php ActiveForm::end(); ?>

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
            $(".serial-wx_big_imgpath_preview").attr("src", objUrl) ;
        }
    })
    $("#serial-wx_small_imgpath").change(function() {
        if( !this.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            alert("图片格式无效！");
            this.value="";
            return false;
        }
        var objUrl = getObjectURL(this.files[0]);
        if (objUrl) {
            $(".serial-wx_small_imgpath_preview").attr("src", objUrl) ;
        }
    })
');
?>
