<?php

use backend\libraries\MemberLib;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuser-form">

    <?php $form = ActiveForm::begin([
        'id' => 'cuser_form',
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

    <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'nick_name')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'user_name')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'role_id')->radioList(MemberLib::getMemberRole($model->role_id),
        [
            'prompt' => '请选择角色',
        ]) ?>

    <div id="role">

    <?= $form->field($model, 'talent_effect_time')->widget(DateTimePicker::classname(), [
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

    <?= $form->field($model, 'talent_failure_time')->widget(DateTimePicker::classname(), [
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

</div>

    <?= $form->field($model, 'lock_status')->radioList(['0'=>'未锁定','1'=>'已锁定']) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$this->registerJs('
   
    $("#cuser-role_id").click(function(){
        var role_id =$(this).find("input[type=\'radio\']:checked").val();
        reChangeOpenFlashExpress1(role_id);
    })
    function reChangeOpenFlashExpress1(role_id){
        if(role_id==1){
                $("#role").hide();
                 }else{
                $("#role").show();
            }
    }
    
');
?>
