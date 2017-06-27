<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Team */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-form">

    <?php $form = ActiveForm::begin([
        'id' => 'team-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>



    <?= $form->field($model, 'team_name')->textInput(['maxlength' => true]) ?>

    <hr>
    <div class="form-group" style="text-align:center">
        <button id="submit_form_btn" class="btn btn-success" style="margin-right: 20px">保存</button>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
