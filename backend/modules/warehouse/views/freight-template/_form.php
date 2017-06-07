<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FreightTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="freight-template-form">

    <?php $form = ActiveForm::begin([
        'id' => 'inventory_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>
    <div style="width:100%;height:30px;background-color:#D8DCE3;line-height:30px;color:#696C75;padding-left:20px;margin-bottom:10px;">基本信息</div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default_freight')->textInput() ?>
    <div style="width:100%;height:30px;background-color:#D8DCE3;line-height:30px;color:#696C75;padding-left:20px;margin-bottom:10px;">明细信息</div>
    <?= $form->field($province_form, 'p010')->textInput() ?>
    <?= $form->field($province_form, 'p022')->textInput() ?>
    <?= $form->field($province_form, 'p021')->textInput() ?>
    <?= $form->field($province_form, 'p023')->textInput() ?>
    <?= $form->field($province_form, 'p0311')->textInput() ?>
    <?= $form->field($province_form, 'p0351')->textInput() ?>
    <?= $form->field($province_form, 'p024')->textInput() ?>
    <?= $form->field($province_form, 'p0431')->textInput() ?>
    <?= $form->field($province_form, 'p0451')->textInput() ?>
    <?= $form->field($province_form, 'p025')->textInput() ?>
    <?= $form->field($province_form, 'p0571')->textInput() ?>
    <?= $form->field($province_form, 'p0551')->textInput() ?>
    <?= $form->field($province_form, 'p0591')->textInput() ?>
    <?= $form->field($province_form, 'p0791')->textInput() ?>
    <?= $form->field($province_form, 'p0531')->textInput() ?>
    <?= $form->field($province_form, 'p0371')->textInput() ?>
    <?= $form->field($province_form, 'p027')->textInput() ?>
    <?= $form->field($province_form, 'p0731')->textInput() ?>
    <?= $form->field($province_form, 'p020')->textInput() ?>
    <?= $form->field($province_form, 'p0898')->textInput() ?>
    <?= $form->field($province_form, 'p028')->textInput() ?>
    <?= $form->field($province_form, 'p0851')->textInput() ?>
    <?= $form->field($province_form, 'p0871')->textInput() ?>
    <?= $form->field($province_form, 'p029')->textInput() ?>
    <?= $form->field($province_form, 'p0931')->textInput() ?>
    <?= $form->field($province_form, 'p0971')->textInput() ?>
    <?= $form->field($province_form, 'p0891')->textInput() ?>
    <?= $form->field($province_form, 'p0471')->textInput() ?>
    <?= $form->field($province_form, 'p0951')->textInput() ?>
    <?= $form->field($province_form, 'p0991')->textInput() ?>
    <hr>
    <div class="form-group" style="text-align:center">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
